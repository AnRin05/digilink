<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Ratings</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite('resources/css/driver/rating.css')
    <link rel="icon" href="{{ asset('images/fastlan1.png') }}">
</head>
<body>
    <nav class="navbar">
        <a href="/" class="nav-brand">Fast<span>Lan</span></a>
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