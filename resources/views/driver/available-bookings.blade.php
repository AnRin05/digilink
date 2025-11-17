<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Bookings - FastLan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f9fa;
            color: #333;
        }

        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .nav-brand {
            color: white;
            font-size: 1.8rem;
            font-weight: 700;
            text-decoration: none;
        }

        .nav-brand span {
            color: #ffd700;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .nav-link {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: opacity 0.3s;
        }

        .nav-link:hover {
            opacity: 0.8;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .page-title {
            color: #2d3748;
            font-size: 2rem;
            font-weight: 600;
        }

        .back-btn {
            background: #667eea;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background 0.3s;
        }

        .back-btn:hover {
            background: #5a6fd8;
        }

        .bookings-section {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e9ecef;
        }

        .section-title {
            color: #2d3748;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .bookings-count {
            background: #667eea;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 500;
        }

        .bookings-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .booking-card {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 1.5rem;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .booking-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border-color: #667eea;
        }

        .booking-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .passenger-info h4 {
            color: #2d3748;
            margin-bottom: 0.5rem;
        }

        .passenger-info p {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .service-badge {
            background: #667eea;
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .booking-details {
            margin-bottom: 1rem;
        }

        .location-row {
            display: flex;
            align-items: flex-start;
            gap: 0.8rem;
            margin-bottom: 0.8rem;
        }

        .location-icon {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 0.8rem;
        }

        .pickup-icon {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        .dropoff-icon {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }

        .location-text {
            flex: 1;
        }

        .location-label {
            font-weight: 600;
            color: #495057;
            font-size: 0.9rem;
            margin-bottom: 0.2rem;
        }

        .location-address {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .booking-meta {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .meta-item {
            text-align: center;
            padding: 0.8rem;
            background: white;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }

        .meta-label {
            font-size: 0.8rem;
            color: #6c757d;
            margin-bottom: 0.3rem;
        }

        .meta-value {
            font-size: 1rem;
            font-weight: 600;
            color: #495057;
        }

        .fare {
            color: #dc3545;
            font-size: 1.1rem;
        }

        .booking-actions {
            display: flex;
            gap: 0.8rem;
        }

        .btn {
            flex: 1;
            padding: 0.8rem 1rem;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: #667eea;
            color: white;
        }

        .btn-primary:hover {
            background: #5a6fd8;
            transform: translateY(-2px);
        }

        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            color: #6c757d;
        }

        .empty-icon {
            font-size: 4rem;
            color: #dee2e6;
            margin-bottom: 1rem;
        }

        .empty-title {
            color: #495057;
            margin-bottom: 0.5rem;
            font-size: 1.5rem;
        }

        .empty-text {
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }
            
            .bookings-grid {
                grid-template-columns: 1fr;
            }
            
            .booking-meta {
                grid-template-columns: 1fr;
            }
        }
    </style>
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
            
            // Show loading state
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

        // Load bookings when page loads
        document.addEventListener('DOMContentLoaded', function() {
            loadAvailableBookings();
            
            // Auto-refresh every 30 seconds
            setInterval(loadAvailableBookings, 30000);
        });
    </script>
</body>
</html>