<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Bookings - FastLan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/driver/avail-book.css') }}" rel="stylesheet">
    @yield('styles')
    <link rel="icon" href="{{ asset('images/fastlan1.png') }}">
</head>
<body>
    <nav class="navbar">
        <a href="/" class="nav-brand">Fast<span>Lan</span></a>
        <div class="nav-links">
            <a href="{{ route('driver.dashboard') }}" class="nav-link">Dashboard</a>
            <a href="{{ route('driver.availableBookings') }}" class="nav-link">Available Bookings</a>
            <a href="{{ route('driver.edit') }}" class="nav-link">Edit Profile</a>
        </div>
    </nav>

    <div class="container">
        <div class="header">
            <h1 class="page-title">Available Bookings</h1>
            <a href="{{ route('driver.dashboard') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i>
                Back to Dashboard
            </a>
        </div>

        <div class="bookings-section">
            <div class="section-header">
                <h2 class="section-title">Available Bookings</h2>
                <div class="bookings-count" id="bookingsCount">Loading...</div>
            </div>

            <div class="bookings-grid" id="bookingsGrid">
                <div class="empty-state" id="loadingState">
                    <div class="empty-icon">
                        <i class="fas fa-spinner fa-spin"></i>
                    </div>
                    <h3 class="empty-title">Loading Bookings</h3>
                    <p class="empty-text">Please wait while we fetch available bookings...</p>
                </div>
            </div>

            <div class="empty-state" id="emptyState" style="display: none;">
                <div class="empty-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <h3 class="empty-title">No Available Bookings</h3>
                <p class="empty-text">There are currently no bookings available. Please check back later.</p>
                <button class="btn btn-primary" onclick="loadAvailableBookings()">
                    <i class="fas fa-redo"></i>
                    Refresh
                </button>
            </div>
        </div>
    </div>

    <script>
        function loadAvailableBookings() {
            const grid = document.getElementById('bookingsGrid');
            const countElement = document.getElementById('bookingsCount');
            const emptyState = document.getElementById('emptyState');
            
            grid.innerHTML = `
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-spinner fa-spin"></i>
                    </div>
                    <h3 class="empty-title">Loading Bookings</h3>
                    <p class="empty-text">Please wait while we fetch available bookings...</p>
                </div>
            `;
            emptyState.style.display = 'none';

            fetch("{{ route('driver.getAvailableBookings') }}")
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok: ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Bookings data:', data);
                    
                    if (!data.success) {
                        throw new Error(data.message || 'Failed to load bookings');
                    }
                    
                    grid.innerHTML = '';
                    countElement.textContent = `${data.count} booking${data.count !== 1 ? 's' : ''}`;

                    if (data.count === 0) {
                        emptyState.style.display = 'block';
                        return;
                    }

                    data.bookings.forEach(booking => {
                        const bookingCard = document.createElement('div');
                        bookingCard.className = 'booking-card';
                        bookingCard.innerHTML = `
                            <div class="booking-header">
                                <div class="passenger-info">
                                    <h4>${booking.passenger_name}</h4>
                                    <p><i class="fas fa-phone"></i> ${booking.passenger_phone}</p>
                                </div>
                                <div class="service-badge">
                                    <i class="fas ${booking.service_type_raw === 'booking_to_go' ? 'fa-car' : 'fa-box'}"></i>
                                    ${booking.service_type}
                                </div>
                            </div>
                            
                            <div class="booking-details">
                                <div class="location-row">
                                    <div class="location-icon pickup-icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div class="location-text">
                                        <div class="location-label">Pickup Location</div>
                                        <div class="location-address">${booking.pickup_location}</div>
                                    </div>
                                </div>
                                <div class="location-row">
                                    <div class="location-icon dropoff-icon">
                                        <i class="fas fa-flag-checkered"></i>
                                    </div>
                                    <div class="location-text">
                                        <div class="location-label">Drop-off Location</div>
                                        <div class="location-address">${booking.dropoff_location}</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="booking-meta">
                                <div class="meta-item">
                                    <div class="meta-label">Fare</div>
                                    <div class="meta-value fare">${booking.fare}</div>
                                </div>
                                <div class="meta-item">
                                    <div class="meta-label">Type</div>
                                    <div class="meta-value">${booking.booking_type}</div>
                                </div>
                            </div>
                            
                            <div class="booking-actions">
                                <a href="/driver/booking-details/${booking.id}" class="btn btn-primary">
                                    <i class="fas fa-eye"></i>
                                    View Details
                                </a>
                            </div>
                        `;
                        grid.appendChild(bookingCard);
                    });
                })
                .catch(error => {
                    console.error('Error loading bookings:', error);
                    grid.innerHTML = `
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <h3 class="empty-title">Error Loading Bookings</h3>
                            <p class="empty-text">There was a problem loading the available bookings. Please try again.</p>
                            <button class="btn btn-primary" onclick="loadAvailableBookings()">
                                <i class="fas fa-redo"></i>
                                Try Again
                            </button>
                        </div>
                    `;
                    countElement.textContent = 'Error';
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            loadAvailableBookings();
            
            setInterval(loadAvailableBookings, 30000);
        });
    </script>
</body>
</html>