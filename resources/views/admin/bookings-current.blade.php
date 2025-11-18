<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Current Bookings</title>
    @vite('resources/css/admin/current.css')
</head>
<body>
    <header class="admin-header">
        <div class="header-left">
            <h1>Admin Dashboard</h1>
        </div>
        <nav class="admin-nav">
            <a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="{{ route('admin.passengers') }}"><i class="fas fa-users"></i> Passengers</a>
            <a href="{{ route('admin.drivers') }}"><i class="fas fa-id-card"></i> Drivers</a>
            
            <!-- More Menu Trigger -->
            <div class="more-menu-container">
                <button class="more-menu-trigger" id="moreMenuTrigger">
                    <i class="fas fa-ellipsis-h"></i> More
                </button>
                
                <!-- More Menu Dropdown -->
                <div class="more-menu-dropdown" id="moreMenuDropdown">
                    <div class="more-menu-header">
                        <h3>More Options</h3>
                        <button class="back-btn" id="backButton">
                            <i class="fas fa-arrow-left"></i> Back
                        </button>
                    </div>
                    
                    <nav class="vertical-nav">
                        <a href="{{ route('admin.analytics') }}" class="nav-item">
                            <i class="fas fa-chart-bar"></i>
                            <span>Analytics</span>
                        </a>
                        
                        <div class="nav-section">
                            <h4>Booking Management</h4>
                            <a href="{{ route('admin.bookings.current') }}" class="nav-item">
                                <i class="fas fa-clock"></i>
                                <span>Current Bookings</span>
                            </a>
                            <a href="{{ route('admin.bookings.completed') }}" class="nav-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Completed Bookings</span>
                            </a>
                            <a href="{{ route('admin.bookings.cancelled') }}" class="nav-item">
                                <i class="fas fa-times-circle"></i>
                                <span>Cancelled Bookings</span>
                            </a>
                        </div>
                        
                        <a href="{{ route('admin.reports') }}" class="nav-item">
                            <i class="fas fa-file-alt"></i>
                            <span>Reports / History</span>
                        </a>
                        
                        <a href="{{ route('admin.notifications') }}" class="nav-item">
                            <i class="fas fa-bell"></i>
                            <span>Notifications</span>
                        </a>
                    </nav>
                </div>
            </div>
        </nav>
    </header>

    <main class="admin-main">
        <div class="page-header">
            <h1>Booking: Pending/Accepted/In Progress</h1>
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

        <section class="bookings-section">
            <div class="section-header">
                <h2 class="section-title">Active Bookings</h2>
                <span class="section-badge">{{ $currentBookings->count() }} Total</span>
            </div>
            
            @if($currentBookings->count() > 0)
                <div class="bookings-table-container">
                    <table class="bookings-table">
                        <thead>
                            <tr>
                                <th>Passenger</th>
                                <th>Driver</th>
                                <th>Pickup Location</th>
                                <th>Dropoff Location</th>
                                <th>Status</th>
                                <th>Service Type</th>
                                <th>Payment Method</th>
                                <th>Fare</th>
                                <th>Schedule Time</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($currentBookings as $booking)
                            <tr>
                                <td>
                                    <strong>{{ $booking->passenger->fullname ?? 'N/A' }}</strong>
                                    <br>
                                    <small>{{ $booking->passenger->email ?? 'N/A' }}</small>
                                </td>
                                <td>
                                    @if($booking->driver)
                                        <strong>{{ $booking->driver->fullname }}</strong>
                                        <br>
                                        <small>{{ $booking->driver->email }}</small>
                                    @else
                                        <span style="color: #6b7280; font-style: italic;">Not assigned</span>
                                    @endif
                                </td>
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
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <h3 class="empty-title">No Current Bookings</h3>
                    <p class="empty-text">There are no pending, accepted, or in-progress bookings at the moment.</p>
                </div>
            @endif
        </section>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
        const moreMenuTrigger = document.getElementById('moreMenuTrigger');
        const moreMenuDropdown = document.getElementById('moreMenuDropdown');
        const backButton = document.getElementById('backButton');

        if (!moreMenuTrigger || !moreMenuDropdown || !backButton) {
            console.error('More menu elements not found');
            return;
        }

        moreMenuTrigger.addEventListener('click', function(e) {
            e.stopPropagation();
            moreMenuDropdown.classList.toggle('active');
        });

        backButton.addEventListener('click', function(e) {
            e.preventDefault();
            moreMenuDropdown.classList.remove('active');
        });

        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', function() {
                moreMenuDropdown.classList.remove('active');
            });
        });

        document.addEventListener('click', function(e) {
            if (!moreMenuTrigger.contains(e.target) && !moreMenuDropdown.contains(e.target)) {
                moreMenuDropdown.classList.remove('active');
            }
        });

        moreMenuDropdown.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    });
    </script>
</body>
</html>