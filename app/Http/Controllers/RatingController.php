<?php
// app/Http/Controllers/RatingController.php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Review;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RatingController extends Controller
{
    public function submitRating(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'booking_id' => 'required|exists:bookings,bookingID',
                'driver_id' => 'required|exists:drivers,id',
                'rating' => 'required|integer|min:1|max:5'
            ]);

            $booking = Booking::findOrFail($validated['booking_id']);
            $passengerId = auth('passenger')->id();
            
            // Check if passenger owns this booking
            if ($booking->passengerID != $passengerId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized to rate this booking.'
                ], 403);
            }
            
            // Check if booking is completed
            if ($booking->status !== 'completed') {
                return response()->json([
                    'success' => false,
                    'message' => 'You can only rate completed trips.'
                ], 400);
            }

            // Check if already rated
            if ($booking->review()->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have already rated this booking.'
                ], 400);
            }

            // Create review
            $review = Review::create([
                'booking_id' => $validated['booking_id'],
                'passenger_id' => $passengerId,
                'driver_id' => $validated['driver_id'],
                'rating' => $validated['rating']
            ]);

            // Calculate new average rating
            $driver = $review->driver;
            $averageRating = $driver->reviews()->avg('rating') ?? 0;
            $totalReviews = $driver->reviews()->count();

            return response()->json([
                'success' => true,
                'message' => 'Rating submitted successfully!',
                'average_rating' => round($averageRating, 1),
                'total_reviews' => $totalReviews
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit rating. Please try again.'
            ], 500);
        }
    }
}