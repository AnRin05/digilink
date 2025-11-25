<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class DriverController extends Controller
{
    // Show driver signup form
    public function create()
    {
        return view('driversign');
    }

    // Handle driver signup
    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:drivers,email',
            'phone' => 'required|string|max:20',
            'licenseNumber' => 'required|string|max:50',
            'licenseExpiry' => 'required|date',
            'licensePhoto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'vehicleMake' => 'required|string|max:100',
            'vehicleModel' => 'required|string|max:100',
            'plateNumber' => 'required|string|max:20',
            'vehicleReg' => 'required|string|max:100',
            'orcrUpload' => 'required|file|mimes:pdf,jpeg,png,jpg|max:5120',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Handle file uploads
        $licensePhotoPath = $request->file('licensePhoto')->store('driver_documents', 'public');
        $orcrUploadPath = $request->file('orcrUpload')->store('driver_documents', 'public');
        
        // Handle profile image upload
        $profileImagePath = null;
        if ($request->hasFile('profile_image')) {
            $profileImagePath = $request->file('profile_image')->store('driver_profile_images', 'public');
        }

        $driver = Driver::create([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'phone' => $request->phone,
            'licenseNumber' => $request->licenseNumber,
            'licenseExpiry' => $request->licenseExpiry,
            'licensePhoto' => $licensePhotoPath,
            'vehicleMake' => $request->vehicleMake,
            'vehicleModel' => $request->vehicleModel,
            'plateNumber' => $request->plateNumber,
            'vehicleReg' => $request->vehicleReg,
            'orcrUpload' => $orcrUploadPath,
            'profile_image' => $profileImagePath,
            'password' => Hash::make($request->password),
            'serviceType' => 'Ride',
            'completedBooking' => 0,
            'availStatus' => false,
            'currentLocation' => 'all',
            'is_approved' => false,
        ]);
        
        Auth::guard('driver')->login($driver);
        return redirect()->route('driver.waiting')->with('success', 'Account created successfully! Waiting for admin approval.');
    }

    // Show driver waiting page
    public function waiting()
    {
        if (!Auth::guard('driver')->check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }
        return view('driver.waiting');
    }

    public function pending()
    {
        if (!Auth::guard('driver')->check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }
        return view('driver.pending');
    }

    // Show driver dashboard
    public function dashboard()
    {
        if (!Auth::guard('driver')->check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }
        
        $driver = Auth::guard('driver')->user();
        $acceptedBookings = Booking::where('driverID', $driver->id)
            ->where('status', 'accepted')
            ->with('passenger')
            ->latest()
            ->get();

        return view('driver.dashboard', compact('driver'));
    }

    // Show edit form
    public function edit()
    {
        if (!Auth::guard('driver')->check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }
        
        $driver = Auth::guard('driver')->user();
        $locations = Driver::getAvailableLocations();
        return view('driver.edit', compact('driver', 'locations'));
    }

    // Update driver info
    public function update(Request $request)
    {
        if (!Auth::guard('driver')->check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }
        
        $driver = Auth::guard('driver')->user();

        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:drivers,email,' . $driver->id,
            'phone' => 'required|string|max:20',
            'licenseNumber' => 'required|string|max:50',
            'licenseExpiry' => 'required|date',
            'licensePhoto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'vehicleMake' => 'required|string|max:100',
            'vehicleModel' => 'required|string|max:100',
            'plateNumber' => 'required|string|max:20',
            'vehicleReg' => 'required|string|max:100',
            'orcrUpload' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5120',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'currentLocation' => 'required|in:all,Anomar,Balibayon,Bonifacio,Cabongbongan,Cagniog,Canlanipa,Capalayan,Danao,Day-asan,Ipil,Lipata,Luna,Mabini,Mabua,Mapawa,Mat-i,Nabago,Orok,Poctoy,Quezon,Rizal,Sabang,San Isidro,San Juan,San Roque,Serna,Silop,Sukailang,Taft,Togbongon,Trinidad,Washington',
            'serviceType' => 'required|in:Ride,Delivery,Both',
            'availStatus' => 'sometimes|boolean',
        ]);

        $data = [
            'fullname' => $request->fullname,
            'email' => $request->email,
            'phone' => $request->phone,
            'licenseNumber' => $request->licenseNumber,
            'licenseExpiry' => $request->licenseExpiry,
            'vehicleMake' => $request->vehicleMake,
            'vehicleModel' => $request->vehicleModel,
            'plateNumber' => $request->plateNumber,
            'vehicleReg' => $request->vehicleReg,
            'currentLocation' => $request->currentLocation,
            'serviceType' => $request->serviceType,
        ];

        // Add availStatus if provided
        if ($request->has('availStatus')) {
            $data['availStatus'] = (bool)$request->availStatus;
        }

        // Update license photo if provided
        if ($request->hasFile('licensePhoto')) {
            if ($driver->licensePhoto) {
                Storage::disk('public')->delete($driver->licensePhoto);
            }
            $data['licensePhoto'] = $request->file('licensePhoto')->store('driver_documents', 'public');
        }

        // Update ORCR document if provided
        if ($request->hasFile('orcrUpload')) {
            if ($driver->orcrUpload) {
                Storage::disk('public')->delete($driver->orcrUpload);
            }
            $data['orcrUpload'] = $request->file('orcrUpload')->store('driver_documents', 'public');
        }

        // Update profile image if provided
        if ($request->hasFile('profile_image')) {
            if ($driver->profile_image) {
                Storage::disk('public')->delete($driver->profile_image);
            }
            $data['profile_image'] = $request->file('profile_image')->store('driver_profile_images', 'public');
        }

        /** @var \App\Models\driver $driver */
        $driver->update($data);

        return redirect()->route('driver.dashboard')->with('success', 'Profile updated successfully!');
    }

    // Update driver availability
    public function updateAvailability(Request $request)
    {
        if (!Auth::guard('driver')->check()) {
            return response()->json(['success' => false, 'message' => 'Not authenticated']);
        }
        
        $driver = Auth::guard('driver')->user();

        $request->validate([
            'availStatus' => 'required|boolean',
        ]);
        /** @var \App\Models\driver $driver */
        $driver->update(['availStatus' => (bool)$request->availStatus]);

        $status = $request->availStatus ? 'online' : 'offline';
        return response()->json(['success' => true, 'message' => "You are now {$status}!"]);
    }

    // Get booking statistics
    public function getBookingStats()
    {
        if (!Auth::guard('driver')->check()) {
            return response()->json(['success' => false]);
        }
        
        $driver = Auth::guard('driver')->user();
        
        // Calculate today's bookings and total earnings
        $todayBookings = 0; // You'll need to implement this logic
        $totalEarnings = '₱0.00'; // You'll need to implement this logic
        
        return response()->json([
            'success' => true,
            'today_bookings' => $todayBookings,
            'total_earnings' => $totalEarnings
        ]);
    }

    // Delete driver account
    public function destroy()
    {
        if (!Auth::guard('driver')->check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }
        
        $driver = Auth::guard('driver')->user();

        // Delete documents if they exist
        if ($driver->licensePhoto) {
            Storage::disk('public')->delete($driver->licensePhoto);
        }
        if ($driver->orcrUpload) {
            Storage::disk('public')->delete($driver->orcrUpload);
        }
        // Delete profile image if exists
        if ($driver->profile_image) {
            Storage::disk('public')->delete($driver->profile_image);
        }
        
        /** @var \App\Models\driver $driver */
        Auth::guard('driver')->logout();
        $driver->delete();

        return redirect()->route('home')->with('success', 'Account deleted successfully!');
    }

    public function getAvailableBookings(Request $request)
    {
        if (!Auth::guard('driver')->check()) {
            return response()->json(['success' => false, 'message' => 'Not authenticated']);
        }

        $driver = Auth::guard('driver')->user();

        if (!$driver->availStatus) {
            return response()->json([
                'success' => true,
                'bookings' => [],
                'count' => 0
            ]);
        }
        $bookings = Booking::where('status', 'pending')
            ->whereNull('driverID')
            ->with('passenger')
            ->latest()
            ->get()
            ->map(function($booking) {
                return [
                    'id' => $booking->bookingID,
                    'passenger_name' => $booking->passenger->fullname ?? 'Unknown Passenger',
                    'passenger_phone' => $booking->passenger->phone ?? 'N/A',
                    'passenger_avatar' => $booking->passenger->profile_image ? 
                        asset('storage/' . $booking->passenger->profile_image) : 
                        'https://ui-avatars.com/api/?name=' . urlencode($booking->passenger->fullname ?? 'Passenger') . '&background=random',
                    'pickup_location' => $booking->pickupLocation,
                    'dropoff_location' => $booking->dropoffLocation,
                    'fare' => '₱' . number_format($booking->fare, 2),
                    'service_type' => $booking->getServiceTypeDisplay(),
                    'service_type_raw' => $booking->serviceType,
                    'booking_type' => $booking->getBookingType(),
                    'booking_type_raw' => $booking->isScheduled() ? 'scheduled' : 'immediate',
                    'payment_method' => $booking->getPaymentMethodDisplay(),
                    'description' => $booking->description,
                    'schedule_time' => $booking->getFormattedScheduleTime(),
                    'created_at' => $booking->created_at->format('M j, Y g:i A')
                ];
            });

        return response()->json([
            'success' => true,
            'bookings' => $bookings,
            'count' => $bookings->count()
        ]);
        
    }

    public function getTodayStats()
    {
        if (!Auth::guard('driver')->check()) {
            return response()->json(['success' => false, 'message' => 'Not authenticated']);
        }

        $driver = Auth::guard('driver')->user();

        // Get all completed bookings for today
        $todayBookings = Booking::where('driverID', $driver->id)
            ->where('status', Booking::STATUS_COMPLETED)
            ->whereDate('updated_at', now()->toDateString())
            ->get();

        $todayRides = $todayBookings->count();
        $todayEarnings = $todayBookings->sum('fare');

        return response()->json([
            'success' => true,
            'today_rides' => $todayRides,
            'today_earnings' => number_format($todayEarnings, 2)
        ]);
    }


    public function updateCurrentLocation(Request $request)
    {
        if (!Auth::guard('driver')->check()) {
            return response()->json(['success' => false, 'message' => 'Not authenticated']);
        }

        $request->validate([
            'location' => 'required|string|max:255',
        ]);

        $driver = Auth::guard('driver')->user();
        /** @var \App\Models\driver $driver */
        $driver->update([
            'currentLocation' => $request->location,

        ]);

        return response()->json([
            'success' => true,
            'message' => 'Location updated successfully',
            'driver' => $driver
        ]);
    }

    public function getBookingDetails($id)
    {
        if (!Auth::guard('driver')->check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        $booking = Booking::with('passenger')->findOrFail($id);

        if ($booking->status !== 'pending') {
            return redirect()->route('driver.availableBookings')->with('error', 'This booking is no longer available.');
        }

        return view('driver.booking-details', compact('booking'));
    }

    public function acceptBooking($id)
    {
        if (!Auth::guard('driver')->check()) {
            return response()->json(['success' => false, 'message' => 'Not authenticated']);
        }

        try {
            $driver = Auth::guard('driver')->user();
            $booking = Booking::findOrFail($id);

            if ($booking->status !== 'pending') {
                return response()->json([
                    'success' => false, 
                    'message' => 'This booking is no longer available.'
                ]);
            }
            $booking->update([
                'driverID' => $driver->id,
                'status' => 'accepted'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Booking accepted successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error accepting booking: ' . $e->getMessage()
            ]);
        }
    }

    public function availableBookings()
    {
        if (!Auth::guard('driver')->check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }
        
        $driver = Auth::guard('driver')->user();
        return view('driver.available-bookings', compact('driver'));
    }

    public function getAcceptedBookings()
    {
        if (!Auth::guard('driver')->check()) {
            return response()->json(['success' => false, 'message' => 'Not authenticated']);
        }

        $driver = Auth::guard('driver')->user();

        $acceptedBookings = Booking::where('driverID', $driver->id)
            ->where('status', 'accepted')
            ->with('passenger')
            ->latest()
            ->get()
            ->map(function($booking) {
                return [
                    'id' => $booking->bookingID,
                    'passenger_name' => $booking->passenger->fullname ?? 'Unknown Passenger',
                    'passenger_phone' => $booking->passenger->phone ?? 'N/A',
                    'pickup_location' => $booking->pickupLocation,
                    'dropoff_location' => $booking->dropoffLocation,
                    'fare' => '₱' . number_format((float) $booking->fare, 2),
                    'schedule_time' => $booking->getFormattedScheduleTime(),
                    'service_type' => $booking->getServiceTypeDisplay(),
                    'created_at' => $booking->created_at->format('M j, Y g:i A')
                ];
            });

        return response()->json([
            'success' => true,
            'bookings' => $acceptedBookings,
            'count' => $acceptedBookings->count()
        ]);
    }

    public function canStartJob($id)
    {
        if (!Auth::guard('driver')->check()) {
            return response()->json(['success' => false, 'message' => 'Not authenticated']);
        }

        try {
            $driver = Auth::guard('driver')->user();
            $booking = Booking::findOrFail($id);

            if ($booking->driverID !== $driver->id || $booking->status !== 'accepted') {
                return response()->json([
                    'success' => false, 
                    'message' => 'You cannot start this job.'
                ]);
            }

            if ($booking->isScheduled()) {
                $scheduleDate = Carbon::parse($booking->scheduleTime)->startOfDay();
                $today = Carbon::today();
                
                if (!$scheduleDate->equalTo($today)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'You cannot start this job yet. Scheduled jobs can only be started on the scheduled date.',
                        'scheduled_date' => $booking->getFormattedScheduleTime()
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'can_start' => true
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error checking job: ' . $e->getMessage()
            ]);
        }
    }

    public function cancelAcceptedBooking($id)
    {
        if (!Auth::guard('driver')->check()) {
            return response()->json(['success' => false, 'message' => 'Not authenticated']);
        }

        try {
            $driver = Auth::guard('driver')->user();
            $booking = Booking::findOrFail($id);

            if ($booking->driverID !== $driver->id || $booking->status !== 'accepted') {
                return response()->json([
                    'success' => false, 
                    'message' => 'You cannot cancel this booking.'
                ]);
            }
            $booking->update([
                'driverID' => null,
                'status' => 'pending'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Booking cancelled successfully. It has been returned to available listings.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error cancelling booking: ' . $e->getMessage()
            ]);
        }
    }

    public function startJob($id)
    {
        if (!Auth::guard('driver')->check()) {
            return response()->json(['success' => false, 'message' => 'Not authenticated']);
        }

        try {
            $driver = Auth::guard('driver')->user();
            $booking = Booking::findOrFail($id);

            // Verify the booking belongs to this driver and is accepted
            if ($booking->driverID !== $driver->id || $booking->status !== 'accepted') {
                return response()->json([
                    'success' => false, 
                    'message' => 'You cannot start this job.'
                ]);
            }

            if ($booking->isScheduled()) {
                $scheduleDate = Carbon::parse($booking->scheduleTime)->startOfDay();
                $today = Carbon::today();
                
                if (!$scheduleDate->equalTo($today)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'You cannot start this job yet. Scheduled jobs can only be started on the scheduled date.',
                        'scheduled_date' => $booking->getFormattedScheduleTime()
                    ]);
                }
            }

            $booking->update([
                'status' => 'in_progress'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Job started successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error starting job: ' . $e->getMessage()
            ]);
        }
    }
    public function updateLocation(Request $request)
    {
        if (!Auth::guard('driver')->check()) {
            return response()->json(['success' => false, 'message' => 'Not authenticated']);
        }

        $driver = Auth::guard('driver')->user();

        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'booking_id' => 'required|exists:bookings,bookingID'
        ]);

        try {
            $latitude = (float) $request->latitude;
            $longitude = (float) $request->longitude;
            $accuracy = $request->accuracy ? (float) $request->accuracy : null;
            $source = $request->source ?? 'unknown';

            Log::info("Driver location update request", [
                'driver_id' => $driver->id,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'accuracy' => $accuracy,
                'source' => $source,
                'booking_id' => $request->booking_id
            ]);

            // Validate coordinates are reasonable (not in middle of ocean, etc.)
            if (!$this->areValidCoordinates($latitude, $longitude)) {
                Log::warning("Invalid coordinates received", [
                    'driver_id' => $driver->id,
                    'latitude' => $latitude,
                    'longitude' => $longitude
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid coordinates provided'
                ], 400);
            }

            $updateData = [
                'current_lat' => $latitude,
                'current_lng' => $longitude
            ];

            // Only update location name if coordinates changed significantly
            $oldLat = $driver->current_lat;
            $oldLng = $driver->current_lng;
            
            if ($oldLat && $oldLng) {
                $distance = $this->calculateDistance($oldLat, $oldLng, $latitude, $longitude);
                if ($distance > 1.0) { // If moved more than 1km, consider location changed
                    $locationName = $this->getLocationName($latitude, $longitude);
                    if ($locationName) {
                        $updateData['currentLocation'] = $locationName;
                    }
                }
            }
             /** @var \App\Models\driver $driver */
            $driver->update($updateData);

            $driver->refresh();

            Log::info("Driver location updated successfully", [
                'driver_id' => $driver->id,
                'old_lat' => $oldLat,
                'old_lng' => $oldLng,
                'new_lat' => $driver->current_lat,
                'new_lng' => $driver->current_lng,
                'location_name' => $driver->currentLocation,
                'source' => $source
            ]);

            $this->broadcastLocationUpdate($request->booking_id, $latitude, $longitude);

            return response()->json([
                'success' => true,
                'message' => 'Location updated successfully',
                'location' => [
                    'lat' => (float) $driver->current_lat,
                    'lng' => (float) $driver->current_lng,
                    'location_name' => $driver->currentLocation
                ],
                'timestamp' => now()->toISOString()
            ]);

        } catch (\Exception $e) {
            Log::error('Error updating driver location: ' . $e->getMessage(), [
                'driver_id' => $driver->id ?? 'unknown',
                'latitude' => $request->latitude ?? 'unknown',
                'longitude' => $request->longitude ?? 'unknown'
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update location: ' . $e->getMessage()
            ], 500);
        }
    }

    private function areValidCoordinates($latitude, $longitude)
    {
        if (abs($latitude) > 90 || abs($longitude) > 180) {
            return false;
        }

        if ($latitude == 0 && $longitude == 0) {
            return false;
        }
        
        return true;
    }

    /**
     * Calculate distance between two coordinates in kilometers
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // Earth's radius in kilometers

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat/2) * sin($dLat/2) + 
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * 
             sin($dLon/2) * sin($dLon/2);
             
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        
        return $earthRadius * $c;
    }

    private function getLocationName($latitude, $longitude)
    {

        $locations = Driver::getAvailableLocations();

        return 'Lipata';
    }

    public function jobTracking($id)
    {
        if (!Auth::guard('driver')->check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        $driver = Auth::guard('driver')->user();
        $booking = Booking::with('passenger')->findOrFail($id);

        // Verify the booking belongs to this driver and is active
        if ($booking->driverID !== $driver->id || !in_array($booking->status, ['accepted', 'in_progress'])) {
            return redirect()->route('driver.dashboard')->with('error', 'Invalid job access.');
        }

        return view('driver.job-tracking', compact('booking', 'driver'));
    }

    private function broadcastLocationUpdate($bookingId, $lat, $lng)
    {
        try {
            Log::info("Driver location updated for booking {$bookingId}: {$lat}, {$lng}");
            
            
        } catch (\Exception $e) {
            Log::error('Error broadcasting location update: ' . $e->getMessage());
        }
    }
    
    // Complete job method
    public function confirmCompletion($id)
    {
        if (!Auth::guard('driver')->check()) {
            return response()->json(['success' => false, 'message' => 'Not authenticated']);
        }

        try {
            $driver = Auth::guard('driver')->user();
            $booking = Booking::findOrFail($id);

            if ($booking->driverID !== $driver->id || $booking->status !== 'in_progress') {
                return response()->json([
                    'success' => false, 
                    'message' => 'You cannot complete this job.'
                ]);
            }

            // Mark driver completion
            $booking->markDriverCompleted();

            $message = 'Completion confirmed! ';
            if ($booking->isBothCompleted()) {
                $message .= 'Trip completed successfully! Earnings updated.';
            } else {
                $message .= 'Waiting for passenger confirmation...';
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'completion_status' => $booking->getCompletionStatus(),
                'is_completed' => $booking->isBothCompleted()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error confirming completion: ' . $e->getMessage()
            ]);
        }
    }

    public function getBookingStatus($id)
    {
        if (!Auth::guard('driver')->check()) {
            return response()->json(['success' => false, 'message' => 'Not authenticated']);
        }

        try {
            $driver = Auth::guard('driver')->user();
            $booking = Booking::findOrFail($id);

            if ($booking->driverID !== $driver->id) {
                return response()->json([
                    'success' => false, 
                    'message' => 'You cannot access this booking.'
                ]);
            }

            return response()->json([
                'success' => true,
                'booking' => [
                    'id' => $booking->bookingID,
                    'status' => $booking->status,
                    'driver_completed_at' => $booking->driver_completed_at,
                    'passenger_completed_at' => $booking->passenger_completed_at,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching booking status: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get driver notifications
     */
    public function getNotifications()
    {
        if (!Auth::guard('driver')->check()) {
            return response()->json(['success' => false, 'message' => 'Not authenticated']);
        }

        $driver = Auth::guard('driver')->user();
        
        $notifications = \App\Models\DriverNotification::where('driver_id', $driver->id)
            ->whereNull('read_at')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($notification) {
                return [
                    'id' => $notification->id,
                    'type' => $notification->type,
                    'title' => $notification->title,
                    'message' => $notification->message,
                    'data' => $notification->data,
                    'read_at' => $notification->read_at,
                    'created_at' => $notification->created_at->toISOString()
                ];
            });

        return response()->json([
            'success' => true,
            'notifications' => $notifications
        ]);
    }

    /**
     * Mark notification as read
     */
    public function markNotificationAsRead($id)
    {
        if (!Auth::guard('driver')->check()) {
            return response()->json(['success' => false, 'message' => 'Not authenticated']);
        }

        try {
            $driver = Auth::guard('driver')->user();
            $notification = \App\Models\DriverNotification::where('id', $id)
                ->where('driver_id', $driver->id)
                ->firstOrFail();

            $notification->markAsRead();

            return response()->json([
                'success' => true,
                'message' => 'Notification marked as read'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error marking notification as read: ' . $e->getMessage()
            ]);
        }
    }
public function seeRating()
{
    if (!Auth::guard('driver')->check()) {
        return redirect()->route('login')->with('error', 'Please login first.');
    }
    
    $driver = Auth::guard('driver')->user();
    
    // Use the accessors for average rating and total reviews
    $averageRating = $driver->average_rating;
    $totalReviews = $driver->total_reviews;
    
    // Get reviews with proper relationships and error handling
    try {
        $reviews = Review::where('driver_id', $driver->id)
            ->with([
                'passenger', 
                'booking' => function($query) {
                    $query->select('bookingID', 'driver_completed_at', 'passenger_completed_at');
                }
            ])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($review) {
                // Debug info
                Log::info('Review data:', [
                    'review_id' => $review->id,
                    'passenger' => $review->passenger ? $review->passenger->toArray() : 'No passenger',
                    'booking' => $review->booking ? $review->booking->toArray() : 'No booking'
                ]);

                return [
                    'id' => $review->id,
                    'rating' => $review->rating,
                    'passenger_name' => $review->passenger->fullname ?? 'Unknown Passenger',
                    'booking_id' => $review->booking->bookingID ?? 'N/A',
                    'booking_date' => $this->getBookingDate($review),
                    'profile_image' => $review->passenger->profile_image ?? null,
                    'comment' => $review->comment ?? null
                ];
            });

    } catch (\Exception $e) {
        Log::error('Error loading reviews in seeRating: ' . $e->getMessage());
        $reviews = collect(); // Empty collection if there's an error
    }

    // Debug output
    Log::info('Final reviews data:', [
        'driver_id' => $driver->id,
        'average_rating' => $averageRating,
        'total_reviews' => $totalReviews,
        'reviews_count' => $reviews->count(),
        'reviews' => $reviews->toArray()
    ]);

    return view('driver.rating', compact('driver', 'averageRating', 'totalReviews', 'reviews'));
}

// Helper method to get booking date
private function getBookingDate($review)
{
    if ($review->booking) {
        if ($review->booking->driver_completed_at) {
            return $review->booking->driver_completed_at->format('M d, Y');
        } elseif ($review->booking->passenger_completed_at) {
            return $review->booking->passenger_completed_at->format('M d, Y');
        } else {
            return $review->created_at->format('M d, Y');
        }
    }
    return $review->created_at->format('M d, Y');
}
    public function getRatings()
    {
        if (!Auth::guard('driver')->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $driver = Auth::guard('driver')->user();
        
        $reviews = Review::where('driver_id', $driver->id)
            ->with(['passenger', 'booking'])
            ->orderBy('driver_completed_at', 'desc')
            ->get()
            ->map(function($review) {
                return [
                    'rating' => $review->rating,
                    'passenger_name' => $review->passenger->fullname ?? 'Unknown',
                    'booking_id' => $review->booking->booking_id,
                    'booking_date' => $review->booking->driver_completed_at->format('M d, Y') ?? 'N/A',
                ];
            });
        
        $averageRating = $driver->average_rating;
        $totalReviews = $driver->total_reviews;
        
        return response()->json([
            'average_rating' => $averageRating,
            'total_reviews' => $totalReviews,
            'reviews' => $reviews
        ]);
    }
    
}