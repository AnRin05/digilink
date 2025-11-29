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
    <link href="{{ asset('css/passenger/edit-bookings.css') }}" rel="stylesheet">
    @yield('styles')
    <link rel="icon" href="{{ asset('images/fastlan1.png') }}">
</head>
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