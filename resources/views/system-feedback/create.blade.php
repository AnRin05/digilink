<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FastLan - System Feedback</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .text-center {
            text-align: center;
        }

        .mb-8 {
            margin-bottom: 2rem;
        }

        .mb-6 {
            margin-bottom: 1.5rem;
        }

        .mb-4 {
            margin-bottom: 1rem;
        }

        .mb-2 {
            margin-bottom: 0.5rem;
        }

        .text-3xl {
            font-size: 1.875rem;
            line-height: 2.25rem;
        }

        .text-2xl {
            font-size: 1.5rem;
            line-height: 2rem;
        }

        .text-lg {
            font-size: 1.125rem;
            line-height: 1.75rem;
        }

        .text-sm {
            font-size: 0.875rem;
            line-height: 1.25rem;
        }

        .text-4xl {
            font-size: 2.25rem;
            line-height: 2.5rem;
        }

        .font-bold {
            font-weight: 700;
        }

        .font-semibold {
            font-weight: 600;
        }

        .font-medium {
            font-weight: 500;
        }

        .text-gray-900 {
            color: #1a202c;
        }

        .text-gray-700 {
            color: #4a5568;
        }

        .text-gray-600 {
            color: #718096;
        }

        .text-gray-500 {
            color: #a0aec0;
        }

        .text-gray-300 {
            color: #e2e8f0;
        }

        .text-red-500 {
            color: #f56565;
        }

        .text-red-600 {
            color: #e53e3e;
        }

        .text-yellow-400 {
            color: #f6e05e;
        }

        .text-white {
            color: #ffffff;
        }

        .bg-white {
            background-color: #ffffff;
        }

        .bg-red-600 {
            background-color: #e53e3e;
        }

        .bg-gray-50 {
            background-color: #f9fafb;
        }

        .border {
            border-width: 1px;
        }

        .border-gray-300 {
            border-color: #e2e8f0;
        }

        .rounded-lg {
            border-radius: 0.5rem;
        }

        .rounded {
            border-radius: 0.25rem;
        }

        .shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .p-6 {
            padding: 1.5rem;
        }

        .p-8 {
            padding: 2rem;
        }

        .p-4 {
            padding: 1rem;
        }

        .p-3 {
            padding: 0.75rem;
        }

        .py-8 {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }

        .py-3 {
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }

        .px-4 {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .px-6 {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }

        .w-full {
            width: 100%;
        }

        .flex {
            display: flex;
        }

        .justify-center {
            justify-content: center;
        }

        .justify-end {
            justify-content: flex-end;
        }

        .items-center {
            align-items: center;
        }

        .space-x-2 > * + * {
            margin-left: 0.5rem;
        }

        .space-x-4 > * + * {
            margin-left: 1rem;
        }

        .space-y-4 > * + * {
            margin-top: 1rem;
        }

        .hidden {
            display: none;
        }

        .block {
            display: block;
        }

        .inline-block {
            display: inline-block;
        }

        .transition-colors {
            transition-property: background-color, border-color, color, fill, stroke;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }

        .hover\:bg-red-700:hover {
            background-color: #c53030;
        }

        .hover\:bg-gray-50:hover {
            background-color: #f9fafb;
        }

        .focus\:ring-2:focus {
            box-shadow: 0 0 0 2px rgba(66, 153, 225, 0.5);
        }

        .focus\:ring-red-500:focus {
            box-shadow: 0 0 0 2px rgba(245, 101, 101, 0.5);
        }

        .focus\:border-red-500:focus {
            border-color: #f56565;
        }

        input[type="checkbox"] {
            border-radius: 0.25rem;
        }

        input[type="email"],
        select,
        textarea {
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 0.75rem;
            width: 100%;
            font-size: 1rem;
        }

        input[type="email"]:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #f56565;
            box-shadow: 0 0 0 2px rgba(245, 101, 101, 0.1);
        }

        button {
            cursor: pointer;
            border: none;
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .rating-star {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.5rem;
            transition: all 0.3s ease;
        }

        .rating-star:hover {
            transform: scale(1.1);
        }

        a {
            text-decoration: none;
            display: inline-block;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            color: #4a5568;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        a:hover {
            background-color: #f9fafb;
        }

        .alert {
            padding: 1rem;
            margin: 1rem 0;
            border-radius: 0.5rem;
            font-weight: 500;
        }

        .alert-success {
            background-color: #c6f6d5;
            color: #22543d;
            border: 1px solid #9ae6b4;
        }

        .alert-error {
            background-color: #fed7d7;
            color: #c53030;
            border: 1px solid #feb2b2;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Share Your Feedback</h1>
            <p class="text-gray-600">Help us improve FastLan by sharing your experience</p>
        </div>

        <!-- Display Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success mb-6">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error mb-6">
                <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <form action="{{ route('feedback.store') }}" method="POST" id="feedbackForm">
                @csrf

                <!-- Debug info (remove in production) -->
                <div style="background: #f3f4f6; padding: 10px; border-radius: 5px; margin-bottom: 20px; font-size: 12px;">
                    <strong>Information:</strong> 
                    User Type: {{ $userType ?? 'Unknown' }}, 
                    User Name: {{ $user->fullname ?? 'Unknown' }}
                </div>

                <!-- Satisfaction Rating -->
                <div class="mb-8">
                    <label class="block text-lg font-semibold text-gray-900 mb-4">
                        How satisfied are you with FastLan? *
                    </label>
                    <div class="flex justify-center space-x-2 mb-4" id="ratingStars">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" class="text-4xl rating-star" data-rating="{{ $i }}">
                                <i class="far fa-star text-gray-300"></i>
                            </button>
                        @endfor
                    </div>
                    <input type="hidden" name="satisfaction_rating" id="satisfactionRating" required value="{{ old('satisfaction_rating') }}">
                    <div class="text-center text-sm text-gray-600" id="ratingText">
                        Tap a star to rate
                    </div>
                    @error('satisfaction_rating')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Feedback Type -->
                <div class="mb-6">
                    <label for="feedback_type" class="block text-sm font-medium text-gray-700 mb-2">
                        What is this feedback about? *
                    </label>
                    <select name="feedback_type" id="feedback_type" class="w-full" required>
                        <option value="">Select category</option>
                        <option value="general" {{ old('feedback_type') == 'general' ? 'selected' : '' }}>General Feedback</option>
                        <option value="booking" {{ old('feedback_type') == 'booking' ? 'selected' : '' }}>Booking Process</option>
                        <option value="payment" {{ old('feedback_type') == 'payment' ? 'selected' : '' }}>Payment System</option>
                        <option value="driver" {{ old('feedback_type') == 'driver' ? 'selected' : '' }}>Driver Experience</option>
                        <option value="passenger" {{ old('feedback_type') == 'passenger' ? 'selected' : '' }}>Passenger Experience</option>
                        <option value="technical" {{ old('feedback_type') == 'technical' ? 'selected' : '' }}>Technical Issues</option>
                    </select>
                    @error('feedback_type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Reason for Low Rating (Conditional) -->
                <div id="reasonSection" class="mb-6 hidden">
                    <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">
                        What was the main reason for your low rating? *
                    </label>
                    <textarea name="reason" id="reason" rows="3" placeholder="Please tell us what we can improve...">{{ old('reason') }}</textarea>
                    @error('reason')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Positive Feedback -->
                <div class="mb-6">
                    <label for="positive_feedback" class="block text-sm font-medium text-gray-700 mb-2">
                        What do you like about FastLan? (Optional)
                    </label>
                    <textarea name="positive_feedback" id="positive_feedback" rows="3" placeholder="Tell us what you enjoy about using our service...">{{ old('positive_feedback') }}</textarea>
                </div>

                <!-- Improvement Suggestions -->
                <div class="mb-6">
                    <label for="improvements" class="block text-sm font-medium text-gray-700 mb-2">
                        How can we improve? (Optional)
                    </label>
                    <textarea name="improvements" id="improvements" rows="3" placeholder="Any suggestions for improvement...">{{ old('improvements') }}</textarea>
                </div>

                <!-- Privacy Options -->
                <div class="mb-6 space-y-4">
                    <div class="flex items-center">
                        <input type="checkbox" name="is_anonymous" id="is_anonymous" value="1" {{ old('is_anonymous') ? 'checked' : '' }}>
                        <label for="is_anonymous" class="ml-2 block text-sm text-gray-700">
                            Submit feedback anonymously
                        </label>
                    </div>
                    
                    <div class="flex items-center">
                        <input type="checkbox" name="can_contact" id="can_contact" value="1" {{ old('can_contact') ? 'checked' : '' }}>
                        <label for="can_contact" class="ml-2 block text-sm text-gray-700">
                            I'm open to being contacted about my feedback
                        </label>
                    </div>

                    <div id="contactEmailSection" class="hidden">
                        <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-2">
                            Contact Email
                        </label>
                        <input type="email" name="contact_email" id="contact_email" placeholder="your@email.com" value="{{ old('contact_email') }}">
                        @error('contact_email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ url()->previous() }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-semibold">
                        Submit Feedback
                    </button>
                </div>
            </form>
        </div>

        <div class="text-center text-sm text-gray-500">
            <p>Your feedback helps us create a better experience for everyone.</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Feedback form loaded');
            
            const ratingStars = document.querySelectorAll('.rating-star');
            const satisfactionRating = document.getElementById('satisfactionRating');
            const ratingText = document.getElementById('ratingText');
            const reasonSection = document.getElementById('reasonSection');
            const contactCheckbox = document.getElementById('can_contact');
            const contactEmailSection = document.getElementById('contactEmailSection');

            const ratingTexts = {
                1: 'Very Unsatisfied 😞',
                2: 'Unsatisfied 🙁',
                3: 'Neutral 😐',
                4: 'Satisfied 🙂',
                5: 'Very Satisfied 😄'
            };

            // Initialize with old data if exists
            const oldRating = satisfactionRating.value;
            if (oldRating) {
                updateRatingDisplay(parseInt(oldRating));
            }

            // Star rating functionality
            ratingStars.forEach(star => {
                star.addEventListener('click', function() {
                    const rating = parseInt(this.dataset.rating);
                    updateRatingDisplay(rating);
                });

                // Add hover effect
                star.addEventListener('mouseenter', function() {
                    const rating = parseInt(this.dataset.rating);
                    ratingStars.forEach((s, index) => {
                        const icon = s.querySelector('i');
                        if (index < rating) {
                            icon.style.color = '#f6e05e';
                        }
                    });
                });

                star.addEventListener('mouseleave', function() {
                    const currentRating = satisfactionRating.value ? parseInt(satisfactionRating.value) : 0;
                    ratingStars.forEach((s, index) => {
                        const icon = s.querySelector('i');
                        if (index >= currentRating) {
                            icon.style.color = '#e2e8f0';
                        }
                    });
                });
            });

            function updateRatingDisplay(rating) {
                console.log('Setting rating:', rating);
                satisfactionRating.value = rating;
                
                // Update stars display
                ratingStars.forEach((s, index) => {
                    const icon = s.querySelector('i');
                    if (index < rating) {
                        icon.className = 'fas fa-star text-yellow-400';
                    } else {
                        icon.className = 'far fa-star text-gray-300';
                    }
                });
                
                // Update rating text
                ratingText.textContent = ratingTexts[rating];
                
                // Show/hide reason section for low ratings
                if (rating <= 2) {
                    reasonSection.classList.remove('hidden');
                    document.getElementById('reason').setAttribute('required', 'required');
                } else {
                    reasonSection.classList.add('hidden');
                    document.getElementById('reason').removeAttribute('required');
                }
            }

            // Contact email toggle
            if (contactCheckbox && contactEmailSection) {
                contactCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        contactEmailSection.classList.remove('hidden');
                    } else {
                        contactEmailSection.classList.add('hidden');
                    }
                });

                // Initialize contact email section
                if (contactCheckbox.checked) {
                    contactEmailSection.classList.remove('hidden');
                }
            }

            // Form validation
            const feedbackForm = document.getElementById('feedbackForm');
            if (feedbackForm) {
                feedbackForm.addEventListener('submit', function(e) {
                    console.log('Form submitted, rating:', satisfactionRating.value);
                    
                    if (!satisfactionRating.value) {
                        e.preventDefault();
                        alert('Please provide a rating by clicking on the stars.');
                        return false;
                    }

                    const rating = parseInt(satisfactionRating.value);
                    if (rating <= 2) {
                        const reason = document.getElementById('reason').value;
                        if (!reason || reason.trim() === '') {
                            e.preventDefault();
                            alert('Please provide a reason for your low rating.');
                            return false;
                        }
                    }

                    if (contactCheckbox && contactCheckbox.checked) {
                        const contactEmail = document.getElementById('contact_email').value;
                        if (!contactEmail || contactEmail.trim() === '') {
                            e.preventDefault();
                            alert('Please provide your email if you want to be contacted.');
                            return false;
                        }
                    }

                    console.log('Form validation passed');
                    return true;
                });
            }
        });
    </script>
</body>
</html>