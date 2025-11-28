<?php
// app/Http/Controllers/RatingController.php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Review;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
            
            if ($booking->passengerID != $passengerId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized to rate this booking.'
                ], 403);
            }
            
            if ($booking->status !== 'completed') {
                return response()->json([
                    'success' => false,
                    'message' => 'You can only rate completed trips.'
                ], 400);
            }

            if ($booking->review()->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have already rated this booking.'
                ], 400);
            }

            $review = Review::create([
                'booking_id' => $validated['booking_id'],
                'passenger_id' => $passengerId,
                'driver_id' => $validated['driver_id'],
                'rating' => $validated['rating']
            ]);

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
        public function getRatings()
    {
        try {
            $driver = Auth::guard('driver')->user();
            
            // Using the accessors
            $averageRating = $driver->average_rating;
            $totalReviews = $driver->total_reviews;

            // Get rating breakdown
            $ratingBreakdown = [];
            for ($i = 5; $i >= 1; $i--) {
                $count = Review::where('driver_id', $driver->id)->where('rating', $i)->count();
                $percentage = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
                $ratingBreakdown[$i] = [
                    'count' => $count,
                    'percentage' => round($percentage, 1)
                ];
            }

            return response()->json([
                'success' => true,
                'average_rating' => round($averageRating, 1),
                'total_reviews' => $totalReviews,
                'rating_breakdown' => $ratingBreakdown
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to fetch ratings: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch ratings'
            ], 500);
        }
    }
        public function checkRatingEligibility($id): JsonResponse
    {
        try {
            $booking = Booking::findOrFail($id);
            $passengerId = auth('passenger')->id();
            
            if ($booking->passengerID != $passengerId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }

            // Show rating section if booking is completed OR if passenger has confirmed
            $canShowRating = $booking->status === 'completed' || $booking->completion_verified === 'passenger_confirmed';
            $canSubmitRating = $booking->canBeRated();
            $hasRated = $booking->review()->exists();

            return response()->json([
                'success' => true,
                'can_show_rating' => $canShowRating,
                'can_submit_rating' => $canSubmitRating,
                'has_rated' => $hasRated,
                'completion_status' => $booking->completion_verified,
                'booking_status' => $booking->status
            ]);

        } catch (\Exception $e) {
            Log::error('Error checking rating eligibility: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error checking rating eligibility'
            ], 500);
        }
    }

}