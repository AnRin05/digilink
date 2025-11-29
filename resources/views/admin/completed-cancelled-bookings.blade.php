<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link href="{{ asset('css/admin/ongoing.css') }}" rel="stylesheet">
    @yield('styles')
    <link rel="icon" href="{{ asset('images/fastlan1.png') }}">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
    <div class="bookings-container">
                                                            <!-- Back Button -->
        <a href="{{ route('admin.reports') }}" class="back-button">
            <i class="fas fa-arrow-left"></i>
            Back to Reports
        </a>
                                                            <!-- Header -->
        <div class="bookings-header">
            <h1 class="header-title">{{ $title }}</h1>
        </div>
                                                             <!-- User Information -->
        <div class="user-info-card">
            <h3>
                <i class="fas fa-user"></i>
                {{ $type === 'passenger' ? 'Passenger' : 'Driver' }} Information
            </h3>
            <div class="user-details">
                <div class="user-detail">
                    <i class="fas fa-signature"></i>
                    <span><strong>Name:</strong> {{ $user->fullname }}</span>
                </div>
                <div class="user-detail">
                    <i class="fas fa-envelope"></i>
                    <span><strong>Email:</strong> {{ $user->email }}</span>
                </div>
                <div class="user-detail">
                    <i class="fas fa-phone"></i>
                    <span><strong>Phone:</strong> {{ $user->phone ?? 'N/A' }}</span>
                </div>
                @if($type === 'driver')
                <div class="user-detail">
                    <i class="fas fa-car"></i>
                    <span><strong>Vehicle:</strong> {{ $user->vehicleMake ?? 'N/A' }} {{ $user->vehicleModel ?? '' }}</span>
                </div>
                @endif
            </div>
        </div>

                                                            <!-- Bookings List -->
        @if($completedBookings->count() > 0 || $cancelledBookings->count() > 0)
            <div class="bookings-grid">
                @foreach(isset($completedBookings) ? $completedBookings : $cancelledBookings as $booking)
                <div class="booking-card {{ isset($completedBookings) ? 'completed' : 'cancelled' }}">
                    <div class="booking-header">
                        <div class="booking-id">Booking #{{ $booking->id }}</div>
                        <div class="booking-status {{ isset($completedBookings) ? 'status-completed' : 'status-cancelled' }}">
                            {{ isset($completedBookings) ? 'Completed' : 'Cancelled' }}
                        </div>
                    </div>

                    <div class="booking-details">
                                                            <!-- Service Type -->
                        <div class="detail-row">
                            <span class="detail-label">
                                <i class="fas fa-tasks"></i>
                                Service Type
                            </span>
                            <span class="detail-value">
                                <span class="service-type">
                                    {{ $booking->serviceType === \App\Models\Booking::SERVICE_BOOKING_TO_GO ? 'Ride' : 'Delivery' }}
                                </span>
                            </span>
                        </div>
                                                            <!-- Route Information -->
                        <div class="route-info">
                            <div class="route-point">
                                <div class="point-marker"></div>
                                <span class="detail-label">Pickup:</span>
                                <span class="detail-value">{{ $booking->pickupLocation }}</span>
                            </div>
                            <div class="route-line"></div>
                            <div class="route-point">
                                <div class="point-marker end"></div>
                                <span class="detail-label">Destination:</span>
                                <span class="detail-value">{{ $booking->destinationLocation }}</span>
                            </div>
                        </div>
                                                            <!-- Associated User -->
                        <div class="detail-row">
                            <span class="detail-label">
                                <i class="fas {{ $type === 'passenger' ? 'fa-id-badge' : 'fa-user' }}"></i>
                                {{ $type === 'passenger' ? 'Driver' : 'Passenger' }}
                            </span>
                            <span class="detail-value">
                                @if($type === 'passenger' && $booking->driver)
                                    {{ $booking->driver->fullname }}
                                @elseif($type === 'driver' && $booking->passenger)
                                    {{ $booking->passenger->fullname }}
                                @else
                                    N/A
                                @endif
                            </span>
                        </div>

                                                            <!-- Date & Time -->
                        <div class="detail-row">
                            <span class="detail-label">
                                <i class="fas fa-calendar"></i>
                                Booking Date
                            </span>
                            <span class="detail-value">{{ $booking->created_at->format('M d, Y h:i A') }}</span>
                        </div>

                        @if(isset($completedBookings))
                        <div class="detail-row">
                            <span class="detail-label">
                                <i class="fas fa-flag-checkered"></i>
                                Completed At
                            </span>
                            <span class="detail-value">
                                {{ $booking->updated_at->format('M d, Y h:i A') }}
                            </span>
                        </div>
                        @endif

                        @if(isset($cancelledBookings))
                        <div class="detail-row">
                            <span class="detail-label">
                                <i class="fas fa-times-circle"></i>
                                Cancelled At
                            </span>
                            <span class="detail-value">
                                {{ $booking->updated_at->format('M d, Y h:i A') }}
                            </span>
                        </div>
                        @endif
                    </div>

                    <div class="booking-footer">
                        <div class="booking-date">
                            <i class="fas fa-clock"></i>
                            {{ $booking->created_at->diffForHumans() }}
                        </div>
                        @if($booking->fare)
                        <div class="booking-amount">
                            ${{ number_format($booking->fare, 2) }}
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <h3 class="empty-title">
                    No {{ isset($completedBookings) ? 'Completed' : 'Cancelled' }} Bookings
                </h3>
                <p class="empty-text">
                    This {{ $type }} doesn't have any {{ isset($completedBookings) ? 'completed' : 'cancelled' }} bookings yet.
                </p>
            </div>
        @endif
    </div>
</body>
</html>