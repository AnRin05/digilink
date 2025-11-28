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

        $request->validate([
            'satisfaction_rating' => 'required|integer|between:1,5',
            'feedback_type' => 'required|in:general,booking,payment,driver,passenger,technical',
            'reason' => 'nullable|string|max:1000',
            'improvements' => 'nullable|string|max:1000',
            'positive_feedback' => 'nullable|string|max:1000',
        ]);

        if ($request->satisfaction_rating <= 2 && empty($request->reason)) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['reason' => 'Please provide a reason for your low rating.']);
        }

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

            if (!$request->has('is_anonymous')) {
                if ($userType === 'passenger') {
                    $feedbackData['passenger_id'] = $user->id;
                } else {
                    $feedbackData['driver_id'] = $user->id;
                }
            }

            Log::info('Creating feedback with data:', $feedbackData);

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
            ->when($request->date_from, function($query, $dateFrom) {
                return $query->whereDate('created_at', '>=', $dateFrom);
            })
            ->when($request->date_to, function($query, $dateTo) {
                return $query->whereDate('created_at', '<=', $dateTo);
            })
            ->latest()
            ->paginate(20);

        $stats = [
            'totalFeedbacks' => SystemFeedback::count(),
            'averageRating' => SystemFeedback::avg('satisfaction_rating'),
            'passengerFeedbacks' => SystemFeedback::where('user_type', 'passenger')->count(),
            'driverFeedbacks' => SystemFeedback::where('user_type', 'driver')->count(),
        ];

        return view('admin.feedback.index', array_merge(compact('feedbacks'), $stats));
    }

    public function show(SystemFeedback $feedback)
    {
        return view('admin.feedback.show', compact('feedback'));
    }

public function analytics()
{
    $totalFeedbacks = SystemFeedback::count();
    $averageRating = SystemFeedback::avg('satisfaction_rating') ?? 0;
    
    $passengerFeedbacks = SystemFeedback::where('user_type', 'passenger')->count();
    $driverFeedbacks = SystemFeedback::where('user_type', 'driver')->count();
    
    $feedbackByType = SystemFeedback::groupBy('feedback_type')
        ->selectRaw('feedback_type, count(*) as count')
        ->orderBy('count', 'desc')
        ->get();
    
    $feedbackByRating = SystemFeedback::groupBy('satisfaction_rating')
        ->selectRaw('satisfaction_rating, count(*) as count')
        ->orderBy('satisfaction_rating')
        ->get();

    return view('admin.feedback.analytics', compact(
        'totalFeedbacks',
        'averageRating',
        'passengerFeedbacks',
        'driverFeedbacks',
        'feedbackByType',
        'feedbackByRating'
    ));
}
}