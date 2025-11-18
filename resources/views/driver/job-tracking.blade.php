<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Tracking - FastLan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    @vite('resources/css/driver/job-track.css')
    <style>
        * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html, body {
        width: 100%;
        height: 100%;
        overflow-x: hidden;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        color: #212529;
        height: 100vh;
        overflow: hidden;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    .navbar {
        background: linear-gradient(135deg, #212529 0%, #343a40 100%);
        padding: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        gap: 1rem;
        flex-wrap: wrap;
    }

    .nav-brand {
        font-size: 1.3rem;
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
        padding: 8px 14px;
        border-radius: 8px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        font-weight: 500;
        font-size: 0.9rem;
        min-height: 44px;
    }

    .nav-link:hover {
        background: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }

    .job-tracking-container {
        display: grid;
        grid-template-columns: 1fr;
        grid-template-rows: auto 1fr;
        height: calc(100vh - 70px);
    }

    .job-sidebar {
        background: white;
        border-bottom: 1px solid #e9ecef;
        padding: 1.5rem;
        overflow-y: auto;
        max-height: 35vh;
    }

    .job-header {
        margin-bottom: 1.2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f8f9fa;
    }

    .job-header h1 {
        font-size: 1.2rem;
        color: #212529;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 700;
    }

    .job-header h1 i {
        color: #dc3545;
        font-size: 1rem;
    }

    .job-header p {
        color: #6c757d;
        font-size: 0.85rem;
    }

    .status-badge {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        background: rgba(255, 193, 7, 0.1);
        color: #ffc107;
        margin-top: 0.5rem;
    }

    .info-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        border-radius: 12px;
        padding: 1.2rem;
        margin-bottom: 1rem;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .info-card:hover {
        border-color: #dc3545;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    .info-card h3 {
        color: #212529;
        margin-bottom: 1rem;
        font-size: 1rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-card h3 i {
        color: #dc3545;
    }

    .info-card p {
        margin: 6px 0;
        color: #495057;
        font-size: 0.85rem;
        line-height: 1.5;
        word-break: break-word;
    }

    .info-card p strong {
        color: #212529;
        font-weight: 600;
    }

    .map-container {
        position: relative;
        background: white;
        height: 100%;
    }

    #jobMap {
        height: 100%;
        width: 100%;
    }

    .tracking-status {
        position: absolute;
        top: 10px;
        left: 10px;
        right: 10px;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.98) 0%, rgba(248, 249, 250, 0.98) 100%);
        padding: 10px 12px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
        z-index: 1000;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        color: #212529;
        border: 1px solid rgba(0, 0, 0, 0.08);
        max-width: calc(100% - 20px);
    }

    .tracking-indicator {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #28a745;
        animation: pulse 2s infinite;
        flex-shrink: 0;
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

    .job-actions {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        display: flex;
        gap: 0.8rem;
        padding: 1rem;
        background: white;
        box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
        z-index: 999;
    }

    .btn {
        padding: 11px 16px;
        border: none;
        border-radius: 12px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.3s ease;
        text-decoration: none;
        flex: 1;
        min-height: 44px;
        white-space: nowrap;
    }

    .btn i {
        transition: transform 0.3s ease;
    }

    .btn:hover i {
        transform: scale(1.1);
    }

    .btn-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        box-shadow: 0 6px 20px rgba(40, 167, 69, 0.25);
    }

    .btn-success:hover {
        background: linear-gradient(135deg, #218838 0%, #1e9e8a 100%);
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(40, 167, 69, 0.35);
    }

    .btn-success:active {
        transform: scale(0.98);
    }

    .btn-danger {
        background: transparent;
        color: #495057;
        border: 2px solid #e9ecef;
    }

    .btn-danger:hover {
        background: rgba(220, 53, 69, 0.05);
        color: #dc3545;
        border-color: #dc3545;
        transform: translateY(-2px);
    }

    .btn-danger:active {
        transform: scale(0.98);
    }

    .btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .location-status {
        background: #f8f9fa;
        padding: 10px;
        border-radius: 8px;
        border-left: 3px solid #28a745;
    }

    .location-status p {
        margin: 5px 0;
        font-size: 0.8rem;
    }

    .distance-info {
        background: #f8f9fa;
        padding: 10px;
        border-radius: 8px;
        border-left: 3px solid #dc3545;
        margin-top: 8px;
    }

    .distance-info p {
        margin: 5px 0;
        font-size: 0.8rem;
    }

    .map-controls {
        position: absolute;
        top: 60px;
        right: 10px;
        z-index: 1000;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .zoom-control {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 1.1rem;
        font-weight: 600;
        color: #495057;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        min-height: 44px;
        min-width: 44px;
    }

    .zoom-control:hover {
        background: #f8f9fa;
        color: #dc3545;
        border-color: #dc3545;
        transform: scale(1.05);
    }

    .job-sidebar::-webkit-scrollbar {
        width: 6px;
    }

    .job-sidebar::-webkit-scrollbar-track {
        background: #f8f9fa;
    }

    .job-sidebar::-webkit-scrollbar-thumb {
        background: #dc3545;
        border-radius: 10px;
    }

    .alert-section {
        margin-top: 1rem;
    }

    .alert {
        border-radius: 12px;
        padding: 1.2rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .alert-danger {
        background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
        border: 2px solid #f1b0b7;
        border-left: 6px solid #dc3545;
    }

    .alert-header {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 1rem;
    }

    .alert-header h3 {
        color: #721c24;
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
        word-break: break-word;
    }

    .alert-header i {
        color: #dc3545;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .alert-body {
        color: #721c24;
        margin-bottom: 1rem;
    }

    .alert-body p {
        margin: 6px 0;
        line-height: 1.5;
        font-size: 0.9rem;
    }

    .alert-actions {
        display: flex;
        gap: 0.8rem;
        justify-content: flex-end;
        flex-wrap: wrap;
    }

    .alert-actions .btn {
        padding: 8px 12px;
        font-size: 0.8rem;
        flex: auto;
        min-width: 100px;
    }

    .status-badge.cancelled {
        background: rgba(220, 53, 69, 0.1);
        color: #dc3545;
        border: 1px solid #dc3545;
    }

    .cancellation-toast {
        position: fixed;
        bottom: 80px;
        right: 20px;
        background: #dc3545;
        color: white;
        padding: 12px 16px;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
        z-index: 10000;
        display: flex;
        align-items: center;
        gap: 8px;
        max-width: 90vw;
        min-height: 44px;
        animation: slideInRight 0.3s ease;
    }

    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    .cancellation-toast.hiding {
        animation: slideOutRight 0.3s ease;
    }

    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }

    @media (min-width: 768px) {
        .navbar {
            padding: 1.2rem 2rem;
            flex-wrap: nowrap;
            gap: 2rem;
        }

        .nav-brand {
            font-size: 1.6rem;
        }

        .nav-link {
            padding: 10px 16px;
            font-size: 1rem;
        }

        .job-tracking-container {
            grid-template-columns: 320px 1fr;
            grid-template-rows: auto;
        }

        .job-sidebar {
            border-right: 1px solid #e9ecef;
            border-bottom: none;
            padding: 1.8rem;
            max-height: calc(100vh - 70px);
        }

        .job-header {
            margin-bottom: 1.8rem;
            padding-bottom: 1.5rem;
        }

        .job-header h1 {
            font-size: 1.3rem;
            margin-bottom: 10px;
        }

        .info-card {
            padding: 1.5rem;
            margin-bottom: 1.2rem;
        }

        .info-card h3 {
            font-size: 1.05rem;
            margin-bottom: 1rem;
        }

        .info-card p {
            font-size: 0.9rem;
            margin: 8px 0;
        }

        .job-actions {
            position: absolute;
            bottom: 24px;
            left: 24px;
            right: auto;
            width: auto;
            padding: 0;
            background: transparent;
            box-shadow: none;
            gap: 12px;
        }

        .job-actions .btn {
            padding: 14px 28px;
            font-size: 1rem;
            flex: 0 1 auto;
            width: auto;
        }

        .tracking-status {
            top: 20px;
            left: 20px;
            right: auto;
            padding: 14px 18px;
            font-size: 0.9rem;
            max-width: none;
        }

        .map-controls {
            top: 20px;
            right: 20px;
        }

        .zoom-control {
            width: 40px;
            height: 40px;
            font-size: 1.2rem;
        }

        .alert {
            padding: 1.8rem;
        }

        .cancellation-toast {
            bottom: auto;
            top: 20px;
            right: 20px;
            max-width: 400px;
            padding: 15px 20px;
        }
    }

    @media (min-width: 992px) {
        .navbar {
            padding: 1.2rem 3rem;
        }

        .nav-brand {
            font-size: 1.8rem;
        }

        .job-tracking-container {
            grid-template-columns: 380px 1fr;
        }

        .job-sidebar {
            padding: 2rem;
        }

        .job-header h1 {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 768px) {
        .job-actions {
            flex-direction: column;
        }

        .job-actions .btn {
            width: 100%;
        }

        .alert-actions {
            flex-direction: column;
        }

        .alert-actions .btn {
            width: 100%;
            flex: 1;
        }
    }

    @media (max-width: 480px) {
        .navbar {
            padding: 0.8rem;
        }

        .nav-brand {
            font-size: 1.2rem;
        }

        .job-sidebar {
            padding: 1rem;
            max-height: 30vh;
        }

        .job-header {
            margin-bottom: 1rem;
            padding-bottom: 0.8rem;
        }

        .job-header h1 {
            font-size: 1.1rem;
        }

        .info-card {
            padding: 1rem;
            margin-bottom: 0.8rem;
        }

        .info-card h3 {
            font-size: 0.95rem;
            margin-bottom: 0.8rem;
        }

        .job-actions {
            padding: 0.8rem;
            gap: 0.6rem;
        }

        .btn {
            padding: 8px 12px;
            font-size: 0.75rem;
            min-height: 40px;
        }

        .alert {
            padding: 1rem;
        }

        .alert-header {
            gap: 6px;
            margin-bottom: 0.8rem;
        }

        .alert-header h3 {
            font-size: 0.95rem;
        }

        .alert-header i {
            font-size: 1rem;
        }

        .tracking-status {
            padding: 8px 10px;
            font-size: 0.8rem;
        }

        .map-controls {
            top: 50px;
            right: 8px;
            gap: 4px;
        }

        .zoom-control {
            width: 36px;
            height: 36px;
            font-size: 1rem;
        }

        .cancellation-toast {
            bottom: 70px;
            right: 10px;
            left: 10px;
            max-width: none;
            padding: 10px 12px;
            font-size: 0.85rem;
        }
    }

    @media (hover: none) and (pointer: coarse) {
        .nav-link,
        .btn,
        .zoom-control {
            min-height: 48px;
            min-width: 48px;
        }

        .zoom-control {
            width: 48px;
            height: 48px;
        }

        .map-controls {
            gap: 8px;
        }
    }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="/" class="nav-brand">Fast<span>Lan</span></a>
        <div class="nav-links">
            <a href="{{ route('driver.dashboard') }}" class="nav-link">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </nav>

    <div class="job-tracking-container">
        <!-- Sidebar -->
        <div class="job-sidebar">
            <div class="job-header">
                <h1>
                    <i class="fas fa-route"></i>
                    Active Job
                </h1>
                <span class="status-badge">IN PROGRESS</span>
                <p style="margin-top: 10px;">Real-time location tracking active</p>
            </div>

            <!-- Cancellation Alert Section -->
            <div id="cancellationAlert" class="alert-section" style="display: none;">
                <div class="alert alert-danger">
                    <div class="alert-header">
                        <i class="fas fa-exclamation-triangle"></i>
                        <h3>Booking Cancelled</h3>
                    </div>
                    <div class="alert-body">
                        <p id="cancellationMessage"></p>
                        <p><strong>This trip has been cancelled by the passenger.</strong></p>
                    </div>
                    <div class="alert-actions">
                        <button class="btn btn-primary" onclick="handleCancellation()">
                            <i class="fas fa-check"></i>
                            Acknowledge
                        </button>
                    </div>
                </div>
            </div>

            <!-- Passenger Info -->
            <div class="info-card">
                <h3><i class="fas fa-user"></i> Passenger Details</h3>
                <p>
                    <strong><i class="fas fa-user-circle"></i> Name:</strong> 
                    {{ $booking->passenger->fullname ?? 'N/A' }}
                </p>
                <p>
                    <strong><i class="fas fa-phone"></i> Phone:</strong> 
                    {{ $booking->passenger->phone ?? 'N/A' }}
                </p>
                <p>
                    <strong><i class="fas fa-car"></i> Service:</strong> 
                    {{ $booking->getServiceTypeDisplay() }}
                </p>
            </div>

            <!-- Trip Info -->
            <div class="info-card">
                <h3><i class="fas fa-route"></i> Trip Details</h3>
                <p>
                    <strong><i class="fas fa-map-marker-alt" style="color: #28a745;"></i> Pickup:</strong> 
                    {{ $booking->pickupLocation }}
                </p>
                <p>
                    <strong><i class="fas fa-flag-checkered" style="color: #dc3545;"></i> Drop-off:</strong> 
                    {{ $booking->dropoffLocation }}
                </p>
                <p>
                    <strong><i class="fas fa-money-bill-wave"></i> Fare:</strong> 
                    ₱{{ number_format($booking->fare, 2) }}
                </p>
                <p>
                    <strong><i class="fas fa-credit-card"></i> Payment:</strong> 
                    {{ $booking->getPaymentMethodDisplay() }}
                </p>
                @if($booking->description)
                <p>
                    <strong><i class="fas fa-sticky-note"></i> Notes:</strong> 
                    {{ $booking->description }}
                </p>
                @endif
            </div>

            <!-- Completion Status -->
            <div class="info-card">
                <h3><i class="fas fa-check-circle"></i> Trip Completion</h3>
                <div id="completionStatus">
                    <p><i class="fas fa-info-circle"></i> Trip in progress...</p>
                </div>
                <div id="completionMessage" style="margin-top: 10px;"></div>
            </div>
        </div>

        <!-- Map -->
        <div class="map-container">
            <!-- Tracking Status -->
            <div class="tracking-status">
                <div class="tracking-indicator"></div>
                <span>Live GPS Tracking Active</span>
            </div>

            <!-- Map Controls -->
            <div class="map-controls">
                <button class="zoom-control" onclick="map.zoomIn()">+</button>
                <button class="zoom-control" onclick="map.zoomOut()">-</button>
            </div>

            <!-- Map -->
            <div id="jobMap"></div>
            
            <!-- Actions -->
            <div class="job-actions">
                <button class="btn btn-success" onclick="confirmCompletion()" id="confirmCompletionBtn">
                    <i class="fas fa-check-circle"></i>
                    Confirm Completion
                </button>
                <a href="{{ route('driver.dashboard') }}" class="btn btn-danger">
                    <i class="fas fa-times"></i>
                    Cancel Job
                </a>
            </div>
        </div>
    </div>
    

<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script src="{{ asset('js/driver/job-tracking.js') }}"></script>
<script>
// Enhanced Driver Tracking with Notifications & Completion
const DRIVER_CONFIG = {
    UPDATE_INTERVAL: 3000,
    HIGH_ACCURACY: true,
    MAX_AGE: 0,
    TIMEOUT: 10000
};

let driverMap;
let driverMarker;
let locationWatchId;
let currentPosition = null;
let cancellationCheckInterval;
let completionCheckInterval;
let notificationCheckInterval;

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
    },
    passengerName: `{{ $booking->passenger->fullname ?? 'Passenger' }}`,
    csrfToken: '{{ csrf_token() }}'
};

// Initialize when page loads
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚗 Initializing driver tracking with notifications...');
    initializeDriverTracking();
    startNotificationMonitoring();
    startCompletionMonitoring();
});

function initializeDriverTracking() {
    initDriverMap();
    startAutomaticLocationUpdates();
}

function initDriverMap() {
    console.log('🗺️ Initializing driver map...');
    
    driverMap = L.map('jobMap', {
        zoomControl: false
    }).setView([bookingData.pickup.lat, bookingData.pickup.lng], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(driverMap);

    // Add pickup marker
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

    L.marker([bookingData.pickup.lat, bookingData.pickup.lng], { icon: pickupIcon })
        .addTo(driverMap)
        .bindPopup(`<strong>📍 PICKUP LOCATION</strong><br>${bookingData.pickup.address}`)
        .openPopup();

    // Add dropoff marker
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

    L.marker([bookingData.dropoff.lat, bookingData.dropoff.lng], { icon: dropoffIcon })
        .addTo(driverMap)
        .bindPopup(`<strong>🏁 DROP-OFF LOCATION</strong><br>${bookingData.dropoff.address}`);
}

// ==================== LOCATION TRACKING ====================
function startAutomaticLocationUpdates() {
    console.log('📍 Starting automatic location updates...');
    
    if (!navigator.geolocation) {
        console.error('❌ Geolocation not supported');
        showLocationStatus('error', 'Geolocation is not supported by your browser');
        return;
    }

    navigator.geolocation.getCurrentPosition(
        (position) => {
            handleNewPosition(position);
            startWatchingPosition();
        },
        (error) => {
            console.error('❌ Initial position error:', error);
            handleLocationError(error);
            tryFallbackLocation();
        },
        {
            enableHighAccuracy: DRIVER_CONFIG.HIGH_ACCURACY,
            timeout: DRIVER_CONFIG.TIMEOUT,
            maximumAge: DRIVER_CONFIG.MAX_AGE
        }
    );
}

function startWatchingPosition() {
    locationWatchId = navigator.geolocation.watchPosition(
        (position) => {
            handleNewPosition(position);
        },
        (error) => {
            console.error('❌ Watch position error:', error);
            handleLocationError(error);
        },
        {
            enableHighAccuracy: DRIVER_CONFIG.HIGH_ACCURACY,
            timeout: DRIVER_CONFIG.TIMEOUT,
            maximumAge: DRIVER_CONFIG.MAX_AGE
        }
    );
}

function handleNewPosition(position) {
    const lat = position.coords.latitude;
    const lng = position.coords.longitude;
    const accuracy = position.coords.accuracy;
    
    console.log('📍 New position:', { lat, lng, accuracy });
    
    updateDriverMarker(lat, lng);
    sendLocationToServer(lat, lng, accuracy);
    
    showLocationStatus('success', 
        `Location updated - Accuracy: ${accuracy.toFixed(1)}m`,
        `Lat: ${lat.toFixed(6)}, Lng: ${lng.toFixed(6)}`
    );
    
    currentPosition = { lat, lng, accuracy };
}

function updateDriverMarker(lat, lng) {
    const driverIcon = L.divIcon({
        className: 'driver-marker',
        html: `
            <div style="position: relative;">
                <div style="background:#007bff; border:3px solid white; border-radius:50%; width:16px; height:16px; box-shadow:0 2px 8px rgba(0,0,0,0.3);"></div>
                <div style="position: absolute; top: -22px; left: 50%; transform: translateX(-50%); background: #007bff; color: white; padding: 2px 6px; border-radius: 8px; font-size: 9px; font-weight: bold; white-space: nowrap;">
                    YOU
                </div>
            </div>
        `,
        iconSize: [16, 38],
        iconAnchor: [8, 16]
    });

    if (!driverMarker) {
        driverMarker = L.marker([lat, lng], { icon: driverIcon })
            .addTo(driverMap)
            .bindPopup(`
                <div style="text-align: center; min-width: 200px;">
                    <strong>🚗 YOUR LOCATION</strong><br>
                    <hr style="margin: 5px 0;">
                    Real-time GPS position<br>
                    <small>Last update: ${new Date().toLocaleTimeString()}</small>
                </div>
            `);
    } else {
        driverMarker.setLatLng([lat, lng]);
    }
}

function sendLocationToServer(lat, lng, accuracy) {
    const payload = {
        latitude: lat,
        longitude: lng,
        accuracy: accuracy,
        booking_id: bookingData.id,
        _token: bookingData.csrfToken
    };

    fetch('/digilink/public/driver/update-location', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': bookingData.csrfToken
        },
        body: JSON.stringify(payload)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('✅ Location saved to database');
        }
    })
    .catch(error => {
        console.error('❌ Error sending location:', error);
    });
}

// ==================== CANCELLATION & NOTIFICATION MONITORING ====================
function startNotificationMonitoring() {
    console.log('🔔 Starting notification monitoring...');
    checkForCancellations();
    checkForNotifications();
    
    // Check for cancellations every 5 seconds
    cancellationCheckInterval = setInterval(checkForCancellations, 5000);
    
    // Check for general notifications every 10 seconds
    notificationCheckInterval = setInterval(checkForNotifications, 10000);
}

function checkForCancellations() {
    fetch(`/digilink/public/driver/get-booking-status/${bookingData.id}?_t=${Date.now()}`)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.booking) {
                if (data.booking.status === 'cancelled') {
                    handleBookingCancellation(data.booking);
                }
            }
        })
        .catch(error => {
            console.error('Error checking booking status:', error);
        });
}

function checkForNotifications() {
    fetch('/digilink/public/driver/notifications')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.notifications) {
                data.notifications.forEach(notification => {
                    if (notification.type === 'booking_cancelled' && !notification.read_at) {
                        showCancellationNotification(notification);
                        markNotificationAsRead(notification.id);
                    } else if (notification.type === 'passenger_completed' && !notification.read_at) {
                        showCompletionNotification(notification);
                        markNotificationAsRead(notification.id);
                    }
                });
            }
        })
        .catch(error => {
            console.error('Error checking notifications:', error);
        });
}

function handleBookingCancellation(booking) {
    console.log('❌ Booking cancelled by passenger');
    
    // Stop all tracking
    stopAllTracking();
    
    // Show cancellation alert
    showCancellationAlert('This booking has been cancelled by the passenger.');
    
    // Update UI
    updateBookingStatus('cancelled');
    
    // Disable completion button
    const confirmBtn = document.getElementById('confirmCompletionBtn');
    if (confirmBtn) {
        confirmBtn.disabled = true;
        confirmBtn.innerHTML = '<i class="fas fa-ban"></i> Trip Cancelled';
        confirmBtn.style.background = '#6c757d';
    }
}

function showCancellationAlert(message) {
    // Create or show cancellation alert section
    let alertSection = document.getElementById('cancellationAlert');
    if (!alertSection) {
        alertSection = document.createElement('div');
        alertSection.id = 'cancellationAlert';
        alertSection.style.cssText = `
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #f5c6cb;
            margin: 15px 0;
            text-align: center;
        `;
        document.querySelector('.container').insertBefore(alertSection, document.querySelector('.container').firstChild);
    }
    
    alertSection.innerHTML = `
        <div style="display: flex; align-items: center; justify-content: center; gap: 10px;">
            <i class="fas fa-exclamation-triangle" style="font-size: 24px;"></i>
            <div>
                <h4 style="margin: 0; color: #721c24;">Booking Cancelled</h4>
                <p style="margin: 5px 0 0 0;">${message}</p>
            </div>
        </div>
        <button onclick="redirectToDashboard()" style="margin-top: 10px; padding: 8px 20px; background: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Return to Dashboard
        </button>
    `;
    alertSection.style.display = 'block';
}

function showCancellationNotification(notification) {
    showToast('error', notification.title, notification.message);
}

function showCompletionNotification(notification) {
    showToast('success', notification.title, notification.message);
    // Refresh completion status when passenger confirms
    checkCompletionStatus();
}

function showToast(type, title, message) {
    const toast = document.createElement('div');
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'error' ? '#f8d7da' : '#d4edda'};
        color: ${type === 'error' ? '#721c24' : '#155724'};
        padding: 15px;
        border-radius: 8px;
        border: 1px solid ${type === 'error' ? '#f5c6cb' : '#c3e6cb'};
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        z-index: 10000;
        max-width: 400px;
        animation: slideIn 0.3s ease-out;
    `;
    
    toast.innerHTML = `
        <div style="display: flex; align-items: flex-start; gap: 10px;">
            <i class="fas fa-${type === 'error' ? 'exclamation-triangle' : 'check-circle'}" style="font-size: 18px;"></i>
            <div>
                <strong>${title}</strong>
                <div style="font-size: 0.9rem; margin-top: 5px;">${message}</div>
            </div>
            <button onclick="this.parentElement.parentElement.remove()" style="background: none; border: none; font-size: 16px; cursor: pointer; color: inherit;">
                &times;
            </button>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    // Auto remove after 8 seconds
    setTimeout(() => {
        if (toast.parentNode) {
            toast.style.animation = 'slideOut 0.3s ease-in';
            setTimeout(() => toast.remove(), 300);
        }
    }, 8000);
}

function markNotificationAsRead(notificationId) {
    fetch(`/digilink/public/driver/notifications/${notificationId}/read`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': bookingData.csrfToken
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('✅ Notification marked as read');
        }
    })
    .catch(error => {
        console.error('Error marking notification as read:', error);
    });
}

// ==================== COMPLETION SYSTEM ====================
function startCompletionMonitoring() {
    console.log('✅ Starting completion monitoring...');
    checkCompletionStatus();
    completionCheckInterval = setInterval(checkCompletionStatus, 8000);
}

function checkCompletionStatus() {
    fetch(`/digilink/public/driver/get-booking-status/${bookingData.id}?_t=${Date.now()}`)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.booking) {
                updateCompletionStatus(data.booking);
            }
        })
        .catch(error => {
            console.error('Error checking completion status:', error);
        });
}

function updateCompletionStatus(booking) {
    const status = booking.status;
    const driverCompleted = booking.driver_completed_at;
    const passengerCompleted = booking.passenger_completed_at;
    
    let completionStatus = 'pending';
    
    if (driverCompleted && passengerCompleted) {
        completionStatus = 'both_confirmed';
    } else if (driverCompleted && !passengerCompleted) {
        completionStatus = 'driver_confirmed';
    } else if (!driverCompleted && passengerCompleted) {
        completionStatus = 'passenger_confirmed';
    }
    
    updateCompletionUI(completionStatus, status === 'completed');
}

function updateCompletionUI(status, isCompleted) {
    const statusContainer = document.getElementById('completionStatus');
    const confirmBtn = document.getElementById('confirmCompletionBtn');
    
    if (!statusContainer) return;
    
    const statusMessages = {
        'pending': `
            <div style="color: #6c757d;">
                <i class="fas fa-clock"></i> <strong>Status:</strong> Waiting for completion confirmation...
            </div>
        `,
        'driver_confirmed': `
            <div style="color: #007bff;">
                <i class="fas fa-user-check"></i> <strong>Status:</strong> You have confirmed completion
            </div>
            <div style="font-size: 0.8rem; color: #6c757d; margin-top: 5px;">
                Waiting for passenger confirmation...
            </div>
        `,
        'passenger_confirmed': `
            <div style="color: #28a745;">
                <i class="fas fa-user-check"></i> <strong>Status:</strong> Passenger has confirmed completion
            </div>
            <div style="font-size: 0.8rem; color: #6c757d; margin-top: 5px;">
                Please confirm completion to finish the trip
            </div>
        `,
        'both_confirmed': `
            <div style="color: #28a745;">
                <i class="fas fa-check-double"></i> <strong>Status:</strong> Trip completed successfully!
            </div>
            <div style="font-size: 0.8rem; color: #6c757d; margin-top: 5px;">
                Redirecting to dashboard...
            </div>
        `
    };
    
    statusContainer.innerHTML = statusMessages[status] || statusMessages.pending;
    
    if (confirmBtn) {
        if (isCompleted || status === 'both_confirmed') {
            confirmBtn.innerHTML = '<i class="fas fa-check-double"></i> Trip Completed';
            confirmBtn.disabled = true;
            confirmBtn.style.background = '#6c757d';
            
            // Redirect after 3 seconds
            setTimeout(() => {
                window.location.href = '/digilink/public/driver/dashboard';
            }, 3000);
        } else if (status === 'driver_confirmed') {
            confirmBtn.innerHTML = '<i class="fas fa-clock"></i> Waiting for Passenger';
            confirmBtn.disabled = true;
            confirmBtn.style.background = '#ffc107';
            confirmBtn.style.color = '#212529';
        } else if (status === 'passenger_confirmed') {
            confirmBtn.innerHTML = '<i class="fas fa-check-circle"></i> Confirm Completion';
            confirmBtn.disabled = false;
            confirmBtn.style.background = '#28a745';
        } else {
            confirmBtn.innerHTML = '<i class="fas fa-check-circle"></i> Confirm Completion';
            confirmBtn.disabled = false;
            confirmBtn.style.background = '#28a745';
        }
    }
}

function confirmCompletion() {
    if (!confirm('Are you sure you want to confirm job completion?\n\nThis will notify the passenger to confirm. The trip will only be completed when both you and the passenger confirm.')) {
        return;
    }

    const confirmBtn = document.getElementById('confirmCompletionBtn');
    const originalText = confirmBtn.innerHTML;
    const originalBackground = confirmBtn.style.background;
    
    confirmBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Confirming...';
    confirmBtn.disabled = true;

    fetch(`/digilink/public/driver/confirm-completion/${bookingData.id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': bookingData.csrfToken
        }
    })
    .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showCompletionMessage(data.message, 'success');
            updateCompletionStatus(data.booking);
            
            if (data.is_completed) {
                stopAllTracking();
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
        confirmBtn.style.background = originalBackground;
    });
}

function showCompletionMessage(message, type) {
    let messageContainer = document.getElementById('completionMessage');
    if (!messageContainer) {
        messageContainer = document.createElement('div');
        messageContainer.id = 'completionMessage';
        const completionSection = document.querySelector('.completion-section');
        if (completionSection) {
            completionSection.appendChild(messageContainer);
        }
    }
    
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

    messageContainer.innerHTML = `
        <div style="color: ${colors[type]}; font-weight: 600; padding: 10px; background: ${backgrounds[type]}; border-radius: 8px; border: 1px solid ${borders[type]}; margin-top: 10px;">
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'}"></i> ${message}
        </div>
    `;
}

// ==================== UTILITY FUNCTIONS ====================
function updateBookingStatus(status) {
    const statusBadge = document.querySelector('.status-badge');
    const trackingIndicator = document.querySelector('.tracking-indicator');
    const trackingStatus = document.querySelector('.tracking-status span');
    
    if (statusBadge) {
        statusBadge.textContent = status.toUpperCase();
        statusBadge.className = `status-badge ${status}`;
    }
    
    if (trackingIndicator) {
        trackingIndicator.style.background = status === 'cancelled' ? '#dc3545' : 
                                           status === 'completed' ? '#6c757d' : '#28a745';
    }
    
    if (trackingStatus) {
        trackingStatus.textContent = status === 'cancelled' ? 'Trip Cancelled' : 
                                   status === 'completed' ? 'Trip Completed' : 'Live Tracking Active';
    }
}

function stopAllTracking() {
    if (locationWatchId && navigator.geolocation) {
        navigator.geolocation.clearWatch(locationWatchId);
    }
    if (cancellationCheckInterval) {
        clearInterval(cancellationCheckInterval);
    }
    if (completionCheckInterval) {
        clearInterval(completionCheckInterval);
    }
    if (notificationCheckInterval) {
        clearInterval(notificationCheckInterval);
    }
}

function redirectToDashboard() {
    window.location.href = '/digilink/public/driver/dashboard';
}

function tryFallbackLocation() {
    navigator.geolocation.getCurrentPosition(
        (position) => {
            handleNewPosition(position);
        },
        (error) => {
            console.error('❌ Fallback also failed:', error);
            showLocationStatus('error', 
                'Cannot access your location. Please check browser permissions and ensure location services are enabled.'
            );
        },
        {
            enableHighAccuracy: false,
            timeout: 15000,
            maximumAge: 300000
        }
    );
}

function handleLocationError(error) {
    let errorMessage = 'Location error: ';
    
    switch(error.code) {
        case error.PERMISSION_DENIED:
            errorMessage = 'Location access denied. Please enable location permissions in your browser settings.';
            break;
        case error.POSITION_UNAVAILABLE:
            errorMessage = 'Location unavailable. Please check your GPS signal and try again.';
            break;
        case error.TIMEOUT:
            errorMessage = 'Location request timed out. Please check your internet connection.';
            break;
        default:
            errorMessage = 'An unknown location error occurred.';
            break;
    }
    
    showLocationStatus('error', errorMessage);
}

function showLocationStatus(type, message, details = '') {
    const statusIcons = {
        'success': '<i class="fas fa-check-circle" style="color: #28a745;"></i>',
        'error': '<i class="fas fa-exclamation-triangle" style="color: #dc3545;"></i>',
        'warning': '<i class="fas fa-info-circle" style="color: #ffc107;"></i>'
    };

    let locationStatus = document.getElementById('locationStatus');
    if (!locationStatus) {
        locationStatus = document.createElement('div');
        locationStatus.id = 'locationStatus';
        locationStatus.className = 'location-status';
        document.querySelector('.info-card').appendChild(locationStatus);
    }

    let statusHTML = `<p>${statusIcons[type]} ${message}</p>`;
    if (details) {
        statusHTML += `<p style="font-size: 0.8rem; color: #6c757d; margin-top: 5px;">${details}</p>`;
    }

    locationStatus.innerHTML = statusHTML;
}

// Manual location controls for testing
function addManualControls() {
    const controls = document.createElement('div');
    controls.style.cssText = `
        position: fixed;
        top: 10px;
        right: 10px;
        background: white;
        padding: 10px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        z-index: 1000;
    `;
    
    controls.innerHTML = `
        <div style="font-weight: bold; margin-bottom: 8px;">📍 Manual Controls</div>
        <button onclick="simulateMovement()" style="padding: 5px 10px; margin: 2px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Simulate Move
        </button>
        <button onclick="forceLocationUpdate()" style="padding: 5px 10px; margin: 2px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Force Update
        </button>
    `;
    
    document.body.appendChild(controls);
}

function simulateMovement() {
    if (!currentPosition) {
        currentPosition = {
            lat: bookingData.pickup.lat,
            lng: bookingData.pickup.lng,
            accuracy: 10
        };
    }
    
    currentPosition.lat += (Math.random() - 0.5) * 0.001;
    currentPosition.lng += (Math.random() - 0.5) * 0.001;
    
    updateDriverMarker(currentPosition.lat, currentPosition.lng);
    sendLocationToServer(currentPosition.lat, currentPosition.lng, currentPosition.accuracy);
    
    console.log('🎮 Simulated movement:', currentPosition);
}

function forceLocationUpdate() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                handleNewPosition(position);
            },
            (error) => {
                console.error('Force update failed:', error);
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
    }
}

// Clean up when page unloads
window.addEventListener('beforeunload', stopAllTracking);

// Add CSS for animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
`;
document.head.appendChild(style);

// Add manual controls in development
setTimeout(addManualControls, 2000);

    </script>
</body>
</html>