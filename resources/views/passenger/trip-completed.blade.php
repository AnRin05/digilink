<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trip Completed - FastLan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="{{ asset('images/fastlan1.png') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            color: #212529;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background: linear-gradient(135deg, #212529 0%, #343a40 100%);
            padding: 1.2rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }

        .nav-brand {
            font-size: 1.8rem;
            font-weight: 700;
            color: #dc3545;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .nav-brand:hover {
            transform: translateY(-2px);
        }

        .nav-brand span {
            color: white;
        }

        .nav-link {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
        }

        .nav-link:hover {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        .completion-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .completion-card {
            background: white;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 500px;
            width: 100%;
            border: 1px solid #e9ecef;
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
            color: white;
        }

        .completion-card h1 {
            color: #28a745;
            margin-bottom: 15px;
            font-size: 2rem;
        }

        .completion-card p {
            color: #6c757d;
            margin-bottom: 25px;
            line-height: 1.6;
            font-size: 1.1rem;
        }

        .trip-details {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            margin: 25px 0;
            text-align: left;
        }

        .trip-details h3 {
            color: #212529;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e9ecef;
        }

        .detail-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .detail-label {
            color: #6c757d;
            font-weight: 500;
        }

        .detail-value {
            color: #212529;
            font-weight: 600;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            flex: 1;
            padding: 15px 20px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            font-size: 1rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
        }

        .btn-success {
            background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
            color: white;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid #007bff;
            color: #007bff;
        }

        .btn-outline:hover {
            background: #007bff;
            color: white;
            transform: translateY(-2px);
        }

        .driver-info {
            background: #e7f3ff;
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
            border-left: 4px solid #007bff;
        }

        .driver-info h4 {
            color: #007bff;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Rating Section Styles */
        .rating-section {
            background: linear-gradient(135deg, #fff9e6 0%, #fff3cd 100%);
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
            border: 2px solid #ffeaa7;
            border-left: 4px solid #ffc107;
        }

        .rating-section h3 {
            color: #212529;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.3rem;
        }

        .rating-section p {
            color: #495057;
            margin-bottom: 20px;
            font-size: 1rem;
        }

        .stars-container {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin: 20px 0;
        }

        .rating-star {
            font-size: 40px;
            cursor: pointer;
            color: #ddd;
            transition: all 0.2s ease;
            margin: 0 2px;
        }

        .rating-star:hover,
        .rating-star.active {
            color: #ffc107;
            transform: scale(1.2);
        }

        .rate-btn {
            background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
            color: #212529;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 1rem;
            width: 100%;
            margin-top: 15px;
            box-shadow: 0 2px 8px rgba(255, 193, 7, 0.3);
        }

        .rate-btn:hover {
            background: linear-gradient(135deg, #e0a800 0%, #c69500 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.4);
        }

        .rate-btn:disabled {
            background: #bdc3c7;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
            opacity: 0.7;
        }

        .rating-message {
            margin-top: 15px;
            padding: 12px;
            border-radius: 8px;
            font-size: 0.9rem;
            text-align: center;
            font-weight: 500;
        }

        .rating-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
            border: 1px solid #b8dfc1;
            box-shadow: 0 2px 5px rgba(21, 87, 36, 0.1);
        }

        .rating-error {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
            border: 1px solid #f1b0b7;
            box-shadow: 0 2px 5px rgba(114, 28, 36, 0.1);
        }

        .rating-completed {
            background: linear-gradient(135deg, #e7f3ff 0%, #d6e9ff 100%);
            border: 2px solid #b3d7ff;
            border-left: 4px solid #007bff;
            padding: 20px;
            border-radius: 12px;
            margin: 20px 0;
        }

        .rating-completed h4 {
            color: #007bff;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        @media (max-width: 768px) {
            .completion-card {
                padding: 30px 20px;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
            }

            .rating-star {
                font-size: 32px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="/" class="nav-brand">Fast<span>Lan</span></a>
        <div class="nav-links">
            <a href="{{ route('passenger.pending.bookings') }}" class="nav-link">
                <i class="fas fa-arrow-left"></i> Back to Bookings
            </a>
        </div>
    </nav>

    <div class="completion-container">
        <div class="completion-card">
            <div class="success-icon">
                <i class="fas fa-check"></i>
            </div>
            
            <h1>Trip Completed!</h1>
            <p>Thank you for choosing FastLan. Your trip has been successfully completed.</p>
            
            <div class="trip-details">
                <h3><i class="fas fa-receipt"></i> Trip Summary</h3>
                
                <div class="detail-item">
                    <span class="detail-label">Booking ID:</span>
                    <span class="detail-value">#{{ $booking->bookingID }}</span>
                </div>
                
                <div class="detail-item">
                    <span class="detail-label">Service Type:</span>
                    <span class="detail-value">{{ $booking->getServiceTypeDisplay() }}</span>
                </div>
                
                <div class="detail-item">
                    <span class="detail-label">Pickup:</span>
                    <span class="detail-value">{{ $booking->pickupLocation }}</span>
                </div>
                
                <div class="detail-item">
                    <span class="detail-label">Drop-off:</span>
                    <span class="detail-value">{{ $booking->dropoffLocation }}</span>
                </div>
                
                <div class="detail-item">
                    <span class="detail-label">Total Fare:</span>
                    <span class="detail-value">₱{{ number_format($booking->fare, 2) }}</span>
                </div>
                
                <div class="detail-item">
                    <span class="detail-label">Payment Method:</span>
                    <span class="detail-value">{{ $booking->getPaymentMethodDisplay() }}</span>
                </div>
            </div>

            @if($booking->driver)
            <div class="driver-info">
                <h4><i class="fas fa-user"></i> Driver Information</h4>
                <p><strong>Name:</strong> {{ $booking->driver->fullname }}</p>
                <p><strong>Vehicle:</strong> {{ $booking->driver->vehicleMake }} {{ $booking->driver->vehicleModel }} ({{ $booking->driver->plateNumber }})</p>
                <p><strong>Contact:</strong> {{ $booking->driver->phone }}</p>
            </div>
            @endif

            <!-- Rating Section -->
            @if(!$booking->review()->exists())
            <div class="rating-section" id="ratingSection">
                <h3><i class="fas fa-star"></i> Rate Your Driver</h3>
                <p>How was your experience with <strong>{{ $booking->driver->fullname ?? 'the driver' }}</strong>?</p>
                
                <div class="stars-container">
                    @for($i = 1; $i <= 5; $i++)
                        <span class="rating-star" data-rating="{{ $i }}">☆</span>
                    @endfor
                </div>
                <input type="hidden" id="selectedRating" value="5">
                
                <button class="rate-btn" onclick="submitRating()" id="submitRatingBtn">
                    <i class="fas fa-paper-plane"></i>
                    Submit Rating
                </button>
                
                <div id="ratingMessage" class="rating-message"></div>
            </div>
            @else
            <div class="rating-completed">
                <h4><i class="fas fa-check-circle"></i> Rating Submitted</h4>
                <p>Thank you for rating your driver! Your feedback helps us improve our service.</p>
                <p><strong>Your Rating:</strong> 
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $booking->review->rating)
                            ★
                        @else
                            ☆
                        @endif
                    @endfor
                    ({{ $booking->review->rating }}/5)
                </p>
            </div>
            @endif

            <div class="action-buttons">
                <a href="{{ route('passenger.dashboard') }}" class="btn btn-primary">
                    <i class="fas fa-home"></i>
                    Go to Dashboard
                </a>
                
                <a href="{{ route('passenger.history') }}" class="btn btn-success">
                    <i class="fas fa-history"></i>
                    View Trip History
                </a>
            </div>

            <div style="margin-top: 25px; padding-top: 20px; border-top: 1px solid #e9ecef;">
                <p style="color: #6c757d; font-size: 0.9rem;">
                    <i class="fas fa-info-circle"></i>
                    Need help with this trip? 
                    <a href="{{ route('passenger.pending.bookings') }}" style="color: #007bff; text-decoration: none;">
                        Contact Support
                    </a>
                </p>
            </div>
        </div>
    </div>

    <script>
        // Initialize rating system
        document.addEventListener('DOMContentLoaded', function() {
            initRatingSystem();
        });

        function initRatingSystem() {
            const stars = document.querySelectorAll('.rating-star');
            const selectedRating = document.getElementById('selectedRating');
            
            // Set default rating to 5
            setRating(5);
            
            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const rating = parseInt(this.getAttribute('data-rating'));
                    setRating(rating);
                });
            });
            
            function setRating(rating) {
                selectedRating.value = rating;
                stars.forEach((star, index) => {
                    if (index < rating) {
                        star.classList.add('active');
                        star.textContent = '★';
                    } else {
                        star.classList.remove('active');
                        star.textContent = '☆';
                    }
                });
            }
        }

        function submitRating() {
            const rating = document.getElementById('selectedRating').value;
            const bookingId = {{ $booking->bookingID }};
            const driverId = {{ $booking->driver->id ?? 0 }};
            const btn = document.getElementById('submitRatingBtn');
            const messageDiv = document.getElementById('ratingMessage');
            
            if (!rating) {
                messageDiv.innerHTML = '<div class="rating-error">Please select a rating</div>';
                return;
            }
            
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';
            btn.disabled = true;
            
            fetch('/digilink/public/passenger/submit-rating', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    booking_id: bookingId,
                    driver_id: driverId,
                    rating: parseInt(rating)
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    messageDiv.innerHTML = `<div class="rating-success">${data.message}</div>`;
                    
                    // Replace rating section with success message
                    setTimeout(() => {
                        document.getElementById('ratingSection').innerHTML = `
                            <div class="rating-completed">
                                <h4><i class="fas fa-check-circle"></i> Rating Submitted</h4>
                                <p>Thank you for rating your driver! Your feedback helps us improve our service.</p>
                                <p><strong>Your Rating:</strong> ${'★'.repeat(rating)}${'☆'.repeat(5-rating)} (${rating}/5)</p>
                            </div>
                        `;
                    }, 1500);
                } else {
                    throw new Error(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                messageDiv.innerHTML = '<div class="rating-error">Failed to submit rating. Please try again.</div>';
                btn.innerHTML = '<i class="fas fa-paper-plane"></i> Submit Rating';
                btn.disabled = false;
            });
        }

        // Auto-redirect to dashboard after 30 seconds (only if no rating is needed)
        @if($booking->review()->exists())
        setTimeout(() => {
            window.location.href = "{{ route('passenger.dashboard') }}";
        }, 30000);
        @endif
    </script>
</body>
</html>