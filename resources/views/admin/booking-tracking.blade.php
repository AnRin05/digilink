<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        :root {
            --primary-red: #dc3545;
            --dark-red: #c82333;
            --black: #212529;
            --white: #ffffff;
            --light-bg: #f1f1f1;
            --border-color: rgba(0, 0, 0, 0.08);
            --hover-bg: rgba(220, 53, 69, 0.1);
        }

        body {
            background-color: var(--light-bg);
            color: var(--black);
            min-height: 100vh;
        }

        /* Admin Header */
        .admin-header {
            background: linear-gradient(135deg, var(--black) 0%, #343a40 100%);
            padding: 1.5rem 3rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 3px solid var(--primary-red);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .admin-header h1 {
            color: var(--primary-red);
            font-size: 2.2rem;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(220, 53, 69, 0.3);
            margin: 0;
        }

        .admin-nav {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: flex-end;
            margin-left: auto;
        }

        .admin-nav a {
            color: var(--white);
            text-decoration: none;
            font-weight: 500;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            background: rgba(255, 255, 255, 0.1);
            white-space: nowrap;
        }

        .admin-nav a::after {
            content: '';
            position: absolute;
            bottom: 5px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: var(--primary-red);
            transition: width 0.3s ease;
        }

        .admin-nav a:hover::after {
            width: 80%;
        }

        .admin-nav a:hover {
            color: var(--primary-red);
            background: var(--hover-bg);
            transform: translateY(-2px);
        }

        .tracking-container {
            display: grid;
            grid-template-columns: 400px 1fr;
            height: calc(100vh - 80px);
        }

        .tracking-sidebar {
            background: white;
            border-right: 1px solid var(--border-color);
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
            color: var(--black);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
        }

        .tracking-header h1 i {
            color: var(--primary-red);
        }

        .status-badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-badge.pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-badge.accepted {
            background: #d1ecf1;
            color: #0c5460;
        }

        .status-badge.in-progress {
            background: #d1e7ff;
            color: #004085;
        }

        .status-badge.completed {
            background: #d4edda;
            color: #155724;
        }

        .status-badge.cancelled {
            background: #f8d7da;
            color: #721c24;
        }

        .info-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 16px;
            border: 2px solid var(--border-color);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .info-card h3 {
            color: var(--black);
            margin-bottom: 16px;
            font-size: 1.05rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-card h3 i {
            color: var(--primary-red);
        }

        .info-card p {
            margin: 8px 0;
            color: #495057;
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .info-card p strong {
            color: var(--black);
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
            background: white;
            padding: 14px 18px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.12);
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--black);
            border: 1px solid var(--border-color);
        }

        .tracking-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #28a745;
            animation: pulse 2s infinite;
        }

        .tracking-indicator.pending { background: #ffc107; }
        .tracking-indicator.accepted { background: #17a2b8; }
        .tracking-indicator.in-progress { background: #007bff; }
        .tracking-indicator.completed { background: #28a745; }
        .tracking-indicator.cancelled { background: #dc3545; }

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
            color: var(--primary-red);
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
            border: 1px solid var(--border-color);
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

        .driver-info, .location-status, .distance-info {
            background: #f8f9fa;
            padding: 12px;
            border-radius: 8px;
            border-left: 3px solid var(--primary-red);
            margin-top: 10px;
        }

        .location-status p {
            margin: 5px 0;
            font-size: 0.85rem;
        }

        .update-time {
            font-size: 0.75rem;
            color: #6c757d;
            margin-top: 5px;
        }

        .status-timeline {
            margin-top: 15px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 3px solid var(--primary-red);
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
            border-left: 3px solid var(--primary-red);
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

        .status-icon.pending { background: #ffc107; color: #212529; }
        .status-icon.accepted { background: #17a2b8; color: white; }
        .status-icon.in-progress { background: #28a745; color: white; }
        .status-icon.completed { background: #6c757d; color: white; }

        .status-details {
            flex: 1;
        }

        .status-time {
            font-size: 0.75rem;
            color: #6c757d;
            margin-top: 2px;
        }

        @media (max-width: 768px) {
            .tracking-container {
                grid-template-columns: 1fr;
                grid-template-rows: auto 1fr;
            }

            .tracking-sidebar {
                border-right: none;
                border-bottom: 1px solid var(--border-color);
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

        /* Ensure markers are visible */
        .driver-marker, .pickup-marker, .dropoff-marker {
            z-index: 1000 !important;
        }

        .leaflet-marker-icon {
            z-index: 1000 !important;
        }
    </style>
</head>
<body>
    <header class="admin-header">
        <div class="header-left">
            <h1>Admin Dashboard</h1>
        </div>
        <nav class="admin-nav">
            <a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="{{ route('admin.bookings.current') }}"><i class="fas fa-clock"></i> Current Bookings</a>
            <a href="{{ route('admin.reports') }}"><i class="fas fa-file-alt"></i> Reports</a>
        </nav>
    </header>

    <div class="tracking-container">
        <div class="tracking-sidebar">
            <a href="{{ route('admin.bookings.current') }}" class="back-link">
                <i class="fas fa-arrow-left"></i>
                Back to Current Bookings
            </a>

            <div class="tracking-header">
                <h1>
                    <i class="fas fa-map-marker-alt"></i>
                    Admin Booking Tracking
                </h1>
                <span id="statusBadge" class="status-badge {{ str_replace('_', '-', $booking->status) }}">
                    {{ strtoupper(str_replace('_', ' ', $booking->status)) }}
                </span>
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
                <h3><i class="fas fa-info-circle"></i> Booking Information</h3>
                <p><strong>Booking ID:</strong> {{ $booking->bookingID }}</p>
                <p><strong>Service Type:</strong> {{ $booking->getServiceTypeDisplay() }}</p>
                <p><strong>Status:</strong> <span id="statusText">{{ strtoupper(str_replace('_', ' ', $booking->status)) }}</span></p>
                <p><strong>Fare:</strong> ₱{{ number_format($booking->fare, 2) }}</p>
                <p><strong>Payment:</strong> {{ $booking->getPaymentMethodDisplay() }}</p>
                <p><strong>Created:</strong> {{ $booking->created_at->format('M d, Y h:i A') }}</p>
            </div>

            <div class="info-card">
                <h3><i class="fas fa-user"></i> Passenger Details</h3>
                <p><strong>Name:</strong> {{ $booking->passenger->fullname ?? 'N/A' }}</p>
                <p><strong>Email:</strong> {{ $booking->passenger->email ?? 'N/A' }}</p>
                <p><strong>Phone:</strong> {{ $booking->passenger->phone ?? 'N/A' }}</p>
            </div>

            <div class="info-card">
                <h3><i class="fas fa-user-tie"></i> Driver Details</h3>
                @if($booking->driver)
                    <div class="driver-info">
                        <p><strong>Name:</strong> {{ $booking->driver->fullname }}</p>
                        <p><strong>Email:</strong> {{ $booking->driver->email }}</p>
                        <p><strong>Phone:</strong> {{ $booking->driver->phone ?? 'N/A' }}</p>
                        <p><strong>Vehicle:</strong> {{ $booking->driver->vehicleMake ?? 'N/A' }} {{ $booking->driver->vehicleModel ?? '' }}</p>
                        <p><strong>Plate:</strong> {{ $booking->driver->plateNumber ?? 'N/A' }}</p>
                        <p><strong>Completed Trips:</strong> {{ $booking->driver->completedBooking ?? '0' }}</p>
                    </div>
                @else
                    <p style="color: #6c757d; font-style: italic;">No driver assigned yet</p>
                @endif
            </div>

            <div class="info-card">
                <h3><i class="fas fa-route"></i> Trip Details</h3>
                <div class="location-status">
                    <p><strong style="color: #28a745;">📍 Pickup:</strong> {{ $booking->pickupLocation }}</p>
                    <p><strong style="color: #dc3545;">🏁 Drop-off:</strong> {{ $booking->dropoffLocation }}</p>
                </div>
                <div id="distanceInfo" class="distance-info">
                    <p><i class="fas fa-sync-alt fa-spin"></i> Calculating distances...</p>
                </div>
            </div>

            <div class="info-card">
                <h3><i class="fas fa-map-marker-alt"></i> Live Tracking</h3>
                <div id="locationStatus">
                    <p><i class="fas fa-sync-alt fa-spin"></i> Initializing tracking...</p>
                </div>
                <div id="lastUpdate" class="update-time"></div>
            </div>
        </div>

        <div class="map-container">
            <div class="tracking-status">
                <div id="trackingIndicator" class="tracking-indicator {{ str_replace('_', '-', $booking->status) }}"></div>
                <span id="trackingStatusText">Live Tracking Active</span>
            </div>
            
            <div class="map-controls">
                <button class="zoom-control" onclick="map.zoomIn()">+</button>
                <button class="zoom-control" onclick="map.zoomOut()">-</button>
                <button class="zoom-control" onclick="refreshTracking()" title="Refresh" style="background: #007bff; color: white;">⟳</button>
            </div>
            
            <div id="trackingMap"></div>
        </div>
    </div>

<script>
    // Global variables
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
                description: 'Waiting for driver to accept the booking'
            }
        },
        'accepted': {
            badge: 'accepted',
            text: 'ACCEPTED',
            indicator: 'accepted',
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
                description: 'Driver is taking passenger to destination'
            }
        },
        'completed': {
            badge: 'completed',
            text: 'COMPLETED',
            indicator: 'completed',
            timeline: {
                icon: 'completed',
                title: 'Trip Completed',
                description: 'Passenger has reached destination'
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
        console.log('Initializing admin tracking map for booking:', bookingData.id);
        
        map = L.map('trackingMap', {
            zoomControl: false
        }).setView([bookingData.pickup.lat, bookingData.pickup.lng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19,
            detectRetina: true
        }).addTo(map);

        // Add zoom control
        L.control.zoom({
            position: 'topright'
        }).addTo(map);

        // Pickup marker
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

        // Dropoff marker
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
    }

    function startTrackingUpdates() {
        console.log('Starting admin tracking updates...');
        updateDriverLocation();
        updateInterval = setInterval(updateDriverLocation, 2000); // 2 seconds as requested
    }

    function updateDriverLocation() {
        const bookingId = {{ $booking->bookingID }};
        
        // CORRECT URL - matches your route definition
        const url = `/admin/get-driver-location/${bookingId}?_t=${Date.now()}`;
        
        console.log('Admin fetching driver location from:', url);
        
        fetch(url, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        })
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Admin driver location API response:', data);
            
            if (data.success) {
                updateStatusDisplay(data.booking.status);
                
                if (data.driver && data.driver.current_lat != null && data.driver.current_lng != null) {
                    const driverLat = parseFloat(data.driver.current_lat);
                    const driverLng = parseFloat(data.driver.current_lng);
                    
                    console.log('Admin driver location processed:', {
                        lat: driverLat,
                        lng: driverLng,
                        is_fallback: data.driver.is_fallback
                    });
                    
                    // Validate coordinates
                    if (!isNaN(driverLat) && !isNaN(driverLng)) {
                        updateDriverPosition(driverLat, driverLng, data.driver);
                        updateDistanceInfo(data.distance_info);
                        
                        const statusMsg = data.driver.is_fallback ? 
                            'Using approximate location' : 
                            'Live GPS tracking active';
                        
                        updateLocationStatus('success', `${statusMsg} - ${data.driver.name}`);
                        
                    } else {
                        console.error('Invalid coordinates:', driverLat, driverLng);
                        updateLocationStatus('error', 'Invalid driver coordinates received');
                    }
                } else {
                    console.log('No driver location available');
                    updateLocationStatus('waiting', 'Waiting for driver location...');
                }
                
                // Stop tracking if booking is completed/cancelled
                if (['completed', 'cancelled'].includes(data.booking.status)) {
                    console.log('Booking ended, stopping tracking');
                    stopTracking();
                }
            } else {
                console.error('API error:', data.message);
                updateLocationStatus('error', data.message || 'Failed to fetch driver location');
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            updateLocationStatus('error', 'Network error: ' + error.message);
        });
    }

    function updateDriverPosition(lat, lng, driverData) {
        console.log('Updating driver position on admin map:', lat, lng);
        
        const driverIcon = L.divIcon({
            className: 'driver-marker',
            html: `
                <div style="position: relative;">
                    <div style="background:#007bff; border:3px solid white; border-radius:50%; width:24px; height:24px; box-shadow:0 2px 8px rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-car" style="color: white; font-size: 10px;"></i>
                    </div>
                    <div style="position: absolute; top: -28px; left: 50%; transform: translateX(-50%); background: #007bff; color: white; padding: 2px 8px; border-radius: 10px; font-size: 10px; font-weight: bold; white-space: nowrap;">
                        DRIVER
                    </div>
                    ${driverData.is_fallback ? '<div style="position: absolute; top: 30px; left: 50%; transform: translateX(-50%); background: #ffc107; color: #212529; padding: 1px 6px; border-radius: 8px; font-size: 8px; font-weight: bold;">APPROX</div>' : ''}
                </div>
            `,
            iconSize: [24, driverData.is_fallback ? 50 : 38],
            iconAnchor: [12, driverData.is_fallback ? 25 : 19]
        });

        if (!driverMarker) {
            console.log('Creating new driver marker for admin');
            driverMarker = L.marker([lat, lng], { 
                icon: driverIcon,
                zIndexOffset: 1000
            }).addTo(map);
            
            // Fit map to show all markers
            fitMapToMarkers();
        } else {
            driverMarker.setLatLng([lat, lng]);
            driverMarker.setIcon(driverIcon);
        }

        // Update popup content
        const popupContent = `
            <div style="text-align: center; min-width: 200px;">
                <strong style="color: #007bff;">🚗 DRIVER LOCATION</strong><br>
                <hr style="margin: 5px 0;">
                ${driverData.name}<br>
                ${driverData.vehicle}<br>
                <small>Phone: ${driverData.phone}</small>
                <br><small>Completed Trips: ${driverData.completed_trips || '0'}</small>
                <br><small>Last update: ${new Date().toLocaleTimeString()}</small>
                ${driverData.is_fallback ? '<br><small style="color: orange;">⚠️ Using approximate location</small>' : ''}
            </div>
        `;

        if (driverMarker.getPopup()) {
            driverMarker.setPopupContent(popupContent);
        } else {
            driverMarker.bindPopup(popupContent);
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

        let statusHTML = `<p>${statusIcons[type] || ''} ${message}</p>`;
        
        if (type === 'success') {
            statusHTML += `
                <p style="font-size: 0.8rem; color: #6c757d; margin-top: 5px;">
                    Last update: ${new Date().toLocaleTimeString()}
                </p>
            `;
        }

        locationStatus.innerHTML = statusHTML;
        updateLastUpdateTime();
    }

    function updateDistanceInfo(distanceInfo) {
        const distanceElement = document.getElementById('distanceInfo');
        if (distanceInfo) {
            distanceElement.innerHTML = `
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
        } else {
            distanceElement.innerHTML = `<p><i class="fas fa-sync-alt fa-spin"></i> Calculating distances...</p>`;
        }
    }

    function updateStatusDisplay(status) {
        const config = statusConfig[status] || statusConfig.in_progress;
        
        // Update status badge
        const statusBadge = document.getElementById('statusBadge');
        if (statusBadge) {
            statusBadge.textContent = config.text;
            statusBadge.className = `status-badge ${config.badge}`;
        }
        
        // Update status text
        const statusText = document.getElementById('statusText');
        if (statusText) {
            statusText.textContent = config.text;
        }
        
        // Update tracking indicator
        const trackingIndicator = document.getElementById('trackingIndicator');
        if (trackingIndicator) {
            trackingIndicator.className = `tracking-indicator ${config.indicator}`;
        }
        
        // Update tracking status text
        const trackingStatusText = document.getElementById('trackingStatusText');
        if (trackingStatusText) {
            trackingStatusText.textContent = getStatusText(status);
        }
        
        updateStatusTimeline(status);
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

    function updateLastUpdateTime() {
        const lastUpdateElement = document.getElementById('lastUpdate');
        const now = new Date();
        if (lastUpdateElement) {
            lastUpdateElement.textContent = `Last updated: ${now.toLocaleTimeString()}`;
        }
    }

    function fitMapToMarkers() {
        const bounds = L.latLngBounds();
        
        // Add pickup marker to bounds
        if (pickupMarker) {
            bounds.extend(pickupMarker.getLatLng());
        }
        
        // Add dropoff marker to bounds
        if (dropoffMarker) {
            bounds.extend(dropoffMarker.getLatLng());
        }
        
        // Add driver marker to bounds if available
        if (driverMarker) {
            bounds.extend(driverMarker.getLatLng());
        }
        
        // If we have any markers, fit the map to them
        if (bounds.isValid()) {
            map.fitBounds(bounds, { padding: [20, 20] });
        } else {
            // Fallback to pickup location
            const pickupLatLng = [{{ $booking->pickupLatitude }}, {{ $booking->pickupLongitude }}];
            map.setView(pickupLatLng, 13);
        }
    }

    function refreshTracking() {
        console.log('Manual refresh triggered for admin');
        updateDriverLocation();
    }

    function stopTracking() {
        console.log('Stopping admin tracking...');
        if (updateInterval) {
            clearInterval(updateInterval);
            updateInterval = null;
        }
        
        updateLocationStatus('success', 'Tracking stopped - Booking completed/cancelled');
        
        const trackingStatusText = document.getElementById('trackingStatusText');
        if (trackingStatusText) {
            trackingStatusText.textContent = 'Tracking Ended';
        }
    }

    // Test function to verify the URL works
    function testAdminAPI() {
        const bookingId = {{ $booking->bookingID }};
        const url = `/admin/get-driver-location/${bookingId}`;
        
        console.log('Testing admin API URL:', url);
        
        fetch(url)
            .then(response => {
                console.log('Test Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Test API Response:', data);
                alert(`Admin API Test Results:\n\n` +
                      `Success: ${data.success}\n` +
                      `Booking Status: ${data.booking?.status}\n` +
                      `Driver Name: ${data.driver?.name}\n` +
                      `Driver Lat: ${data.driver?.current_lat}\n` +
                      `Driver Lng: ${data.driver?.current_lng}\n\n` +
                      `Check browser console for full details`);
            })
            .catch(error => {
                console.error('Test API Error:', error);
                alert('Admin API Test Failed: ' + error.message);
            });
    }

    // Initialize map when DOM is fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded, initializing admin tracking map...');
        initMap();
        
        // Add test button to map controls
        const mapControls = document.querySelector('.map-controls');
        if (mapControls) {
            const testBtn = document.createElement('button');
            testBtn.className = 'zoom-control';
            testBtn.innerHTML = '🧪';
            testBtn.title = 'Test Admin API';
            testBtn.style.background = '#28a745';
            testBtn.style.color = 'white';
            testBtn.onclick = testAdminAPI;
            mapControls.appendChild(testBtn);
        }
    });

    // Clean up on page unload
    window.addEventListener('beforeunload', stopTracking);
</script>
</body>
</html>