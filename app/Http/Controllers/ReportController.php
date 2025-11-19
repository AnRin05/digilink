<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Booking;
use App\Models\Driver;
use App\Models\Passenger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    public function sendUrgentHelp(Request $request)
    {
        try {
            $request->validate([
                'booking_id' => 'required|exists:bookings,bookingID',
                'additional_notes' => 'nullable|string|max:1000',
            ]);

            $booking = Booking::with(['passenger', 'driver'])->findOrFail($request->booking_id);

            $reporterType = 'passenger';
            $reporterId = Auth::guard('passenger')->id();
            
            if (Auth::guard('driver')->check()) {
                $reporterType = 'driver';
                $reporterId = Auth::guard('driver')->id();
            }

            $locationData = $this->collectLocationData($booking, $reporterType);
            $bookingData = $this->collectBookingData($booking);
            $driverData = $this->collectDriverData($booking);
            $passengerData = $this->collectPassengerData($booking);

            $description = $this->generateUrgentHelpDescription($booking, $reporterType, $request->additional_notes);

            $report = Report::create([
                'report_type' => Report::TYPE_URGENT_HELP,
                'description' => $description,
                'reporter_type' => $reporterType,
                'reporter_id' => $reporterId,
                'booking_id' => $booking->bookingID,
                'location_data' => $locationData,
                'booking_data' => $bookingData,
                'driver_data' => $driverData,
                'passenger_data' => $passengerData,
                'status' => Report::STATUS_PENDING,
            ]);

            Log::info("Urgent help report created", [
                'report_id' => $report->id,
                'booking_id' => $booking->bookingID,
                'reporter_type' => $reporterType
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Urgent help request sent to admin! Help is on the way.',
                'report_id' => $report->id
            ]);

        } catch (\Exception $e) {
            Log::error('Error sending urgent help: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to send urgent help request. Please try again.'
            ], 500);
        }
    }
    public function sendComplaint(Request $request)
    {
        try {
            $request->validate([
                'booking_id' => 'required|exists:bookings,bookingID',
                'complaint_type' => 'required|in:driver_behavior,service_issue,safety_concern,payment_issue,other',
                'description' => 'required|string|max:2000',
                'severity' => 'required|in:low,medium,high,critical',
            ]);

            $booking = Booking::with(['passenger', 'driver'])->findOrFail($request->booking_id);

            $reporterType = 'passenger';
            $reporterId = Auth::guard('passenger')->id();
            
            if (Auth::guard('driver')->check()) {
                $reporterType = 'driver';
                $reporterId = Auth::guard('driver')->id();
            }

            $locationData = $this->collectLocationData($booking, $reporterType);
            $bookingData = $this->collectBookingData($booking);
            $driverData = $this->collectDriverData($booking);
            $passengerData = $this->collectPassengerData($booking);

            $report = Report::create([
                'report_type' => Report::TYPE_COMPLAINT,
                'description' => $this->generateComplaintDescription($request, $booking, $reporterType),
                'reporter_type' => $reporterType,
                'reporter_id' => $reporterId,
                'booking_id' => $booking->bookingID,
                'location_data' => $locationData,
                'booking_data' => $bookingData,
                'driver_data' => $driverData,
                'passenger_data' => $passengerData,
                'status' => Report::STATUS_PENDING,
            ]);

            Log::info("Complaint report created", [
                'report_id' => $report->id,
                'booking_id' => $booking->bookingID,
                'complaint_type' => $request->complaint_type,
                'severity' => $request->severity
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Complaint submitted successfully. Admin will review it shortly.',
                'report_id' => $report->id
            ]);

        } catch (\Exception $e) {
            Log::error('Error sending complaint: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit complaint. Please try again.'
            ], 500);
        }
    }

    private function collectLocationData($booking, $reporterType)
    {
        $locationData = [
            'booking_pickup' => [
                'address' => $booking->pickupLocation,
                'latitude' => $booking->pickupLatitude,
                'longitude' => $booking->pickupLongitude,
            ],
            'booking_dropoff' => [
                'address' => $booking->dropoffLocation,
                'latitude' => $booking->dropoffLatitude,
                'longitude' => $booking->dropoffLongitude,
            ],
            'reported_at' => now()->toISOString(),
        ];
        if ($booking->driver && $booking->driver->current_lat) {
            $locationData['driver_current'] = [
                'latitude' => $booking->driver->current_lat,
                'longitude' => $booking->driver->current_lng,
                'location_name' => $booking->driver->currentLocation,
                'last_updated' => $booking->driver->updated_at->toISOString(),
            ];
        }

        if ($reporterType === 'passenger' && Auth::guard('passenger')->check()) {
            $passenger = Auth::guard('passenger')->user();
        }

        return $locationData;
    }

    private function collectBookingData($booking)
    {
        return [
            'booking_id' => $booking->bookingID,
            'status' => $booking->status,
            'service_type' => $booking->serviceType,
            'fare' => $booking->fare,
            'payment_method' => $booking->paymentMethod,
            'created_at' => $booking->created_at->toISOString(),
            'description' => $booking->description,
            'schedule_time' => $booking->scheduleTime?->toISOString(),
        ];
    }

    private function collectDriverData($booking)
    {
        if (!$booking->driver) {
            return null;
        }

        return [
            'id' => $booking->driver->id,
            'name' => $booking->driver->fullname,
            'email' => $booking->driver->email,
            'phone' => $booking->driver->phone,
            'vehicle' => $booking->driver->vehicleMake . ' ' . $booking->driver->vehicleModel,
            'plate_number' => $booking->driver->plateNumber,
            'current_location' => $booking->driver->currentLocation,
            'availability_status' => $booking->driver->availStatus,
            'completed_trips' => $booking->driver->completedBooking,
        ];
    }
    private function collectPassengerData($booking)
    {
        if (!$booking->passenger) {
            return null;
        }

        return [
            'id' => $booking->passenger->id,
            'name' => $booking->passenger->fullname,
            'email' => $booking->passenger->email,
            'phone' => $booking->passenger->phone,
        ];
    }

    /**
     * Generate automatic description for urgent help
     */
    private function generateUrgentHelpDescription($booking, $reporterType, $additionalNotes = null)
    {
        $baseDescription = "🚨 URGENT HELP REQUESTED\n";
        $baseDescription .= "Booking: {$booking->bookingID}\n";
        $baseDescription .= "Reporter: " . ($reporterType === 'passenger' ? 'Passenger' : 'Driver') . "\n";
        $baseDescription .= "Status: " . strtoupper($booking->status) . "\n";
        $baseDescription .= "Service: {$booking->getServiceTypeDisplay()}\n";
        
        if ($booking->driver) {
            $baseDescription .= "Driver: {$booking->driver->fullname} ({$booking->driver->phone})\n";
        }
        
        if ($booking->passenger) {
            $baseDescription .= "Passenger: {$booking->passenger->fullname} ({$booking->passenger->phone})\n";
        }

        $baseDescription .= "Pickup: {$booking->pickupLocation}\n";
        $baseDescription .= "Dropoff: {$booking->dropoffLocation}\n";
        
        if ($additionalNotes) {
            $baseDescription .= "\nAdditional Notes: {$additionalNotes}";
        }

        return $baseDescription;
    }

    private function generateComplaintDescription($request, $booking, $reporterType)
    {
        $complaintTypes = [
            'driver_behavior' => 'Driver Behavior Issue',
            'service_issue' => 'Service Quality Issue',
            'safety_concern' => 'Safety Concern',
            'payment_issue' => 'Payment Issue',
            'other' => 'Other Issue'
        ];

        $description = "📋 COMPLAINT REPORT\n";
        $description .= "Type: {$complaintTypes[$request->complaint_type]}\n";
        $description .= "Severity: " . strtoupper($request->severity) . "\n";
        $description .= "Booking: {$booking->bookingID}\n";
        $description .= "Reporter: " . ($reporterType === 'passenger' ? 'Passenger' : 'Driver') . "\n";
        
        if ($booking->driver) {
            $description .= "Driver: {$booking->driver->fullname}\n";
        }
        
        $description .= "\nDescription:\n{$request->description}";

        return $description;
    }
}