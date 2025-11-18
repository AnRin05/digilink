<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use App\Models\Passenger;
use App\Models\Driver;
use App\Models\Booking;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\DriverApprovedNotification;
use App\Notifications\DriverRejectedNotification;

class AdminController extends Controller
{
                                        // Show admin dashboard
    public function dashboard()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login')->with('error', 'Please login as admin.');
        }

        $passengers = Passenger::all();
        $drivers = Driver::all();
        $pendingDrivers = Driver::where('is_approved', false)->get();

        $currentBookingsCount = Booking::whereIn('status', [
            Booking::STATUS_PENDING,
            Booking::STATUS_ACCEPTED,
            Booking::STATUS_IN_PROGRESS
        ])->count();

        $completedBookingsCount = Booking::where('status', Booking::STATUS_COMPLETED)->count();
        $cancelledBookingsCount = Booking::where('status', Booking::STATUS_CANCELLED)->count();

        $pendingBookingsCount = Booking::where('status', Booking::STATUS_PENDING)->count();
        $acceptedBookingsCount = Booking::where('status', Booking::STATUS_ACCEPTED)->count();
        $inProgressBookingsCount = Booking::where('status', Booking::STATUS_IN_PROGRESS)->count();
        

        return view('admin.dashboard', compact(
            'passengers',
            'drivers', 
            'pendingDrivers',
            'currentBookingsCount',
            'cancelledBookingsCount',
            'completedBookingsCount',
            'pendingBookingsCount',
            'acceptedBookingsCount',
            'inProgressBookingsCount'
        ));
    }

                                        // Show all passengers
    public function passengers()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login')->with('error', 'Please login as admin.');
        }

        $passengers = Passenger::latest()->get();
        return view('admin.passengers', compact('passengers'));
    }

                                        // Show passenger details
    public function showPassenger($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login')->with('error', 'Please login as admin.');
        }

        $passenger = Passenger::findOrFail($id);
        return view('admin.passenger-show', compact('passenger'));
    }

                                        // Show all drivers
    public function drivers()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login')->with('error', 'Please login as admin.');
        }

        $drivers = Driver::latest()->get();
        return view('admin.drivers', compact('drivers'));
    }

                                        // Show driver details
    public function showDriver($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login')->with('error', 'Please login as admin.');
        }

        $driver = Driver::findOrFail($id);
        return view('admin.driver-show', compact('driver'));
    }

                                        // Approve driver
    public function approveDriver($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login')->with('error', 'Please login as admin.');
        }

        try {
            $driver = Driver::findOrFail($id);
            
            // Update driver status
            $driver->update([
                'is_approved' => true,
                'approved_at' => now()
            ]);
            
            // Send approval notification with error handling
            try {
                $driver->notify(new DriverApprovedNotification());
                $emailStatus = 'Notification email sent.';
            } catch (\Exception $e) {
                Log::error('Failed to send approval email to driver: ' . $e->getMessage());
                $emailStatus = 'Driver approved but email notification failed.';
            }
            
            return redirect()->route('admin.drivers')->with('success', 'Driver approved successfully! ' . $emailStatus);
            
        } catch (\Exception $e) {
            Log::error('Error approving driver: ' . $e->getMessage());
            return redirect()->route('admin.drivers')->with('error', 'Error approving driver: ' . $e->getMessage());
        }
    }

                                        // Reject driver with email error handling
    public function rejectDriver($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login')->with('error', 'Please login as admin.');
        }

        try {
            $driver = Driver::findOrFail($id);
            
            // Send rejection notification with error handling
            try {
                $driver->notify(new DriverRejectedNotification());
                $emailStatus = 'Notification email sent.';
            } catch (\Exception $e) {
                Log::error('Failed to send rejection email to driver: ' . $e->getMessage());
                $emailStatus = 'Driver rejected but email notification failed.';
            }
            
            // Update driver status (you might want to delete or keep as rejected)
            $driver->update(['is_approved' => false]);
            
            return redirect()->route('admin.drivers')->with('success', 'Driver rejected successfully! ' . $emailStatus);
            
        } catch (\Exception $e) {
            Log::error('Error rejecting driver: ' . $e->getMessage());
            return redirect()->route('admin.drivers')->with('error', 'Error rejecting driver: ' . $e->getMessage());
        }
    }

                                        // Delete passenger
    public function deletePassenger($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login')->with('error', 'Please login as admin.');
        }

        $passenger = Passenger::findOrFail($id);
        $passenger->delete();

        return redirect()->route('admin.passengers')->with('success', 'Passenger deleted successfully!');
    }

                                        // Delete driver
    public function deleteDriver($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login')->with('error', 'Please login as admin.');
        }

        $driver = Driver::findOrFail($id);
        $driver->delete();

        return redirect()->route('admin.drivers')->with('success', 'Driver deleted successfully!');
    }



    public function analytics()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login')->with('error', 'Please login as admin.');
        }

        // Date ranges
        $today = now()->today();
        $weekStart = now()->startOfWeek();
        $monthStart = now()->startOfMonth();

        // Graph 1: Bookings by status for today, this week, this month
        $bookingsData = [
            'today' => [
                'pending' => Booking::whereDate('created_at', $today)
                    ->where('status', Booking::STATUS_PENDING)->count(),
                'accepted' => Booking::whereDate('created_at', $today)
                    ->where('status', Booking::STATUS_ACCEPTED)->count(),
                'in_progress' => Booking::whereDate('created_at', $today)
                    ->where('status', Booking::STATUS_IN_PROGRESS)->count(),
                'completed' => Booking::whereDate('created_at', $today)
                    ->where('status', Booking::STATUS_COMPLETED)->count(),
                'cancelled' => Booking::whereDate('created_at', $today)
                    ->where('status', Booking::STATUS_CANCELLED)->count(),
            ],
            'this_week' => [
                'pending' => Booking::whereBetween('created_at', [$weekStart, now()])
                    ->where('status', Booking::STATUS_PENDING)->count(),
                'accepted' => Booking::whereBetween('created_at', [$weekStart, now()])
                    ->where('status', Booking::STATUS_ACCEPTED)->count(),
                'in_progress' => Booking::whereBetween('created_at', [$weekStart, now()])
                    ->where('status', Booking::STATUS_IN_PROGRESS)->count(),
                'completed' => Booking::whereBetween('created_at', [$weekStart, now()])
                    ->where('status', Booking::STATUS_COMPLETED)->count(),
                'cancelled' => Booking::whereBetween('created_at', [$weekStart, now()])
                    ->where('status', Booking::STATUS_CANCELLED)->count(),
            ],
            'this_month' => [
                'pending' => Booking::whereBetween('created_at', [$monthStart, now()])
                    ->where('status', Booking::STATUS_PENDING)->count(),
                'accepted' => Booking::whereBetween('created_at', [$monthStart, now()])
                    ->where('status', Booking::STATUS_ACCEPTED)->count(),
                'in_progress' => Booking::whereBetween('created_at', [$monthStart, now()])
                    ->where('status', Booking::STATUS_IN_PROGRESS)->count(),
                'completed' => Booking::whereBetween('created_at', [$monthStart, now()])
                    ->where('status', Booking::STATUS_COMPLETED)->count(),
                'cancelled' => Booking::whereBetween('created_at', [$monthStart, now()])
                    ->where('status', Booking::STATUS_CANCELLED)->count(),
            ]
        ];

        // Graph 2: Account creation stats
        $accountCreationData = [
            'today' => [
                'passengers' => Passenger::whereDate('created_at', $today)->count(),
                'drivers' => Driver::whereDate('created_at', $today)->count(),
            ],
            'this_week' => [
                'passengers' => Passenger::whereBetween('created_at', [$weekStart, now()])->count(),
            'drivers' => Driver::whereBetween('created_at', [$weekStart, now()])->count(),
            ],
            'this_month' => [
                'passengers' => Passenger::whereBetween('created_at', [$monthStart, now()])->count(),
                'drivers' => Driver::whereBetween('created_at', [$monthStart, now()])->count(),
            ]
        ];

        $serviceTypeData = [
            'ride' => Booking::where('serviceType', Booking::SERVICE_BOOKING_TO_GO)->count(),
            'delivery' => Booking::where('serviceType', Booking::SERVICE_FOR_DELIVERY)->count(),
        ];

        $totalBookings = $serviceTypeData['ride'] + $serviceTypeData['delivery'];
        

        $serviceTypePercentages = [
            'ride' => $totalBookings > 0 ? round(($serviceTypeData['ride'] / $totalBookings) * 100, 1) : 0,
            'delivery' => $totalBookings > 0 ? round(($serviceTypeData['delivery'] / $totalBookings) * 100, 1) : 0,
        ];

        return view('admin.analytics', compact(
            'bookingsData',
            'accountCreationData',
            'serviceTypeData',
            'serviceTypePercentages'
        ));
    }

    public function currentBookings()
    {
        $currentBookings = Booking::whereIn('status', [
            Booking::STATUS_PENDING,
            Booking::STATUS_ACCEPTED,
            Booking::STATUS_IN_PROGRESS
        ])->get();
        
        return view('admin.bookings-current', compact('currentBookings'));
    }

    public function completedBookings()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login')->with('error', 'Please login as admin.');
        }

        $completedBookings = Booking::with(['passenger', 'driver'])
            ->where('status', Booking::STATUS_COMPLETED)
            ->latest()
            ->get();
        
        return view('admin.bookings-completed', compact('completedBookings'));
    }

    public function cancelledBookings()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login')->with('error', 'Please login as admin.');
        }

        $cancelledBookings = Booking::with(['passenger', 'driver'])
            ->where('status', Booking::STATUS_CANCELLED)
            ->latest()
            ->get();
        
        return view('admin.bookings-cancelled', compact('cancelledBookings'));
    }


public function reports()
{
    if (!Auth::guard('admin')->check()) {
        return redirect()->route('login')->with('error', 'Please login as admin.');
    }

    try {
        // Get all passengers
        $passengers = Passenger::latest()->get();
        
        // Get all drivers
        $drivers = Driver::latest()->get();

        // Manually count ongoing bookings for each passenger
        foreach ($passengers as $passenger) {
            $passenger->ongoing_bookings_count = Booking::where('passengerID', $passenger->id)
                ->whereIn('status', [
                    Booking::STATUS_IN_PROGRESS
                ])->count();
            
            // Count completed bookings
            $passenger->completed_bookings_count = Booking::where('passengerID', $passenger->id)
                ->where('status', Booking::STATUS_COMPLETED)->count();
            
            // Count cancelled bookings
            $passenger->cancelled_bookings_count = Booking::where('passengerID', $passenger->id)
                ->where('status', Booking::STATUS_CANCELLED)->count();
        }

        // Manually count ongoing bookings for each driver
        foreach ($drivers as $driver) {
            $driver->ongoing_bookings_count = Booking::where('driverID', $driver->id)
                ->whereIn('status', [
                    Booking::STATUS_PENDING,
                    Booking::STATUS_ACCEPTED,
                    Booking::STATUS_IN_PROGRESS
                ])->count();
            
            // Count completed bookings
            $driver->completed_bookings_count = Booking::where('driverID', $driver->id)
                ->where('status', Booking::STATUS_COMPLETED)->count();
            
            // Count cancelled bookings
            $driver->cancelled_bookings_count = Booking::where('driverID', $driver->id)
                ->where('status', Booking::STATUS_CANCELLED)->count();
        }

        return view('admin.reports', compact('passengers', 'drivers'));

    } catch (\Exception $e) {
        Log::error('Error loading reports: ' . $e->getMessage());
        return redirect()->route('admin.dashboard')->with('error', 'Error loading reports: ' . $e->getMessage());
    }
}

public function viewOngoingBookings($type, $id)
{
    if (!Auth::guard('admin')->check()) {
        return redirect()->route('login')->with('error', 'Please login as admin.');
    }

    try {
        $ongoingBookings = Booking::whereIn('status', [
            Booking::STATUS_IN_PROGRESS
        ]);

        if ($type === 'passenger') {
            $user = Passenger::findOrFail($id);
            $ongoingBookings->where('passengerID', $id);
            $title = "Ongoing Bookings - {$user->fullname}";
        } else {
            $user = Driver::findOrFail($id);
            $ongoingBookings->where('driverID', $id);
            $title = "Assigned Bookings - {$user->fullname}";
        }

        $ongoingBookings = $ongoingBookings->latest()->get();

        return view('admin.ongoing-bookings', compact('ongoingBookings', 'title', 'type', 'user'));

    } catch (\Exception $e) {
        Log::error('Error loading ongoing bookings: ' . $e->getMessage());
        return redirect()->route('admin.reports')->with('error', 'Error loading bookings: ' . $e->getMessage());
    }
}

public function viewCompletedBookings($type, $id)
{
    if (!Auth::guard('admin')->check()) {
        return redirect()->route('login')->with('error', 'Please login as admin.');
    }

    try {
        $completedBookings = Booking::where('status', Booking::STATUS_COMPLETED);

        if ($type === 'passenger') {
            $user = Passenger::findOrFail($id);
            $completedBookings->where('passengerID', $id);
            $title = "Completed Bookings - {$user->fullname}";
        } else {
            $user = Driver::findOrFail($id);
            $completedBookings->where('driverID', $id);
            $title = "Completed Bookings - {$user->fullname}";
        }

        $completedBookings = $completedBookings->latest()->get();

        // FIX: Remove 'status' from compact()
        return view('admin.view-completed-bookings', compact('completedBookings', 'title', 'type', 'user'));

    } catch (\Exception $e) {
        Log::error('Error loading completed bookings: ' . $e->getMessage());
        return redirect()->route('admin.reports')->with('error', 'Error loading completed bookings: ' . $e->getMessage());
    }
}

public function viewCancelledBookings($type, $id)
{
    if (!Auth::guard('admin')->check()) {
        return redirect()->route('login')->with('error', 'Please login as admin.');
    }

    try {
        $cancelledBookings = Booking::where('status', Booking::STATUS_CANCELLED);

        if ($type === 'passenger') {
            $user = Passenger::findOrFail($id);
            $cancelledBookings->where('passengerID', $id);
            $title = "Cancelled Bookings - {$user->fullname}";
        } else {
            $user = Driver::findOrFail($id);
            $cancelledBookings->where('driverID', $id);
            $title = "Cancelled Bookings - {$user->fullname}";
        }

        $cancelledBookings = $cancelledBookings->latest()->get();

        // FIX: Remove 'status' from compact()
        return view('admin.view-cancelled-bookings', compact('cancelledBookings', 'title', 'type', 'user'));

    } catch (\Exception $e) {
        Log::error('Error loading cancelled bookings: ' . $e->getMessage());
        return redirect()->route('admin.reports')->with('error', 'Error loading cancelled bookings: ' . $e->getMessage());
    }
}

    public function notifications()
    {
        return view('admin.notifications');
    }
    public function trackBooking($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login')->with('error', 'Please login as admin.');
        }

        try {
            $booking = Booking::with(['passenger', 'driver'])
                ->findOrFail($id);

            if (!in_array($booking->status, [
                Booking::STATUS_PENDING,
                Booking::STATUS_ACCEPTED,
                Booking::STATUS_IN_PROGRESS
            ])) {
                return redirect()->back()->with('error', 'This booking is not currently active.');
            }

            $title = "Tracking Booking #{$booking->bookingID}";

            return view('admin.booking-tracking', compact('booking', 'title'));

        } catch (\Exception $e) {
            Log::error('Error loading booking tracking: ' . $e->getMessage());
            return redirect()->route('admin.dashboard')->with('error', 'Error loading booking tracking: ' . $e->getMessage());
        }
    }

/**
 * Get driver location data for tracking
 */
public function getDriverLocation($id)
{
    // Check admin authentication
    if (!Auth::guard('admin')->check()) {
        return response()->json([
            'success' => false, 
            'message' => 'Authentication required. Please login as admin.'
        ], 401);
    }

    try {
        Log::info("Admin accessing driver location for booking: {$id}");

        $booking = Booking::with(['passenger', 'driver'])
            ->findOrFail($id);

        $driverData = null;
        $bookingData = null;
        $distanceInfo = null;

        // Prepare booking data
        $bookingData = [
            'id' => $booking->bookingID,
            'status' => $booking->status,
            'pickup_location' => $booking->pickupLocation,
            'dropoff_location' => $booking->dropoffLocation,
            'pickup_lat' => (float) $booking->pickupLatitude,
            'pickup_lng' => (float) $booking->pickupLongitude,
            'dropoff_lat' => (float) $booking->dropoffLatitude,
            'dropoff_lng' => (float) $booking->dropoffLongitude,
            'service_type' => $booking->getServiceTypeDisplay(),
            'fare' => '₱' . number_format((float) $booking->fare, 2),
            'created_at' => $booking->created_at->toISOString(),
            'passenger_name' => $booking->passenger->fullname ?? 'Unknown',
            'passenger_phone' => $booking->passenger->phone ?? 'N/A'
        ];

        // Prepare driver data if available
        if ($booking->driver) {
            $freshDriver = Driver::find($booking->driver->id);
            
            if ($freshDriver) {
                // Get driver coordinates with proper validation
                $driverLat = $freshDriver->current_lat;
                $driverLng = $freshDriver->current_lng;
                $isFallback = false;

                // Convert to float and validate
                if (is_string($driverLat)) $driverLat = (float) $driverLat;
                if (is_string($driverLng)) $driverLng = (float) $driverLng;

                // Check if coordinates are valid
                $hasValidCoordinates = $driverLat && $driverLng && 
                                     $driverLat != 0 && $driverLng != 0 &&
                                     $driverLat >= -90 && $driverLat <= 90 &&
                                     $driverLng >= -180 && $driverLng <= 180;

                if (!$hasValidCoordinates) {
                    // Use pickup location as fallback
                    $driverLat = (float) $booking->pickupLatitude;
                    $driverLng = (float) $booking->pickupLongitude;
                    $isFallback = true;
                }

                $driverData = [
                    'id' => $freshDriver->id,
                    'name' => $freshDriver->fullname,
                    'phone' => $freshDriver->phone,
                    'vehicle' => $freshDriver->vehicleMake . ' ' . $freshDriver->vehicleModel . ' (' . $freshDriver->plateNumber . ')',
                    'current_lat' => $driverLat,
                    'current_lng' => $driverLng,
                    'is_fallback' => $isFallback,
                    'location_updated' => $freshDriver->updated_at->toISOString(),
                    'availStatus' => (bool) $freshDriver->availStatus,
                    'currentLocation' => $freshDriver->currentLocation
                ];

                // Calculate distance information
                $distanceInfo = $this->calculateDistanceInfo($driverLat, $driverLng, $booking);
            }
        }

        $response = [
            'success' => true,
            'booking' => $bookingData,
            'driver' => $driverData,
            'distance_info' => $distanceInfo,
            'timestamp' => now()->toISOString()
        ];

        Log::info("Driver location data retrieved successfully", [
            'booking_id' => $booking->bookingID,
            'has_driver' => !is_null($driverData),
            'driver_coords' => $driverData ? [$driverData['current_lat'], $driverData['current_lng']] : null
        ]);

        return response()->json($response);

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        Log::error("Booking not found: {$id}");
        return response()->json([
            'success' => false,
            'message' => 'Booking not found.'
        ], 404);
    } catch (\Exception $e) {
        Log::error('Error getting driver location: ' . $e->getMessage(), [
            'booking_id' => $id,
            'exception' => $e
        ]);
        return response()->json([
            'success' => false,
            'message' => 'Error fetching tracking data: ' . $e->getMessage()
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

    /**
     * Calculate distance between two coordinates in kilometers using Haversine formula
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

    /**
     * Get all active bookings with markers for admin map view
     */
    public function getActiveBookingsMarkers()
    {
        if (!Auth::guard('admin')->check()) {
            return response()->json(['success' => false, 'message' => 'Not authenticated']);
        }

        try {
            $activeBookings = Booking::with(['passenger', 'driver'])
                ->whereIn('status', [
                    Booking::STATUS_PENDING,
                    Booking::STATUS_ACCEPTED,
                    Booking::STATUS_IN_PROGRESS
                ])
                ->get()
                ->map(function($booking) {
                    $driverMarker = null;
                    
                    if ($booking->driver && $booking->driver->current_lat && $booking->driver->current_lng) {
                        $driverMarker = [
                            'id' => 'driver-' . $booking->driver->id,
                            'type' => 'driver',
                            'lat' => (float) $booking->driver->current_lat,
                            'lng' => (float) $booking->driver->current_lng,
                            'name' => $booking->driver->fullname,
                            'vehicle' => $booking->driver->vehicleMake . ' ' . $booking->driver->vehicleModel,
                            'status' => $booking->status,
                            'booking_id' => $booking->bookingID
                        ];
                    }

                    return [
                        'booking_id' => $booking->bookingID,
                        'pickup_marker' => [
                            'id' => 'pickup-' . $booking->bookingID,
                            'type' => 'pickup',
                            'lat' => (float) $booking->pickupLatitude,
                            'lng' => (float) $booking->pickupLongitude,
                            'location' => $booking->pickupLocation,
                            'status' => $booking->status
                        ],
                        'dropoff_marker' => [
                            'id' => 'dropoff-' . $booking->bookingID,
                            'type' => 'dropoff',
                            'lat' => (float) $booking->dropoffLatitude,
                            'lng' => (float) $booking->dropoffLongitude,
                            'location' => $booking->dropoffLocation,
                            'status' => $booking->status
                        ],
                        'driver_marker' => $driverMarker,
                        'passenger_name' => $booking->passenger->fullname ?? 'Unknown',
                        'service_type' => $booking->getServiceTypeDisplay(),
                        'fare' => '₱' . number_format((float) $booking->fare, 2)
                    ];
                });

            return response()->json([
                'success' => true,
                'bookings' => $activeBookings,
                'count' => $activeBookings->count()
            ]);

        } catch (\Exception $e) {
            Log::error('Error getting active bookings markers: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error fetching booking markers'
            ], 500);
        }
    }

}