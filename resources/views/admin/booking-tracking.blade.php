<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - FastLan Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
    <link rel="icon" href="{{ asset('images/fastlan1.png') }}">
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
            --light-bg: #f8f9fa;
            --border-color: #e9ecef;
            --hover-bg: rgba(220, 53, 69, 0.1);
        }

        body {
            background-color: var(--light-bg);
            color: var(--black);
            min-height: 100vh;
        }

        .admin-header {
            background: linear-gradient(135deg, var(--black) 0%, #343a40 100%);
            padding: 1.2rem 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 3px solid var(--primary-red);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .admin-header h1 {
            color: var(--primary-red);
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
        }

        .admin-header h1 span {
            color: var(--white);
        }

        .admin-nav {
            display: flex;
            gap: 1rem;
        }

        .admin-nav a {
            color: var(--white);
            text-decoration: none;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 6px;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.1);
        }

        .admin-nav a:hover {
            color: var(--primary-red);
            background: var(--hover-bg);
            transform: translateY(-1px);
        }

        .tracking-container {
            display: grid;
            grid-template-columns: 380px 1fr;
            height: calc(100vh - 80px);
        }

        .tracking-sidebar {
            background: white;
            border-right: 1px solid var(--border-color);
            padding: 20px;
            overflow-y: auto;
        }

        .tracking-header {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--border-color);
        }

        .tracking-header h1 {
            font-size: 1.3rem;
            color: var(--black);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
        }

        .tracking-header h1 i {
            color: var(--primary-red);
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 0.7rem;
            font-weight: 600;
            background: var(--primary-red);
            color: white;
        }

        .status-badge.pending { background: #ffc107; color: #212529; }
        .status-badge.accepted { background: #17a2b8; color: white; }
        .status-badge.in-progress { background: var(--primary-red); color: white; }
        .status-badge.completed { background: #28a745; color: white; }
        .status-badge.cancelled { background: #6c757d; color: white; }

        .info-card {
            background: white;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 12px;
            border: 1px solid var(--border-color);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .info-card h3 {
            color: var(--black);
            margin-bottom: 12px;
            font-size: 0.95rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .info-card h3 i {
            color: var(--primary-red);
        }

        .info-card p {
            margin: 6px 0;
            color: #495057;
            font-size: 0.85rem;
            line-height: 1.5;
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
            top: 15px;
            left: 15px;
            background: white;
            padding: 10px 15px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--black);
            border: 1px solid var(--border-color);
        }

        .tracking-indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--primary-red);
            animation: pulse 2s infinite;
        }

        .tracking-indicator.pending { background: #ffc107; }
        .tracking-indicator.accepted { background: #17a2b8; }
        .tracking-indicator.in-progress { background: var(--primary-red); }
        .tracking-indicator.completed { background: #28a745; }
        .tracking-indicator.cancelled { background: #6c757d; }

        @keyframes pulse {
            0%, 100% { 
                opacity: 1; 
                transform: scale(1);
            }
            50% { 
                opacity: 0.6;
                transform: scale(1.1);
            }
        }

        .back-link {
            color: #6c757d;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 500;
            transition: all 0.3s ease;
            margin-bottom: 15px;
            font-size: 0.9rem;
        }

        .back-link:hover {
            color: var(--primary-red);
        }

        .map-controls {
            position: absolute;
            top: 60px;
            right: 15px;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .zoom-control {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 5px;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 1px 5px rgba(0,0,0,0.1);
            transition: all 0.2s ease;
        }

        .zoom-control:hover {
            background: #f8f9fa;
            border-color: var(--primary-red);
        }

        .driver-info, .location-status, .distance-info {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 6px;
            border-left: 3px solid var(--primary-red);
            margin-top: 8px;
        }

        .location-status p {
            margin: 4px 0;
            font-size: 0.8rem;
        }

        .update-time {
            font-size: 0.7rem;
            color: #6c757d;
            margin-top: 5px;
        }

        .current-target {
            background: #fff3cd;
            border-left: 3px solid #ffc107;
            padding: 8px;
            border-radius: 4px;
            margin-top: 8px;
        }

        .current-target p {
            margin: 2px 0;
            font-size: 0.8rem;
            color: #856404;
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
                padding: 8px 12px;
                font-size: 0.75rem;
            }

            .map-controls {
                top: 50px;
                right: 10px;
            }
        }

        /* Custom marker styles with labels */
        .driver-marker, .pickup-marker, .dropoff-marker {
            z-index: 1000 !important;
        }

        .leaflet-marker-icon {
            z-index: 1000 !important;
        }

        /* Hide routing machine controls */
        .leaflet-routing-container {
            display: none;
        }
    </style>
</head>
<body>
    <header class="admin-header">
        <div class="header-left">
            <h1>Fast<span>Lan</span> Admin</h1>
        </div>
        <nav class="admin-nav">
            <a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="{{ route('admin.bookings.current') }}"><i class="fas fa-clock"></i> Current</a>
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
                    Live Booking Tracking
                </h1>
                <span id="statusBadge" class="status-badge {{ str_replace('_', '-', $booking->status) }}">
                    {{ strtoupper(str_replace('_', ' ', $booking->status)) }}
                </span>
                <p style="margin-top: 8px; font-size: 0.8rem; color: #6c757d;">Real-time driver location tracking</p>
            </div>

            <div class="info-card">
                <h3><i class="fas fa-info-circle"></i> Booking Information</h3>
                <p><strong>Booking ID:</strong> {{ $booking->bookingID }}</p>
                <p><strong>Service Type:</strong> {{ $booking->getServiceTypeDisplay() }}</p>
                <p><strong>Status:</strong> <span id="statusText">{{ strtoupper(str_replace('_', ' ', $booking->status)) }}</span></p>
                <p><strong>Fare:</strong> ₱{{ number_format($booking->fare, 2) }}</p>
            </div>

            <div class="info-card">
                <h3><i class="fas fa-user"></i> Passenger Details</h3>
                <p><strong>Name:</strong> {{ $booking->passenger->fullname ?? 'N/A' }}</p>
                <p><strong>Phone:</strong> {{ $booking->passenger->phone ?? 'N/A' }}</p>
            </div>

            <div class="info-card">
                <h3><i class="fas fa-user-tie"></i> Driver Details</h3>
                @if($booking->driver)
                    <div class="driver-info">
                        <p><strong>Name:</strong> {{ $booking->driver->fullname }}</p>
                        <p><strong>Vehicle:</strong> {{ $booking->driver->vehicleMake ?? 'N/A' }} {{ $booking->driver->vehicleModel ?? '' }}</p>
                        <p><strong>Plate:</strong> {{ $booking->driver->plateNumber ?? 'N/A' }}</p>
                    </div>
                @else
                    <p style="color: #6c757d; font-style: italic; font-size: 0.85rem;">No driver assigned yet</p>
                @endif
            </div>

            <div class="info-card">
                <h3><i class="fas fa-route"></i> Trip Details</h3>
                <div class="location-status">
                    <p><strong>📍 Pickup:</strong> {{ $booking->pickupLocation }}</p>
                    <p><strong>🏁 Drop-off:</strong> {{ $booking->dropoffLocation }}</p>
                </div>
                <div id="currentTarget" class="current-target">
                    <p><i class="fas fa-bullseye"></i> <strong>Current Target:</strong> <span id="targetText">Pickup Location</span></p>
                    <p id="distanceToTarget"><i class="fas fa-sync-alt fa-spin"></i> Calculating distance...</p>
                    <p id="etaToTarget"><i class="fas fa-clock"></i> <strong>ETA:</strong> Calculating...</p>
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
                <button class="zoom-control" onclick="refreshTracking()" title="Refresh">⟳</button>
                <button class="zoom-control" onclick="fitToRoute()" title="Fit to Route">🗺️</button>
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
let routingControl;
let updateInterval;
let currentTarget = 'pickup'; // 'pickup' or 'dropoff'
const PROXIMITY_THRESHOLD = 0.1; // 100 meters in kilometers

// Base URL helper
function getBaseUrl() {
    return window.location.origin + '/digilink/public';
}

// Calculate distance between two coordinates in kilometers
function calculateDistance(lat1, lon1, lat2, lon2) {
    const R = 6371; // Earth's radius in kilometers
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;
    const a = 
        Math.sin(dLat/2) * Math.sin(dLat/2) +
        Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * 
        Math.sin(dLon/2) * Math.sin(dLon/2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    return R * c;
}

// Initialize the map
function initMap() {
    // Default center (Surigao City coordinates)
    const defaultCenter = [9.7869, 125.4920];
    
    // Initialize map
    map = L.map('trackingMap').setView(defaultCenter, 13);
    
    // Add tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Add booking markers
    addBookingMarkers();
    
    // Start live tracking
    startLiveTracking();
}

// Create marker with label
function createMarker(lat, lng, color, label, className) {
    return L.marker([lat, lng], {
        icon: L.divIcon({
            html: `
                <div style="position: relative;">
                    <div style="background-color: ${color}; border: 3px solid white; border-radius: 50%; width: 20px; height: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.4);"></div>
                    <div style="position: absolute; top: -25px; left: 50%; transform: translateX(-50%); background: ${color}; color: white; padding: 2px 8px; border-radius: 10px; font-size: 10px; font-weight: bold; white-space: nowrap; border: 1px solid white;">
                        ${label}
                    </div>
                </div>
            `,
            className: className,
            iconSize: [20, 45],
            iconAnchor: [10, 20]
        })
    });
}

// Add booking markers to map
function addBookingMarkers() {
    const bookingData = @json($booking);
    
    // Add pickup marker (red) with passenger name
    if (bookingData.pickupLatitude && bookingData.pickupLongitude) {
        const passengerName = bookingData.passenger?.fullname ? bookingData.passenger.fullname.split(' ')[0] : 'Pickup';
        pickupMarker = createMarker(
            bookingData.pickupLatitude, 
            bookingData.pickupLongitude, 
            '#dc3545', 
            `PICKUP - ${passengerName}`,
            'pickup-marker'
        ).addTo(map);
        
        pickupMarker.bindPopup(`
            <div style="text-align: center; min-width: 200px;">
                <strong style="color: #dc3545;">📍 PICKUP LOCATION</strong><br>
                <hr style="margin: 5px 0;">
                <strong>Passenger:</strong> ${bookingData.passenger?.fullname || 'N/A'}<br>
                <strong>Address:</strong> ${bookingData.pickupLocation}<br>
                <small>Booking: ${bookingData.bookingID}</small>
            </div>
        `);
    }

    // Add dropoff marker (black) with location name
    if (bookingData.dropoffLatitude && bookingData.dropoffLongitude) {
        // Extract location name from dropoff address (first few words)
        const locationName = bookingData.dropoffLocation.split(',')[0].substring(0, 15) + '...';
        dropoffMarker = createMarker(
            bookingData.dropoffLatitude, 
            bookingData.dropoffLongitude, 
            '#212529', 
            `DROPOFF - ${locationName}`,
            'dropoff-marker'
        ).addTo(map);
        
        dropoffMarker.bindPopup(`
            <div style="text-align: center; min-width: 200px;">
                <strong style="color: #212529;">🏁 DROP-OFF LOCATION</strong><br>
                <hr style="margin: 5px 0;">
                <strong>Address:</strong> ${bookingData.dropoffLocation}<br>
                <small>Booking: ${bookingData.bookingID}</small>
            </div>
        `);
        
        // Initially hide dropoff marker
        dropoffMarker.setOpacity(0.3);
    }
}

// Start live tracking of driver location
function startLiveTracking() {
    // Initial update
    updateDriverLocation();
    
    // Set up interval for updates (every 10 seconds)
    updateInterval = setInterval(updateDriverLocation, 10000);
}

// Update driver location from API
async function updateDriverLocation() {
    const bookingId = @json($booking->bookingID);
    
    try {
        // Use the correct URL with base path
        const url = `${getBaseUrl()}/admin/get-driver-location/${bookingId}`;
        
        const response = await fetch(url, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            credentials: 'same-origin'
        });

        // Check if response is JSON
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            const text = await response.text();
            showError('Unable to fetch driver location. Please try again.');
            return;
        }

        const data = await response.json();
        
        if (data.success) {
            updateDriverMarker(data);
            updateRouteAndTarget(data);
            updateSidebarInfo(data);
        } else {
            showError(data.message || 'Failed to get driver location');
        }
    } catch (error) {
        showError('Network error. Please check your connection.');
    }
}

// Create driver marker with name
function createDriverMarker(lat, lng, driverName) {
    const shortName = driverName ? driverName.split(' ')[0] : 'Driver';
    return L.marker([lat, lng], {
        icon: L.divIcon({
            html: `
                <div style="position: relative;">
                    <div style="background-color: white; border: 3px solid #dc3545; border-radius: 50%; width: 16px; height: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.4);"></div>
                    <div style="position: absolute; top: -22px; left: 50%; transform: translateX(-50%); background: #dc3545; color: white; padding: 2px 6px; border-radius: 8px; font-size: 9px; font-weight: bold; white-space: nowrap; border: 1px solid white;">
                        ${shortName}
                    </div>
                </div>
            `,
            className: 'driver-marker',
            iconSize: [16, 38],
            iconAnchor: [8, 16]
        })
    });
}

// Update driver marker
function updateDriverMarker(data) {
    const driver = data.driver;
    
    if (!driver || !driver.current_lat || !driver.current_lng) {
        return;
    }

    // Remove existing driver marker
    if (driverMarker) {
        map.removeLayer(driverMarker);
    }

    // Create new driver marker with name
    driverMarker = createDriverMarker(driver.current_lat, driver.current_lng, driver.name);
    driverMarker.addTo(map);
    
    driverMarker.bindPopup(`
        <div style="text-align: center; min-width: 200px;">
            <strong style="color: #dc3545;">🚗 DRIVER LOCATION</strong><br>
            <hr style="margin: 5px 0;">
            <strong>Name:</strong> ${driver.name}<br>
            <strong>Vehicle:</strong> ${driver.vehicle}<br>
            <strong>Phone:</strong> ${driver.phone || 'N/A'}<br>
            <strong>Status:</strong> ${data.booking.status}<br>
            <small>Last update: ${new Date().toLocaleTimeString()}</small>
        </div>
    `);
}

// Update route using OSRM for road-following
function updateRoute(startLatLng, endLatLng) {
    // Remove existing route
    if (routingControl) {
        map.removeControl(routingControl);
    }

    // Create new route with road-following
    routingControl = L.Routing.control({
        waypoints: [
            L.latLng(startLatLng[0], startLatLng[1]),
            L.latLng(endLatLng[0], endLatLng[1])
        ],
        routeWhileDragging: false,
        showAlternatives: false,
        fitSelectedRoutes: false,
        show: false, // Hide the routing instructions panel
        createMarker: function() { return null; }, // Don't create default markers
        lineOptions: {
            styles: [
                {
                    color: '#dc3545',
                    opacity: 0.8,
                    weight: 6
                }
            ],
            missingRouteTolerance: 0
        },
        router: L.Routing.osrmv1({
            serviceUrl: 'https://router.project-osrm.org/route/v1'
        })
    }).addTo(map);

    // Listen for route found event
    routingControl.on('routesfound', function(e) {
        const routes = e.routes;
        if (routes && routes.length > 0) {
            const route = routes[0];
            const distance = (route.summary.totalDistance / 1000).toFixed(2); // Convert to km
            const time = Math.ceil(route.summary.totalTime / 60); // Convert to minutes
            
            // Update ETA display
            document.getElementById('etaToTarget').innerHTML = 
                `<i class="fas fa-clock"></i> <strong>ETA:</strong> ${time} minutes`;
                
            document.getElementById('distanceToTarget').innerHTML = 
                `<i class="fas fa-route"></i> <strong>Distance:</strong> ${distance} km`;
        }
    });
}

// Update route and check target proximity
function updateRouteAndTarget(data) {
    const driver = data.driver;
    const booking = data.booking;
    
    if (!driver || !pickupMarker || !dropoffMarker) return;

    const driverLatLng = [driver.current_lat, driver.current_lng];
    const pickupLatLng = [booking.pickup_lat, booking.pickup_lng];
    const dropoffLatLng = [booking.dropoff_lat, booking.dropoff_lng];

    // Calculate straight-line distances for proximity check
    const distanceToPickup = calculateDistance(
        driver.current_lat, driver.current_lng,
        booking.pickup_lat, booking.pickup_longitude
    );
    
    const distanceToDropoff = calculateDistance(
        driver.current_lat, driver.current_lng,
        booking.dropoff_lat, booking.dropoff_longitude
    );

    // Check if driver is close to current target
    if (currentTarget === 'pickup' && distanceToPickup <= PROXIMITY_THRESHOLD) {
        // Driver reached pickup, switch to dropoff
        currentTarget = 'dropoff';
        updateTargetDisplay();
        hidePickupMarker();
        showDropoffMarker();
        
        // Update route to dropoff
        updateRoute(driverLatLng, dropoffLatLng);
    } else if (currentTarget === 'dropoff' && distanceToDropoff <= PROXIMITY_THRESHOLD) {
        // Driver reached dropoff
        updateTargetDisplay(true);
        if (routingControl) {
            map.removeControl(routingControl);
        }
    } else {
        // Update route to current target
        const targetLatLng = currentTarget === 'pickup' ? pickupLatLng : dropoffLatLng;
        updateRoute(driverLatLng, targetLatLng);
    }
}

// Hide pickup marker
function hidePickupMarker() {
    if (pickupMarker) {
        pickupMarker.setOpacity(0.3);
    }
}

// Show dropoff marker
function showDropoffMarker() {
    if (dropoffMarker) {
        dropoffMarker.setOpacity(1);
    }
}

// Update target display
function updateTargetDisplay(reached = false) {
    const targetText = document.getElementById('targetText');
    const targetContainer = document.getElementById('currentTarget');
    
    if (reached) {
        targetText.textContent = 'Destination Reached!';
        targetContainer.style.background = '#d4edda';
        targetContainer.style.borderLeftColor = '#28a745';
        document.getElementById('distanceToTarget').innerHTML = 
            '<i class="fas fa-check-circle"></i> <strong>Status:</strong> Trip completed';
        document.getElementById('etaToTarget').innerHTML = 
            '<i class="fas fa-check-circle"></i> <strong>ETA:</strong> Arrived';
    } else {
        targetText.textContent = currentTarget === 'pickup' ? 'Pickup Location' : 'Drop-off Location';
        targetContainer.style.background = '#fff3cd';
        targetContainer.style.borderLeftColor = '#ffc107';
    }
}

// Fit map to show the entire route
function fitToRoute() {
    if (routingControl) {
        routingControl.getPlan().fire('routesfound');
    } else {
        // Fallback to fitting all markers
        const bounds = L.latLngBounds();
        if (pickupMarker) bounds.extend(pickupMarker.getLatLng());
        if (dropoffMarker) bounds.extend(dropoffMarker.getLatLng());
        if (driverMarker) bounds.extend(driverMarker.getLatLng());
        
        if (bounds.isValid()) {
            map.fitBounds(bounds, { padding: [20, 20] });
        }
    }
}

// Show error message to user
function showError(message) {
    // Update location status with error
    document.getElementById('locationStatus').innerHTML = `
        <div style="color: #dc3545; background: #f8d7da; padding: 8px; border-radius: 4px; font-size: 0.8rem;">
            <i class="fas fa-exclamation-triangle"></i> <strong>Error:</strong> ${message}
        </div>
    `;
    
    // Update tracking status
    document.getElementById('trackingStatusText').textContent = 'Tracking Error';
    document.getElementById('trackingIndicator').style.background = '#dc3545';
}

// Update sidebar information
function updateSidebarInfo(data) {
    const driver = data.driver;
    const booking = data.booking;

    // Update location status
    if (driver) {
        document.getElementById('locationStatus').innerHTML = `
            <p><strong>Current Location:</strong> ${driver.currentLocation || 'Unknown'}</p>
            <p><strong>Vehicle:</strong> ${driver.vehicle}</p>
            <p><strong>Status:</strong> ${driver.availStatus ? 'Online' : 'Offline'}</p>
        `;
    }

    // Update last update time
    document.getElementById('lastUpdate').textContent = `Last updated: ${new Date().toLocaleTimeString()}`;

    // Update status badge and indicator
    updateStatusDisplay(booking.status);
}

// Update status display
function updateStatusDisplay(status) {
    const statusBadge = document.getElementById('statusBadge');
    const statusText = document.getElementById('statusText');
    const trackingIndicator = document.getElementById('trackingIndicator');
    const trackingStatusText = document.getElementById('trackingStatusText');

    const statusDisplay = status.replace('_', ' ').toUpperCase();
    
    statusBadge.textContent = statusDisplay;
    statusText.textContent = statusDisplay;
    
    // Update classes
    statusBadge.className = `status-badge ${status.replace('_', '-')}`;
    trackingIndicator.className = `tracking-indicator ${status.replace('_', '-')}`;
    
    // Update status text
    trackingStatusText.textContent = getStatusMessage(status);
}

// Get status message
function getStatusMessage(status) {
    const messages = {
        'pending': 'Waiting for driver assignment',
        'accepted': 'Driver assigned - en route to pickup',
        'in_progress': 'Trip in progress - tracking active',
        'completed': 'Trip completed',
        'cancelled': 'Trip cancelled'
    };
    return messages[status] || 'Tracking active';
}

// Refresh tracking
function refreshTracking() {
    updateDriverLocation();
}

// Initialize when page loads
document.addEventListener('DOMContentLoaded', function() {
    initMap();
});

// Clean up on page unload
window.addEventListener('beforeunload', function() {
    if (updateInterval) {
        clearInterval(updateInterval);
    }
});
    </script>
</body>
</html>