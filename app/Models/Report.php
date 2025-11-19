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

    // Relationships
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'bookingID');
    }

    public function reporter()
    {
        if ($this->reporter_type === 'passenger') {
            return $this->belongsTo(Passenger::class, 'reporter_id');
        } else {
            return $this->belongsTo(Driver::class, 'reporter_id');
        }
    }

    // Report types
    const TYPE_URGENT_HELP = 'urgent_help';
    const TYPE_COMPLAINT = 'complaint';
    const TYPE_GENERAL = 'general';

    // Statuses
    const STATUS_PENDING = 'pending';
    const STATUS_REVIEWED = 'reviewed';
    const STATUS_RESOLVED = 'resolved';

    public function getReportTypeDisplay()
    {
        return match($this->report_type) {
            self::TYPE_URGENT_HELP => 'Urgent Help',
            self::TYPE_COMPLAINT => 'Complaint',
            self::TYPE_GENERAL => 'General Report',
            default => ucfirst($this->report_type)
        };
    }
}