<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - Admin</title>
    @vite('resources/css/admin/ongoing.css')
    <link rel="icon" href="{{ asset('images/fastlan1.png') }}">
</head>
<body>
    <header class="admin-header">
        <div class="header-left">
            <h1>Admin</h1>
        </div>
        <nav class="admin-nav">
            <a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="{{ route('admin.passengers') }}"><i class="fas fa-users"></i> Passengers</a>
            <a href="{{ route('admin.drivers') }}"><i class="fas fa-id-card"></i> Drivers</a>
            <a href="{{ route('admin.analytics') }}"><i class="fas fa-chart-bar"></i> Analytics</a>
            <a href="{{ route('admin.reports') }}"><i class="fas fa-file-alt"></i> Reports & History</a>
        </nav>
    </header>

    <main class="admin-main">
        <div class="page-header">
            <div class="page-header-content">
                <h1>{{ $title }}</h1>
                <p>View ongoing bookings for this {{ $type }}</p>
            </div>
            <a href="{{ route('admin.reports') }}" class="back-button">
                <i class="fas fa-arrow-left"></i> Back to Reports
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

                                                            <!-- User Information -->
        <div class="user-info-card">
            <div class="user-avatar">
                {{ substr($user->fullname, 0, 1) }}
            </div>
            <div class="user-details">
                <h3>{{ $user->fullname }}</h3>
                <p><i class="fas fa-envelope"></i> {{ $user->email }}</p>
                <p><i class="fas fa-phone"></i> {{ $user->phone ?? 'N/A' }}</p>
                @if($type === 'driver')
                <p><i class="fas fa-car"></i> {{ $user->vehicleMake ?? 'N/A' }} {{ $user->vehicleModel ?? '' }}</p>
                <p><i class="fas fa-id-card"></i> {{ $user->is_approved ? 'Approved' : 'Pending Approval' }}</p>
                @endif
            </div>
        </div>

        <section class="bookings-section">
            <div class="section-header">
                <h2 class="section-title">Ongoing Bookings</h2>
                <span class="section-badge">{{ $ongoingBookings->count() }} Total</span>
            </div>
            
            @if($ongoingBookings->count() > 0)
                <div class="bookings-table-container">
                    <div class="table-wrapper">
                        <table class="bookings-table">
                            <thead>
                                <tr>
                                    @if($type === 'passenger')
                                    <th>Driver</th>
                                    @else
                                    <th>Passenger</th>
                                    @endif
                                    <th>Pickup Location</th>
                                    <th>Dropoff Location</th>
                                    <th>Status</th>
                                    <th>Service Type</th>
                                    <th>Payment Method</th>
                                    <th>Fare</th>
                                    <th>Schedule Time</th>
                                    <th>Created At</th>
                                    <th>Actions</th> <!-- Add this header -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ongoingBookings as $booking)
                                <tr>
                                    @if($type === 'passenger')
                                    <td>
                                        @if($booking->driver)
                                            <strong>{{ $booking->driver->fullname }}</strong>
                                            <br>
                                            <small>{{ $booking->driver->email }}</small>
                                        @else
                                            <span style="color: #6b7280; font-style: italic;">Not assigned</span>
                                        @endif
                                    </td>
                                    @else
                                    <td>
                                        <strong>{{ $booking->passenger->fullname ?? 'N/A' }}</strong>
                                        <br>
                                        <small>{{ $booking->passenger->email ?? 'N/A' }}</small>
                                    </td>
                                    @endif
                                    <td>{{ $booking->pickupLocation }}</td>
                                    <td>{{ $booking->dropoffLocation }}</td>
                                    <td>
                                        @if($booking->status === \App\Models\Booking::STATUS_PENDING)
                                            <span class="status-badge status-pending">Pending</span>
                                        @elseif($booking->status === \App\Models\Booking::STATUS_ACCEPTED)
                                            <span class="status-badge status-accepted">Accepted</span>
                                        @elseif($booking->status === \App\Models\Booking::STATUS_IN_PROGRESS)
                                            <span class="status-badge status-in-progress">In Progress</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($booking->serviceType === \App\Models\Booking::SERVICE_BOOKING_TO_GO)
                                            <span class="service-badge service-ride">Ride</span>
                                        @elseif($booking->serviceType === \App\Models\Booking::SERVICE_FOR_DELIVERY)
                                            <span class="service-badge service-delivery">Delivery</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="payment-method">
                                            @if($booking->paymentMethod === \App\Models\Booking::PAYMENT_CASH)
                                                <i class="fas fa-money-bill-wave payment-cash"></i>
                                                <span>Cash</span>
                                            @elseif($booking->paymentMethod === \App\Models\Booking::PAYMENT_GCASH)
                                                <i class="fas fa-mobile-alt payment-gcash"></i>
                                                <span>GCash</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <strong>{{ $booking->getFormattedFare() }}</strong>
                                    </td>
                                    <td>
                                        @if($booking->scheduleTime)
                                            <small>{{ $booking->scheduleTime->format('M d, Y h:i A') }}</small>
                                        @else
                                            <span style="color: #6b7280; font-style: italic;">Immediate</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small>{{ $booking->created_at->format('M d, Y h:i A') }}</small>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.booking.tracking', $booking->bookingID) }}" class="admin-btn admin-btn-view">
                                            <i class="fas fa-map-marker-alt"></i> View on Map
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <h3 class="empty-title">No Ongoing Bookings</h3>
                    <p class="empty-text">
                        @if($type === 'passenger')
                        This passenger doesn't have any pending, accepted, or in-progress bookings at the moment.
                        @else
                        This driver doesn't have any assigned pending, accepted, or in-progress bookings at the moment.
                        @endif
                    </p>
                </div>
            @endif
        </section>
    </main>
</body>
</html>