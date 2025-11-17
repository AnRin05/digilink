<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Driver;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Driver $driver)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:500',
            'booking_id' => 'required|exists:bookings,id'
        ]);

        // Check if passenger has already reviewed this booking
        $existingReview = Review::where('booking_id', $request->booking_id)
            ->where('passenger_id', Auth::id())
            ->first();

        if ($existingReview) {
            return back()->with('error', 'You have already reviewed this booking.');
        }

        Review::create([
            'passenger_id' => Auth::id(),
            'driver_id' => $driver->id,
            'booking_id' => $request->booking_id,
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        return back()->with('success', 'Review submitted successfully!');
    }
}