<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Profile - FastLan</title>
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

        .navbar {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 1rem 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .nav-brand {
            font-size: 1.8rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
        }

        .nav-brand span {
            color: #ffd700;
        }

        .back-button {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .back-button:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        .profile-container {
            max-width: 800px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .profile-header {
            display: flex;
            align-items: center;
            gap: 2rem;
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 2px solid #f0f0f0;
        }

        .driver-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid #667eea;
        }

        .driver-info h1 {
            color: #333;
            margin-bottom: 0.5rem;
            font-size: 2rem;
        }

        .driver-stats {
            display: flex;
            gap: 2rem;
            margin-top: 1rem;
        }

        .stat {
            text-align: center;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 600;
            color: #667eea;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #666;
        }

        .rating {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 0.5rem 0;
        }

        .stars {
            color: #ffd700;
        }

        .rating-value {
            font-weight: 600;
            color: #333;
        }

        .profile-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .detail-card {
            background: white;
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            border-left: 4px solid #667eea;
        }

        .detail-card h3 {
            color: #333;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .detail-item {
            margin-bottom: 0.8rem;
            display: flex;
            justify-content: space-between;
        }

        .detail-label {
            font-weight: 500;
            color: #666;
        }

        .detail-value {
            font-weight: 600;
            color: #333;
        }

        .reviews-section {
            margin-top: 2rem;
        }

        .reviews-section h2 {
            color: #333;
            margin-bottom: 1rem;
        }

        .review-card {
            background: white;
            padding: 1.5rem;
            border-radius: 15px;
            margin-bottom: 1rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .review-rating {
            color: #ffd700;
        }

        .review-date {
            color: #666;
            font-size: 0.9rem;
        }

        .no-reviews {
            text-align: center;
            color: #666;
            padding: 2rem;
            background: white;
            border-radius: 15px;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .status-approved {
            background: #d4edda;
            color: #155724;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="/" class="nav-brand">Fast<span>Lan</span></a>
        <a href="{{ route('passenger.pending.bookings') }}" class="back-button">
            <i class="fas fa-arrow-left"></i>
            Back to Bookings
        </a>
    </nav>

    <div class="profile-container">
        <div class="profile-header">
            <img src="{{ $driver->profile_image ? asset('storage/' . $driver->profile_image) : asset('images/default-avatar.png') }}" 
                 alt="Driver Photo" class="driver-avatar">
            <div class="driver-info">
                <h1>{{ $driver->fullname }}</h1>
                <div class="rating">
                    <div class="stars">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star{{ $i <= $averageRating ? '' : '-empty' }}"></i>
                        @endfor
                    </div>
                    <span class="rating-value">{{ number_format($averageRating, 1) }}</span>
                    <span>({{ $totalReviews }} reviews)</span>
                </div>
                <div class="driver-stats">
                    <div class="stat">
                        <div class="stat-value">{{ $driver->completedBooking }}</div>
                        <div class="stat-label">Completed Rides</div>
                    </div>
                    <div class="stat">
                        <div class="stat-value">{{ $driver->yearsDriving ?? 'N/A' }}</div>
                        <div class="stat-label">Years Driving</div>
                    </div>
                    <div class="stat">
                        <div class="stat-value">
                            <span class="status-badge {{ $driver->is_approved ? 'status-approved' : 'status-pending' }}">
                                {{ $driver->is_approved ? 'Verified' : 'Pending' }}
                            </span>
                        </div>
                        <div class="stat-label">Status</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="profile-details">
            <div class="detail-card">
                <h3><i class="fas fa-id-card"></i> Personal Information</h3>
                <div class="detail-item">
                    <span class="detail-label">Email:</span>
                    <span class="detail-value">{{ $driver->email }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Phone:</span>
                    <span class="detail-value">{{ $driver->phone }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Location:</span>
                    <span class="detail-value">{{ $driver->currentLocation ?? 'N/A' }}</span>
                </div>
            </div>

            <div class="detail-card">
                <h3><i class="fas fa-car"></i> Vehicle Information</h3>
                <div class="detail-item">
                    <span class="detail-label">Vehicle:</span>
                    <span class="detail-value">{{ $driver->vehicleMake }} {{ $driver->vehicleModel }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Plate Number:</span>
                    <span class="detail-value">{{ $driver->plateNumber }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Service Type:</span>
                    <span class="detail-value">{{ $driver->serviceType }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Availability:</span>
                    <span class="detail-value {{ $driver->availStatus ? 'status-approved' : 'status-pending' }}">
                        {{ $driver->availStatus ? 'Available' : 'Not Available' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="reviews-section">
            <h2><i class="fas fa-comments"></i> Driver Reviews</h2>
            @if($totalReviews > 0)
                @foreach($driver->reviews->take(5) as $review)
                    <div class="review-card">
                        <div class="review-header">
                            <div class="review-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star{{ $i <= $review->rating ? '' : '-empty' }}"></i>
                                @endfor
                                <span>({{ $review->rating }}/5)</span>
                            </div>
                            <div class="review-date">
                                {{ $review->created_at->format('M d, Y') }}
                            </div>
                        </div>
                        <p>{{ $review->comment ?: 'No comment provided.' }}</p>
                    </div>
                @endforeach
                @if($totalReviews > 5)
                    <p style="text-align: center; color: #666; margin-top: 1rem;">
                        And {{ $totalReviews - 5 }} more reviews...
                    </p>
                @endif
            @else
                <div class="no-reviews">
                    <i class="fas fa-comment-slash" style="font-size: 2rem; margin-bottom: 1rem;"></i>
                    <p>No reviews yet for this driver.</p>
                </div>
            @endif
        </div>
    </div>
</body>
</html>