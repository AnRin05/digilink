<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FastLan - System Feedback</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="{{ asset('images/fastlan1.png') }}">
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
    display: flex;
    flex-direction: column;
    align-items: center;
}

.container {
    max-width: 800px;
    width: 100%;
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

.font-bold {
    font-weight: 700;
}

.font-semibold {
    font-weight: 600;
}

.font-medium {
    font-weight: 500;
}

.text-white {
    color: #ffffff;
}

.bg-white {
    background-color: #ffffff;
}

.bg-red-600 {
    background-color: #e63946;
}

.bg-gray-50 {
    background-color: #f9fafb;
}

.rounded-lg {
    border-radius: 12px;
}

.rounded {
    border-radius: 6px;
}

.shadow-lg {
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.p-6 {
    padding: 1.5rem;
}

.p-4 {
    padding: 1rem;
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

.justify-between {
    justify-content: space-between;
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

.header-section {
    margin-bottom: 2.5rem;
}

.header-section h1 {
    font-size: 2.2rem;
    color: #212529;
    margin-bottom: 0.5rem;
    font-weight: 700;
}

.header-section p {
    font-size: 1.1rem;
    color: #6c757d;
}

.feedback-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
    padding: 2rem;
    margin-bottom: 2rem;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.rating-section {
    margin-bottom: 2rem;
}

.rating-label {
    font-size: 1.2rem;
    color: #212529;
    margin-bottom: 1rem;
    display: block;
    font-weight: 600;
}

.rating-stars {
    display: flex;
    justify-content: center;
    gap: 0.8rem;
    margin-bottom: 1rem;
}

.rating-star {
    background: none;
    border: none;
    cursor: pointer;
    padding: 0.5rem;
    transition: all 0.3s ease;
    font-size: 2.5rem;
}

.rating-star i {
    color: #e2e8f0;
    transition: all 0.3s ease;
}

.rating-star:hover i {
    color: #f6e05e;
    transform: scale(1.1);
}

.rating-star.active i {
    color: #f6e05e;
}

.rating-text {
    text-align: center;
    color: #6c757d;
    font-size: 0.95rem;
    margin-top: 0.5rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    font-size: 0.95rem;
    color: #212529;
    margin-bottom: 0.5rem;
    font-weight: 500;
}

.form-input,
.form-select,
.form-textarea {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e9ecef;
    border-radius: 10px;
    font-size: 1rem;
    color: #212529;
    background: white;
    transition: all 0.3s ease;
}

.form-input:focus,
.form-select:focus,
.form-textarea:focus {
    border-color: #e63946;
    outline: none;
    box-shadow: 0 0 0 3px rgba(230, 57, 70, 0.1);
}

.form-textarea {
    min-height: 120px;
    resize: vertical;
}

.checkbox-group {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
}

.checkbox-group input[type="checkbox"] {
    width: 18px;
    height: 18px;
    margin-right: 10px;
    accent-color: #e63946;
}

.checkbox-label {
    color: #495057;
    font-size: 0.95rem;
}

.button-group {
    display: flex;
    justify-content: space-between;
    gap: 1rem;
    margin-top: 2rem;
}

.btn {
    padding: 12px 28px;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 1rem;
    text-align: center;
    text-decoration: none;
}

.btn-secondary {
    background: white;
    color: #495057;
    border: 2px solid #e9ecef;
}

.btn-secondary:hover {
    background: #f8f9fa;
    border-color: #dee2e6;
}

.btn-primary {
    background: linear-gradient(135deg, #e63946 0%, #dc3545 100%);
    color: white;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(230, 57, 70, 0.3);
}

.footer-text {
    text-align: center;
    color: #6c757d;
    font-size: 0.9rem;
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e9ecef;
}

.alert {
    padding: 15px 20px;
    border-radius: 10px;
    margin-bottom: 1.5rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 10px;
}

.alert-success {
    background: linear-gradient(135deg, #d1fae5, #a7f3d0);
    border: 1px solid #34d399;
    color: #065f46;
}

.alert-error {
    background: linear-gradient(135deg, #fee2e2, #fecaca);
    border: 1px solid #f87171;
    color: #7f1d1d;
}

.debug-info {
    background: #f8f9fa;
    padding: 12px 16px;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    font-size: 0.85rem;
    color: #6c757d;
    border: 1px dashed #dee2e6;
}

.error-text {
    color: #e63946;
    font-size: 0.85rem;
    margin-top: 0.5rem;
    display: flex;
    align-items: center;
    gap: 5px;
}

@media (max-width: 1024px) {
    .container {
        max-width: 700px;
    }
    
    .feedback-card {
        padding: 1.75rem;
    }
    
    .header-section h1 {
        font-size: 2rem;
    }
}

@media (max-width: 768px) {
    body {
        padding: 15px;
    }
    
    .container {
        max-width: 100%;
    }
    
    .feedback-card {
        padding: 1.5rem;
        border-radius: 14px;
    }
    
    .header-section h1 {
        font-size: 1.8rem;
    }
    
    .header-section p {
        font-size: 1rem;
    }
    
    .rating-star {
        font-size: 2.2rem;
    }
    
    .button-group {
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
        text-align: center;
    }
}

@media (max-width: 480px) {
    body {
        padding: 10px;
    }
    
    .feedback-card {
        padding: 1.25rem;
        border-radius: 12px;
    }
    
    .header-section h1 {
        font-size: 1.6rem;
    }
    
    .header-section p {
        font-size: 0.95rem;
    }
    
    .rating-stars {
        gap: 0.5rem;
    }
    
    .rating-star {
        font-size: 1.8rem;
        padding: 0.3rem;
    }
    
    .form-input,
    .form-select,
    .form-textarea {
        padding: 10px 14px;
        font-size: 15px;
    }
    
    .btn {
        padding: 10px 20px;
        font-size: 15px;
    }
    
    .alert {
        padding: 12px 16px;
        font-size: 0.9rem;
    }
}

@media (max-width: 375px) {
    .header-section h1 {
        font-size: 1.4rem;
    }
    
    .feedback-card {
        padding: 1rem;
    }
    
    .rating-star {
        font-size: 1.6rem;
    }
    
    .form-group {
        margin-bottom: 1.25rem;
    }
}

@media (min-width: 1200px) {
    .container {
        max-width: 900px;
    }
    
    .feedback-card {
        padding: 2.5rem;
    }
    
    .header-section h1 {
        font-size: 2.5rem;
    }
}

@media (orientation: landscape) and (max-height: 600px) {
    body {
        padding: 10px;
    }
    
    .feedback-card {
        margin: 0.5rem 0;
    }
}
    </style>
</head>
<body>
    <div class="container">
        <div class="header-section text-center">
            <h1>Share Your Feedback</h1>
            <p>Help us improve FastLan by sharing your experience</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
            </div>
        @endif

        <div class="feedback-card">
            <div class="debug-info">
                <strong>Information:</strong> 
                User Type: {{ $userType ?? 'Unknown' }}, 
                User Name: {{ $user->fullname ?? 'Unknown' }}
            </div>

            <form action="{{ route('feedback.store') }}" method="POST" id="feedbackForm">
                @csrf

                <div class="rating-section">
                    <label class="rating-label">
                        How satisfied are you with FastLan? *
                    </label>
                    <div class="rating-stars" id="ratingStars">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" class="rating-star" data-rating="{{ $i }}">
                                <i class="far fa-star"></i>
                            </button>
                        @endfor
                    </div>
                    <input type="hidden" name="satisfaction_rating" id="satisfactionRating" required value="{{ old('satisfaction_rating') }}">
                    <div class="rating-text" id="ratingText">
                        Tap a star to rate
                    </div>
                    @error('satisfaction_rating')
                        <div class="error-text">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="feedback_type" class="form-label">
                        What is this feedback about? *
                    </label>
                    <select name="feedback_type" id="feedback_type" class="form-select" required>
                        <option value="">Select category</option>
                        <option value="general" {{ old('feedback_type') == 'general' ? 'selected' : '' }}>General Feedback</option>
                        <option value="booking" {{ old('feedback_type') == 'booking' ? 'selected' : '' }}>Booking Process</option>
                        <option value="payment" {{ old('feedback_type') == 'payment' ? 'selected' : '' }}>Payment System</option>
                        <option value="driver" {{ old('feedback_type') == 'driver' ? 'selected' : '' }}>Driver Experience</option>
                        <option value="passenger" {{ old('feedback_type') == 'passenger' ? 'selected' : '' }}>Passenger Experience</option>
                        <option value="technical" {{ old('feedback_type') == 'technical' ? 'selected' : '' }}>Technical Issues</option>
                    </select>
                    @error('feedback_type')
                        <div class="error-text">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <div id="reasonSection" class="form-group hidden">
                    <label for="reason" class="form-label">
                        What was the main reason for your low rating? *
                    </label>
                    <textarea name="reason" id="reason" class="form-textarea" rows="3" placeholder="Please tell us what we can improve...">{{ old('reason') }}</textarea>
                    @error('reason')
                        <div class="error-text">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="positive_feedback" class="form-label">
                        What do you like about FastLan? (Optional)
                    </label>
                    <textarea name="positive_feedback" id="positive_feedback" class="form-textarea" rows="3" placeholder="Tell us what you enjoy about using our service...">{{ old('positive_feedback') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="improvements" class="form-label">
                        How can we improve? (Optional)
                    </label>
                    <textarea name="improvements" id="improvements" class="form-textarea" rows="3" placeholder="Any suggestions for improvement...">{{ old('improvements') }}</textarea>
                </div>

                <div class="space-y-4">
                    <div class="checkbox-group">
                        <input type="checkbox" name="is_anonymous" id="is_anonymous" value="1" {{ old('is_anonymous') ? 'checked' : '' }}>
                        <label for="is_anonymous" class="checkbox-label">
                            Submit feedback anonymously
                        </label>
                    </div>
                    
                    <div class="checkbox-group">
                        <input type="checkbox" name="can_contact" id="can_contact" value="1" {{ old('can_contact') ? 'checked' : '' }}>
                        <label for="can_contact" class="checkbox-label">
                            I'm open to being contacted about my feedback
                        </label>
                    </div>

                    <div id="contactEmailSection" class="form-group hidden">
                        <label for="contact_email" class="form-label">
                            Contact Email
                        </label>
                        <input type="email" name="contact_email" id="contact_email" class="form-input" placeholder="your@email.com" value="{{ old('contact_email') }}">
                        @error('contact_email')
                            <div class="error-text">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="button-group">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Submit Feedback
                    </button>
                </div>
            </form>
        </div>

        <div class="footer-text">
            <p>Your feedback helps us create a better experience for everyone.</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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

            const oldRating = satisfactionRating.value;
            if (oldRating) {
                updateRatingDisplay(parseInt(oldRating));
            }

            ratingStars.forEach(star => {
                star.addEventListener('click', function() {
                    const rating = parseInt(this.dataset.rating);
                    updateRatingDisplay(rating);
                });
            });

            function updateRatingDisplay(rating) {
                satisfactionRating.value = rating;
                
                ratingStars.forEach((star, index) => {
                    const icon = star.querySelector('i');
                    if (index < rating) {
                        icon.className = 'fas fa-star';
                        icon.style.color = '#f6e05e';
                    } else {
                        icon.className = 'far fa-star';
                        icon.style.color = '#e2e8f0';
                    }
                });

                ratingText.textContent = ratingTexts[rating];
                
                if (rating <= 2) {
                    reasonSection.classList.remove('hidden');
                    document.getElementById('reason').setAttribute('required', 'required');
                } else {
                    reasonSection.classList.add('hidden');
                    document.getElementById('reason').removeAttribute('required');
                }
            }

            if (contactCheckbox && contactEmailSection) {
                contactCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        contactEmailSection.classList.remove('hidden');
                    } else {
                        contactEmailSection.classList.add('hidden');
                    }
                });

                if (contactCheckbox.checked) {
                    contactEmailSection.classList.remove('hidden');
                }
            }

            const feedbackForm = document.getElementById('feedbackForm');
            if (feedbackForm) {
                feedbackForm.addEventListener('submit', function(e) {
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

                    return true;
                });
            }
        });
    </script>
</body>
</html>