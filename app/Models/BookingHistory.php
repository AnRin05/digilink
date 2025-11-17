<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingHistory extends Model
{
    use HasFactory;

    protected $primaryKey = 'history_id';
    protected $table = 'booking_history';

    protected $fillable = [
        'booking_id',
        'passenger_id', 
        'driver_id',
        'pickup_location',
        'dropoff_location',
        'pickup_latitude',
        'pickup_longitude',
        'dropoff_latitude',
        'dropoff_longitude',
        'fare',
        'status',
        'service_type',
        'payment_method',
        'description',
        'schedule_time',
        'driver_completed_at',
        'passenger_completed_at',
        'completion_verified',
        'is_deleted_by_passenger',
        'is_deleted_by_driver',
        'deleted_by_passenger_at',
        'deleted_by_driver_at',
        'deletion_reason',
    ];

    protected $casts = [
        'fare' => 'decimal:2',
        'pickup_latitude' => 'decimal:8',
        'pickup_longitude' => 'decimal:8',
        'dropoff_latitude' => 'decimal:8',
        'dropoff_longitude' => 'decimal:8',
        'schedule_time' => 'datetime',
        'driver_completed_at' => 'datetime',
        'passenger_completed_at' => 'datetime',
        'deleted_by_passenger_at' => 'datetime',
        'deleted_by_driver_at' => 'datetime',
        'is_deleted_by_passenger' => 'boolean',
        'is_deleted_by_driver' => 'boolean',
    ];

    /* 
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'bookingID');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    public function passenger()
    {
        return $this->belongsTo(Passenger::class, 'passenger_id');
    }

    /* 
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Scope for records visible to passenger
     */
    public function scopeVisibleToPassenger($query, $passengerId = null)
    {
        return $query->where('passenger_id', $passengerId)
            ->where('is_deleted_by_passenger', false);
    }

    /**
     * Scope for records visible to driver
     */
    public function scopeVisibleToDriver($query, $driverId = null)
    {
        return $query->where('driver_id', $driverId)
            ->where('is_deleted_by_driver', false);
    }

    /**
     * Scope for active records (not deleted by either party)
     */
    public function scopeActive($query)
    {
        return $query->where('is_deleted_by_passenger', false)
            ->where('is_deleted_by_driver', false);
    }

    /**
     * Scope for completed bookings
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope for completed or cancelled bookings
     */
    public function scopeCompletedOrCancelled($query)
    {
        return $query->whereIn('status', ['completed', 'cancelled']);
    }

    /**
     * Scope for recent first ordering
     */
    public function scopeRecentFirst($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Scope for specific service type
     */
    public function scopeServiceType($query, $serviceType)
    {
        if ($serviceType && $serviceType !== 'all') {
            return $query->where('service_type', $serviceType);
        }
        return $query;
    }

    /**
     * Scope for time period filter
     */
    public function scopeTimePeriod($query, $period)
    {
        if ($period && $period !== 'all') {
            $now = now();
            switch ($period) {
                case 'today':
                    return $query->whereDate('created_at', $now->toDateString());
                case 'week':
                    return $query->where('created_at', '>=', $now->subWeek());
                case 'month':
                    return $query->where('created_at', '>=', $now->subMonth());
            }
        }
        return $query;
    }

    /* 
    |--------------------------------------------------------------------------
    | Accessors & Mutators
    |--------------------------------------------------------------------------
    */

    public function getFormattedFareAttribute()
    {
        return '₱' . number_format((float) $this->fare, 2);
    }

    public function getServiceTypeDisplayAttribute()
    {
        return match ($this->service_type) {
            'booking_to_go', 'ride' => 'Ride Service',
            'for_delivery', 'delivery' => 'Delivery Service',
            default => ucfirst(str_replace('_', ' ', $this->service_type)),
        };
    }

    public function getPaymentMethodDisplayAttribute()
    {
        return match ($this->payment_method) {
            'cash' => 'Cash',
            'gcash' => 'GCash',
            'wallet' => 'E-Wallet',
            'credit_card' => 'Credit Card',
            default => ucfirst($this->payment_method),
        };
    }

    public function getStatusDisplayAttribute()
    {
        return match ($this->status) {
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
            'ongoing' => 'On Going',
            'accepted' => 'Accepted',
            'pending' => 'Pending',
            'arrived' => 'Arrived',
            'picked_up' => 'Picked Up',
            default => ucfirst(str_replace('_', ' ', $this->status)),
        };
    }

    public function getBookingTypeAttribute()
    {
        return $this->schedule_time && $this->schedule_time->isFuture() 
            ? 'Scheduled' 
            : 'Instant';
    }

    public function getIsVisibleToPassengerAttribute()
    {
        return !$this->is_deleted_by_passenger;
    }

    public function getIsVisibleToDriverAttribute()
    {
        return !$this->is_deleted_by_driver;
    }

    public function getIsDeletedAttribute()
    {
        return $this->is_deleted_by_passenger || $this->is_deleted_by_driver;
    }

    /* 
    |--------------------------------------------------------------------------
    | Business Logic Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Mark as deleted by passenger with optional reason
     */
    public function markAsDeletedByPassenger($reason = null)
    {
        $this->update([
            'is_deleted_by_passenger' => true,
            'deleted_by_passenger_at' => now(),
            'deletion_reason' => $reason ?? 'Removed from history by passenger'
        ]);

        return $this;
    }

    /**
     * Mark as deleted by driver with optional reason
     */
    public function markAsDeletedByDriver($reason = null)
    {
        $this->update([
            'is_deleted_by_driver' => true,
            'deleted_by_driver_at' => now(),
            'deletion_reason' => $reason ?? 'Removed from history by driver'
        ]);

        return $this;
    }

    /**
     * Restore for passenger
     */
    public function restoreForPassenger()
    {
        $this->update([
            'is_deleted_by_passenger' => false,
            'deleted_by_passenger_at' => null,
        ]);

        return $this;
    }

    /**
     * Restore for driver
     */
    public function restoreForDriver()
    {
        $this->update([
            'is_deleted_by_driver' => false,
            'deleted_by_driver_at' => null,
        ]);

        return $this;
    }

    /**
     * Check if record is visible to specific user type
     */
    public function isVisibleTo($userType, $userId = null)
    {
        if ($userType === 'driver') {
            return !$this->is_deleted_by_driver && 
                   (!$userId || $this->driver_id == $userId);
        } elseif ($userType === 'passenger') {
            return !$this->is_deleted_by_passenger && 
                   (!$userId || $this->passenger_id == $userId);
        }

        return false;
    }

    /**
     * Permanently delete if soft-deleted by both parties
     */
    public function permanentDeleteIfOrphaned()
    {
        if ($this->is_deleted_by_passenger && $this->is_deleted_by_driver) {
            return $this->delete();
        }

        return false;
    }

    
}