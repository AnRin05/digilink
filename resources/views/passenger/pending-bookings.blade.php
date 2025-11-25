<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FastLan - Passenger Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
    @vite('resources/css/passenger/pending.css')
    <link rel="icon" href="{{ asset('images/fastlan1.png') }}">
</head>
<body>
                                                            <!-- Navbar -->
    <nav class="navbar">
        <a href="/" class="nav-brand">Fast<span>Lan</span></a>
        <div class="nav-links">
            <a href="{{ route('passenger.dashboard') }}" class="nav-link">Dashboard</a>
            <a href="{{ route('passenger.edit') }}" class="nav-link">Edit Profile</a>
            <div class="user-profile-dropdown">
                <div class="user-profile" id="userProfileDropdown">
                    <div class="profile-container">
                        <img src="{{ Auth::guard('passenger')->user()->profile_image ? asset('storage/' . Auth::guard('passenger')->user()->profile_image) : asset('images/default-avatar.png') }}" 
                             alt="Profile" class="profile-pic">
                        <div class="online-indicator"></div>
                    </div>
                    <span>{{ Auth::guard('passenger')->user()->fullname }}</span>
                    <i class="fas fa-chevron-down" style="font-size: 0.8rem; color: #ffffff;"></i>
                </div>
                <div class="dropdown-content" id="dropdownMenu">
                    <a href="{{ route('passenger.dashboard') }}" class="dropdown-item">
                        <i class="fas fa-car"></i>
                        Ride Service
                    </a>
                    <a href="{{ route('passenger.history') }}" class="dropdown-item">
                        <i class="fas fa-history"></i>
                        Ride History
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-cog"></i>
                        Settings
                    </a>
                    <a href="#" class="dropdown-item logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </nav>
                                                            <!-- Booking Navigation -->
    <div class="booking-nav">
        <a href="{{ route('passenger.dashboard') }}" class="btn-link">
            <i class="fas fa-motorcycle"></i> Booking to Go
        </a>
        <a href="{{ route('passenger.delivery') }}" class="btn-link">
            <i class="fas fa-box"></i> For Delivery
       </a>
        <a href="#" class="btn-link active">
            <i class="fas fa-hourglass-half"></i> See Pending
        </a>
    </div>
                                                            <!-- Main Container -->
    <div class="main-container">
        <div class="page-header">
            <h1 class="page-title">My Bookings</h1>
            <div class="bookings-count" id="bookingsCount">0 bookings</div>
        </div>

        <div class="bookings-grid" id="bookingsList">
            <!-- Bookings will be loaded here -->
        </div>
    </div>

    <script>
        // Load pending bookings
        function loadPendingBookings() {
            const bookingsList = document.getElementById('bookingsList');
            const bookingsCount = document.getElementById('bookingsCount');

            // Show loading state
            bookingsList.innerHTML = `
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-spinner fa-spin"></i>
                    </div>
                    <h3 class="empty-title">Loading Bookings</h3>
                    <p class="empty-text">Please wait while we fetch your bookings...</p>
                </div>
            `;

            fetch("{{ route('passenger.get.pending.bookings') }}")
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (!data.success) {
                        throw new Error(data.message || 'Failed to load bookings');
                    }

                    bookingsCount.textContent = `${data.count} booking${data.count !== 1 ? 's' : ''}`;

                    if (data.count === 0) {
                        bookingsList.innerHTML = `
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-clipboard-list"></i>
                                </div>
                                <h3 class="empty-title">No Active Bookings</h3>
                                <p class="empty-text">You don't have any pending, accepted, or on-going bookings.</p>
                            </div>
                        `;
                        return;
                    }

                    bookingsList.innerHTML = '';
                    data.bookings.forEach(booking => {
                        const bookingCard = document.createElement('div');
                        bookingCard.className = 'booking-card';
                        bookingCard.innerHTML = `
                            <div class="booking-header">
                                <div class="booking-info">
                                    <h3>${booking.service_type} Booking</h3>
                                    <p class="detail-row">
                                        <i class="fas fa-calendar"></i>
                                        Booked on: ${booking.created_at}
                                    </p>
                                </div>
                                <span class="status-badge status-${booking.status}">
                                    ${booking.status_display}
                                </span>
                            </div>

                            <div class="booking-details">
                                <div class="detail-row">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <strong>Pickup:</strong> ${booking.pickup_location}
                                </div>
                                <div class="detail-row">
                                    <i class="fas fa-flag-checkered"></i>
                                    <strong>Drop-off:</strong> ${booking.dropoff_location}
                                </div>
                                <div class="detail-row">
                                    <i class="fas fa-money-bill-wave"></i>
                                    <strong>Fare:</strong> ${booking.fare}
                                </div>
                                <div class="detail-row">
                                    <i class="fas fa-credit-card"></i>
                                    <strong>Payment:</strong> ${booking.payment_method}
                                </div>
                                ${booking.schedule_time !== 'Immediate' ? `
                                <div class="detail-row">
                                    <i class="fas fa-clock"></i>
                                    <strong>Scheduled:</strong> ${booking.schedule_time}
                                </div>
                                ` : ''}
                                ${booking.description ? `
                                <div class="detail-row">
                                    <i class="fas fa-sticky-note"></i>
                                    <strong>Description:</strong> ${booking.description}
                                </div>
                                ` : ''}
                            </div>

                            ${booking.driver_name !== 'Not assigned yet' ? `
                            <div class="driver-info">
                                <h4>Driver Information</h4>
                                <div class="detail-row">
                                    <i class="fas fa-user"></i>
                                    <strong>Driver:</strong> ${booking.driver_name}
                                </div>
                                <div class="detail-row">
                                    <i class="fas fa-phone"></i>
                                    <strong>Phone:</strong> ${booking.driver_phone}
                                </div>
                                <div class="detail-row">
                                    <i class="fas fa-car"></i>
                                    <strong>Vehicle:</strong> ${booking.vehicle_info}
                                </div>
                                <div class="detail-row">
                                    <i class="fas fa-list"></i>
                                    <strong>Completed Booking:</strong> ${booking.completed_booking}
                                </div>
                            </div>
                            ` : ''}
                            ${booking.can_edit ? `
                                <div class="booking-actions">
                                    <a href="/digilink/public/passenger/edit-booking/${booking.id}" class="btn btn-outline">
                                        <i class="fas fa-edit"></i>
                                        Edit Booking
                                    </a>
                                    <button class="btn btn-danger" onclick="cancelBooking(${booking.id})">
                                        <i class="fas fa-times"></i>
                                        Cancel Booking
                                    </button>
                                </div>
                                ` : booking.can_track ? `
                                <div class="booking-actions">
                                    <a href="/digilink/public/passenger/track-booking/${booking.id}" class="btn btn-track">
                                        <i class="fas fa-map-marker-alt"></i>
                                        View Progress
                                    </a>
                                </div>
                                ` : booking.can_cancel ? `
                                <div class="booking-actions">
                                    <button class="btn btn-danger" onclick="cancelBooking(${booking.id})">
                                        <i class="fas fa-times"></i>
                                        Cancel Booking
                                    </button>
                                </div>
                                ` : ''}
                        `;
                        bookingsList.appendChild(bookingCard);
                    });
                })
                .catch(error => {
                    console.error('Error loading bookings:', error);
                    bookingsList.innerHTML = `
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <h3 class="empty-title">Error Loading Bookings</h3>
                            <p class="empty-text">There was a problem loading your bookings. Please try again.</p>
                            <button class="btn btn-danger" onclick="loadPendingBookings()" style="margin-top: 1rem;">
                                <i class="fas fa-redo"></i>
                                Try Again
                            </button>
                        </div>
                    `;
                    bookingsCount.textContent = 'Error';
                });
        }

        // Cancel booking function
        function cancelBooking(bookingId) {
            if (!confirm('Are you sure you want to cancel this booking? This action cannot be undone.')) {
                return;
            }

            fetch(`/digilink/public/passenger/cancel-booking/${bookingId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alert('Booking cancelled successfully!');
                    loadPendingBookings(); // Reload the list
                } else {
                    throw new Error(data.message || 'Failed to cancel booking');
                }
            })
            .catch(error => {
                console.error('Error cancelling booking:', error);
                alert('Failed to cancel booking: ' + error.message);
            });
        }

        // Dropdown functionality
        document.getElementById('userProfileDropdown').addEventListener('click', function(e) {
            e.stopPropagation();
            document.getElementById('dropdownMenu').classList.toggle('show');
        });

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.user-profile-dropdown')) {
                document.getElementById('dropdownMenu').classList.remove('show');
            }
        });

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            loadPendingBookings();
            
            // Auto-refresh every 30 seconds
            setInterval(loadPendingBookings, 30000);
        });
    </script>
</body>
</html>