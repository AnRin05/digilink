<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $primaryKey = 'bookingID';

    protected $fillable = [
        'passengerID',
        'driverID',
        'pickupLocation',
        'dropoffLocation',
        'status',
        'fare',
        'timeStamp',
        'pickupLatitude',
        'pickupLongitude',
        'dropoffLatitude',
        'dropoffLongitude',
        'serviceType',
        'description',
        'paymentMethod',
        'scheduleTime',
    ];

    protected $casts = [
        'fare' => 'decimal:2',
        'pickupLatitude' => 'decimal:8',
        'pickupLongitude' => 'decimal:8',
        'dropoffLatitude' => 'decimal:8',
        'dropoffLongitude' => 'decimal:8',
        'timeStamp' => 'datetime',
        'scheduleTime' => 'datetime',
    ];

    // Relationships
    public function passenger()
    {
        return $this->belongsTo(Passenger::class, 'passengerID');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driverID');
    }

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_ACCEPTED = 'accepted';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    // Service type constants
    const SERVICE_BOOKING_TO_GO = 'booking_to_go';
    const SERVICE_FOR_DELIVERY = 'for_delivery';

    // Payment method constants
    const PAYMENT_CASH = 'cash';
    const PAYMENT_GCASH = 'gcash';

    // Scope for available bookings (not assigned to any driver)
    public function scopeAvailable($query)
    {
        return $query->where('status', self::STATUS_PENDING)
                    ->whereNull('driverID');
    }

    // Scope for immediate bookings (not scheduled)
    public function scopeImmediate($query)
    {
        return $query->whereNull('scheduleTime')
                    ->orWhere('scheduleTime', '<=', now());
    }

    // Scope for scheduled bookings
    public function scopeScheduled($query)
    {
        return $query->whereNotNull('scheduleTime')
                    ->where('scheduleTime', '>', now());
    }

    // Scope for driver's bookings
    public function scopeForDriver($query, $driverId)
    {
        return $query->where('driverID', $driverId);
    }

    // Scope for passenger's bookings
    public function scopeForPassenger($query, $passengerId)
    {
        return $query->where('passengerID', $passengerId);
    }

    // Scope for today's bookings
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    // Check if booking is available for drivers to accept
    public function isAvailable()
    {
        return $this->status === self::STATUS_PENDING && is_null($this->driverID);
    }

    // Check if booking is scheduled
    public function isScheduled()
    {
        return !is_null($this->scheduleTime) && $this->scheduleTime->isFuture();
    }

    // Check if booking is immediate
    public function isImmediate()
    {
        return is_null($this->scheduleTime) || $this->scheduleTime->isPast();
    }

    // Accept booking by driver
    public function accept($driverId)
    {
        $this->driverID = $driverId;
        $this->status = self::STATUS_ACCEPTED;
        return $this->save();
    }

    // Start ride
    public function startRide()
    {
        $this->status = self::STATUS_IN_PROGRESS;
        return $this->save();
    }

    // Complete ride
    public function completeRide()
    {
        $this->status = self::STATUS_COMPLETED;
        
        // Increment driver's completed bookings count
        if ($this->driver) {
            $this->driver->increment('completedBooking');
        }
        
        return $this->save();
    }

    // Cancel booking
    public function cancel()
    {
        $this->status = self::STATUS_CANCELLED;
        return $this->save();
    }

    // Get status badge class
    public function getStatusBadgeClass()
    {
        switch ($this->status) {
            case self::STATUS_PENDING:
                return 'badge badge-warning';
            case self::STATUS_ACCEPTED:
                return 'badge badge-info';
            case self::STATUS_IN_PROGRESS:
                return 'badge badge-primary';
            case self::STATUS_COMPLETED:
                return 'badge badge-success';
            case self::STATUS_CANCELLED:
                return 'badge badge-danger';
            default:
                return 'badge badge-secondary';
        }
    }

    // Get formatted fare
    public function getFormattedFare()
    {
        return '₱' . number_format((float) $this->fare, 2);
    }

    // Get formatted schedule time
    public function getFormattedScheduleTime()
    {
        if ($this->scheduleTime) {
            return $this->scheduleTime->format('M d, Y h:i A');
        }
        return 'Immediate';
    }

    // Get payment method display name
    public function getPaymentMethodDisplay()
    {
        switch ($this->paymentMethod) {
            case self::PAYMENT_CASH:
                return 'Cash';
            case self::PAYMENT_GCASH:
                return 'GCash';
            default:
                return $this->paymentMethod;
        }
    }

    // Get service type display name
    public function getServiceTypeDisplay()
    {
        switch ($this->serviceType) {
            case self::SERVICE_BOOKING_TO_GO:
                return 'Ride';
            case self::SERVICE_FOR_DELIVERY:
                return 'Delivery';
            default:
                return $this->serviceType;
        }
    }

    // Check if booking can be cancelled
    public function canBeCancelled()
    {
        return in_array($this->status, [self::STATUS_PENDING, self::STATUS_ACCEPTED]);
    }

    // Get booking type (immediate or scheduled)
    public function getBookingType()
    {
        return $this->isScheduled() ? 'Scheduled' : 'Immediate';
    }
}