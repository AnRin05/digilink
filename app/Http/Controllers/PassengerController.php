<?php

namespace App\Http\Controllers;

use App\Models\Passenger;
use App\Models\Booking;
use App\Models\Driver;
use App\Models\DriverNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PassengerController extends Controller
{
    public function create()
    {
        return view('passign');
    }

    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:passengers,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $profileImagePath = null;
        if ($request->hasFile('profile_image')) {
            $profileImagePath = $request->file('profile_image')->store('profile_images', 'public');
        }

        $passenger = Passenger::create([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'phone' => $request->phone,
            'profile_image' => $profileImagePath,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('passenger')->login($passenger);

        return redirect()->route('passenger.dashboard')->with('success', 'Account created successfully!');
    }

    public function edit()
    {
        $passenger = Auth::guard('passenger')->user();
        return view('passenger.edit', compact('passenger'));
    }

    public function update(Request $request)
    {
        $passenger = Auth::guard('passenger')->user();

        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:passengers,email,' . $passenger->id,
            'phone' => 'required|string|max:20',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'fullname' => $request->fullname,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        if ($request->hasFile('profile_image')) {
            if ($passenger->profile_image) {
                Storage::disk('public')->delete($passenger->profile_image);
            }
            $data['profile_image'] = $request->file('profile_image')->store('profile_images', 'public');
        }

        /** @var \App\Models\Passenger $passenger */
        $passenger->update($data);

        return redirect()->route('passenger.dashboard')->with('success', 'Profile updated successfully!');
    }

    public function destroy()
    {
        $passenger = Auth::guard('passenger')->user();

        if ($passenger->profile_image) {
            Storage::disk('public')->delete($passenger->profile_image);
        }
        
        Auth::guard('passenger')->logout();
        /** @var \App\Models\Passenger $passenger */
        $passenger->delete();

        return redirect()->route('home')->with('success', 'Account deleted successfully!');
    }

public function bookRide(Request $request)
{
    $passenger = Auth::guard('passenger')->user();

    $activeBookingsCount = Booking::where('passengerID', $passenger->id)
        ->whereIn('status', [Booking::STATUS_PENDING, Booking::STATUS_ACCEPTED, Booking::STATUS_IN_PROGRESS])
        ->count();

    if ($activeBookingsCount >= 3) {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot book more than 3 bookings at a time. Please wait for your current booking to be completed or cancelled.'
            ], 422);
        }
        return redirect()->back()->with('error',
            'You cannot book more than 3 bookings at a time. Please wait for your current booking to be completed or cancelled.');
    }

    $request->validate([
        'pickupLocation' => 'required|string|max:255',
        'dropoffLocation' => 'required|string|max:255',
        'pickupLatitude' => 'required|numeric',
        'pickupLongitude' => 'required|numeric',
        'dropoffLatitude' => 'required|numeric',
        'dropoffLongitude' => 'required|numeric',
        'serviceType' => 'required|in:booking_to_go,for_delivery',
        'fare' => 'required|numeric|min:0',
        'paymentMethod' => 'required|in:cash,gcash',
        'description' => 'nullable|string|max:500',
        'scheduleTime' => 'nullable|date|after:now',
    ]);

    try {
        DB::beginTransaction();

        $fare = $request->fare;

        $bookingData = [
            'passengerID' => $passenger->id,
            'driverID' => null,
            'pickupLocation' => $request->pickupLocation,
            'dropoffLocation' => $request->dropoffLocation,
            'status' => Booking::STATUS_PENDING,
            'fare' => $fare,
            'pickupLatitude' => $request->pickupLatitude,
            'pickupLongitude' => $request->pickupLongitude,
            'dropoffLatitude' => $request->dropoffLatitude,
            'dropoffLongitude' => $request->dropoffLongitude,
            'serviceType' => $request->serviceType,
            'description' => $request->description,
            'paymentMethod' => $request->paymentMethod,
            'timeStamp' => now(),
        ];

        if ($request->filled('scheduleTime')) {
            $bookingData['scheduleTime'] = $request->scheduleTime;
        }

        // ONLY CREATE THE BOOKING - NO BOOKING HISTORY FOR NEW BOOKINGS
        $booking = Booking::create($bookingData);

        DB::commit();

        $message = ($request->serviceType === 'for_delivery' ? 'Delivery' : 'Ride') . ' booked successfully! Fare: ₱' . number_format($fare, 2);
        if ($request->filled('scheduleTime')) {
            $message .= ' (Scheduled for ' . Carbon::parse($request->scheduleTime)->format('M d, Y h:i A') . ')';
        } else {
            $message .= '. A driver will be assigned soon.';
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'booking_id' => $booking->bookingID
            ]);
        }

        return redirect()->route('passenger.dashboard')->with('success', $message);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Booking error: ' . $e->getMessage());

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Booking Successful.'
            ], 500);
        }

        return redirect()->back()->with('error', 'An error occurred while creating your booking. Please try again.');
    }
}

    public function getAvailableDrivers(Request $request)
    {
        try {
            $barangay = $request->get('barangay', 'all');

            $query = Driver::where('is_approved', true)
                ->where('availStatus', true)
                ->where(function ($q) {
                    $q->where('serviceType', 'Ride')
                    ->orWhere('serviceType', 'Both');
                });

            if ($barangay !== 'all') {
                $query->where(function($q) use ($barangay) {
                    $q->where('currentLocation', $barangay)
                    ->orWhere('currentLocation', 'all');
                });
            }

            $availableDrivers = $query->withCount('reviews')
                ->with(['reviews'])
                ->get()
                ->map(function($driver) {
                    $averageRating = $driver->reviews->avg('rating') ?? 0;
                    $totalReviews = $driver->reviews_count;
                    
                    return [
                        'id' => $driver->id,
                        'fullname' => $driver->fullname,
                        'plateNumber' => $driver->plateNumber,
                        'vehicleMake' => $driver->vehicleMake,
                        'vehicleModel' => $driver->vehicleModel,
                        'currentLocation' => $driver->currentLocation,
                        'completedBooking' => $driver->completedBooking,
                        'availStatus' => $driver->availStatus,
                        'serviceType' => $driver->serviceType,
                        'average_rating' => $averageRating,
                        'total_reviews' => $totalReviews,
                        'profile_image' => $driver->getProfileImageUrl()
                    ];
                });

            return response()->json([
                'success' => true,
                'drivers' => $availableDrivers,
                'count' => $availableDrivers->count()
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching drivers: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error fetching drivers: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAvailableDeliveryDrivers(Request $request)
    {
        try {
            $barangay = $request->get('barangay', 'all');

            $query = Driver::where('is_approved', true)
                        ->where('availStatus', true)
                        ->where(function($q) {
                            $q->where('serviceType', 'Delivery')
                            ->orWhere('serviceType', 'Both');
                        });

            if ($barangay !== 'all') {
                $query->where(function($q) use ($barangay) {
                    $q->where('currentLocation', $barangay)
                    ->orWhere('currentLocation', 'all');
                });
            }

            $availableDrivers = $query->withCount('reviews')
                ->with(['reviews'])
                ->get()
                ->map(function($driver) {
                    $averageRating = $driver->reviews->avg('rating') ?? 0;
                    $totalReviews = $driver->reviews_count;
                    
                    return [
                        'id' => $driver->id,
                        'fullname' => $driver->fullname,
                        'plateNumber' => $driver->plateNumber,
                        'vehicleMake' => $driver->vehicleMake,
                        'vehicleModel' => $driver->vehicleModel,
                        'currentLocation' => $driver->currentLocation,
                        'completedBooking' => $driver->completedBooking,
                        'availStatus' => $driver->availStatus,
                        'serviceType' => $driver->serviceType,
                        'average_rating' => $averageRating,
                        'total_reviews' => $totalReviews,
                        'profile_image' => $driver->getProfileImageUrl()
                    ];
                });

            return response()->json([
                'success' => true,
                'drivers' => $availableDrivers,
                'count' => $availableDrivers->count()
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching delivery drivers: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error fetching delivery drivers: ' . $e->getMessage()
            ], 500);
        }
    }

    public function dashboard(Request $request)
    {
        $passenger = Auth::guard('passenger')->user();
        $barangay = $request->get('barangay', 'all');
        
        $query = Driver::where('is_approved', true)
                    ->where('availStatus', true)
                    ->where(function($q) {
                        $q->where('serviceType', 'Ride')
                          ->orWhere('serviceType', 'Both');
                    });

        if ($barangay !== 'all') {
            $query->where(function($q) use ($barangay) {
                $q->where('currentLocation', $barangay)
                  ->orWhere('currentLocation', 'all');
            });
        }

        $availableDrivers = $query->get();

        return view('passenger.dashboard', compact('passenger', 'availableDrivers', 'barangay'));
    }

    public function delivery(Request $request)
    {
        $passenger = Auth::guard('passenger')->user();
        $barangay = $request->get('barangay', 'all');
        
        $query = Driver::where('is_approved', true)
                    ->where('availStatus', true)
                    ->where(function($q) {
                        $q->where('serviceType', 'Delivery')
                          ->orWhere('serviceType', 'Both');
                    });

        if ($barangay !== 'all') {
            $query->where(function($q) use ($barangay) {
                $q->where('currentLocation', $barangay)
                  ->orWhere('currentLocation', 'all');
            });
        }

        $availableDrivers = $query->get();

        return view('passenger.delivery', compact('passenger', 'availableDrivers', 'barangay'));
    }

    public function editBooking($id)
    {
        $passenger = Auth::guard('passenger')->user();
        $booking = Booking::where('bookingID', $id)
            ->where('passengerID', $passenger->id)
            ->firstOrFail();

        if ($booking->status !== Booking::STATUS_PENDING) {
            return redirect()->route('passenger.pending.bookings')
                ->with('error', 'Only pending bookings can be edited.');
        }

        return view('passenger.edit-booking', compact('passenger', 'booking'));
    }

    public function updateBooking(Request $request, $id)
    {
        if (!Auth::guard('passenger')->check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        $passenger = Auth::guard('passenger')->user();
        $booking = Booking::where('bookingID', $id)
            ->where('passengerID', $passenger->id)
            ->firstOrFail();

        if ($booking->status !== Booking::STATUS_PENDING) {
            return response()->json([
                'success' => false,
                'message' => 'Only pending bookings can be edited.'
            ]);
        }

        $request->validate([
            'pickupLocation' => 'required|string|max:255',
            'dropoffLocation' => 'required|string|max:255',
            'pickupLatitude' => 'required|numeric',
            'pickupLongitude' => 'required|numeric',
            'dropoffLatitude' => 'required|numeric',
            'dropoffLongitude' => 'required|numeric',
            'description' => 'nullable|string|max:500',
            'scheduleTime' => 'nullable|date|after:now',
        ]);

        try {
            $booking->update([
                'pickupLocation' => $request->pickupLocation,
                'dropoffLocation' => $request->dropoffLocation,
                'pickupLatitude' => $request->pickupLatitude,
                'pickupLongitude' => $request->pickupLongitude,
                'dropoffLatitude' => $request->dropoffLatitude,
                'dropoffLongitude' => $request->dropoffLongitude,
                'description' => $request->description,
                'scheduleTime' => $request->scheduleTime,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Booking updated successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating booking: ' . $e->getMessage()
            ]);
        }
    }

    public function pendingBookings()
    {
        $passenger = Auth::guard('passenger')->user();
        return view('passenger.pending-bookings', compact('passenger'));
    }

    public function getPendingBookings()
    {
        if (!Auth::guard('passenger')->check()) {
            return response()->json(['success' => false, 'message' => 'Not authenticated']);
        }

        $passenger = Auth::guard('passenger')->user();

        $bookings = Booking::where('passengerID', $passenger->id)
            ->whereIn('status', [Booking::STATUS_PENDING, Booking::STATUS_ACCEPTED, Booking::STATUS_IN_PROGRESS])
            ->with('driver')
            ->latest()
            ->get()
            ->map(function($booking) {
                $driverId = $booking->driver ? $booking->driver->id : $booking->driverID;
                
                return [
                    'id' => $booking->bookingID,
                    'pickup_location' => $booking->pickupLocation,
                    'dropoff_location' => $booking->dropoffLocation,
                    'fare' => '₱' . number_format((float) $booking->fare, 2),
                    'service_type' => $booking->getServiceTypeDisplay(),
                    'service_type_raw' => $booking->serviceType,
                    'status' => $booking->status,
                    'status_display' => $this->getStatusDisplay($booking->status),
                    'payment_method' => $booking->getPaymentMethodDisplay(),
                    'description' => $booking->description,
                    'schedule_time' => $booking->getFormattedScheduleTime(),
                    'driver_id' => $driverId,
                    'created_at' => $booking->created_at->format('M j, Y g:i A'),
                    'driver_name' => $booking->driver ? $booking->driver->fullname : 'Not assigned yet',
                    'driver_phone' => $booking->driver ? $booking->driver->phone : 'N/A',
                    'vehicle_info' => $booking->driver ? $booking->driver->vehicleMake . ' ' . $booking->driver->vehicleModel . ' (' . $booking->driver->plateNumber . ')' : 'N/A',
                    'completed_booking' => $booking->driver ? $booking->driver->completedBooking : '0',
                    'can_cancel' => in_array($booking->status, [Booking::STATUS_PENDING, Booking::STATUS_ACCEPTED]),
                    'can_edit' => $booking->status === Booking::STATUS_PENDING,
                    'can_track' => $booking->status === Booking::STATUS_IN_PROGRESS
                ];
            });

        return response()->json([
            'success' => true,
            'bookings' => $bookings,
            'count' => $bookings->count()
        ]);
    }

    public function cancelBooking($id)
    {
        if (!Auth::guard('passenger')->check()) {
            return response()->json(['success' => false, 'message' => 'Not authenticated']);
        }

        try {
            $passenger = Auth::guard('passenger')->user();
            $booking = Booking::findOrFail($id);

            if ($booking->passengerID !== $passenger->id) {
                return response()->json([
                    'success' => false, 
                    'message' => 'You cannot cancel this booking.'
                ]);
            }

            if (!in_array($booking->status, [Booking::STATUS_PENDING, Booking::STATUS_ACCEPTED])) {
                return response()->json([
                    'success' => false, 
                    'message' => 'This booking cannot be cancelled.'
                ]);
            }

            $booking->cancel();

            return response()->json([
                'success' => true,
                'message' => 'Booking cancelled successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error cancelling booking: ' . $e->getMessage()
            ]);
        }
    }

    private function getStatusDisplay($status)
    {
        return match ($status) {
            Booking::STATUS_PENDING => 'Pending',
            Booking::STATUS_ACCEPTED => 'Accepted',
            Booking::STATUS_IN_PROGRESS => 'On-going',
            Booking::STATUS_COMPLETED => 'Completed',
            Booking::STATUS_CANCELLED => 'Cancelled',
            default => ucfirst($status)
        };
    }

    // TRACKING FUNCTIONS

    public function trackBooking($id)
    {
        $passenger = Auth::guard('passenger')->user();
        $booking = Booking::where('bookingID', $id)
            ->where('passengerID', $passenger->id)
            ->with('driver')
            ->firstOrFail();

        if (!in_array($booking->status, [Booking::STATUS_ACCEPTED, Booking::STATUS_IN_PROGRESS])) {
            return redirect()->route('passenger.pending.bookings')
                ->with('error', 'This booking cannot be tracked yet. Please wait for driver acceptance.');
        }

        return view('passenger.track-booking', compact('passenger', 'booking'));
    }

    public function getBookingLocation($id)
    {
        if (!Auth::guard('passenger')->check()) {
            return response()->json(['success' => false, 'message' => 'Not authenticated']);
        }

        try {
            $passenger = Auth::guard('passenger')->user();
            $booking = Booking::where('bookingID', $id)
                ->where('passengerID', $passenger->id)
                ->with('driver')
                ->firstOrFail();

            if (!in_array($booking->status, [Booking::STATUS_ACCEPTED, Booking::STATUS_IN_PROGRESS])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking is not active for tracking'
                ]);
            }

            $driver = $booking->driver;
            $driverData = null;

            if ($driver) {
                $freshDriver = Driver::where('id', $driver->id)->first();
                
                $driverData = [
                    'name' => $driver->fullname,
                    'phone' => $driver->phone,
                    'vehicle' => $driver->vehicleMake . ' ' . $driver->vehicleModel . ' (' . $driver->plateNumber . ')',
                    'current_lat' => $freshDriver->current_lat,
                    'current_lng' => $freshDriver->current_lng,
                ];
            }

            return response()->json([
                'success' => true,
                'booking' => [
                    'id' => $booking->bookingID,
                    'status' => $booking->status,
                    'pickup_location' => $booking->pickupLocation,
                    'dropoff_location' => $booking->dropoffLocation,
                    'pickup_lat' => $booking->pickupLatitude,
                    'pickup_lng' => $booking->pickupLongitude,
                    'dropoff_lat' => $booking->dropoffLatitude,
                    'dropoff_lng' => $booking->dropoffLongitude,
                ],
                'driver' => $driverData
            ]);

        } catch (\Exception $e) {
            Log::error('Error getting booking location: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error fetching booking data'
            ], 500);
        }
    }

    // NEW DEDICATED DRIVER TRACKING FUNCTION
    public function getDriverLocation($id)
    {
        if (!Auth::guard('passenger')->check()) {
            return response()->json(['success' => false, 'message' => 'Not authenticated']);
        }

        try {
            $passenger = Auth::guard('passenger')->user();
            $booking = Booking::where('bookingID', $id)
                ->where('passengerID', $passenger->id)
                ->with('driver')
                ->firstOrFail();

            if (!in_array($booking->status, [Booking::STATUS_ACCEPTED, Booking::STATUS_IN_PROGRESS])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking is not active for tracking'
                ]);
            }

            $driver = $booking->driver;
            
            if (!$driver) {
                return response()->json([
                    'success' => false,
                    'message' => 'No driver assigned to this booking yet'
                ]);
            }

            // Get fresh driver data
            $freshDriver = Driver::find($driver->id);
            
            if (!$freshDriver) {
                throw new \Exception("Driver not found with ID: {$driver->id}");
            }

            // Handle coordinates - convert to float if they are strings
            $driverLat = $freshDriver->current_lat;
            $driverLng = $freshDriver->current_lng;
            $isFallback = false;

            // Convert to float if they are strings
            if (is_string($driverLat)) {
                $driverLat = (float) $driverLat;
            }
            if (is_string($driverLng)) {
                $driverLng = (float) $driverLng;
            }

            // Check if driver location is valid
            if ($driverLat === null || $driverLng === null || $driverLat == 0 || $driverLng == 0) {
                // Use pickup location as fallback
                $driverLat = (float) $booking->pickupLatitude;
                $driverLng = (float) $booking->pickupLongitude;
                $isFallback = true;
            }

            $response = [
                'success' => true,
                'booking' => [
                    'id' => $booking->bookingID,
                    'status' => $booking->status,
                    'pickup_location' => $booking->pickupLocation,
                    'dropoff_location' => $booking->dropoffLocation,
                    'pickup_lat' => (float) $booking->pickupLatitude,
                    'pickup_lng' => (float) $booking->pickupLongitude,
                    'dropoff_lat' => (float) $booking->dropoffLatitude,
                    'dropoff_lng' => (float) $booking->dropoffLongitude,
                ],
                'driver' => [
                    'id' => $freshDriver->id,
                    'name' => $freshDriver->fullname,
                    'phone' => $freshDriver->phone,
                    'vehicle' => $freshDriver->vehicleMake . ' ' . $freshDriver->vehicleModel . ' (' . $freshDriver->plateNumber . ')',
                    'current_lat' => $driverLat,
                    'current_lng' => $driverLng,
                    'is_fallback' => $isFallback,
                    'location_updated' => $freshDriver->updated_at
                ],
                'distance_info' => $this->calculateDistanceInfo($driverLat, $driverLng, $booking),
                'timestamp' => now()->toISOString()
            ];

            return response()->json($response);

        } catch (\Exception $e) {
            Log::error('Error getting driver location: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error fetching driver location'
            ], 500);
        }
    }

    private function calculateDistanceInfo($driverLat, $driverLng, $booking)
    {
        $toPickup = $this->calculateDistance(
            $driverLat, $driverLng, 
            $booking->pickupLatitude, $booking->pickupLongitude
        );
        
        $toDropoff = $this->calculateDistance(
            $driverLat, $driverLng,
            $booking->dropoffLatitude, $booking->dropoffLongitude
        );
        
        $totalDistance = $this->calculateDistance(
            $booking->pickupLatitude, $booking->pickupLongitude,
            $booking->dropoffLatitude, $booking->dropoffLongitude
        );

        $estimatedTimeToPickup = $toPickup > 0 ? max(1, round($toPickup / 30 * 60)) : 0;
        $estimatedTimeToDropoff = $toDropoff > 0 ? max(1, round($toDropoff / 30 * 60)) : 0;

        return [
            'to_pickup_km' => round($toPickup, 2),
            'to_dropoff_km' => round($toDropoff, 2),
            'total_trip_km' => round($totalDistance, 2),
            'est_time_to_pickup_min' => $estimatedTimeToPickup,
            'est_time_to_dropoff_min' => $estimatedTimeToDropoff
        ];
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371;

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat/2) * sin($dLat/2) + 
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * 
             sin($dLon/2) * sin($dLon/2);
             
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        
        return $earthRadius * $c;
    }

public function confirmCompletion($id)
{
    if (!Auth::guard('passenger')->check()) {
        return response()->json(['success' => false, 'message' => 'Not authenticated']);
    }

    try {
        $passenger = Auth::guard('passenger')->user();
        $booking = Booking::where('bookingID', $id)
            ->where('passengerID', $passenger->id)
            ->firstOrFail();

        if ($booking->status !== Booking::STATUS_IN_PROGRESS) {
            return response()->json([
                'success' => false, 
                'message' => 'This booking cannot be completed.'
            ]);
        }

        DB::beginTransaction();

        $booking->markPassengerCompleted();

        // Check if both passenger and driver have completed
        if ($booking->isBothCompleted()) {
            // Update booking status to completed
            $booking->update([
                'status' => Booking::STATUS_COMPLETED,
                'completed_at' => now()
            ]);

            // Create booking history for COMPLETED booking
            \App\Models\BookingHistory::create([
                'booking_id' => $booking->bookingID,
                'passenger_id' => $booking->passengerID,
                'driver_id' => $booking->driverID,
                'pickup_location' => $booking->pickupLocation,
                'dropoff_location' => $booking->dropoffLocation,
                'pickup_latitude' => $booking->pickupLatitude,
                'pickup_longitude' => $booking->pickupLongitude,
                'dropoff_latitude' => $booking->dropoffLatitude,
                'dropoff_longitude' => $booking->dropoffLongitude,
                'fare' => $booking->fare,
                'status' => Booking::STATUS_COMPLETED,
                'service_type' => $booking->serviceType,
                'payment_method' => $booking->paymentMethod,
                'description' => $booking->description,
                'schedule_time' => $booking->scheduleTime,
                'driver_completed_at' => $booking->driver_completed_at,
                'passenger_completed_at' => $booking->passenger_completed_at,
                'completion_verified' => true,
                'completed_at' => now()
            ]);
        }

        DB::commit();

        $message = 'Completion confirmed! ';
        if ($booking->isBothCompleted()) {
            $message .= 'Trip completed successfully!';
        } else {
            $message .= 'Waiting for driver confirmation...';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'completion_status' => $booking->getCompletionStatus(),
            'is_completed' => $booking->isBothCompleted()
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Error confirming completion: ' . $e->getMessage()
        ]);
    }
}

    public function cancelOngoingBooking($id)
    {
        if (!Auth::guard('passenger')->check()) {
            return response()->json(['success' => false, 'message' => 'Not authenticated']);
        }

        try {
            $passenger = Auth::guard('passenger')->user();
            $booking = Booking::findOrFail($id);

            if ($booking->passengerID !== $passenger->id) {
                return response()->json([
                    'success' => false, 
                    'message' => 'You cannot cancel this booking.'
                ]);
            }

            if ($booking->status !== Booking::STATUS_IN_PROGRESS) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Only ongoing bookings can be cancelled.'
                ]);
            }

            $driverId = $booking->driverID;
            $passengerName = $passenger->fullname;

            $booking->update([
                'status' => Booking::STATUS_CANCELLED,
                'cancelled_at' => now(),
                'cancelled_by' => 'passenger'
            ]);

            if ($driverId) {
                $driver = Driver::find($driverId);
                if ($driver) {
                    $driver->update(['availStatus' => true]);
                    $this->notifyDriverCancellation($driverId, $booking->bookingID, $passengerName);
                }
            }

            Log::info("Passenger {$passenger->id} cancelled ongoing booking {$booking->bookingID}", [
                'driver_id' => $driverId,
                'passenger_name' => $passengerName
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Booking cancelled successfully! Driver has been notified.'
            ]);

        } catch (\Exception $e) {
            Log::error('Error cancelling ongoing booking: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error cancelling booking: ' . $e->getMessage()
            ]);
        }
    }

    private function notifyDriverCancellation($driverId, $bookingId, $passengerName)
    {
        try {
            DriverNotification::create([
                'driver_id' => $driverId,
                'booking_id' => $bookingId,
                'type' => 'booking_cancelled',
                'title' => 'Booking Cancelled',
                'message' => "Passenger {$passengerName} cancelled the ongoing trip.",
                'data' => json_encode([
                    'booking_id' => $bookingId,
                    'passenger_name' => $passengerName,
                    'cancelled_at' => now()->toISOString()
                ]),
                'read_at' => null
            ]);

            Log::info("Driver {$driverId} notified about booking {$bookingId} cancellation");

        } catch (\Exception $e) {
            Log::error('Error notifying driver about cancellation: ' . $e->getMessage());
        }
    }

    public function showDriverProfile($driverId)
    {
        try {
            // Find the driver with their reviews and comments
            $driver = Driver::with(['reviews', 'comments'])->findOrFail($driverId);
            
            // Calculate average rating
            $averageRating = $driver->reviews->avg('rating') ?? 0;
            $totalReviews = $driver->reviews->count();
            
            // Get passenger info for the view
            $passenger = Auth::guard('passenger')->user();
            
            return view('passenger.driver-profile', compact('driver', 'averageRating', 'totalReviews', 'passenger'));
            
        } catch (\Exception $e) {
            Log::error('Error loading driver profile: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Driver profile not found.');
        }
    }
}