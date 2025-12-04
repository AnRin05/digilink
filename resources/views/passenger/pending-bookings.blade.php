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
    <link rel="icon" href="{{ asset('images/fastlan1.png') }}">
</head>
<style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html, body {
    width: 100%;
    overflow-x: hidden;
}

body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    color: #212529;
    min-height: 100vh;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    display: flex;
    flex-direction: column;
}

.navbar {
    background: linear-gradient(135deg, #212529 0%, #343a40 100%);
    padding: 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    flex-wrap: wrap;
    gap: 0.8rem;
    width: 100%;
    position: sticky;
    top: 0;
    z-index: 1000;
}

.nav-brand {
    font-size: 1.3rem;
    font-weight: 700;
    color: #dc3545;
    text-decoration: none;
    transition: transform 0.3s ease;
    display: flex;
    align-items: center;
    min-height: 44px;
}

.nav-brand:hover {
    transform: translateY(-2px);
}

.nav-brand span {
    color: white;
    margin-left: 2px;
}

.nav-links {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    flex-wrap: wrap;
}

.nav-link {
    color: white;
    text-decoration: none;
    padding: 8px 12px;
    border-radius: 8px;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    font-weight: 500;
    font-size: 0.85rem;
    min-height: 44px;
}

.nav-link:hover {
    background: rgba(220, 53, 69, 0.15);
    color: #ff6b6b;
}

.nav-link:active {
    transform: scale(0.95);
}

.user-profile-dropdown {
    position: relative;
    display: inline-block;
}

.user-profile {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 8px 12px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50px;
    transition: all 0.3s ease;
    cursor: pointer;
    min-height: 44px;
}

.user-profile:hover {
    background: rgba(255, 255, 255, 0.15);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

.user-profile:active {
    background: rgba(255, 255, 255, 0.15);
}

.profile-container {
    position: relative;
}

.profile-pic {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 3px solid #dc3545;
    object-fit: cover;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
}

.online-indicator {
    position: absolute;
    bottom: 2px;
    right: 2px;
    width: 12px;
    height: 12px;
    background: #28a745;
    border-radius: 50%;
    border: 2px solid #212529;
    animation: pulse 2s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { 
        transform: scale(1); 
        opacity: 1; 
    }
    50% { 
        transform: scale(1.1); 
        opacity: 0.8; 
    }
}

.user-profile span {
    color: white;
    font-weight: 600;
    font-size: 0.9rem;
    display: none;
}

.dropdown-content {
    display: none;
    position: absolute;
    right: 0;
    top: 100%;
    background: linear-gradient(135deg, white 0%, #f8f9fa 100%);
    min-width: 200px;
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    z-index: 1001;
    overflow: hidden;
    margin-top: 10px;
    animation: dropdownFade 0.3s ease;
    border: 1px solid #e9ecef;
}

@keyframes dropdownFade {
    from { 
        opacity: 0; 
        transform: translateY(-10px); 
    }
    to { 
        opacity: 1; 
        transform: translateY(0); 
    }
}

.dropdown-content.show {
    display: block;
}

.dropdown-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 20px;
    color: #495057;
    text-decoration: none;
    transition: all 0.3s ease;
    border-bottom: 1px solid #f1f3f4;
    min-height: 44px;
    cursor: pointer;
}

.dropdown-item:last-child {
    border-bottom: none;
}

.dropdown-item:hover,
.dropdown-item:active {
    background: rgba(220, 53, 69, 0.08);
    color: #dc3545;
}

.dropdown-item i {
    width: 20px;
    text-align: center;
    color: #6c757d;
}

.dropdown-item:hover i {
    color: #dc3545;
}

.dropdown-item.logout {
    color: #dc3545;
    font-weight: 600;
}

.dropdown-item.logout i {
    color: #dc3545;
}

.dropdown-item.logout:hover {
    background: rgba(220, 53, 69, 0.1);
}

.alert {
    padding: 12px 20px;
    margin: 15px auto;
    max-width: calc(100% - 30px);
    border-radius: 12px;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 12px;
    animation: slideDown 0.4s ease;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    flex-wrap: wrap;
}

@keyframes slideDown {
    from { 
        opacity: 0; 
        transform: translateY(-20px); 
    }
    to { 
        opacity: 1; 
        transform: translateY(0); 
    }
}

.alert-success {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    border: 2px solid #28a745;
    color: #155724;
}

.alert-danger {
    background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
    border: 2px solid #dc3545;
    color: #721c24;
}

.alert i {
    font-size: 1.1rem;
}

.close {
    margin-left: auto;
    background: none;
    border: none;
    font-size: 1.3rem;
    cursor: pointer;
    opacity: 0.6;
    transition: opacity 0.3s ease;
    min-height: 44px;
    min-width: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.close:hover {
    opacity: 1;
}

.booking-nav {
    margin: 20px auto;
    display: flex;
    justify-content: center;
    gap: 0.6rem;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 249, 250, 0.95) 100%);
    padding: 0.8rem;
    border-radius: 50px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(220, 53, 69, 0.1);
    max-width: 90%;
    flex-wrap: wrap;
}

.booking-nav .btn-link {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    border: none;
    background: transparent;
    font-weight: 600;
    font-size: 0.85rem;
    color: #495057;
    padding: 8px 14px;
    border-radius: 25px;
    transition: all 0.3s ease;
    cursor: pointer;
    text-decoration: none;
    min-height: 44px;
}

.booking-nav .btn-link.active {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    color: white;
    box-shadow: 0 6px 20px rgba(220, 53, 69, 0.3);
}

.booking-nav .btn-link i {
    font-size: 0.95rem;
    transition: transform 0.3s ease;
}

.booking-nav .btn-link.active i {
    color: white;
}

.booking-nav .btn-link:not(.active) i {
    color: #dc3545;
}

.booking-nav .btn-link:hover:not(.active) {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
}

.main-container {
    flex: 1;
    width: 100%;
    max-width: 1200px;
    margin: 1.5rem auto;
    padding: 0 1rem;
}

.page-header {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-bottom: 1.5rem;
    align-items: flex-start;
}

.page-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #212529;
    line-height: 1.2;
}

.bookings-count {
    background: #dc3545;
    color: white;
    padding: 6px 14px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.9rem;
    align-self: flex-start;
}

.bookings-grid {
    display: grid;
    gap: 1.2rem;
}

.booking-card {
    background: white;
    border-radius: 16px;
    padding: 1.2rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.booking-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    border-color: #dc3545;
}

.booking-header {
    display: flex;
    flex-direction: column;
    gap: 0.8rem;
    margin-bottom: 1rem;
    align-items: flex-start;
}

.booking-info h3 {
    font-size: 1rem;
    font-weight: 700;
    color: #212529;
    margin-bottom: 0.3rem;
    word-break: break-word;
}

.status-badge {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    align-self: flex-start;
}

.status-pending {
    background: rgba(255, 193, 7, 0.1);
    color: #ffc107;
    border: 1px solid rgba(255, 193, 7, 0.3);
}

.status-accepted {
    background: rgba(40, 167, 69, 0.1);
    color: #28a745;
    border: 1px solid rgba(40, 167, 69, 0.3);
}

.status-in_progress {
    background: rgba(0, 123, 255, 0.1);
    color: #007bff;
    border: 1px solid rgba(0, 123, 255, 0.3);
}

.status-cancelled {
    background: rgba(108, 117, 125, 0.1);
    color: #6c757d;
    border: 1px solid rgba(108, 117, 125, 0.3);
}

.status-completed {
    background: rgba(40, 167, 69, 0.1);
    color: #28a745;
    border: 1px solid rgba(40, 167, 69, 0.3);
}

.booking-details {
    margin-bottom: 1rem;
}

.detail-row {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    margin-bottom: 0.6rem;
    color: #495057;
    font-size: 0.9rem;
    word-break: break-word;
    line-height: 1.4;
}

.detail-row i {
    width: 16px;
    color: #dc3545;
    flex-shrink: 0;
    margin-top: 2px;
}

.driver-info {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 0.8rem;
    border-radius: 10px;
    margin-bottom: 0.8rem;
    border-left: 4px solid #dc3545;
}

.driver-info h4 {
    color: #212529;
    margin-bottom: 0.4rem;
    font-size: 0.95rem;
    font-weight: 600;
}

.booking-actions {
    display: flex;
    flex-direction: column;
    gap: 0.6rem;
    margin-top: 0.8rem;
}

.btn {
    padding: 10px 16px;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    text-decoration: none;
    font-size: 0.85rem;
    min-height: 44px;
    white-space: nowrap;
    text-align: center;
}

.btn i {
    transition: transform 0.3s ease;
}

.btn:hover i {
    transform: scale(1.1);
}

.btn-danger {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(220, 53, 69, 0.2);
    width: 100%;
}

.btn-danger:hover {
    background: linear-gradient(135deg, #c82333 0%, #a71e2a 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(220, 53, 69, 0.3);
}

.btn-danger:active {
    transform: scale(0.98);
}

.btn-edit {
    background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%);
    color: #212529;
    border: none;
    box-shadow: 0 4px 15px rgba(255, 193, 7, 0.25);
    width: 100%;
}

.btn-edit:hover {
    background: linear-gradient(135deg, #e0a800 0%, #d39e00 100%);
    color: #212529;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 193, 7, 0.35);
}

.btn-edit:active {
    transform: scale(0.98);
}

.btn-outline {
    background: transparent;
    color: #495057;
    border: 2px solid #e9ecef;
    width: 100%;
}

.btn-outline:hover {
    background: rgba(220, 53, 69, 0.05);
    color: #dc3545;
    border-color: #dc3545;
    transform: translateY(-2px);
}

.btn-track {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    color: white;
    border: none;
    box-shadow: 0 4px 15px rgba(0, 123, 255, 0.25);
    width: 100%;
}

.btn-track:hover {
    background: linear-gradient(135deg, #0056b3 0%, #004085 100%);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 123, 255, 0.35);
}

.btn-track:active {
    transform: scale(0.98);
}

.btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

.empty-state {
    text-align: center;
    padding: 3rem 1.5rem;
    color: #6c757d;
    background: white;
    border-radius: 16px;
    border: 2px dashed #e9ecef;
    margin-top: 1rem;
}

.empty-icon {
    font-size: 3rem;
    color: #e9ecef;
    margin-bottom: 1rem;
}

.empty-icon .fa-spin {
    color: #dc3545;
}

.empty-title {
    font-size: 1.3rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #495057;
}

.empty-text {
    font-size: 0.95rem;
    color: #6c757d;
    margin-bottom: 1rem;
    line-height: 1.5;
}

@media (min-width: 768px) {
    .navbar {
        padding: 1rem 2rem;
        gap: 1.5rem;
        flex-wrap: nowrap;
    }

    .nav-brand {
        font-size: 1.6rem;
    }

    .nav-links {
        gap: 1.2rem;
    }

    .nav-link {
        padding: 10px 18px;
        font-size: 0.95rem;
    }

    .user-profile span {
        display: inline;
    }

    .booking-nav {
        gap: 1.2rem;
        padding: 1rem 2rem;
        max-width: fit-content;
    }

    .booking-nav .btn-link {
        font-size: 1rem;
        padding: 10px 20px;
    }

    .main-container {
        padding: 0 2rem;
        margin: 2rem auto;
    }

    .page-header {
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        gap: 2rem;
    }

    .page-title {
        font-size: 1.8rem;
    }

    .bookings-count {
        padding: 8px 16px;
        font-size: 1rem;
        align-self: center;
    }

    .booking-header {
        flex-direction: row;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
    }

    .booking-info h3 {
        font-size: 1.1rem;
    }

    .booking-actions {
        flex-direction: row;
        gap: 0.8rem;
        margin-top: 1rem;
    }

    .booking-actions .btn {
        flex: 1;
        width: auto;
    }

    .btn {
        padding: 12px 20px;
        font-size: 0.9rem;
    }

    .alert {
        padding: 15px 25px;
    }

    .alert i {
        font-size: 1.2rem;
    }

    .bookings-grid {
        gap: 1.5rem;
    }

    .booking-card {
        padding: 1.5rem;
    }

    .detail-row {
        font-size: 0.95rem;
    }

    .empty-state {
        padding: 4rem 2rem;
    }
}

@media (min-width: 992px) {
    .navbar {
        padding: 1.2rem 3rem;
    }

    .nav-brand {
        font-size: 1.8rem;
    }

    .nav-links {
        gap: 1.5rem;
    }

    .nav-link {
        padding: 12px 20px;
        font-size: 1rem;
    }

    .main-container {
        padding: 0 3rem;
    }

    .page-title {
        font-size: 2rem;
    }

    .booking-card {
        padding: 1.8rem;
    }

    .bookings-grid {
        grid-template-columns: repeat(auto-fill, minmax(500px, 1fr));
        gap: 2rem;
    }
}

@media (max-width: 767px) {
    .nav-links {
        width: 100%;
        justify-content: center;
        order: 3;
        margin-top: 0.5rem;
    }

    .navbar {
        flex-direction: column;
        align-items: flex-start;
        padding: 1rem;
    }

    .nav-brand {
        margin-bottom: 0.5rem;
    }

    .booking-nav .btn-link {
        padding: 8px 12px;
        font-size: 0.8rem;
    }

    .booking-nav {
        padding: 0.6rem;
        gap: 0.5rem;
        border-radius: 30px;
    }

    .page-title {
        font-size: 1.3rem;
    }

    .bookings-count {
        align-self: stretch;
        text-align: center;
    }

    .booking-actions .btn {
        width: 100%;
    }

    .detail-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
    }

    .driver-info {
        padding: 0.6rem;
    }
}

@media (hover: none) and (pointer: coarse) {
    .nav-link,
    .btn,
    .booking-nav .btn-link,
    .dropdown-item,
    .user-profile {
        min-height: 48px;
    }

    .btn-link {
        min-height: 48px;
    }

    .nav-link:hover,
    .btn:hover,
    .booking-nav .btn-link:hover {
        transform: none;
    }

    .booking-card:hover {
        transform: none;
    }

    .btn-primary:active,
    .btn-danger:active,
    .btn-track:active,
    .btn-edit:active {
        transform: scale(0.95);
    }
}

.loading-spinner {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 3px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top-color: white;
    animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}
</style>
<body>
                                                            <!-- Navbar -->
    <nav class="navbar">
        <a href="#" class="nav-brand">Fast<span>Lan</span></a>
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
        function loadPendingBookings() {
            const bookingsList = document.getElementById('bookingsList');
            const bookingsCount = document.getElementById('bookingsCount');
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
                    loadPendingBookings();
                } else {
                    throw new Error(data.message || 'Failed to cancel booking');
                }
            })
            .catch(error => {
                console.error('Error cancelling booking:', error);
                alert('Failed to cancel booking: ' + error.message);
            });
        }

        document.getElementById('userProfileDropdown').addEventListener('click', function(e) {
            e.stopPropagation();
            document.getElementById('dropdownMenu').classList.toggle('show');
        });

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.user-profile-dropdown')) {
                document.getElementById('dropdownMenu').classList.remove('show');
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            loadPendingBookings();

            setInterval(loadPendingBookings, 30000);
        });
    </script>
</body>
</html>