<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Ratings</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    body {
    background: linear-gradient(135deg, #f5f5f5 0%, #e8e8e8 100%);
    font-family: 'Poppins', sans-serif;
    min-height: 100vh;
    margin: 0;
    overflow-x: hidden;
}

.navbar {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    padding: 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    flex-wrap: wrap;
    gap: 1rem;
    position: sticky;
    top: 0;
    z-index: 1000;
    width: 100%;
}

.nav-brand {
    font-size: 1.3rem;
    font-weight: 700;
    color: #e63946;
    text-decoration: none;
    transition: all 0.3s ease;
}

.nav-brand:hover {
    transform: translateY(-2px);
}

.nav-brand span {
    color: #f5f5f5;
}

.back-link {
    color: #f5f5f5;
    text-decoration: none;
    padding: 8px 12px;
    border-radius: 8px;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 6px;
    font-weight: 500;
    font-size: 0.9rem;
    min-height: 44px;
    white-space: nowrap;
}

.back-link:hover {
    background: rgba(230, 57, 70, 0.1);
    color: #e63946;
}

.page-title {
    color: #f5f5f5;
    font-size: 1.2rem;
    font-weight: 600;
    margin: 0;
    word-break: break-word;
    flex-grow: 1;
    text-align: center;
}

.rating-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 1.5rem;
    width: 100%;
}

.rating-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
}

.profile-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    text-align: center;
    border: 1px solid rgba(0,0,0,0.08);
}

.profile-img {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: 50%;
    border: 4px solid #ffffff;
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    margin: 0 auto 1rem;
}

.driver-name {
    font-size: 1.4rem;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 0.5rem;
}

.rating-display {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
    flex-wrap: wrap;
}

.star-rating {
    color: #e63946;
    font-size: 1.1rem;
    display: flex;
    gap: 2px;
}

.average-rating {
    font-weight: 700;
    color: #1a1a1a;
    font-size: 1.1rem;
}

.review-count {
    color: #666666;
    font-size: 0.9rem;
}

.reviews-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    border: 1px solid rgba(0,0,0,0.08);
}

.card-header {
    border-bottom: 2px solid #e63946;
    padding-bottom: 1rem;
    margin-bottom: 1rem;
}

.card-header h5 {
    color: #1a1a1a;
    font-weight: 700;
    margin: 0;
    font-size: 1.2rem;
}

.reviews-list {
    max-height: 600px;
    overflow-y: auto;
}

.review-item {
    padding: 1rem 0;
    border-bottom: 1px solid rgba(0,0,0,0.1);
}

.review-item:last-child {
    border-bottom: none;
}

.review-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 0.8rem;
}

.passenger-img {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 50%;
    border: 2px solid #e63946;
}

.passenger-info {
    flex: 1;
}

.passenger-name {
    font-weight: 600;
    color: #1a1a1a;
    margin-bottom: 0.2rem;
    font-size: 1rem;
}

.booking-id {
    color: #666666;
    font-size: 0.85rem;
}

.review-rating {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.star-rating-small {
    color: #e63946;
    font-size: 0.9rem;
    display: flex;
    gap: 1px;
}

.review-date {
    color: #666666;
    font-size: 0.85rem;
    text-align: right;
}

.empty-state {
    text-align: center;
    padding: 3rem 1rem;
    color: #666666;
}

.empty-icon {
    font-size: 3rem;
    color: #e63946;
    opacity: 0.7;
    margin-bottom: 1rem;
}

.empty-title {
    font-size: 1.3rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #666666;
}

.empty-text {
    font-size: 0.9rem;
    color: #666666;
}

@keyframes starPulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

.star-rating i.fas,
.star-rating-small i.fas {
    animation: starPulse 0.5s ease-in-out;
}

@media (min-width: 768px) {
    .navbar {
        padding: 1.2rem 2rem;
        flex-wrap: nowrap;
        gap: 2rem;
    }

    .nav-brand {
        font-size: 1.6rem;
    }

    .back-link {
        padding: 10px 16px;
        font-size: 1rem;
    }

    .page-title {
        font-size: 1.4rem;
    }

    .rating-container {
        padding: 2rem;
    }

    .rating-grid {
        grid-template-columns: 300px 1fr;
        gap: 2rem;
    }

    .profile-card {
        position: sticky;
        top: 100px;
        height: fit-content;
        padding: 2rem;
    }

    .profile-img {
        width: 140px;
        height: 140px;
    }

    .driver-name {
        font-size: 1.5rem;
    }

    .star-rating {
        font-size: 1.2rem;
    }

    .average-rating {
        font-size: 1.2rem;
    }

    .reviews-card {
        padding: 2rem;
    }

    .card-header h5 {
        font-size: 1.3rem;
    }
}

@media (min-width: 992px) {
    .navbar {
        padding: 1.2rem 3rem;
    }

    .nav-brand {
        font-size: 1.8rem;
    }

    .rating-container {
        padding: 2.5rem;
    }

    .profile-img {
        width: 150px;
        height: 150px;
    }

    .driver-name {
        font-size: 1.6rem;
    }
}

@media (max-width: 767px) {
    .navbar {
        gap: 0.8rem;
    }

    .page-title {
        order: 3;
        width: 100%;
        text-align: center;
        margin-top: 0.5rem;
    }

    .rating-grid {
        gap: 1.25rem;
    }

    .profile-card,
    .reviews-card {
        padding: 1.25rem;
    }

    .review-item {
        padding: 0.875rem 0;
    }

    .passenger-img {
        width: 45px;
        height: 45px;
    }

    .empty-state {
        padding: 2rem 1rem;
    }
}

@media (max-width: 480px) {
    .navbar {
        padding: 0.8rem;
    }

    .nav-brand {
        font-size: 1.2rem;
    }

    .back-link {
        padding: 6px 10px;
        font-size: 0.8rem;
        min-height: 40px;
    }

    .page-title {
        font-size: 1rem;
    }

    .rating-container {
        padding: 1rem;
    }

    .profile-img {
        width: 100px;
        height: 100px;
    }

    .driver-name {
        font-size: 1.2rem;
    }

    .star-rating {
        font-size: 1rem;
    }

    .average-rating {
        font-size: 1rem;
    }

    .review-count {
        font-size: 0.8rem;
    }

    .profile-card,
    .reviews-card {
        padding: 1rem;
    }

    .passenger-img {
        width: 40px;
        height: 40px;
    }

    .passenger-name {
        font-size: 0.95rem;
    }

    .booking-id {
        font-size: 0.8rem;
    }

    .star-rating-small {
        font-size: 0.8rem;
    }

    .review-date {
        font-size: 0.8rem;
    }

    .empty-icon {
        font-size: 2.5rem;
    }

    .empty-title {
        font-size: 1.1rem;
    }
}

@media (hover: none) and (pointer: coarse) {
    .back-link,
    .review-item {
        min-height: 48px;
    }

    .profile-img,
    .passenger-img {
        min-width: 50px;
    }
}
</style>
<body>
    <nav class="navbar">
        @include('logo')
        <a href="{{ route('driver.dashboard') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
        <h1 class="page-title">Edit Driver Profile</h1>
    </nav>
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <img src="{{ $driver->getProfileImageUrl() }}" 
                                 alt="{{ $driver->fullname }}" 
                                 class="rounded-circle profile-img shadow-sm">
                        </div>
                        <h2 class="h4 mb-2 text-dark">{{ $driver->fullname }}</h2>
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="star-rating me-2">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($averageRating))
                                        <i class="fas fa-star"></i>
                                    @elseif($i - 0.5 <= $averageRating)
                                        <i class="fas fa-star-half-alt"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="fw-bold text-dark ms-2">{{ number_format($averageRating, 1) }}</span>
                            <span class="text-muted ms-2">({{ $totalReviews }} reviews)</span>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0 text-dark">Passenger Ratings</h5>
                    </div>
                    <div class="card-body p-0">
                        @if($reviews->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach($reviews as $review)
                                    <div class="list-group-item border-0 py-3 px-4">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <img src="{{ $review['profile_image'] ? asset('storage/' . $review['profile_image']) : asset('images/default-avatar.png') }}" 
                                                     alt="{{ $review['passenger_name'] }}"
                                                     class="rounded-circle passenger-img">
                                            </div>
                                            <div class="col">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h6 class="mb-1 text-dark">{{ $review['passenger_name'] }}</h6>
                                                        <small class="text-muted">Booking ID: {{ $review['booking_id'] }}</small>
                                                    </div>
                                                    <div class="text-end">
                                                        <div class="star-rating mb-1">
                                                            @for($i = 1; $i <= 5; $i++)
                                                                @if($i <= $review['rating'])
                                                                    <i class="fas fa-star small"></i>
                                                                @else
                                                                    <i class="far fa-star small"></i>
                                                                @endif
                                                            @endfor
                                                        </div>
                                                        <small class="text-muted">{{ $review['booking_date'] }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if(!$loop->last)
                                        <hr class="my-0 mx-4">
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-star fa-3x text-muted mb-3"></i>
                                <p class="text-muted mb-0">No ratings yet</p>
                                <small class="text-muted">Your ratings will appear here once passengers rate your service.</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>