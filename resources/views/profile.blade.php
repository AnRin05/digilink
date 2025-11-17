<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $driver->fullname }} - FastLan Driver</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .driver-profile-container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .profile-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px;
            text-align: center;
            position: relative;
        }

        .back-button {
            position: absolute;
            left: 20px;
            top: 20px;
            background: rgba(255,255,255,0.2);
            border: none;
            color: white;
            padding: 10px 15px;
            border-radius: 50px;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .back-button:hover {
            background: rgba(255,255,255,0.3);
            transform: translateX(-5px);
        }

        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 5px solid white;
            margin: 0 auto 20px;
            overflow: hidden;
            background: #f8f9fa;
        }

        .profile-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .driver-name {
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .driver-rating {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .stars {
            color: #FFD700;
            font-size: 1.2rem;
        }

        .rating-text {
            font-size: 1.1rem;
            font-weight: 500;
        }

        .profile-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            padding: 40px;
        }

        .info-section, .reviews-section {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #667eea;
        }

        .info-grid {
            display: grid;
            gap: 15px;
        }

        .info-item {
            display: flex;
            justify-content: between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .info-label {
            font-weight: 500;
            color: #555;
            min-width: 200px;
        }

        .info-value {
            color: #333;
            font-weight: 400;
        }

        .status-available {
            background: #28a745;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .status-unavailable {
            background: #dc3545;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .review-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            border-left: 4px solid #667eea;
        }

        .review-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 10px;
        }

        .reviewer-name {
            font-weight: 600;
            color: #333;
        }

        .review-rating {
            color: #FFD700;
        }

        .review-comment {
            color: #555;
            line-height: 1.6;
        }

        .review-date {
            color: #888;
            font-size: 0.9rem;
            margin-top: 10px;
        }

        .no-reviews {
            text-align: center;
            color: #888;
            padding: 40px 20px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 600;
            color: #667eea;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #666;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .profile-content {
                grid-template-columns: 1fr;
                padding: 20px;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .profile-header {
                padding: 30px 20px;
            }
            
            .driver-name {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="driver-profile-container">
        <!-- Header Section -->
        <div class="profile-header">
            <a href="{{ url()->previous() }}" class="back-button">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            
            <div class="profile-image">
                <img src="{{ $driver->getProfileImageUrl() }}" alt="{{ $driver->fullname }}">
            </div>
            
            <h1 class="driver-name">{{ $driver->fullname }}</h1>
            
            <div class="driver-rating">
                <div class="stars">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star{{ $i <= $driver->reviews_avg_rating ? '' : '-empty' }}"></i>
                    @endfor
                </div>
                <span class="rating-text">
                    {{ number_format($driver->reviews_avg_rating, 1) }} ({{ $driver->reviews_count }} reviews)
                </span>
            </div>
        </div>

        <!-- Content Section -->
        <div class="profile-content">
            <!-- Driver Information -->
            <div class="info-section">
                <h2 class="section-title">Driver Information</h2>
                
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-number">{{ $driver->completedBooking }}</div>
                        <div class="stat-label">Completed Rides</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">{{ $driver->reviews_count }}</div>
                        <div class="stat-label">Total Reviews</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">{{ number_format($driver->reviews_avg_rating, 1) }}</div>
                        <div class="stat-label">Average Rating</div>
                    </div>
                </div>

                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Current Status:</span>
                        <span class="info-value">
                            <span class="{{ $driver->availStatus ? 'status-available' : 'status-unavailable' }}">
                                {{ $driver->availStatus ? 'Available' : 'Unavailable' }}
                            </span>
                        </span>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Current Location:</span>
                        <span class="info-value">{{ $driver->currentLocation }}</span>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Service Type:</span>
                        <span class="info-value">{{ $driver->serviceType }}</span>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Vehicle:</span>
                        <span class="info-value">{{ $driver->vehicleMake }} {{ $driver->vehicleModel }}</span>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Plate Number:</span>
                        <span class="info-value">{{ $driver->plateNumber }}</span>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Contact:</span>
                        <span class="info-value">{{ $driver->phone }}</span>
                    </div>
                </div>
            </div>

            <!-- Reviews Section -->
            <div class="reviews-section">
                <h2 class="section-title">Passenger Reviews</h2>
                
                @if($reviews->count() > 0)
                    @foreach($reviews as $review)
                        <div class="review-card">
                            <div class="review-header">
                                <span class="reviewer-name">{{ $review->passenger->fullname }}</span>
                                <div class="review-rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star{{ $i <= $review->rating ? '' : '-empty' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            
                            @if($review->comment)
                                <p class="review-comment">"{{ $review->comment }}"</p>
                            @endif
                            
                            <div class="review-date">
                                {{ $review->created_at->format('M d, Y') }}
                            </div>
                        </div>
                    @endforeach

                    <!-- Pagination -->
                    {{ $reviews->links() }}
                @else
                    <div class="no-reviews">
                        <i class="fas fa-comment-slash" style="font-size: 3rem; margin-bottom: 15px; color: #ccc;"></i>
                        <p>No reviews yet for this driver.</p>
                        <p>Be the first to leave a review after your ride!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Simple animation on load
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.info-section, .reviews-section');
            elements.forEach((el, index) => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    el.style.transition = 'all 0.6s ease';
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, index * 200);
            });
        });
    </script>
</body>
</html>