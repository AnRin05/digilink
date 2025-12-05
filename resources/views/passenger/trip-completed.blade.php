<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trip Completed - FastLan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="{{ asset('images/fastlan1.png') }}">
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
            min-height: 100vh;
            display: flex;
            flex-direction: column;
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

        .completion-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .completion-card {
            background: white;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 500px;
            width: 100%;
            border: 1px solid #e9ecef;
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
            color: white;
        }

        .completion-card h1 {
            color: #28a745;
            margin-bottom: 15px;
            font-size: 2rem;
        }

        .completion-card p {
            color: #6c757d;
            margin-bottom: 25px;
            line-height: 1.6;
            font-size: 1.1rem;
        }

        .trip-details {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            margin: 25px 0;
            text-align: left;
        }

        .trip-details h3 {
            color: #212529;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e9ecef;
        }

        .detail-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .detail-label {
            color: #6c757d;
            font-weight: 500;
        }

        .detail-value {
            color: #212529;
            font-weight: 600;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            flex: 1;
            padding: 15px 20px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            font-size: 1rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
        }

        .btn-success {
            background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
            color: white;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid #007bff;
            color: #007bff;
        }

        .btn-outline:hover {
            background: #007bff;
            color: white;
            transform: translateY(-2px);
        }

        .driver-info {
            background: #e7f3ff;
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
            border-left: 4px solid #007bff;
        }

        .driver-info h4 {
            color: #007bff;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Rating Section Styles */
        .rating-section {
            background: linear-gradient(135deg, #fff9e6 0%, #fff3cd 100%);
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
            border: 2px solid #ffeaa7;
            border-left: 4px solid #ffc107;
        }

        .rating-section h3 {
            color: #212529;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.3rem;
        }

        .rating-section p {
            color: #495057;
            margin-bottom: 20px;
            font-size: 1rem;
        }

        .stars-container {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin: 20px 0;
        }

        .rating-star {
            font-size: 40px;
            cursor: pointer;
            color: #ddd;
            transition: all 0.2s ease;
            margin: 0 2px;
        }

        .rating-star:hover,
        .rating-star.active {
            color: #ffc107;
            transform: scale(1.2);
        }

        .rate-btn {
            background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
            color: #212529;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 1rem;
            width: 100%;
            margin-top: 15px;
            box-shadow: 0 2px 8px rgba(255, 193, 7, 0.3);
        }

        .rate-btn:hover {
            background: linear-gradient(135deg, #e0a800 0%, #c69500 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.4);
        }

        .rate-btn:disabled {
            background: #bdc3c7;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
            opacity: 0.7;
        }

        .rating-message {
            margin-top: 15px;
            padding: 12px;
            border-radius: 8px;
            font-size: 0.9rem;
            text-align: center;
            font-weight: 500;
        }

        .rating-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
            border: 1px solid #b8dfc1;
            box-shadow: 0 2px 5px rgba(21, 87, 36, 0.1);
        }

        .rating-error {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
            border: 1px solid #f1b0b7;
            box-shadow: 0 2px 5px rgba(114, 28, 36, 0.1);
        }

        .rating-completed {
            background: linear-gradient(135deg, #e7f3ff 0%, #d6e9ff 100%);
            border: 2px solid #b3d7ff;
            border-left: 4px solid #007bff;
            padding: 20px;
            border-radius: 12px;
            margin: 20px 0;
        }

        .rating-completed h4 {
            color: #007bff;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        @media (max-width: 768px) {
            .completion-card {
                padding: 30px 20px;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
            }

            .rating-star {
                font-size: 32px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="#" class="nav-brand">Fast<span>Lan</span></a>
        <div class="nav-links">
            <a href="{{ route('passenger.pending.bookings') }}" class="nav-link">
                <i class="fas fa-arrow-left"></i> Back to Bookings
            </a>
        </div>
    </nav>

    <div class="completion-container">
        <div class="completion-card">
            <div class="success-icon">
                <i class="fas fa-check"></i>
            </div>
            
            <h1>Trip Completed!</h1>
            <p>Thank you for choosing FastLan. Your trip has been successfully completed.</p>
            
            <div class="trip-details">
                <h3><i class="fas fa-receipt"></i> Trip Summary</h3>
                
                <div class="detail-item">
                    <span class="detail-label">Booking ID:</span>
                    <span class="detail-value">#{{ $booking->bookingID }}</span>
                </div>
                
                <div class="detail-item">
                    <span class="detail-label">Service Type:</span>
                    <span class="detail-value">{{ $booking->getServiceTypeDisplay() }}</span>
                </div>
                
                <div class="detail-item">
                    <span class="detail-label">Pickup:</span>
                    <span class="detail-value">{{ $booking->pickupLocation }}</span>
                </div>
                
                <div class="detail-item">
                    <span class="detail-label">Drop-off:</span>
                    <span class="detail-value">{{ $booking->dropoffLocation }}</span>
                </div>
                
                <div class="detail-item">
                    <span class="detail-label">Total Fare:</span>
                    <span class="detail-value">₱{{ number_format($booking->fare, 2) }}</span>
                </div>
                
                <div class="detail-item">
                    <span class="detail-label">Payment Method:</span>
                    <span class="detail-value">{{ $booking->getPaymentMethodDisplay() }}</span>
                </div>
            </div>

            @if($booking->driver)
            <div class="driver-info">
                <h4><i class="fas fa-user"></i> Driver Information</h4>
                <p><strong>Name:</strong> {{ $booking->driver->fullname }}</p>
                <p><strong>Vehicle:</strong> {{ $booking->driver->vehicleMake }} {{ $booking->driver->vehicleModel }} ({{ $booking->driver->plateNumber }})</p>
                <p><strong>Contact:</strong> {{ $booking->driver->phone }}</p>
            </div>
            @endif

            <!-- Rating Section -->
            @if(!$booking->review()->exists())
            <div class="rating-section" id="ratingSection">
                <h3><i class="fas fa-star"></i> Rate Your Driver</h3>
                <p>How was your experience with <strong>{{ $booking->driver->fullname ?? 'the driver' }}</strong>?</p>
                
                <div class="stars-container">
                    @for($i = 1; $i <= 5; $i++)
                        <span class="rating-star" data-rating="{{ $i }}">☆</span>
                    @endfor
                </div>
                <input type="hidden" id="selectedRating" value="5">
                
                <button class="rate-btn" onclick="submitRating()" id="submitRatingBtn">
                    <i class="fas fa-paper-plane"></i>
                    Submit Rating
                </button>
                
                <div id="ratingMessage" class="rating-message"></div>
            </div>
            @else
            <div class="rating-completed">
                <h4><i class="fas fa-check-circle"></i> Rating Submitted</h4>
                <p>Thank you for rating your driver! Your feedback helps us improve our service.</p>
                <p><strong>Your Rating:</strong> 
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $booking->review->rating)
                            ★
                        @else
                            ☆
                        @endif
                    @endfor
                    ({{ $booking->review->rating }}/5)
                </p>
            </div>
            @endif

            <div class="action-buttons">
                <a href="{{ route('passenger.dashboard') }}" class="btn btn-primary">
                    <i class="fas fa-home"></i>
                    Go to Dashboard
                </a>
                
                <a href="{{ route('passenger.history') }}" class="btn btn-success">
                    <i class="fas fa-history"></i>
                    View Trip History
                </a>
            </div>

            <div style="margin-top: 25px; padding-top: 20px; border-top: 1px solid #e9ecef;">
                <p style="color: #6c757d; font-size: 0.9rem;">
                    <i class="fas fa-info-circle"></i>
                    Need help with this trip? 
                    <a href="{{ route('passenger.pending.bookings') }}" style="color: #007bff; text-decoration: none;">
                        Contact Support
                    </a>
                </p>
            </div>
        </div>
    </div>
<script>
// ==================== CONFIGURATION ====================
const CONFIG = {
    UPDATE_INTERVAL: 3000,
    STATUS_UPDATE_INTERVAL: 5000,
    API_TIMEOUT: 10000,
    MAX_RETRIES: 3,
    RETRY_DELAY: 2000
};

// API endpoints - relative paths work on both local and Railway
const API_ENDPOINTS = {
    confirmCompletion: "/passenger/confirm-completion",
    getBookingLocation: "/passenger/get-booking-location",
    getDriverLocation: "/passenger/get-driver-location",
    cancelBooking: "/passenger/cancel-ongoing-booking",
    tripCompleted: "/passenger/trip-completed",
    urgentHelp: "/report/urgent-help",
    complaint: "/report/complaint"
};

// Booking data
const bookingData = {
    id: {{ $booking->bookingID }},
    driver_id: {{ $booking->driver->id ?? 0 }},
    pickup: {
        lat: {{ $booking->pickupLatitude }},
        lng: {{ $booking->pickupLongitude }},
        address: `{{ $booking->pickupLocation }}`
    },
    dropoff: {
        lat: {{ $booking->dropoffLatitude }},
        lng: {{ $booking->dropoffLongitude }},
        address: `{{ $booking->dropoffLocation }}`
    },
    csrfToken: window.AppConfig.csrfToken
};

// Status configuration
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

// ==================== GLOBAL VARIABLES ====================
let map;
let driverMarker;
let pickupMarker;
let dropoffMarker;
let updateInterval;
let statusInterval;
let retryCount = 0;
let isOnline = navigator.onLine;

// ==================== UTILITY FUNCTIONS ====================
function log(message, data = null, type = 'info') {
    const timestamp = new Date().toISOString().split('T')[1].split('.')[0];
    const logMessage = `[${timestamp}] ${message}`;
    
    console[type](logMessage, data || '');
    
    // Also log to debug panel if it exists
    const debugLog = document.getElementById('debugLog');
    if (debugLog) {
        const logEntry = document.createElement('div');
        logEntry.className = `log-${type}`;
        logEntry.textContent = logMessage;
        debugLog.appendChild(logEntry);
        debugLog.scrollTop = debugLog.scrollHeight;
    }
}

function showNotification(type, message, duration = 5000) {
    log(`Notification: ${type} - ${message}`);
    
    const existingNotifications = document.querySelectorAll('.custom-notification');
    existingNotifications.forEach(notification => notification.remove());

    const notification = document.createElement('div');
    notification.className = 'custom-notification';
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'success' ? '#28a745' : '#dc3545'};
        color: white;
        padding: 15px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 10001;
        max-width: 400px;
        animation: slideInRight 0.3s ease;
        display: flex;
        align-items: center;
        gap: 10px;
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;
    `;
    
    notification.innerHTML = `
        <div style="display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'}"></i>
            <span>${message}</span>
        </div>
        <button onclick="this.parentElement.remove()" style="background: none; border: none; color: inherit; cursor: pointer; margin-left: auto; padding: 0; font-size: 1rem;">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        if (notification.parentElement) {
            notification.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }
    }, duration);
}

function getApiUrl(endpoint, id = null) {
    let url = API_ENDPOINTS[endpoint];
    if (id) {
        url += `/${id}`;
    }
    
    // Add timestamp to prevent caching
    const timestamp = Date.now();
    return `${url}?_t=${timestamp}`;
}

async function safeFetch(url, options = {}) {
    const controller = new AbortController();
    const timeoutId = setTimeout(() => controller.abort(), CONFIG.API_TIMEOUT);
    
    const fetchOptions = {
        ...options,
        signal: controller.signal,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': bookingData.csrfToken,
            'X-Requested-With': 'XMLHttpRequest',
            ...options.headers
        }
    };
    
    try {
        log(`Fetching: ${url}`);
        const response = await fetch(url, fetchOptions);
        clearTimeout(timeoutId);
        
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            const text = await response.text();
            log('Non-JSON response', text.substring(0, 200), 'warn');
            throw new Error('Server returned non-JSON response');
        }
        
        const data = await response.json();
        log(`Response from ${url}`, data);
        return data;
        
    } catch (error) {
        clearTimeout(timeoutId);
        log(`Fetch error: ${url}`, error.message, 'error');
        
        if (error.name === 'AbortError') {
            throw new Error('Request timeout. Please check your internet connection.');
        }
        
        throw error;
    }
}

function updateNetworkStatus(online) {
    const networkStatus = document.getElementById('networkStatus');
    const networkStatusText = document.getElementById('networkStatusText');
    
    if (networkStatus && networkStatusText) {
        if (online) {
            networkStatus.className = 'network-status network-online';
            networkStatusText.textContent = 'Online';
            networkStatus.style.display = 'block';
            setTimeout(() => {
                networkStatus.style.display = 'none';
            }, 3000);
        } else {
            networkStatus.className = 'network-status network-offline';
            networkStatusText.textContent = 'Offline';
            networkStatus.style.display = 'block';
        }
    }
}

// ==================== MAP FUNCTIONS ====================
function initMap() {
    log('Initializing map...', bookingData);
    
    try {
        map = L.map('trackingMap', {
            zoomControl: false,
            preferCanvas: true // Better performance
        }).setView([bookingData.pickup.lat, bookingData.pickup.lng], 13);

        // Use HTTPS for Railway
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19,
            detectRetina: true
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

        log('Map initialized successfully');
        
        // Start tracking
        startTrackingUpdates();
        startStatusUpdates();
        
    } catch (error) {
        log('Error initializing map', error.message, 'error');
        showNotification('error', 'Failed to initialize map. Please refresh the page.');
    }
}

function updateDriverPosition(lat, lng, driverInfo = null) {
    try {
        if (!driverMarker) {
            const driverIcon = L.divIcon({
                className: 'driver-marker',
                html: `
                    <div style="position: relative;">
                        <div style="background:#212529; border:3px solid white; border-radius:50%; width:20px; height:20px; box-shadow:0 2px 8px rgba(0,0,0,0.3);"></div>
                        <div style="position: absolute; top: -22px; left: 50%; transform: translateX(-50%); background: #212529; color: white; padding: 2px 6px; border-radius: 8px; font-size: 9px; font-weight: bold; white-space: nowrap;">
                            DRIVER
                        </div>
                    </div>
                `,
                iconSize: [16, 38],
                iconAnchor: [8, 16]
            });

            driverMarker = L.marker([lat, lng], { 
                icon: driverIcon,
                zIndexOffset: 1000 // Ensure driver marker is on top
            })
            .addTo(map)
            .bindPopup(`
                <div style="text-align: center; min-width: 200px;">
                    <strong>🚗 YOUR DRIVER</strong><br>
                    <hr style="margin: 5px 0;">
                    ${driverInfo?.name || '{{ $booking->driver->fullname ?? "Driver" }}'}<br>
                    ${driverInfo?.vehicle || '{{ $booking->driver->vehicleMake ?? "" }} {{ $booking->driver->vehicleModel ?? "" }}'}
                </div>
            `);

            // Fit all markers in view
            const group = new L.featureGroup([pickupMarker, dropoffMarker, driverMarker]);
            map.fitBounds(group.getBounds().pad(0.2));
            
            log('Driver marker created', { lat, lng });
        } else {
            driverMarker.setLatLng([lat, lng]);
            log('Driver marker updated', { lat, lng });
        }
    } catch (error) {
        log('Error updating driver position', error.message, 'error');
    }
}

// ==================== API FUNCTIONS ====================
async function updateDriverLocation() {
    if (!isOnline) {
        log('Offline - skipping driver location update', null, 'warn');
        showNotification('warning', 'You are offline. Reconnecting...');
        return;
    }

    try {
        const url = getApiUrl('getDriverLocation', bookingData.id);
        const data = await safeFetch(url);
        
        if (data.success) {
            retryCount = 0; // Reset retry count on success
            
            // Update status display
            updateStatusDisplay(data.booking.status);
            
            // Update completion status
            if (data.booking.completion_verified) {
                updateCompletionStatus(data.booking.completion_verified, data.booking.status === 'completed');
            }
            
            // Check for driver location
            if (data.driver && data.driver.current_lat != null && data.driver.current_lng != null) {
                const driverLat = parseFloat(data.driver.current_lat);
                const driverLng = parseFloat(data.driver.current_lng);
                
                if (!isNaN(driverLat) && !isNaN(driverLng)) {
                    updateDriverPosition(driverLat, driverLng, {
                        name: data.driver.name,
                        vehicle: data.driver.vehicle
                    });
                    
                    if (data.distance_info) {
                        updateDistanceInfo(data.distance_info);
                    }
                    
                    updateLocationStatus('success', `Driver location updated - ${data.driver.name}`);
                    
                    // Check if trip should redirect
                    if (data.booking.status === 'completed' || 
                        data.booking.completion_verified === 'passenger_confirmed' ||
                        data.booking.completion_verified === 'both_confirmed') {
                        handleTripCompletion();
                    }
                } else {
                    updateLocationStatus('waiting', 'Waiting for valid driver location...');
                }
            } else {
                updateLocationStatus('waiting', 'Driver location not available yet...');
            }
            
            // Check if cancelled
            if (data.booking.status === 'cancelled') {
                handleTripCancellation();
            }
        } else {
            throw new Error(data.message || 'Failed to get driver location');
        }
        
    } catch (error) {
        log('Error in driver location update', error.message, 'error');
        
        retryCount++;
        if (retryCount <= CONFIG.MAX_RETRIES) {
            updateLocationStatus('error', `Connection error. Retrying... (${retryCount}/${CONFIG.MAX_RETRIES})`);
            setTimeout(updateDriverLocation, CONFIG.RETRY_DELAY);
        } else {
            updateLocationStatus('error', 'Unable to connect to server. Please check your internet connection.');
            showNotification('error', 'Connection lost. Please refresh the page.');
        }
    }
}

async function updateBookingStatus() {
    try {
        const url = getApiUrl('getBookingLocation', bookingData.id);
        const data = await safeFetch(url);
        
        if (data.success) {
            updateStatusDisplay(data.booking.status);
            
            if (data.booking.completion_verified) {
                updateCompletionStatus(data.booking.completion_verified, data.booking.status === 'completed');
            }
            
            if (data.booking.status === 'completed' || 
                data.booking.completion_verified === 'passenger_confirmed' ||
                data.booking.completion_verified === 'both_confirmed') {
                handleTripCompletion();
            }
            
            if (data.booking.status === 'cancelled') {
                handleTripCancellation();
            }
        }
    } catch (error) {
        log('Error updating booking status', error.message, 'error');
    }
}

// ==================== TRACKING CONTROL ====================
function startTrackingUpdates() {
    log('Starting tracking updates...');
    updateDriverLocation();
    updateInterval = setInterval(updateDriverLocation, CONFIG.UPDATE_INTERVAL);
}

function startStatusUpdates() {
    updateBookingStatus();
    statusInterval = setInterval(updateBookingStatus, CONFIG.STATUS_UPDATE_INTERVAL);
}

function stopTracking() {
    log('Stopping tracking...');
    if (updateInterval) {
        clearInterval(updateInterval);
        updateInterval = null;
    }
    if (statusInterval) {
        clearInterval(statusInterval);
        statusInterval = null;
    }
}

// ==================== UI UPDATE FUNCTIONS ====================
function updateStatusDisplay(status) {
    const config = statusConfig[status] || statusConfig.in_progress;
    
    // Update status badge
    const statusBadge = document.getElementById('overallStatusBadge');
    if (statusBadge) {
        statusBadge.textContent = config.text;
        statusBadge.className = `status-badge ${config.badge}`;
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
    
    // Update timeline
    updateStatusTimeline(status);
    
    // Update button visibility
    const cancelBtn = document.getElementById('cancelBookingBtn');
    if (cancelBtn && (status === 'completed' || status === 'cancelled')) {
        cancelBtn.style.display = 'none';
    }
    
    const confirmBtn = document.getElementById('confirmCompletionBtn');
    if (confirmBtn && status === 'completed') {
        confirmBtn.style.display = 'none';
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

function updateLocationStatus(type, message) {
    const locationStatus = document.getElementById('locationStatus');
    if (!locationStatus) return;

    const statusIcons = {
        'success': '<i class="fas fa-check-circle" style="color: #28a745;"></i>',
        'waiting': '<i class="fas fa-clock" style="color: #6c757d;"></i>',
        'error': '<i class="fas fa-exclamation-triangle" style="color: #dc3545;"></i>',
        'warning': '<i class="fas fa-exclamation-circle" style="color: #ffc107;"></i>'
    };

    locationStatus.innerHTML = `<p>${statusIcons[type]} ${message}</p>`;
}

function updateDistanceInfo(distanceInfo) {
    const distanceInfoElement = document.getElementById('distanceInfo');
    if (distanceInfoElement && distanceInfo) {
        distanceInfoElement.innerHTML = `
            <div class="location-status">
                <p><i class="fas fa-route" style="color: #28a745;"></i> <strong>Driver to Pickup:</strong> ${distanceInfo.to_pickup_km || 'N/A'} km</p>
                <p><i class="fas fa-clock" style="color: #6c757d;"></i> <strong>Est. Time:</strong> ${distanceInfo.est_time_to_pickup_min || 'N/A'} min</p>
            </div>
            <div class="distance-info">
                <p><i class="fas fa-flag-checkered" style="color: #dc3545;"></i> <strong>Driver to Drop-off:</strong> ${distanceInfo.to_dropoff_km || 'N/A'} km</p>
                <p><i class="fas fa-clock" style="color: #6c757d;"></i> <strong>Est. Time:</strong> ${distanceInfo.est_time_to_dropoff_min || 'N/A'} min</p>
            </div>
        `;
    }
}

function updateCompletionStatus(status, isCompleted) {
    const completionStatus = document.getElementById('completionStatus');
    if (!completionStatus) return;

    const statusMessages = {
        'pending': `<div style="color: #6c757d;"><i class="fas fa-clock"></i> <strong>Status:</strong> Waiting for completion confirmation...</div>`,
        'driver_confirmed': `<div style="color: #007bff;"><i class="fas fa-user-check"></i> <strong>Status:</strong> Driver has confirmed completion</div>`,
        'passenger_confirmed': `<div style="color: #28a745;"><i class="fas fa-user-check"></i> <strong>Status:</strong> You have confirmed completion</div>`,
        'both_confirmed': `<div style="color: #28a745;"><i class="fas fa-check-double"></i> <strong>Status:</strong> Trip completed successfully!</div>`
    };

    completionStatus.innerHTML = statusMessages[status] || statusMessages.pending;

    if (isCompleted || status === 'both_confirmed') {
        const confirmBtn = document.getElementById('confirmCompletionBtn');
        if (confirmBtn) confirmBtn.style.display = 'none';
    }
}

function showCompletionMessage(message, type) {
    const completionMessage = document.getElementById('completionMessage');
    if (!completionMessage) return;

    completionMessage.innerHTML = `
        <div style="color: ${type === 'success' ? '#28a745' : '#dc3545'}; font-weight: 600; padding: 10px; background: ${type === 'success' ? '#d4edda' : '#f8d7da'}; border-radius: 8px; border: 1px solid ${type === 'success' ? '#c3e6cb' : '#f5c6cb'};">
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'}"></i> ${message}
        </div>
    `;
}

// ==================== EVENT HANDLERS ====================
async function confirmCompletion() {
    if (!confirm('Are you sure you want to confirm trip completion?\n\nPlease ensure you have reached your destination safely and received your service.')) {
        return;
    }

    const confirmBtn = document.getElementById('confirmCompletionBtn');
    if (!confirmBtn) return;
    
    const originalText = confirmBtn.innerHTML;
    confirmBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Confirming...';
    confirmBtn.disabled = true;

    try {
        const url = getApiUrl('confirmCompletion', bookingData.id);
        const data = await safeFetch(url, {
            method: 'POST',
            body: JSON.stringify({})
        });
        
        if (data.success) {
            showNotification('success', data.message || 'Trip completed successfully!');
            
            // Handle completion
            stopTracking();
            updateStatusDisplay('completed');
            
            // Redirect to trip completed page
            setTimeout(() => {
                const tripCompletedUrl = getApiUrl('tripCompleted', bookingData.id);
                window.location.href = tripCompletedUrl.replace('?_t=', '');
            }, 1000);
        } else {
            throw new Error(data.message || 'Failed to confirm completion');
        }
    } catch (error) {
        showNotification('error', error.message || 'Error confirming completion');
        confirmBtn.innerHTML = originalText;
        confirmBtn.disabled = false;
    }
}

async function cancelOngoingBooking() {
    if (!confirm('Are you sure you want to cancel this ongoing trip?\n\n⚠️ This action cannot be undone. The driver will be notified immediately.')) {
        return;
    }

    const cancelBtn = document.getElementById('cancelBookingBtn');
    if (!cancelBtn) return;
    
    const originalText = cancelBtn.innerHTML;
    cancelBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Cancelling...';
    cancelBtn.disabled = true;

    try {
        const url = getApiUrl('cancelBooking', bookingData.id);
        const data = await safeFetch(url, {
            method: 'POST',
            body: JSON.stringify({})
        });
        
        if (data.success) {
            showNotification('success', data.message || 'Booking cancelled successfully!');
            document.getElementById('cancelMessage').innerHTML = `<div class="cancel-success"><i class="fas fa-check-circle"></i> ${data.message}</div>`;
            stopTracking();
            updateStatusDisplay('cancelled');
            cancelBtn.style.display = 'none';
            
            const confirmBtn = document.getElementById('confirmCompletionBtn');
            if (confirmBtn) confirmBtn.disabled = true;
        } else {
            throw new Error(data.message);
        }
    } catch (error) {
        showNotification('error', error.message || 'Error cancelling booking');
        document.getElementById('cancelMessage').innerHTML = `<div class="cancel-error"><i class="fas fa-exclamation-triangle"></i> ${error.message}</div>`;
        cancelBtn.innerHTML = originalText;
        cancelBtn.disabled = false;
    }
}

function handleTripCompletion() {
    log('Handling trip completion...');
    stopTracking();
    updateStatusDisplay('completed');
    
    // Redirect to trip completed page
    setTimeout(() => {
        const tripCompletedUrl = getApiUrl('tripCompleted', bookingData.id);
        window.location.href = tripCompletedUrl.replace('?_t=', '');
    }, 2000);
}

function handleTripCancellation() {
    log('Handling trip cancellation...');
    stopTracking();
    updateStatusDisplay('cancelled');
    
    const cancelBtn = document.getElementById('cancelBookingBtn');
    if (cancelBtn) cancelBtn.style.display = 'none';
    
    const confirmBtn = document.getElementById('confirmCompletionBtn');
    if (confirmBtn) confirmBtn.disabled = true;
}

// ==================== MODAL FUNCTIONS ====================
function showUrgentHelpModal() {
    document.getElementById('urgentHelpModal').style.display = 'flex';
}

function hideUrgentHelpModal() {
    document.getElementById('urgentHelpModal').style.display = 'none';
    document.getElementById('urgentHelpNotes').value = '';
}

function showComplaintModal() {
    document.getElementById('complaintModal').style.display = 'flex';
}

function hideComplaintModal() {
    document.getElementById('complaintModal').style.display = 'none';
    document.getElementById('complaintType').value = 'driver_behavior';
    document.getElementById('complaintSeverity').value = 'medium';
    document.getElementById('complaintDescription').value = '';
}

async function sendUrgentHelp() {
    const notes = document.getElementById('urgentHelpNotes').value;
    
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
    btn.disabled = true;

    try {
        const url = getApiUrl('urgentHelp');
        const data = await safeFetch(url, {
            method: 'POST',
            body: JSON.stringify({
                booking_id: bookingData.id,
                additional_notes: notes,
                user_type: 'passenger'
            })
        });
        
        if (data.success) {
            showNotification('success', data.message || 'Help request sent successfully!');
            hideUrgentHelpModal();
        } else {
            throw new Error(data.message || 'Failed to send help request');
        }
    } catch (error) {
        showNotification('error', error.message || 'Failed to send help request. Please try again.');
    } finally {
        btn.innerHTML = originalText;
        btn.disabled = false;
    }
}

async function sendComplaint() {
    const type = document.getElementById('complaintType').value;
    const severity = document.getElementById('complaintSeverity').value;
    const description = document.getElementById('complaintDescription').value;

    if (!description.trim()) {
        showNotification('error', 'Please provide a description of the issue');
        return;
    }

    if (description.trim().length < 10) {
        showNotification('error', 'Please provide a more detailed description (at least 10 characters)');
        return;
    }

    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';
    btn.disabled = true;

    try {
        const url = getApiUrl('complaint');
        const data = await safeFetch(url, {
            method: 'POST',
            body: JSON.stringify({
                booking_id: bookingData.id,
                complaint_type: type,
                severity: severity,
                description: description,
                user_type: 'passenger'
            })
        });
        
        if (data.success) {
            showNotification('success', data.message || 'Complaint submitted successfully!');
            hideComplaintModal();
        } else {
            throw new Error(data.message || 'Failed to submit complaint');
        }
    } catch (error) {
        showNotification('error', error.message || 'Failed to submit complaint. Please try again.');
    } finally {
        btn.innerHTML = originalText;
        btn.disabled = false;
    }
}

// ==================== DEBUG FUNCTIONS ====================
function testDriverLocation() {
    log('Testing driver location API...');
    updateDriverLocation();
}

function simulateDriverMovement() {
    if (!driverMarker) {
        log('No driver marker to simulate', null, 'warn');
        return;
    }
    
    const currentLatLng = driverMarker.getLatLng();
    const newLat = currentLatLng.lat + (Math.random() - 0.5) * 0.001;
    const newLng = currentLatLng.lng + (Math.random() - 0.5) * 0.001;
    
    driverMarker.setLatLng([newLat, newLng]);
    log('Simulated driver movement', { newLat, newLng });
}

async function testConnection() {
    log('Testing connection to endpoints...');
    
    const endpoints = [
        getApiUrl('getDriverLocation', bookingData.id),
        getApiUrl('getBookingLocation', bookingData.id),
        window.AppConfig.baseUrl + '/'
    ];
    
    for (const url of endpoints) {
        try {
            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            if (response.ok) {
                log(`✓ ${url} - Connected (${response.status})`);
                showNotification('success', `✓ ${new URL(url).pathname} - Connected`);
            } else {
                log(`✗ ${url} - Failed (${response.status})`, null, 'error');
                showNotification('error', `✗ ${new URL(url).pathname} - Failed (${response.status})`);
            }
        } catch (error) {
            log(`✗ ${url} - Error: ${error.message}`, null, 'error');
            showNotification('error', `✗ ${new URL(url).pathname} - ${error.message}`);
        }
    }
}

// ==================== INITIALIZATION ====================
document.addEventListener('DOMContentLoaded', function() {
    log('DOM loaded, initializing passenger tracking...');
    log('App Config:', window.AppConfig);
    
    try {
        // Initialize map
        initMap();
        
        // Set up network event listeners
        window.addEventListener('online', () => {
            isOnline = true;
            updateNetworkStatus(true);
            log('Network status: Online');
            
            // Restart tracking if it was stopped
            if (!updateInterval) {
                startTrackingUpdates();
            }
        });
        
        window.addEventListener('offline', () => {
            isOnline = false;
            updateNetworkStatus(false);
            log('Network status: Offline', null, 'warn');
        });
        
        // Check initial network status
        if (!navigator.onLine) {
            handleOfflineStatus();
        }
        
        // Show debug panel if in debug mode
        if (window.AppConfig.debug) {
            const debugPanel = document.getElementById('debugPanel');
            if (debugPanel) {
                debugPanel.style.display = 'block';
            }
        }
        
        log('Passenger tracking initialized successfully');
        
    } catch (error) {
        log('Error during initialization', error.message, 'error');
        showNotification('error', 'Failed to initialize tracking. Please refresh the page.');
    }
});

// Clean up on page unload
window.addEventListener('beforeunload', function() {
    stopTracking();
    log('Page unloading, cleaning up...');
});

// Close modals when clicking outside
document.addEventListener('click', function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
    }
});

// Close modals with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            modal.style.display = 'none';
        });
    }
});

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    @keyframes slideOutRight {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
    
    @keyframes modalSlideIn {
        from { transform: translateY(-50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    
    .custom-notification {
        animation: slideInRight 0.3s ease;
    }
    
    .modal-content {
        animation: modalSlideIn 0.3s ease;
    }
`;
document.head.appendChild(style);
</script>
</body>
</html>