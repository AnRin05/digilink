<?php
// app/Models/Review.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'passenger_id',
        'driver_id',
        'rating',
    ];

    protected $casts = [
        'rating' => 'integer'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'bookingID');
    }

    public function passenger()
    {
        return $this->belongsTo(Passenger::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}