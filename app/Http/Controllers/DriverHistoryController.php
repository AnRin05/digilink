<?php

namespace App\Http\Controllers;

use App\Models\BookingHistory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DriverHistoryController extends Controller
{
    public function index()
    {
        return view('driver.history');
    }

    public function getHistory(Request $request): JsonResponse
    {
        try {
            $driverId = Auth::guard('driver')->id();
            
            if (!$driverId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Driver not authenticated'
                ], 401);
            }

            $status = $request->get('status', 'all');
            $serviceType = $request->get('service_type', 'all');
            $timePeriod = $request->get('time_period', 'all');

            $bookings = BookingHistory::where('driver_id', $driverId)
                ->visibleToDriver($driverId)
                ->serviceType($serviceType)
                ->timePeriod($timePeriod)
                ->when($status !== 'all', function ($query) use ($status) {
                    return $query->where('status', $status);
                })
                ->with('passenger')
                ->recentFirst()
                ->get();

            $transformedBookings = $bookings->map(function($booking) {
                $passengerInfo = $booking->passenger;
                
                return [
                    'history_id' => $booking->history_id,
                    'booking_id' => $booking->booking_id ?? 'N/A',
                    'pickup_location' => $booking->pickup_location ?? 'Pickup Location',
                    'dropoff_location' => $booking->dropoff_location ?? 'Dropoff Location',
                    'fare' => '₱' . number_format($booking->fare ?? 0, 2),
                    'status' => $booking->status ?? 'completed',
                    'status_display' => $booking->status_display,
                    'service_type' => $booking->service_type_display,
                    'service_type_raw' => $booking->service_type ?? 'booking_to_go',
                    'payment_method' => $booking->payment_method_display,
                    'payment_method_raw' => $booking->payment_method ?? 'cash',
                    'booking_type' => $booking->booking_type,
                    'created_at' => $booking->created_at ? $booking->created_at->format('M d, Y h:i A') : now()->format('M d, Y h:i A'),
                    'completed_at' => $booking->driver_completed_at ? $booking->driver_completed_at->format('M d, Y h:i A') : null,
                    
                    // Passenger information
                    'passenger_name' => $passengerInfo ? ($passengerInfo->fullname ?? $passengerInfo->name ?? 'Not assigned') : 'Not assigned',
                    'passenger_phone' => $passengerInfo ? ($passengerInfo->phone ?? 'N/A') : 'N/A',
                    'passenger_email' => $passengerInfo ? ($passengerInfo->email ?? 'N/A') : 'N/A',

                    // Deletion info (for admin purposes)
                    'is_deleted_by_driver' => $booking->is_deleted_by_driver,
                    'deleted_by_driver_at' => $booking->deleted_by_driver_at,
                ];
            });

            return response()->json([
                'success' => true,
                'bookings' => $transformedBookings,
                'total_count' => $bookings->count(),
                'filters' => [
                    'status' => $status,
                    'service_type' => $serviceType,
                    'time_period' => $timePeriod
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching driver history: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Server error while loading history'
            ], 500);
        }
    }

public function deleteFromHistory(Request $request, $id): JsonResponse
{
    try {
        $driverId = Auth::guard('driver')->id();
        
        if (!$driverId) {
            return response()->json([
                'success' => false,
                'message' => 'Driver not authenticated'
            ], 401);
        }

        $bookingHistory = BookingHistory::where('history_id', $id)
            ->where('driver_id', $driverId)
            ->first();

        if (!$bookingHistory) {
            return response()->json([
                'success' => false,
                'message' => 'Booking not found in your history'
            ], 404);
        }

        if ($bookingHistory->is_deleted_by_driver) {
            return response()->json([
                'success' => false,
                'message' => 'This booking has already been removed from your history'
            ], 400);
        }
        $bookingHistory->markAsDeletedByDriver('Uneeded');
        $bookingHistory->permanentDeleteIfOrphaned();

        return response()->json([
            'success' => true,
            'message' => 'Booking removed from your history successfully'
        ]);

    } catch (\Exception $e) {
        Log::error('Error soft-deleting driver booking history: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'Failed to remove booking from history. Please try again.'
        ], 500);
    }
}
    public function restoreHistory($id): JsonResponse
    {
        try {
            $driverId = Auth::guard('driver')->id();
            
            if (!$driverId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Driver not authenticated'
                ], 401);
            }

            $bookingHistory = BookingHistory::where('history_id', $id)
                ->where('driver_id', $driverId)
                ->first();

            if (!$bookingHistory) {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking not found'
                ], 404);
            }

            // Restore for driver
            $bookingHistory->restoreForDriver();

            Log::info("Driver {$driverId} restored booking history {$id}");

            return response()->json([
                'success' => true,
                'message' => 'Booking restored to your history successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Error restoring driver booking history: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to restore booking to history'
            ], 500);
        }
    }

    public function getDeletedHistory(): JsonResponse
    {
        try {
            $driverId = Auth::guard('driver')->id();
            
            if (!$driverId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Driver not authenticated'
                ], 401);
            }

            $deletedBookings = BookingHistory::where('driver_id', $driverId)
                ->where('is_deleted_by_driver', true)
                ->with('passenger')
                ->recentFirst()
                ->get();

            return response()->json([
                'success' => true,
                'deleted_bookings' => $deletedBookings,
                'total_deleted' => $deletedBookings->count()
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching deleted driver history: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load deleted history'
            ], 500);
        }
    }
}