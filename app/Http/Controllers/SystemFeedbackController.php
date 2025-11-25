<?php

namespace App\Http\Controllers;

use App\Models\SystemFeedback;
use App\Models\Driver;
use App\Models\Passenger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SystemFeedbackController extends Controller
{
    public function create()
    {
        // Check which guard is authenticated
        if (Auth::guard('passenger')->check()) {
            $user = Auth::guard('passenger')->user();
            $userType = 'passenger';
        } elseif (Auth::guard('driver')->check()) {
            $user = Auth::guard('driver')->user();
            $userType = 'driver';
        } else {
            return redirect()->route('login')->with('error', 'Please login to submit feedback.');
        }

        return view('system-feedback.create', compact('user', 'userType'));
    }

    public function store(Request $request)
    {
        Log::info('Feedback submission started', $request->all());

        // Basic validation
        $request->validate([
            'satisfaction_rating' => 'required|integer|between:1,5',
            'feedback_type' => 'required|in:general,booking,payment,driver,passenger,technical',
            'reason' => 'nullable|string|max:1000',
            'improvements' => 'nullable|string|max:1000',
            'positive_feedback' => 'nullable|string|max:1000',
        ]);

        // Add manual validation for reason when rating is low
        if ($request->satisfaction_rating <= 2 && empty($request->reason)) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['reason' => 'Please provide a reason for your low rating.']);
        }

        // Get user info
        if (Auth::guard('passenger')->check()) {
            $user = Auth::guard('passenger')->user();
            $userType = 'passenger';
        } elseif (Auth::guard('driver')->check()) {
            $user = Auth::guard('driver')->user();
            $userType = 'driver';
        } else {
            return redirect()->route('login')->with('error', 'Please login to submit feedback.');
        }

        try {
            // Prepare feedback data
            $feedbackData = [
                'user_type' => $userType,
                'satisfaction_rating' => $request->satisfaction_rating,
                'satisfaction_level' => $this->getSatisfactionLevel($request->satisfaction_rating),
                'feedback_type' => $request->feedback_type,
                'reason' => $request->reason,
                'improvements' => $request->improvements,
                'positive_feedback' => $request->positive_feedback,
                'is_anonymous' => $request->has('is_anonymous') ? 1 : 0,
                'can_contact' => $request->has('can_contact') ? 1 : 0,
                'contact_email' => $request->contact_email,
            ];

            // Add user ID if not anonymous
            if (!$request->has('is_anonymous')) {
                if ($userType === 'passenger') {
                    $feedbackData['passenger_id'] = $user->id;
                } else {
                    $feedbackData['driver_id'] = $user->id;
                }
            }

            Log::info('Creating feedback with data:', $feedbackData);

            // Create the feedback
            $feedback = SystemFeedback::create($feedbackData);

            Log::info('Feedback created successfully', ['id' => $feedback->id]);

            return redirect()->route('feedback.thank-you')->with('success', 'Thank you for your valuable feedback!');

        } catch (\Exception $e) {
            Log::error('Error creating feedback: ' . $e->getMessage());
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'There was an error submitting your feedback. Please try again.');
        }
    }

    private function getSatisfactionLevel($rating)
    {
        $levels = [
            1 => 'very_unsatisfied',
            2 => 'unsatisfied',
            3 => 'neutral',
            4 => 'satisfied',
            5 => 'very_satisfied'
        ];

        return $levels[$rating] ?? 'neutral';
    }

    public function thankYou()
    {
        return view('system-feedback.thank-you');
    }

    // Admin methods
    public function index(Request $request)
    {
        $feedbacks = SystemFeedback::with(['passenger', 'driver'])
            ->when($request->type, function($query, $type) {
                return $query->where('feedback_type', $type);
            })
            ->when($request->rating, function($query, $rating) {
                return $query->where('satisfaction_rating', $rating);
            })
            ->when($request->user_type, function($query, $userType) {
                return $query->where('user_type', $userType);
            })
            ->latest()
            ->paginate(20);

        return view('admin.feedback.index', compact('feedbacks'));
    }

    public function show(SystemFeedback $feedback)
    {
        return view('admin.feedback.show', compact('feedback'));
    }

    public function analytics()
    {
        $totalFeedbacks = SystemFeedback::count();
        $averageRating = SystemFeedback::avg('satisfaction_rating');
        $feedbackByType = SystemFeedback::groupBy('feedback_type')
            ->selectRaw('feedback_type, count(*) as count')
            ->get();
        $feedbackByRating = SystemFeedback::groupBy('satisfaction_rating')
            ->selectRaw('satisfaction_rating, count(*) as count')
            ->get();

        return view('admin.feedback.analytics', compact(
            'totalFeedbacks',
            'averageRating',
            'feedbackByType',
            'feedbackByRating'
        ));
    }
}