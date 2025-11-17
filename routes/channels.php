<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('driver.location.{bookingId}', function ($user, $bookingId) {
    // Allow passenger to listen to driver location updates
    $booking = \App\Models\Booking::find($bookingId);
    return $booking && $booking->passengerID === $user->id;
});

Broadcast::channel('booking.status.{bookingId}', function ($user, $bookingId) {
    // Allow both driver and passenger to listen to booking status updates
    $booking = \App\Models\Booking::find($bookingId);
    return $booking && (
        $booking->driverID === $user->id || 
        $booking->passengerID === $user->id
    );
});