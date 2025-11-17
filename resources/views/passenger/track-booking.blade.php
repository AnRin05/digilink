<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FastLan - Track Booking</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            color: #212529;
            height: 100vh;
            overflow: hidden;
        }

        .navbar {
            background: linear-gradient(135deg, #212529 0%, #343a40 100%);
            padding: 1.2rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }

        .nav-brand {
            font-size: 1.8rem;
            font-weight: 700;
            color: #dc3545;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .nav-brand:hover {
            transform: translateY(-2px);
        }

        .nav-brand span {
            color: white;
        }

        .nav-link {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
        }

        .nav-link:hover {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        .cancel-section {
            margin-top: 20px;
            padding: 20px;
            background: linear-gradient(135deg, #fff9e6 0%, #fff3cd 100%);
            border: 2px solid #ffeaa7;
            border-radius: 12px;
            border-left: 4px solid #fdcb6e;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .cancel-warning {
            color: #e17055;
            font-size: 0.95rem;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
        }

        .cancel-warning i {
            font-size: 1.1rem;
            color: #e74c3c;
        }

        .cancel-note {
            color: #6c757d;
            font-size: 0.85rem;
            margin-top: 8px;
            line-height: 1.4;
            text-align: center;
        }

        .btn-warning {
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 0.9rem;
            width: 100%;
            box-shadow: 0 2px 8px rgba(243, 156, 18, 0.3);
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, #e67e22 0%, #d35400 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(243, 156, 18, 0.4);
        }

        .btn-warning:disabled {
            background: #bdc3c7;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
            opacity: 0.7;
        }

        #cancelMessage {
            margin-top: 15px;
            padding: 12px;
            border-radius: 8px;
            font-size: 0.9rem;
            text-align: center;
            font-weight: 500;
        }

        .cancel-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
            border: 1px solid #b8dfc1;
            box-shadow: 0 2px 5px rgba(21, 87, 36, 0.1);
        }

        .cancel-error {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
            border: 1px solid #f1b0b7;
            box-shadow: 0 2px 5px rgba(114, 28, 36, 0.1);
        }

        .tracking-container {
            display: grid;
            grid-template-columns: 380px 1fr;
            height: calc(100vh - 80px);
        }

        .tracking-sidebar {
            background: white;
            border-right: 1px solid #e9ecef;
            padding: 24px;
            overflow-y: auto;
        }

        .tracking-header {
            margin-bottom: 24px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f8f9fa;
        }

        .tracking-header h1 {
            font-size: 1.5rem;
            color: #212529;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
        }

        .tracking-header h1 i {
            color: #dc3545;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            background: rgba(0, 123, 255, 0.1);
            color: #007bff;
        }

        .status-badge.in-progress {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }

        .status-badge.completed {
            background: rgba(108, 117, 125, 0.1);
            color: #6c757d;
        }

        .status-badge.cancelled {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        .info-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 16px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .info-card:hover {
            border-color: #007bff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .info-card h3 {
            color: #212529;
            margin-bottom: 16px;
            font-size: 1.05rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-card h3 i {
            color: #007bff;
        }

        .info-card p {
            margin: 8px 0;
            color: #495057;
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .info-card p strong {
            color: #212529;
            font-weight: 600;
        }

        .map-container {
            position: relative;
            background: white;
        }

        #trackingMap {
            height: 100%;
            width: 100%;
        }

        .tracking-status {
            position: absolute;
            top: 20px;
            left: 20px;
            background: linear-gradient(135deg, rgba(255,255,255,0.98) 0%, rgba(248,249,250,0.98) 100%);
            padding: 14px 18px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.12);
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
            font-weight: 600;
            color: #212529;
            border: 1px solid rgba(0,0,0,0.08);
        }

        .tracking-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #28a745;
            animation: pulse 2s infinite;
        }

        .tracking-indicator.completed {
            background: #6c757d;
            animation: none;
        }

        .tracking-indicator.cancelled {
            background: #dc3545;
            animation: none;
        }

        @keyframes pulse {
            0%, 100% { 
                opacity: 1; 
                transform: scale(1);
            }
            50% { 
                opacity: 0.6;
                transform: scale(1.15);
            }
        }

        .driver-info {
            background: #f8f9fa;
            padding: 12px;
            border-radius: 8px;
            border-left: 3px solid #007bff;
            margin-top: 10px;
        }

        .driver-info p {
            margin: 6px 0;
            font-size: 0.85rem;
        }

        .back-link {
            color: #6c757d;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }

        .back-link:hover {
            color: #007bff;
        }

        .location-status {
            background: #f8f9fa;
            padding: 12px;
            border-radius: 8px;
            border-left: 3px solid #28a745;
            margin-top: 10px;
        }

        .distance-info {
            background: #f8f9fa;
            padding: 12px;
            border-radius: 8px;
            border-left: 3px solid #007bff;
            margin-top: 10px;
        }

        .map-controls {
            position: absolute;
            top: 70px;
            right: 20px;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .zoom-control {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 6px;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: all 0.2s ease;
        }

        .zoom-control:hover {
            background: #f8f9fa;
            transform: translateY(-1px);
        }

        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 0.9rem;
        }

        .btn-success {
            background: #28a745;
            color: white;
        }

        .btn-success:hover {
            background: #218838;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
        }

        .btn:disabled {
            background: #6c757d;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .status-timeline {
            margin-top: 15px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 3px solid #007bff;
        }

        .status-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            padding: 8px;
            border-radius: 6px;
            background: white;
        }

        .status-item.active {
            background: #e7f3ff;
            border-left: 3px solid #007bff;
        }

        .status-icon {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            font-size: 0.8rem;
        }

        .status-icon.pending {
            background: #ffc107;
            color: #212529;
        }

        .status-icon.accepted {
            background: #17a2b8;
            color: white;
        }

        .status-icon.in-progress {
            background: #28a745;
            color: white;
        }

        .status-icon.completed {
            background: #6c757d;
            color: white;
        }

        .status-details {
            flex: 1;
        }

        .status-time {
            font-size: 0.75rem;
            color: #6c757d;
            margin-top: 2px;
        }

        .tracking-sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .tracking-sidebar::-webkit-scrollbar-track {
            background: #f8f9fa;
        }

        .tracking-sidebar::-webkit-scrollbar-thumb {
            background: #007bff;
            border-radius: 10px;
        }

        @media (max-width: 768px) {
            .tracking-container {
                grid-template-columns: 1fr;
                grid-template-rows: auto 1fr;
            }

            .tracking-sidebar {
                border-right: none;
                border-bottom: 1px solid #e9ecef;
                max-height: 40vh;
            }

            .tracking-status {
                top: 10px;
                left: 10px;
                right: 10px;
                padding: 10px 14px;
                font-size: 0.85rem;
            }

            .map-controls {
                top: 60px;
                right: 10px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="/" class="nav-brand">Fast<span>Lan</span></a>
        <div class="nav-links">
            <a href="{{ route('passenger.pending.bookings') }}" class="nav-link">
                <i class="fas fa-arrow-left"></i> Back to Bookings
            </a>
        </div>
    </nav>

    <div class="tracking-container">
        <div class="tracking-sidebar">
            <a href="{{ route('passenger.pending.bookings') }}" class="back-link">
                <i class="fas fa-arrow-left"></i>
                Back to My Bookings
            </a>

            <div class="tracking-header">
                <h1>
                    <i class="fas fa-route"></i>
                    Active Trip
                </h1>
                <span class="status-badge in-progress" id="overallStatusBadge">IN PROGRESS</span>
                <p style="margin-top: 10px;">Real-time driver location tracking</p>
            </div>

            <div class="info-card">
                <h3><i class="fas fa-history"></i> Trip Status</h3>
                <div id="statusTimeline">
                    <div class="status-item active">
                        <div class="status-icon in-progress">
                            <i class="fas fa-sync-alt fa-spin"></i>
                        </div>
                        <div class="status-details">
                            <strong>Loading status...</strong>
                            <div class="status-time">Updating...</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="info-card">
                <h3><i class="fas fa-user"></i> Driver Details</h3>
                <p><strong><i class="fas fa-user-circle"></i> Name:</strong> {{ $booking->driver->fullname ?? 'N/A' }}</p>
                <p><strong><i class="fas fa-phone"></i> Phone:</strong> {{ $booking->driver->phone ?? 'N/A' }}</p>
                <p><strong><i class="fas fa-car"></i> Vehicle:</strong> {{ $booking->driver->vehicleMake ?? 'N/A' }} {{ $booking->driver->vehicleModel ?? '' }} ({{ $booking->driver->plateNumber ?? 'N/A' }})</p>
                <p><strong><i class="fas fa-chart-line"></i> Completed Trips:</strong> {{ $booking->driver->completedBooking ?? '0' }}</p>
            </div>

            <div class="info-card">
                <h3><i class="fas fa-route"></i> Trip Details</h3>
                <p><strong><i class="fas fa-car"></i> Service:</strong> {{ $booking->getServiceTypeDisplay() }}</p>
                <p><strong><i class="fas fa-map-marker-alt" style="color: #28a745;"></i> Pickup:</strong> {{ $booking->pickupLocation }}</p>
                <p><strong><i class="fas fa-flag-checkered" style="color: #dc3545;"></i> Drop-off:</strong> {{ $booking->dropoffLocation }}</p>
                <p><strong><i class="fas fa-money-bill-wave"></i> Fare:</strong> ₱{{ number_format($booking->fare, 2) }}</p>
                <p><strong><i class="fas fa-credit-card"></i> Payment:</strong> {{ $booking->getPaymentMethodDisplay() }}</p>
                @if($booking->description)
                <p><strong><i class="fas fa-sticky-note"></i> Notes:</strong> {{ $booking->description }}</p>
                @endif
            </div>

            <div class="info-card">
                <h3><i class="fas fa-map-marker-alt"></i> Current Status</h3>
                <div id="locationStatus">
                    <p><i class="fas fa-sync-alt fa-spin"></i> Connecting to driver...</p>
                </div>
                <div id="distanceInfo"></div>
            </div>

            <div class="info-card">
                <h3><i class="fas fa-check-circle"></i> Trip Completion</h3>
                <div id="completionStatus">
                    <p><i class="fas fa-info-circle"></i> Trip in progress...</p>
                </div>
                <div id="completionActions" style="margin-top: 15px;">
                    <button class="btn btn-success" onclick="confirmCompletion()" id="confirmCompletionBtn" style="width: 100%;">
                        <i class="fas fa-check"></i>
                        Confirm Trip Completion
                    </button>
                    <div id="completionMessage" style="margin-top: 10px; font-size: 0.9rem;"></div>
                </div>
                <div class="cancel-section">
                    <div class="cancel-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        Need to cancel this trip?
                    </div>
                    <p class="cancel-note">
                        This action will immediately end the trip and notify the driver.
                    </p>
                    <button class="btn-warning" onclick="cancelOngoingBooking()" id="cancelBookingBtn">
                        <i class="fas fa-times-circle"></i>
                        Cancel Ongoing Trip
                    </button>
                    <div id="cancelMessage"></div>
                </div>
            </div>
        </div>

        <div class="map-container">
            <div class="tracking-status">
                <div class="tracking-indicator" id="trackingIndicator"></div>
                <span id="trackingStatusText">Live Driver Tracking Active</span>
            </div>
            
        <div class="map-controls">
            <button class="zoom-control" onclick="map.zoomIn()">+</button>
            <button class="zoom-control" onclick="map.zoomOut()">-</button>
            <button class="zoom-control" onclick="testDriverLocation()" style="background: #007bff; color: white;">⟳</button>
        </div>
            <div id="trackingMap"></div>
        </div>
    </div>

    

<script>
    let map;
    let driverMarker;
    let pickupMarker;
    let dropoffMarker;
    let updateInterval;
    let statusInterval;

    const bookingData = {
        id: {{ $booking->bookingID }},
        pickup: {
            lat: {{ $booking->pickupLatitude }},
            lng: {{ $booking->pickupLongitude }},
            address: `{{ $booking->pickupLocation }}`
        },
        dropoff: {
            lat: {{ $booking->dropoffLatitude }},
            lng: {{ $booking->dropoffLongitude }},
            address: `{{ $booking->dropoffLocation }}`
        }
    };

    const statusConfig = {
        'pending': {
            badge: 'pending',
            text: 'PENDING',
            indicator: 'pending',
            timeline: {
                icon: 'pending',
                title: 'Booking Request Sent',
                description: 'Waiting for driver to accept your booking'
            }
        },
        'accepted': {
            badge: 'in-progress',
            text: 'ACCEPTED',
            indicator: 'in-progress',
            timeline: {
                icon: 'accepted',
                title: 'Booking Accepted',
                description: 'Driver is on the way to pickup location'
            }
        },
        'in_progress': {
            badge: 'in-progress',
            text: 'IN PROGRESS',
            indicator: 'in-progress',
            timeline: {
                icon: 'in-progress',
                title: 'Trip in Progress',
                description: 'Driver is taking you to your destination'
            }
        },
        'completed': {
            badge: 'completed',
            text: 'COMPLETED',
            indicator: 'completed',
            timeline: {
                icon: 'completed',
                title: 'Trip Completed',
                description: 'You have reached your destination'
            }
        },
        'cancelled': {
            badge: 'cancelled',
            text: 'CANCELLED',
            indicator: 'cancelled',
            timeline: {
                icon: 'cancelled',
                title: 'Trip Cancelled',
                description: 'This trip has been cancelled'
            }
        }
    };

    function initMap() {
        console.log('Initializing map for booking:', bookingData.id);
        
        map = L.map('trackingMap', {
            zoomControl: false
        }).setView([bookingData.pickup.lat, bookingData.pickup.lng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19,
            detectRetina: true
        }).addTo(map);

        const pickupIcon = L.divIcon({
            className: 'pickup-marker',
            html: `
                <div style="position: relative;">
                    <div style="background:#28a745; border:3px solid white; border-radius:50%; width:20px; height:20px; box-shadow:0 2px 8px rgba(0,0,0,0.3);"></div>
                    <div style="position: absolute; top: -25px; left: 50%; transform: translateX(-50%); background: #28a745; color: white; padding: 2px 8px; border-radius: 10px; font-size: 10px; font-weight: bold; white-space: nowrap;">
                        PICKUP
                    </div>
                </div>
            `,
            iconSize: [20, 45],
            iconAnchor: [10, 20]
        });

        pickupMarker = L.marker([bookingData.pickup.lat, bookingData.pickup.lng], { icon: pickupIcon })
            .addTo(map)
            .bindPopup(`
                <div style="text-align: center; min-width: 200px;">
                    <strong style="color: #28a745;">📍 PICKUP LOCATION</strong><br>
                    <hr style="margin: 5px 0;">
                    ${bookingData.pickup.address}
                </div>
            `);

        const dropoffIcon = L.divIcon({
            className: 'dropoff-marker',
            html: `
                <div style="position: relative;">
                    <div style="background:#dc3545; border:3px solid white; border-radius:50%; width:20px; height:20px; box-shadow:0 2px 8px rgba(0,0,0,0.3);"></div>
                    <div style="position: absolute; top: -25px; left: 50%; transform: translateX(-50%); background: #dc3545; color: white; padding: 2px 8px; border-radius: 10px; font-size: 10px; font-weight: bold; white-space: nowrap;">
                        DROP-OFF
                    </div>
                </div>
            `,
            iconSize: [20, 45],
            iconAnchor: [10, 20]
        });

        dropoffMarker = L.marker([bookingData.dropoff.lat, bookingData.dropoff.lng], { icon: dropoffIcon })
            .addTo(map)
            .bindPopup(`
                <div style="text-align: center; min-width: 200px;">
                    <strong style="color: #dc3545;">🏁 DROP-OFF LOCATION</strong><br>
                    <hr style="margin: 5px 0;">
                    ${bookingData.dropoff.address}
                </div>
            `);

        startTrackingUpdates();
        startStatusUpdates();
    }

    function startTrackingUpdates() {
        console.log('Starting tracking updates...');
        updateDriverLocation();
        updateInterval = setInterval(updateDriverLocation, 3000);
    }

    function startStatusUpdates() {
        updateBookingStatus();
        statusInterval = setInterval(updateBookingStatus, 10000);
    }

    function updateBookingStatus() {
        fetch(`/digilink/public/passenger/get-booking-location/${bookingData.id}?_t=${Date.now()}`)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                console.log('Status update response:', data);
                if (data.success) {
                    updateStatusDisplay(data.booking.status);
                    if (['completed', 'cancelled'].includes(data.booking.status)) {
                        stopTracking();
                    }
                }
            })
            .catch(error => {
                console.error('Error fetching booking status:', error);
            });
    }

    function updateStatusDisplay(status) {
        const config = statusConfig[status] || statusConfig.in_progress;
        
        const statusBadge = document.getElementById('overallStatusBadge');
        if (statusBadge) {
            statusBadge.textContent = config.text;
            statusBadge.className = `status-badge ${config.badge}`;
        }
        
        const trackingIndicator = document.getElementById('trackingIndicator');
        if (trackingIndicator) {
            trackingIndicator.className = `tracking-indicator ${config.indicator}`;
        }
        
        const trackingStatusText = document.getElementById('trackingStatusText');
        if (trackingStatusText) {
            trackingStatusText.textContent = getStatusText(status);
        }
        
        updateStatusTimeline(status);
        
        const cancelBtn = document.getElementById('cancelBookingBtn');
        if (cancelBtn && (status === 'completed' || status === 'cancelled')) {
            cancelBtn.style.display = 'none';
        }
    }

    function getStatusText(status) {
        const statusTexts = {
            'pending': 'Waiting for Driver Acceptance',
            'accepted': 'Driver is Coming to Pickup',
            'in_progress': 'Live Driver Tracking Active',
            'completed': 'Trip Completed',
            'cancelled': 'Trip Cancelled'
        };
        return statusTexts[status] || 'Live Driver Tracking Active';
    }

    function updateStatusTimeline(currentStatus) {
        const timeline = document.getElementById('statusTimeline');
        if (!timeline) return;

        const statuses = ['pending', 'accepted', 'in_progress', 'completed'];
        
        let timelineHTML = '';
        
        statuses.forEach(status => {
            const config = statusConfig[status];
            const isActive = status === currentStatus;
            const isPast = statuses.indexOf(status) < statuses.indexOf(currentStatus);
            
            timelineHTML += `
                <div class="status-item ${isActive ? 'active' : ''}">
                    <div class="status-icon ${config.timeline.icon} ${isPast ? 'completed' : ''}">
                        ${isActive && status !== 'completed' ? '<i class="fas fa-sync-alt fa-spin"></i>' : 
                          isPast ? '<i class="fas fa-check"></i>' : 
                          `<i class="fas fa-${getStatusIcon(status)}"></i>`}
                    </div>
                    <div class="status-details">
                        <strong>${config.timeline.title}</strong>
                        <div class="status-time">${config.timeline.description}</div>
                    </div>
                </div>
            `;
        });
        
        timeline.innerHTML = timelineHTML;
    }

    function getStatusIcon(status) {
        const icons = {
            'pending': 'clock',
            'accepted': 'user-check',
            'in_progress': 'car',
            'completed': 'flag-checkered'
        };
        return icons[status] || 'info-circle';
    }

function updateDriverLocation() {
    const url = `/digilink/public/passenger/get-driver-location/${bookingData.id}?_t=${Date.now()}`;
    console.log('Fetching driver location from:', url);

    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Driver location API response:', data);
            
            if (data.success) {
                updateStatusDisplay(data.booking.status);
                
                if (data.driver && data.driver.current_lat != null && data.driver.current_lng != null) {
                    // Ensure coordinates are numbers, not strings
                    const driverLat = parseFloat(data.driver.current_lat);
                    const driverLng = parseFloat(data.driver.current_lng);
                    
                    console.log('Driver location processed:', {
                        lat: driverLat,
                        lng: driverLng,
                        type_lat: typeof driverLat,
                        type_lng: typeof driverLng,
                        is_fallback: data.driver.is_fallback,
                        source: data.debug?.location_source || 'unknown',
                        debug: data.debug
                    });
                    
                    // Validate coordinates are valid numbers
                    if (!isNaN(driverLat) && !isNaN(driverLng) && 
                        driverLat >= -90 && driverLat <= 90 && 
                        driverLng >= -180 && driverLng <= 180) {
                        
                        updateDriverPosition(driverLat, driverLng);
                        updateDistanceInfo(data.distance_info);
                        
                        const statusMsg = data.driver.is_fallback ? 
                            'Using approximate location (waiting for driver GPS)' : 
                            'Live GPS tracking active';
                        
                        updateLocationStatus('success', `${statusMsg} - ${data.driver.name}`);
                        
                        if (driverMarker) {
                            driverMarker.setPopupContent(`
                                <div style="text-align: center; min-width: 200px;">
                                    <strong>🚗 YOUR DRIVER</strong><br>
                                    <hr style="margin: 5px 0;">
                                    ${data.driver.name}<br>
                                    ${data.driver.vehicle}<br>
                                    <small>Phone: ${data.driver.phone}</small>
                                    <br><small>Last update: ${new Date().toLocaleTimeString()}</small>
                                    ${data.driver.is_fallback ? '<br><small style="color: orange;">⚠️ Using approximate location</small>' : ''}
                                </div>
                            `);
                        }
                    } else {
                        console.error('Invalid coordinates received:', driverLat, driverLng);
                        updateLocationStatus('error', 'Received invalid driver coordinates');
                    }
                } else {
                    console.log('No valid driver location in response:', data);
                    updateLocationStatus('waiting', 'Waiting for driver location updates...');
                }
                
                if (['completed', 'cancelled'].includes(data.booking.status)) {
                    console.log('Booking completed/cancelled, stopping tracking');
                    stopTracking();
                }
            } else {
                console.error('API returned error:', data.message);
                updateLocationStatus('error', data.message || 'Unable to fetch booking data');
            }
        })
        .catch(error => {
            console.error('Error fetching driver location:', error);
            updateLocationStatus('error', 'Unable to fetch driver location: ' + error.message);
        });
}
    function updateDriverPosition(lat, lng) {
        console.log('Updating driver position on map:', lat, lng);
        
        if (!driverMarker) {
            console.log('Creating new driver marker');
            const driverIcon = L.divIcon({
                className: 'driver-marker',
                html: `
                    <div style="position: relative;">
                        <div style="background:#212529; border:3px solid white; border-radius:50%; width:16px; height:16px; box-shadow:0 2px 8px rgba(0,0,0,0.3);"></div>
                        <div style="position: absolute; top: -22px; left: 50%; transform: translateX(-50%); background: #212529; color: white; padding: 2px 6px; border-radius: 8px; font-size: 9px; font-weight: bold; white-space: nowrap;">
                            DRIVER
                        </div>
                    </div>
                `,
                iconSize: [16, 38],
                iconAnchor: [8, 16]
            });

            driverMarker = L.marker([lat, lng], { icon: driverIcon })
                .addTo(map)
                .bindPopup(`
                    <div style="text-align: center; min-width: 200px;">
                        <strong>🚗 YOUR DRIVER</strong><br>
                        <hr style="margin: 5px 0;">
                        {{ $booking->driver->fullname ?? 'Driver' }}<br>
                        {{ $booking->driver->vehicleMake ?? '' }} {{ $booking->driver->vehicleModel ?? '' }}
                    </div>
                `);

            const group = new L.featureGroup([pickupMarker, dropoffMarker, driverMarker]);
            map.fitBounds(group.getBounds().pad(0.2));
        } else {
            driverMarker.setLatLng([lat, lng]);
        }
    }

    function updateLocationStatus(type, message) {
        const locationStatus = document.getElementById('locationStatus');
        if (!locationStatus) return;

        const statusIcons = {
            'success': '<i class="fas fa-check-circle" style="color: #28a745;"></i>',
            'waiting': '<i class="fas fa-clock" style="color: #6c757d;"></i>',
            'error': '<i class="fas fa-exclamation-triangle" style="color: #dc3545;"></i>'
        };

        let statusHTML = `<p>${statusIcons[type]} ${message}</p>`;
        
        if (type === 'success') {
            statusHTML += `
                <p style="font-size: 0.8rem; color: #6c757d; margin-top: 5px;">
                    Last update: ${new Date().toLocaleTimeString()}
                </p>
            `;
        }

        locationStatus.innerHTML = statusHTML;
    }

    function updateDistanceInfo(distanceInfo) {
        const distanceInfoElement = document.getElementById('distanceInfo');
        if (distanceInfoElement) {
            distanceInfoElement.innerHTML = `
                <div class="location-status">
                    <p><i class="fas fa-route" style="color: #28a745;"></i> <strong>Driver to Pickup:</strong> ${distanceInfo.to_pickup_km} km</p>
                    <p><i class="fas fa-clock" style="color: #6c757d;"></i> <strong>Est. Time:</strong> ${distanceInfo.est_time_to_pickup_min} min</p>
                </div>
                <div class="distance-info">
                    <p><i class="fas fa-flag-checkered" style="color: #dc3545;"></i> <strong>Driver to Drop-off:</strong> ${distanceInfo.to_dropoff_km} km</p>
                    <p><i class="fas fa-clock" style="color: #6c757d;"></i> <strong>Est. Time:</strong> ${distanceInfo.est_time_to_dropoff_min} min</p>
                    <p><i class="fas fa-road" style="color: #007bff;"></i> <strong>Trip Distance:</strong> ${distanceInfo.total_trip_km} km</p>
                </div>
            `;
        }
    }

    function confirmCompletion() {
        if (!confirm('Are you sure you want to confirm trip completion?\n\nPlease ensure you have reached your destination safely and received your service.')) {
            return;
        }

        const confirmBtn = document.getElementById('confirmCompletionBtn');
        const originalText = confirmBtn.innerHTML;
        confirmBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Confirming...';
        confirmBtn.disabled = true;

        fetch(`/digilink/public/passenger/confirm-completion/${bookingData.id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            if (data.success) {
                updateCompletionStatus(data.completion_status, data.is_completed);
                showCompletionMessage(data.message, 'success');
                
                if (data.is_completed) {
                    stopTracking();
                    updateStatusDisplay('completed');
                    setTimeout(() => {
                        window.location.href = "{{ route('passenger.pending.bookings') }}";
                    }, 3000);
                }
            } else {
                throw new Error(data.message || 'Failed to confirm completion');
            }
        })
        .catch(error => {
            console.error('Error confirming completion:', error);
            showCompletionMessage(error.message, 'error');
            confirmBtn.innerHTML = originalText;
            confirmBtn.disabled = false;
        });
    }

    function updateCompletionStatus(status, isCompleted) {
        const completionStatus = document.getElementById('completionStatus');
        if (!completionStatus) return;

        const statusMessages = {
            'pending': `
                <div style="color: #6c757d;">
                    <i class="fas fa-clock"></i> <strong>Status:</strong> Waiting for completion confirmation...
                </div>
            `,
            'driver_confirmed': `
                <div style="color: #007bff;">
                    <i class="fas fa-user-check"></i> <strong>Status:</strong> Driver has confirmed completion
                </div>
                <div style="font-size: 0.8rem; color: #6c757d; margin-top: 5px;">
                    Waiting for your confirmation...
                </div>
            `,
            'passenger_confirmed': `
                <div style="color: #28a745;">
                    <i class="fas fa-user-check"></i> <strong>Status:</strong> You have confirmed completion
                </div>
                <div style="font-size: 0.8rem; color: #6c757d; margin-top: 5px;">
                    Waiting for driver confirmation...
                </div>
            `,
            'both_confirmed': `
                <div style="color: #28a745;">
                    <i class="fas fa-check-double"></i> <strong>Status:</strong> Trip completed successfully!
                </div>
                <div style="font-size: 0.8rem; color: #6c757d; margin-top: 5px;">
                    Redirecting to bookings...
                </div>
            `
        };

        completionStatus.innerHTML = statusMessages[status] || statusMessages.pending;

        const confirmBtn = document.getElementById('confirmCompletionBtn');
        if (confirmBtn) {
            if (isCompleted || status === 'both_confirmed') {
                confirmBtn.style.display = 'none';
            } else if (status === 'passenger_confirmed') {
                confirmBtn.style.display = 'none';
            }
        }
    }

    function showCompletionMessage(message, type) {
        const completionMessage = document.getElementById('completionMessage');
        if (!completionMessage) return;

        const colors = {
            'success': '#28a745',
            'error': '#dc3545'
        };
        const backgrounds = {
            'success': '#d4edda',
            'error': '#f8d7da'
        };
        const borders = {
            'success': '#c3e6cb',
            'error': '#f5c6cb'
        };

        completionMessage.innerHTML = `
            <div style="color: ${colors[type]}; font-weight: 600; padding: 10px; background: ${backgrounds[type]}; border-radius: 8px; border: 1px solid ${borders[type]};">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'}"></i> ${message}
            </div>
        `;
    }

    function stopTracking() {
        console.log('Stopping tracking...');
        if (updateInterval) {
            clearInterval(updateInterval);
            updateInterval = null;
        }
        if (statusInterval) {
            clearInterval(statusInterval);
            statusInterval = null;
        }
    }

    function cancelOngoingBooking() {
        if (!confirm('Are you sure you want to cancel this ongoing trip?\n\n⚠️ This action cannot be undone. The driver will be notified immediately.')) {
            return;
        }

        const cancelBtn = document.getElementById('cancelBookingBtn');
        const originalText = cancelBtn.innerHTML;
        cancelBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Cancelling...';
        cancelBtn.disabled = true;

        fetch(`/digilink/public/passenger/cancel-ongoing-booking/${bookingData.id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            if (data.success) {
                const cancelMessage = document.getElementById('cancelMessage');
                if (cancelMessage) {
                    cancelMessage.innerHTML = `
                        <div class="cancel-success">
                            <i class="fas fa-check-circle"></i> ${data.message}
                        </div>
                    `;
                }
                
                stopTracking();
                updateStatusDisplay('cancelled');
                
                const confirmBtn = document.getElementById('confirmCompletionBtn');
                if (confirmBtn) {
                    confirmBtn.disabled = true;
                    confirmBtn.innerHTML = '<i class="fas fa-ban"></i> Trip Cancelled';
                }
                
                if (cancelBtn) {
                    cancelBtn.style.display = 'none';
                }
                
                setTimeout(() => {
                    window.location.href = "{{ route('passenger.pending.bookings') }}";
                }, 3000);
            } else {
                throw new Error(data.message);
            }
        })
        .catch(error => {
            console.error('Error cancelling booking:', error);
            const cancelMessage = document.getElementById('cancelMessage');
            if (cancelMessage) {
                cancelMessage.innerHTML = `
                    <div class="cancel-error">
                        <i class="fas fa-exclamation-triangle"></i> ${error.message}
                    </div>
                `;
            }
            if (cancelBtn) {
                cancelBtn.innerHTML = originalText;
                cancelBtn.disabled = false;
            }
        });
    }

    window.addEventListener('beforeunload', stopTracking);

    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded, initializing tracking...');
        initMap();
        updateBookingStatus();
    });
</script>
</body>
</html>