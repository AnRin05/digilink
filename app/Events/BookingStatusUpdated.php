<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BookingStatusUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $bookingId;
    public $status;
    public $timestamp;

    public function __construct($bookingId, $status)
    {
        $this->bookingId = $bookingId;
        $this->status = $status;
        $this->timestamp = now()->toISOString();
    }

    public function broadcastOn()
    {
        return new PrivateChannel('booking.status.' . $this->bookingId);
    }

    public function broadcastAs()
    {
        return 'status.updated';
    }

    public function broadcastWith()
    {
        return [
            'booking_id' => $this->bookingId,
            'status' => $this->status,
            'timestamp' => $this->timestamp
        ];
    }
}