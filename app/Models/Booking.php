<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    // Primary key
    protected $primaryKey = 'bookingID';
    public $incrementing = true;
    protected $keyType = 'int';

    // Mass assignable fields
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
        'driver_completed_at',
        'passenger_completed_at',
        'completion_verified',
    ];

    // Attribute casting
    protected $casts = [
        'fare'             => 'decimal:2',
        'pickupLatitude'   => 'decimal:8',
        'pickupLongitude'  => 'decimal:8',
        'dropoffLatitude'  => 'decimal:8',
        'dropoffLongitude' => 'decimal:8',
        'timeStamp'        => 'datetime',
        'scheduleTime'     => 'datetime',
        'driver_completed_at' => 'datetime',
        'passenger_completed_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function passenger()
    {
        return $this->belongsTo(Passenger::class, 'passengerID');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driverID');
    }

    /*
    |--------------------------------------------------------------------------
    | Status Constants
    |--------------------------------------------------------------------------
    */
    const STATUS_PENDING     = 'pending';
    const STATUS_ACCEPTED    = 'accepted';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_COMPLETED   = 'completed';
    const STATUS_CANCELLED   = 'cancelled';

        /*
    |--------------------------------------------------------------------------
    | Completion Verification Constants
    |--------------------------------------------------------------------------
    */
    const VERIFICATION_PENDING = 'pending';
    const VERIFICATION_DRIVER_CONFIRMED = 'driver_confirmed';
    const VERIFICATION_PASSENGER_CONFIRMED = 'passenger_confirmed';
    const VERIFICATION_BOTH_CONFIRMED = 'both_confirmed';

    /*
    |--------------------------------------------------------------------------
    | Service Type Constants
    |--------------------------------------------------------------------------
    */
    const SERVICE_BOOKING_TO_GO = 'booking_to_go';
    const SERVICE_FOR_DELIVERY  = 'for_delivery';

    /*
    |--------------------------------------------------------------------------
    | Payment Method Constants
    |--------------------------------------------------------------------------
    */
    const PAYMENT_CASH  = 'cash';
    const PAYMENT_GCASH = 'gcash';

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */
    public function scopeAvailable($query)
    {
        return $query->where('status', self::STATUS_PENDING)
                     ->whereNull('driverID');
    }

    public function scopeImmediate($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('scheduleTime')
              ->orWhere('scheduleTime', '<=', now());
        });
    }

    public function scopeScheduled($query)
    {
        return $query->whereNotNull('scheduleTime')
                     ->where('scheduleTime', '>', now());
    }

    public function scopeForDriver($query, $driverId)
    {
        return $query->where('driverID', $driverId);
    }

    public function scopeForPassenger($query, $passengerId)
    {
        return $query->where('passengerID', $passengerId);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    public function cancelAndRelease()
    {
        $this->driverID = null;
        $this->status = self::STATUS_PENDING;
        return $this->save();
    }

    /*
    |--------------------------------------------------------------------------
    | Business Logic Helpers
    |--------------------------------------------------------------------------
    */
    public function isAvailable()
    {
        return $this->status === self::STATUS_PENDING && is_null($this->driverID);
    }

    public function isScheduled()
    {
        return !is_null($this->scheduleTime) && $this->scheduleTime->isFuture();
    }

    public function isImmediate()
    {
        return is_null($this->scheduleTime) || $this->scheduleTime->isPast();
    }

    public function accept($driverId)
    {
        $this->driverID = $driverId;
        $this->status = self::STATUS_ACCEPTED;
        return $this->save();
    }

    public function startRide()
    {
        $this->status = self::STATUS_IN_PROGRESS;
        return $this->save();
    }

    public function completeRide()
    {
        $this->status = self::STATUS_COMPLETED;

        if ($this->driver) {
            $this->driver->increment('completedBooking');
        }

        return $this->save();
    }

    public function markAsCompleted()
    {
        $this->update([
            'status' => self::STATUS_COMPLETED,
            'driver_completed_at' => now(),
            'completion_verified' => self::VERIFICATION_BOTH_CONFIRMED
        ]);

        if ($this->driver) {
            $this->driver->increment('completedBooking');
        }

        return $this;
    }

    public function cancel()
    {
        $this->status = self::STATUS_CANCELLED;
        return $this->save();
    }

        /*
    |--------------------------------------------------------------------------
    | Completion Verification Methods
    |--------------------------------------------------------------------------
    */
    public function markDriverCompleted()
    {
        $this->update([
            'driver_completed_at' => now(),
            'completion_verified' => $this->passenger_completed_at 
                ? self::VERIFICATION_BOTH_CONFIRMED 
                : self::VERIFICATION_DRIVER_CONFIRMED
        ]);

        // If both confirmed, complete the booking
        if ($this->completion_verified === self::VERIFICATION_BOTH_CONFIRMED) {
            $this->completeBooking();
        }
    }

    public function markPassengerCompleted()
    {
        $this->update([
            'passenger_completed_at' => now(),
            'completion_verified' => $this->driver_completed_at 
                ? self::VERIFICATION_BOTH_CONFIRMED 
                : self::VERIFICATION_PASSENGER_CONFIRMED
        ]);

        // If both confirmed, complete the booking
        if ($this->completion_verified === self::VERIFICATION_BOTH_CONFIRMED) {
            $this->completeBooking();
        }
    }

    public function completeBooking()
    {
        $this->status = self::STATUS_COMPLETED;
        $this->save();

        // Increment driver's completed bookings count
        if ($this->driver) {
            $this->driver->incrementCompletedBookings();
        }
    }

    public function getCompletionStatus()
    {
        if (!$this->driver_completed_at && !$this->passenger_completed_at) {
            return self::VERIFICATION_PENDING;
        } elseif ($this->driver_completed_at && !$this->passenger_completed_at) {
            return self::VERIFICATION_DRIVER_CONFIRMED;
        } elseif (!$this->driver_completed_at && $this->passenger_completed_at) {
            return self::VERIFICATION_PASSENGER_CONFIRMED;
        } else {
            return self::VERIFICATION_BOTH_CONFIRMED;
        }
    }

    public function isDriverCompleted()
    {
        return !is_null($this->driver_completed_at);
    }

    public function isPassengerCompleted()
    {
        return !is_null($this->passenger_completed_at);
    }

    public function isBothCompleted()
    {
        return $this->isDriverCompleted() && $this->isPassengerCompleted();
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */
    public function getFormattedFare()
    {
        return '₱' . number_format((float) $this->fare, 2);
    }

    public function getFormattedScheduleTime()
    {
        return $this->scheduleTime
            ? $this->scheduleTime->format('M d, Y h:i A')
            : 'Immediate';
    }

    public function getPaymentMethodDisplay()
    {
        return match ($this->paymentMethod) {
            self::PAYMENT_CASH  => 'Cash',
            self::PAYMENT_GCASH => 'GCash',
            default              => $this->paymentMethod,
        };
    }

    public function getServiceTypeDisplay()
    {
        return match ($this->serviceType) {
            self::SERVICE_BOOKING_TO_GO => 'Ride',
            self::SERVICE_FOR_DELIVERY  => 'Delivery',
            default                     => $this->serviceType,
        };
    }

    public function canBeCancelled()
    {
        return in_array($this->status, [self::STATUS_PENDING, self::STATUS_ACCEPTED]);
    }

    public function getBookingType()
    {
        return $this->isScheduled() ? 'Scheduled' : 'Immediate';
    }

       protected static function boot()
    {
        parent::boot();

        // Create history record when booking is completed or cancelled
        static::updated(function ($booking) {
            if ($booking->isDirty('status') && 
                in_array($booking->status, [self::STATUS_COMPLETED, self::STATUS_CANCELLED])) {
                $booking->createHistoryRecord();
            }
        });

        // Also create history record when booking is created (for immediate history tracking)
        static::created(function ($booking) {
            $booking->createHistoryRecord();
        });
    }

    /*
    |--------------------------------------------------------------------------
    | History Methods
    |--------------------------------------------------------------------------
    */
    public function createHistoryRecord()
    {
        BookingHistory::create([
            'booking_id' => $this->bookingID,
            'passenger_id' => $this->passengerID,
            'driver_id' => $this->driverID,
            'pickup_location' => $this->pickupLocation,
            'dropoff_location' => $this->dropoffLocation,
            'pickup_latitude' => $this->pickupLatitude,
            'pickup_longitude' => $this->pickupLongitude,
            'dropoff_latitude' => $this->dropoffLatitude,
            'dropoff_longitude' => $this->dropoffLongitude,
            'fare' => $this->fare,
            'status' => $this->status,
            'service_type' => $this->serviceType,
            'payment_method' => $this->paymentMethod,
            'description' => $this->description,
            'schedule_time' => $this->scheduleTime,
            'driver_completed_at' => $this->driver_completed_at,
            'passenger_completed_at' => $this->passenger_completed_at,
            'completion_verified' => $this->completion_verified,
        ]);
    }

    public function history()
    {
        return $this->hasOne(BookingHistory::class, 'booking_id', 'bookingID');
    }
}
