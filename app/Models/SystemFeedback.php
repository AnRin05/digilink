<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemFeedback extends Model
{
    use HasFactory;

    // Specify the table name since it's not the plural of the model
    protected $table = 'system_feedback';

    protected $fillable = [
        'passenger_id',
        'driver_id',
        'user_type',
        'satisfaction_rating',
        'satisfaction_level',
        'feedback_type',
        'reason',
        'improvements',
        'positive_feedback',
        'is_anonymous',
        'can_contact',
        'contact_email',
    ];

    protected $casts = [
        'satisfaction_rating' => 'integer',
        'is_anonymous' => 'boolean',
        'can_contact' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Feedback types
    const FEEDBACK_TYPES = [
        'general' => 'General Feedback',
        'booking' => 'Booking Process',
        'payment' => 'Payment System',
        'driver' => 'Driver Experience',
        'passenger' => 'Passenger Experience',
        'technical' => 'Technical Issues'
    ];

    // Relationships
    public function passenger()
    {
        return $this->belongsTo(Passenger::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    // Scopes
    public function scopePassengerFeedbacks($query)
    {
        return $query->where('user_type', 'passenger');
    }

    public function scopeDriverFeedbacks($query)
    {
        return $query->where('user_type', 'driver');
    }

    public function scopeSatisfied($query, $minRating = 4)
    {
        return $query->where('satisfaction_rating', '>=', $minRating);
    }

    public function scopeUnsatisfied($query, $maxRating = 2)
    {
        return $query->where('satisfaction_rating', '<=', $maxRating);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    // Accessors
    public function getUserNameAttribute()
    {
        if ($this->is_anonymous) {
            return 'Anonymous User';
        }

        if ($this->user_type === 'passenger' && $this->passenger) {
            return $this->passenger->fullname;
        }

        if ($this->user_type === 'driver' && $this->driver) {
            return $this->driver->fullname;
        }

        return 'Unknown User';
    }

    public function getSatisfactionLevelTextAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->satisfaction_level));
    }

    public function getFeedbackTypeTextAttribute()
    {
        return self::FEEDBACK_TYPES[$this->feedback_type] ?? ucfirst($this->feedback_type);
    }

    public function getRatingStarsAttribute()
    {
        return str_repeat('⭐', $this->satisfaction_rating) . str_repeat('☆', 5 - $this->satisfaction_rating);
    }

    // Methods
    public function isSatisfied()
    {
        return $this->satisfaction_rating >= 4;
    }

    public function isUnsatisfied()
    {
        return $this->satisfaction_rating <= 2;
    }

    public function hasImprovementSuggestions()
    {
        return !empty($this->improvements);
    }

    public function markAsContacted()
    {
        $this->update(['can_contact' => false]);
    }
}