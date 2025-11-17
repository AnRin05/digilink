<?php

namespace App\Http\Controllers;

use App\Models\BookingHistory;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PassengerHistoryController extends Controller
{
    public function index()
    {
        return view('passenger.history');
    }

    public function getHistory()
    {
        try {
            $passengerId = Auth::guard('passenger')->id();
            
            Log::info('Fetching history for passenger ID: ' . $passengerId);
            
            if (!$passengerId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Passenger not authenticated'
                ], 401);
            }

            $bookings = BookingHistory::where('passenger_id', $passengerId)
                ->where('is_deleted_by_passenger', false)
                ->with('driver')
                ->orderBy('created_at', 'desc')
                ->get();

            Log::info('Found ' . $bookings->count() . ' bookings for passenger');

            // Transform bookings with driver info
            $transformedBookings = $bookings->map(function($booking) {
                $driverInfo = $booking->driver;
                
                return [
                    'history_id' => $booking->history_id,
                    'booking_id' => $booking->booking_id ?? 'N/A',
                    'pickup_location' => $booking->pickup_location ?? 'Pickup Location',
                    'dropoff_location' => $booking->dropoff_location ?? 'Dropoff Location',
                    'fare' => '₱' . number_format($booking->fare ?? 0, 2),
                    'status' => $booking->status ?? 'completed',
                    'status_display' => $this->getStatusDisplay($booking->status ?? 'completed'),
                    'service_type' => $this->getServiceTypeDisplay($booking->service_type ?? 'booking_to_go'),
                    'payment_method' => $this->getPaymentMethodDisplay($booking->payment_method ?? 'cash'),
                    'booking_type' => $this->getBookingType($booking),
                    'created_at' => $booking->created_at ? $booking->created_at->format('M d, Y h:i A') : now()->format('M d, Y h:i A'),
                    'completed_at' => $booking->driver_completed_at ? $booking->driver_completed_at->format('M d, Y h:i A') : null,
                    
                    // Driver information
                    'driver_name' => $driverInfo ? $driverInfo->fullname : 'Not assigned',
                    'driver_phone' => $driverInfo ? $driverInfo->phone : 'N/A',
                    'driver_email' => $driverInfo ? $driverInfo->email : 'N/A',
                    'driver_vehicle' => $driverInfo ? ($driverInfo->vehicleMake . ' ' . $driverInfo->vehicleModel) : 'N/A',
                    'driver_plate' => $driverInfo ? $driverInfo->plateNumber : 'N/A',
                ];
            });

            return response()->json([
                'success' => true,
                'bookings' => $transformedBookings
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching passenger history: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteFromHistory($id): JsonResponse
    {
        try {
            $passengerId = Auth::guard('passenger')->id();
            
            if (!$passengerId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Passenger not authenticated'
                ], 401);
            }

            $bookingHistory = BookingHistory::where('history_id', $id)
                ->where('passenger_id', $passengerId)
                ->first();

            if (!$bookingHistory) {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking not found in your history'
                ], 404);
            }

            // Check if already deleted
            if ($bookingHistory->is_deleted_by_passenger) {
                return response()->json([
                    'success' => false,
                    'message' => 'This booking has already been removed from your history'
                ], 400);
            }

            // Soft delete - mark as deleted by passenger
            $bookingHistory->update([
                'is_deleted_by_passenger' => true,
                'deleted_by_passenger_at' => now(),
                'deletion_reason' => 'Unneeded'
            ]);

            Log::info("Passenger {$passengerId} soft-deleted booking history {$id}");

            return response()->json([
                'success' => true,
                'message' => 'Booking removed from your history successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Error soft-deleting passenger booking history: ' . $e->getMessage(), [
                'history_id' => $id,
                'passenger_id' => $passengerId ?? 'unknown'
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove booking from history. Please try again.'
            ], 500);
        }
    }

    // Helper methods
    private function getStatusDisplay($status)
    {
        $statusMap = [
            'completed' => 'Completed',
            'cancelled' => 'Cancelled', 
            'accepted' => 'Accepted',
            'pending' => 'Pending',
            'ongoing' => 'On Going',
            'arrived' => 'Arrived',
            'picked_up' => 'Picked Up'
        ];
        
        return $statusMap[$status] ?? ucfirst(str_replace('_', ' ', $status));
    }

    private function getServiceTypeDisplay($serviceType)
    {
        $serviceMap = [
            'booking_to_go' => 'Ride Service',
            'for_delivery' => 'Delivery Service',
            'ride' => 'Ride Service',
            'delivery' => 'Delivery Service'
        ];
        
        return $serviceMap[$serviceType] ?? ucfirst(str_replace('_', ' ', $serviceType));
    }

    private function getPaymentMethodDisplay($paymentMethod)
    {
        $paymentMap = [
            'cash' => 'Cash',
            'gcash' => 'GCash',
        ];
        
        return $paymentMap[$paymentMethod] ?? ucfirst($paymentMethod);
    }

    private function getBookingType($booking)
    {
        if ($booking->schedule_time && $booking->schedule_time->isFuture()) {
            return 'Scheduled';
        }
        return 'Instant';
    }
}