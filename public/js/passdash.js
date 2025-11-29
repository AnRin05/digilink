// Service type selection
        function setServiceType(type) {
            document.getElementById('serviceType').value = type;
            
            // Update active button
            document.querySelectorAll('.booking-nav button, .booking-nav a').forEach(element => {
                element.classList.remove('active');
            });
            event.currentTarget.classList.add('active');
        }

        // Surigao City center
        const surigaoCity = [9.7890, 125.4950];

        // Initialize map
        const map = L.map('map', {
            center: surigaoCity,
            zoom: 13,
            maxBounds: [
                [9.70, 125.40],
                [9.88, 125.58]
            ],
            maxBoundsViscosity: 1.0
        });

        // Add OpenStreetMap tiles
        const tileLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Hide loading overlay when tiles are loaded
        tileLayer.on('load', function() {
            document.getElementById('map-loading').style.display = 'none';
        });

        let pickupMarker = null;
        let dropoffMarker = null;
        let routeControl = null;
        let currentRoute = null;

function calculateFare(distanceKm) {
    // === Surigao City Tricycle Fare Structure (Example/Assumption) ===
    const BASE_FARE = 13; // Base fare for the first 2.0 km (Adjust this if different)
    const BASE_DISTANCE_KM = 2.0; // The distance covered by the base fare
    const PER_KM_CHARGE = 1; // Charge for every kilometer AFTER the base distance
    const SERVICE_CHARGE = 10; // Fixed service charge

    let totalFare = BASE_FARE;

    if (distanceKm > BASE_DISTANCE_KM) {
        // Calculate the distance beyond the base distance
        const extraDistance = distanceKm - BASE_DISTANCE_KM;
        
        // Add the charge for the extra distance, rounded UP to the nearest whole number (for a complete km)
        totalFare += Math.ceil(extraDistance) * PER_KM_CHARGE;
    }

    // Add the fixed service charge
    totalFare += SERVICE_CHARGE;

    // Ensure the fare is a number and return
    return Math.max(totalFare, BASE_FARE + SERVICE_CHARGE); // Return at least the minimum possible fare
}

// Unified showRoute function (distance, duration, fare) - FIX: Improved duration calculation for clarity
function showRoute(start, end) {
    if (routeControl) {
        map.removeControl(routeControl);
    }
    
    // ... [L.Routing.control initialization code remains the same] ...
    routeControl = L.Routing.control({
        waypoints: [
            L.latLng(start.lat, start.lng),
            L.latLng(end.lat, end.lng)
        ],
        lineOptions: {
            styles: [{ color: '#007bff', weight: 5, opacity: 0.7 }]
        },
        routeWhileDragging: false,
        addWaypoints: false,
        draggableWaypoints: false,
        fitSelectedRoutes: true,
        showAlternatives: false
    }).addTo(map);

    // Listen for route found event
    routeControl.on('routesfound', function(e) {
        const route = e.routes[0];
        const distanceKm = route.summary.totalDistance / 1000;
        const totalSeconds = route.summary.totalTime;

        // FIX: Calculate and display duration in a more readable format (e.g., 5 min, or 1 hr 15 min)
        const durationMin = Math.round(totalSeconds / 60);

        let durationDisplay;
        if (durationMin >= 60) {
            const hours = Math.floor(durationMin / 60);
            const minutes = durationMin % 60;
            durationDisplay = `${hours} hr${hours > 1 ? 's' : ''} ${minutes} min`;
        } else {
            durationDisplay = `${durationMin} min`;
        }

        // Update UI
        document.getElementById('distanceDisplay').textContent = distanceKm.toFixed(1) + ' km';
        document.getElementById('durationDisplay').textContent = durationDisplay; // Use the new formatted string

        // Compute fare
        const fare = calculateFare(distanceKm);
        document.getElementById('fareDisplay').textContent = "₱" + fare.toFixed(2);

        // Save to hidden input for DB
        document.getElementById('fare').value = fare.toFixed(2); // FIX: Ensure fare is saved with 2 decimal places

        currentRoute = route;
    });
}

        // Click to set pickup and dropoff
        map.on('click', function(e) {
            if (!pickupMarker) {
                // Set pickup
                pickupMarker = L.marker(e.latlng, { 
                    draggable: true,
                    icon: L.divIcon({
                        className: 'pickup-marker',
                        html: '<div style="background: #28a745; width: 20px; height: 20px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.3);"></div>',
                        iconSize: [20, 20]
                    })
                }).addTo(map).bindPopup('Pickup Location');

                document.getElementById('pickupLatitude').value = e.latlng.lat.toFixed(6);
                document.getElementById('pickupLongitude').value = e.latlng.lng.toFixed(6);
                document.getElementById('pickupDisplay').textContent = e.latlng.lat.toFixed(4) + ', ' + e.latlng.lng.toFixed(4);

                pickupMarker.on('dragend', function(ev) {
                    let coords = ev.target.getLatLng();
                    updatePickupCoords(coords);
                    if (dropoffMarker) {
                        showRoute(pickupMarker.getLatLng(), dropoffMarker.getLatLng());
                    }
                });

            } else if (!dropoffMarker) {
                // Set drop-off
                dropoffMarker = L.marker(e.latlng, { 
                    draggable: true,
                    icon: L.divIcon({
                        className: 'dropoff-marker',
                        html: '<div style="background: #dc3545; width: 20px; height: 20px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.3);"></div>',
                        iconSize: [20, 20]
                    })
                }).addTo(map).bindPopup('Drop-off Location');

                document.getElementById('dropoffLatitude').value = e.latlng.lat.toFixed(6);
                document.getElementById('dropoffLongitude').value = e.latlng.lng.toFixed(6);
                document.getElementById('dropoffDisplay').textContent = e.latlng.lat.toFixed(4) + ', ' + e.latlng.lng.toFixed(4);

                dropoffMarker.on('dragend', function(ev) {
                    let coords = ev.target.getLatLng();
                    updateDropoffCoords(coords);
                    if (pickupMarker) {
                        showRoute(pickupMarker.getLatLng(), dropoffMarker.getLatLng());
                    }
                });

                // Show initial route
                showRoute(pickupMarker.getLatLng(), dropoffMarker.getLatLng());
            }
        });

        function updatePickupCoords(coords) {
            document.getElementById('pickupLatitude').value = coords.lat.toFixed(6);
            document.getElementById('pickupLongitude').value = coords.lng.toFixed(6);
            document.getElementById('pickupDisplay').textContent = coords.lat.toFixed(4) + ', ' + coords.lng.toFixed(4);
        }

        function updateDropoffCoords(coords) {
            document.getElementById('dropoffLatitude').value = coords.lat.toFixed(6);
            document.getElementById('dropoffLongitude').value = coords.lng.toFixed(6);
            document.getElementById('dropoffDisplay').textContent = coords.lat.toFixed(4) + ', ' + coords.lng.toFixed(4);
        }

        // Reset Map Function
        document.getElementById('resetMapBtn').addEventListener('click', function() {
            if (pickupMarker) {
                map.removeLayer(pickupMarker);
                pickupMarker = null;
            }
            if (dropoffMarker) {
                map.removeLayer(dropoffMarker);
                dropoffMarker = null;
            }
            if (routeControl) {
                map.removeControl(routeControl);
                routeControl = null;
            }

            document.getElementById('pickupLatitude').value = '';
            document.getElementById('pickupLongitude').value = '';
            document.getElementById('dropoffLatitude').value = '';
            document.getElementById('dropoffLongitude').value = '';
            document.getElementById('pickupLocation').value = '';
            document.getElementById('dropoffLocation').value = '';
            document.getElementById('pickupDisplay').textContent = 'Click on map to set pickup';
            document.getElementById('dropoffDisplay').textContent = 'Click again to set drop-off';
            document.getElementById('distanceDisplay').textContent = '-';
            document.getElementById('durationDisplay').textContent = '-';
            document.getElementById('fareDisplay').textContent = '₱0.00';
            document.getElementById('fare').value = '';

            map.setView(surigaoCity, 13);
        });

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            if (!pickupMarker || !dropoffMarker) {
                e.preventDefault();
                alert('Please set both pickup and drop-off locations on the map before booking.');
                return false;
            }
            
            const pickupLocation = document.getElementById('pickupLocation').value;
            const dropoffLocation = document.getElementById('dropoffLocation').value;
            
            if (!pickupLocation || !dropoffLocation) {
                e.preventDefault();
                alert('Please fill in both pickup and drop-off barangay names.');
                return false;
            }
            return true;
        });


        
