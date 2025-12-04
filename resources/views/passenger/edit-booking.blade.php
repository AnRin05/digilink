<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FastLan - Edit Booking</title>
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
    font-family: 'Poppins', sans-serif;
}

body {
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

.back-link {
    color: #6c757d;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 6px;
    font-weight: 500;
    transition: all 0.3s ease;
    min-height: 44px;
    padding: 8px 12px;
    font-size: 0.9rem;
    border-radius: 8px;
}

.back-link:hover {
    color: #dc3545;
    background: rgba(220, 53, 69, 0.05);
}

.back-link:active {
    transform: scale(0.95);
}

.edit-form {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    border: 2px solid #e9ecef;
    transition: box-shadow 0.3s ease;
}

.edit-form:hover {
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
}

.form-group {
    margin-bottom: 1.2rem;
}

.form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #212529;
    font-size: 0.95rem;
}

.form-input,
.form-textarea,
.form-select {
    width: 100%;
    padding: 12px 14px;
    border: 2px solid #e9ecef;
    border-radius: 10px;
    font-size: 1rem;
    transition: all 0.3s ease;
    font-family: 'Poppins', sans-serif;
    min-height: 44px;
    background: white;
}

.form-input:focus,
.form-textarea:focus,
.form-select:focus {
    border-color: #dc3545;
    outline: none;
    box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
}

.form-input:hover:not(:focus),
.form-textarea:hover:not(:focus),
.form-select:hover:not(:focus) {
    border-color: #ced4da;
}

.form-textarea {
    resize: vertical;
    min-height: 100px;
    line-height: 1.5;
}

.form-select {
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 14 14'%3E%3Cpath fill='%23dc3545' d='M7 10L2 5h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 14px center;
    padding-right: 40px;
}

.form-input[readonly] {
    background-color: #f8f9fa;
    cursor: not-allowed;
    opacity: 0.8;
}

.map-container {
    height: 280px;
    border-radius: 12px;
    overflow: hidden;
    border: 3px solid #e9ecef;
    margin-bottom: 1rem;
    position: relative;
    background: #f8f9fa;
}

#editMap {
    height: 100%;
    width: 100%;
    z-index: 1;
}

.location-buttons {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.8rem;
    margin-bottom: 1rem;
}

.btn {
    padding: 12px 16px;
    border: 2px solid transparent;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    text-decoration: none;
    font-size: 0.9rem;
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

.btn-primary {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(220, 53, 69, 0.25);
}

.btn-primary:hover {
    background: linear-gradient(135deg, #c82333 0%, #a71e2a 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(220, 53, 69, 0.35);
}

.btn-primary:active {
    transform: scale(0.98);
}

.btn-secondary {
    background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(108, 117, 125, 0.25);
}

.btn-secondary:hover {
    background: linear-gradient(135deg, #5a6268 0%, #495057 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(108, 117, 125, 0.35);
}

.btn-secondary:active {
    transform: scale(0.98);
}

.btn-outline {
    background: transparent;
    color: #495057;
    border: 2px solid #e9ecef;
}

.btn-outline:hover {
    background: rgba(220, 53, 69, 0.05);
    color: #dc3545;
    border-color: #dc3545;
    transform: translateY(-2px);
}

.btn-outline:active {
    transform: scale(0.95);
}

.btn-outline.active {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
    border-color: #dc3545;
}

.form-actions {
    display: flex;
    flex-direction: column;
    gap: 0.8rem;
    margin-top: 1.8rem;
    padding-top: 1.5rem;
    border-top: 2px solid #f8f9fa;
}

.current-location {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 1.2rem;
    border-radius: 10px;
    margin-bottom: 1rem;
    border-left: 4px solid #dc3545;
}

.current-location p {
    margin: 0.4rem 0;
    font-size: 0.9rem;
    color: #495057;
    word-break: break-word;
    line-height: 1.4;
}

.map-instructions {
    position: absolute;
    top: 12px;
    left: 12px;
    background: rgba(255, 255, 255, 0.95);
    padding: 10px 14px;
    border-radius: 8px;
    font-size: 0.85rem;
    z-index: 1000;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    pointer-events: none;
    max-width: calc(100% - 24px);
    border: 1px solid #e9ecef;
}

.small-note {
    color: #6c757d;
    font-size: 0.85rem;
    margin-top: 4px;
    display: block;
    font-style: italic;
}

.alert {
    padding: 12px 16px;
    border-radius: 10px;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 10px;
    animation: slideDown 0.3s ease;
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

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
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

    .main-container {
        margin: 2rem auto;
        padding: 0 2rem;
    }

    .page-header {
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .page-title {
        font-size: 1.8rem;
    }

    .back-link {
        padding: 10px 18px;
        font-size: 1rem;
    }

    .edit-form {
        padding: 2rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-size: 1rem;
        margin-bottom: 0.6rem;
    }

    .form-input,
    .form-textarea,
    .form-select {
        padding: 14px 16px;
    }

    .form-textarea {
        min-height: 120px;
    }

    .map-container {
        height: 400px;
        margin-bottom: 1.5rem;
    }

    .location-buttons {
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
    }

    .btn {
        padding: 12px 20px;
        font-size: 0.95rem;
    }

    .form-actions {
        flex-direction: row;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 1.8rem;
    }

    .form-actions .btn {
        min-width: 140px;
    }

    .current-location {
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .current-location p {
        font-size: 0.95rem;
        margin: 0.5rem 0;
    }

    .map-instructions {
        top: 16px;
        left: 16px;
        padding: 12px 16px;
        font-size: 0.9rem;
        max-width: 300px;
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
        padding: 0 2rem;
    }

    .page-title {
        font-size: 2rem;
    }

    .edit-form {
        padding: 2.5rem;
        border-radius: 20px;
    }

    .map-container {
        height: 450px;
        border-radius: 16px;
    }

    .location-buttons {
        gap: 1.2rem;
    }

    .btn {
        padding: 14px 24px;
        font-size: 1rem;
        border-radius: 12px;
    }

    .current-location {
        padding: 1.8rem;
        border-radius: 12px;
    }

    .map-instructions {
        padding: 14px 18px;
        border-radius: 10px;
        font-size: 0.95rem;
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
    }

    .nav-brand {
        margin-bottom: 0.5rem;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .map-container {
        height: 250px;
    }

    .location-buttons {
        grid-template-columns: 1fr;
    }

    .form-actions .btn {
        width: 100%;
    }

    .page-title {
        font-size: 1.3rem;
    }

    .back-link {
        width: 100%;
        justify-content: center;
    }
}

@media (hover: none) and (pointer: coarse) {
    .nav-link,
    .back-link,
    .btn {
        min-height: 48px;
    }

    .form-input,
    .form-textarea,
    .form-select {
        min-height: 48px;
        font-size: 16px;
    }

    .location-buttons {
        gap: 1rem;
    }

    .btn {
        padding: 14px 18px;
    }

    .nav-link:hover,
    .back-link:hover,
    .btn:hover {
        transform: none;
    }

    .btn-primary:active,
    .btn-secondary:active,
    .btn-outline:active {
        transform: scale(0.95);
    }
}

.leaflet-container {
    font-family: 'Poppins', sans-serif;
    z-index: 1;
}

.pickup-marker,
.dropoff-marker {
    background: none;
    border: none;
}

.pickup-marker div {
    animation: pulse 2s infinite;
}

.dropoff-marker div {
    animation: pulse 2s infinite 0.5s;
}

@keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(220, 53, 69, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
    }
}

.leaflet-routing-container {
    background: white;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    font-size: 0.9rem;
}

.leaflet-routing-alt {
    max-height: 200px;
    overflow-y: auto;
}

@media (max-width: 767px) {
    .leaflet-routing-container {
        font-size: 0.8rem;
        max-width: 90%;
    }

    .leaflet-routing-alt {
        max-height: 150px;
    }
}

input[type="datetime-local"]::-webkit-calendar-picker-indicator {
    cursor: pointer;
    opacity: 0.6;
    transition: opacity 0.3s ease;
}

input[type="datetime-local"]::-webkit-calendar-picker-indicator:hover {
    opacity: 1;
}

.loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.95);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    font-size: 1.1rem;
    color: #495057;
    font-weight: 500;
}

.loading-spinner {
    border: 4px solid #f3f3f3;
    border-top: 4px solid #dc3545;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    animation: spin 1s linear infinite;
    margin-bottom: 1rem;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a href="#" class="nav-brand">Fast<span>Lan</span></a>
        <div class="nav-links">
            <a href="{{ route('passenger.dashboard') }}" class="nav-link">Dashboard</a>
            <a href="{{ route('passenger.edit') }}" class="nav-link">Edit Profile</a>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="main-container">
        <div class="page-header">
            <h1 class="page-title">Edit Booking</h1>
            <a href="{{ route('passenger.pending.bookings') }}" class="back-link">
                <i class="fas fa-arrow-left"></i>
                Back to My Bookings
            </a>
        </div>

        <div class="edit-form">
            <form id="editBookingForm">
                @csrf
                @method('PUT') 
                <div class="form-group">
                    <label class="form-label">Service Type</label>
                    <input type="text" class="form-input" value="{{ $booking->getServiceTypeDisplay() }}" readonly>
                    <small style="color: #6c757d; font-size: 0.85rem;">Service type cannot be changed</small>
                </div>

                <div class="form-group">
                    <label class="form-label">Payment Method</label>
                    <input type="text" class="form-input" value="{{ $booking->getPaymentMethodDisplay() }}" readonly>
                    <small style="color: #6c757d; font-size: 0.85rem;">Payment method cannot be changed</small>
                </div>

                <div class="form-group">
                    <label class="form-label">Fare</label>
                    <input type="text" class="form-input" value="₱{{ number_format($booking->fare, 2) }}" readonly>
                    <small style="color: #6c757d; font-size: 0.85rem;">Fare cannot be changed</small>
                </div>

                <div class="form-group">
                    <label class="form-label">Pickup Location *</label>
                    <input type="text" id="pickupLocation" name="pickupLocation" class="form-input" 
                           value="{{ $booking->pickupLocation }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Drop-off Location *</label>
                    <input type="text" id="dropoffLocation" name="dropoffLocation" class="form-input" 
                           value="{{ $booking->dropoffLocation }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Map</label>
                    <div class="map-container">
                        <div class="map-instructions">Click on the map to set pickup or drop-off location</div>
                        <div id="editMap"></div>
                    </div>
                    <div class="location-buttons">
                        <button type="button" class="btn btn-outline" onclick="useCurrentLocation()">
                            <i class="fas fa-location-arrow"></i>
                            Use My Location
                        </button>
                        <button type="button" class="btn btn-outline" onclick="resetMap()">
                            <i class="fas fa-undo"></i>
                            Reset Map
                        </button>
                        <button type="button" class="btn btn-outline" id="setPickupBtn" onclick="setPickupMode()">
                            <i class="fas fa-map-marker-alt"></i>
                            Set Pickup
                        </button>
                        <button type="button" class="btn btn-outline" id="setDropoffBtn" onclick="setDropoffMode()">
                            <i class="fas fa-flag"></i>
                            Set Drop-off
                        </button>
                    </div>
                    <div class="current-location" id="currentLocationInfo" style="display: none;">
                        <p><strong>Current Coordinates:</strong></p>
                        <p>Pickup: <span id="currentPickupCoords"></span></p>
                        <p>Drop-off: <span id="currentDropoffCoords"></span></p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Description (Optional)</label>
                    <textarea name="description" class="form-textarea" 
                              placeholder="Add any additional notes for the driver...">{{ $booking->description }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Schedule Time (Optional)</label>
                    <input type="datetime-local" name="scheduleTime" class="form-input" 
                           value="{{ $booking->scheduleTime ? $booking->scheduleTime->format('Y-m-d\TH:i') : '' }}"
                           min="{{ now()->format('Y-m-d\TH:i') }}">
                    <small style="color: #6c757d; font-size: 0.85rem;">Leave empty for immediate booking</small>
                </div>

                <input type="hidden" id="pickupLatitude" name="pickupLatitude" value="{{ $booking->pickupLatitude }}">
                <input type="hidden" id="pickupLongitude" name="pickupLongitude" value="{{ $booking->pickupLongitude }}">
                <input type="hidden" id="dropoffLatitude" name="dropoffLatitude" value="{{ $booking->dropoffLatitude }}">
                <input type="hidden" id="dropoffLongitude" name="dropoffLongitude" value="{{ $booking->dropoffLongitude }}">

                <div class="form-actions">
                    <a href="{{ route('passenger.pending.bookings') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i>
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Update Booking
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let map;
        let pickupMarker;
        let dropoffMarker;
        let routingControl;
        let mapClickMode = 'pickup'; // 'pickup' or 'dropoff'
        let originalPickupLat = {{ $booking->pickupLatitude }};
        let originalPickupLng = {{ $booking->pickupLongitude }};
        let originalDropoffLat = {{ $booking->dropoffLatitude }};
        let originalDropoffLng = {{ $booking->dropoffLongitude }};

        // Initialize map
        function initMap() {
            map = L.map('editMap').setView([{{ $booking->pickupLatitude }}, {{ $booking->pickupLongitude }}], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Add pickup marker
            pickupMarker = L.marker([{{ $booking->pickupLatitude }}, {{ $booking->pickupLongitude }}], {
                draggable: true,
                icon: L.divIcon({
                    className: 'pickup-marker',
                    html: '<div style="background-color: #dc3545; width: 20px; height: 20px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.3);"></div>',
                    iconSize: [20, 20],
                    iconAnchor: [10, 10]
                })
            }).addTo(map)
            .bindPopup('Pickup Location')
            .on('dragend', function(e) {
                const position = e.target.getLatLng();
                document.getElementById('pickupLatitude').value = position.lat;
                document.getElementById('pickupLongitude').value = position.lng;
                updateAddressFromCoords(position.lat, position.lng, 'pickup');
                updateRoute();
                updateLocationInfo();
            });

            // Add dropoff marker
            dropoffMarker = L.marker([{{ $booking->dropoffLatitude }}, {{ $booking->dropoffLongitude }}], {
                draggable: true,
                icon: L.divIcon({
                    className: 'dropoff-marker',
                    html: '<div style="background-color: #28a745; width: 20px; height: 20px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.3);"></div>',
                    iconSize: [20, 20],
                    iconAnchor: [10, 10]
                })
            }).addTo(map)
            .bindPopup('Drop-off Location')
            .on('dragend', function(e) {
                const position = e.target.getLatLng();
                document.getElementById('dropoffLatitude').value = position.lat;
                document.getElementById('dropoffLongitude').value = position.lng;
                updateAddressFromCoords(position.lat, position.lng, 'dropoff');
                updateRoute();
                updateLocationInfo();
            });

            // Add click event to map
            map.on('click', function(e) {
                if (mapClickMode === 'pickup') {
                    setPickupLocation(e.latlng.lat, e.latlng.lng);
                } else if (mapClickMode === 'dropoff') {
                    setDropoffLocation(e.latlng.lat, e.latlng.lng);
                }
            });

            // Fit map to show both markers
            const group = new L.featureGroup([pickupMarker, dropoffMarker]);
            map.fitBounds(group.getBounds().pad(0.1));

            updateRoute();
            updateLocationInfo();
        }

        // Set pickup mode
        function setPickupMode() {
            mapClickMode = 'pickup';
            document.getElementById('setPickupBtn').style.borderColor = '#dc3545';
            document.getElementById('setPickupBtn').style.color = '#dc3545';
            document.getElementById('setDropoffBtn').style.borderColor = '#e9ecef';
            document.getElementById('setDropoffBtn').style.color = '#495057';
        }

        // Set dropoff mode
        function setDropoffMode() {
            mapClickMode = 'dropoff';
            document.getElementById('setDropoffBtn').style.borderColor = '#28a745';
            document.getElementById('setDropoffBtn').style.color = '#28a745';
            document.getElementById('setPickupBtn').style.borderColor = '#e9ecef';
            document.getElementById('setPickupBtn').style.color = '#495057';
        }

        // Set pickup location
        function setPickupLocation(lat, lng) {
            pickupMarker.setLatLng([lat, lng]);
            document.getElementById('pickupLatitude').value = lat;
            document.getElementById('pickupLongitude').value = lng;
            updateAddressFromCoords(lat, lng, 'pickup');
            updateRoute();
            updateLocationInfo();
        }

        // Set dropoff location
        function setDropoffLocation(lat, lng) {
            dropoffMarker.setLatLng([lat, lng]);
            document.getElementById('dropoffLatitude').value = lat;
            document.getElementById('dropoffLongitude').value = lng;
            updateAddressFromCoords(lat, lng, 'dropoff');
            updateRoute();
            updateLocationInfo();
        }

        // Update routing between pickup and dropoff
        function updateRoute() {
            if (routingControl) {
                map.removeControl(routingControl);
            }

            const pickupLat = document.getElementById('pickupLatitude').value;
            const pickupLng = document.getElementById('pickupLongitude').value;
            const dropoffLat = document.getElementById('dropoffLatitude').value;
            const dropoffLng = document.getElementById('dropoffLongitude').value;

            routingControl = L.Routing.control({
                waypoints: [
                    L.latLng(pickupLat, pickupLng),
                    L.latLng(dropoffLat, dropoffLng)
                ],
                routeWhileDragging: true,
                showAlternatives: false,
                lineOptions: {
                    styles: [{color: '#dc3545', opacity: 0.7, weight: 5}]
                },
                createMarker: function() { return null; } // Don't create default markers
            }).addTo(map);
        }

        // Use current location for pickup
        function useCurrentLocation() {
            if (!navigator.geolocation) {
                alert('Geolocation is not supported by your browser');
                return;
            }

            navigator.geolocation.getCurrentPosition(function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                // Update pickup marker and coordinates
                setPickupLocation(lat, lng);
                map.setView([lat, lng], 15);
            }, function(error) {
                alert('Unable to get your current location. Please enable location services.');
            });
        }

        // Update address from coordinates
        function updateAddressFromCoords(lat, lng, type) {
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                .then(response => response.json())
                .then(data => {
                    if (data.display_name) {
                        if (type === 'pickup') {
                            document.getElementById('pickupLocation').value = data.display_name;
                        } else if (type === 'dropoff') {
                            document.getElementById('dropoffLocation').value = data.display_name;
                        }
                    }
                })
                .catch(() => {
                    // If reverse geocoding fails, just update with coordinates
                    if (type === 'pickup') {
                        document.getElementById('pickupLocation').value = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                    } else if (type === 'dropoff') {
                        document.getElementById('dropoffLocation').value = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                    }
                });
        }

        function resetMap() {
            setPickupLocation(originalPickupLat, originalPickupLng);
            setDropoffLocation(originalDropoffLat, originalDropoffLng);
            
            // Reset the address fields to original values
            document.getElementById('pickupLocation').value = "{{ $booking->pickupLocation }}";
            document.getElementById('dropoffLocation').value = "{{ $booking->dropoffLocation }}";
            
            // Fit map to show both markers
            const group = new L.featureGroup([pickupMarker, dropoffMarker]);
            map.fitBounds(group.getBounds().pad(0.1));
            
            alert('Map has been reset to original locations');
        }

        // Update location information display
        function updateLocationInfo() {
            const pickupLat = document.getElementById('pickupLatitude').value;
            const pickupLng = document.getElementById('pickupLongitude').value;
            const dropoffLat = document.getElementById('dropoffLatitude').value;
            const dropoffLng = document.getElementById('dropoffLongitude').value;

            document.getElementById('currentPickupCoords').textContent = `${pickupLat}, ${pickupLng}`;
            document.getElementById('currentDropoffCoords').textContent = `${dropoffLat}, ${dropoffLng}`;
            document.getElementById('currentLocationInfo').style.display = 'block';
        }

        // Handle form submission
        document.getElementById('editBookingForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            // Show loading state
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
            submitBtn.disabled = true;

            fetch("{{ route('passenger.update.booking', $booking->bookingID) }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Booking updated successfully!');
                    window.location.href = "{{ route('passenger.pending.bookings') }}";
                } else {
                    throw new Error(data.message || 'Failed to update booking');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating booking: ' + error.message);
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });

        // Initialize map when page loads
        document.addEventListener('DOMContentLoaded', function() {
            initMap();
            // Set initial mode to pickup
            setPickupMode();
        });
    </script>
</body>
</html>