<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_type',
        'description',
        'reporter_type',
        'reporter_id',
        'reporter_name',
        'reporter_phone',
        'booking_id',
        'location_data',
        'booking_data',
        'driver_data',
        'passenger_data',
        'status',
        'admin_notes'
    ];

    protected $casts = [
        'location_data' => 'array',
        'booking_data' => 'array',
        'driver_data' => 'array',
        'passenger_data' => 'array',
    ];

    // Report Types
    const TYPE_URGENT_HELP = 'urgent_help';
    const TYPE_COMPLAINT = 'complaint';

    // Status Types
    const STATUS_PENDING = 'pending';
    const STATUS_IN_REVIEW = 'in_review';
    const STATUS_RESOLVED = 'resolved';
    const STATUS_CLOSED = 'closed';

    // Relationships
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'bookingID');
    }

    public function reporter()
    {
        if ($this->reporter_type === 'driver') {
            return $this->belongsTo(Driver::class, 'reporter_id');
        } else {
            return $this->belongsTo(Passenger::class, 'reporter_id');
        }
    }

    // Helper methods to get the opposite party
    public function getReportedPartyAttribute()
    {
        if ($this->reporter_type === 'driver') {
            // Driver reported, so show passenger info
            return [
                'type' => 'passenger',
                'name' => $this->passenger_data['name'] ?? 'N/A',
                'phone' => $this->passenger_data['phone'] ?? 'N/A'
            ];
        } else {
            // Passenger reported, so show driver info
            return [
                'type' => 'driver',
                'name' => $this->driver_data['name'] ?? 'N/A',
                'phone' => $this->driver_data['phone'] ?? 'N/A'
            ];
        }
    }

    // Scope methods
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeUrgentHelp($query)
    {
        return $query->where('report_type', self::TYPE_URGENT_HELP);
    }

    public function scopeComplaint($query)
    {
        return $query->where('report_type', self::TYPE_COMPLAINT);
    }
}