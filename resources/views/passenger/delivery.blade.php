<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FastLan - Delivery Service</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
    @vite('resources/css/passenger/passdashboard.css')
</head>
<body>
                                                            <!-- Navbar -->
    <nav class="navbar">
        <a href="/digilink/public" class="nav-brand">Fast<span>Lan</span></a>
        <div class="nav-links">
            <a href="{{ route('passenger.dashboard') }}" class="nav-link">Ride Service</a>
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

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

                                                            <!-- Booking Navigation -->
    <div class="booking-nav">
        <a href="{{ route('passenger.dashboard') }}" class="btn-link">
            <i class="fas fa-motorcycle"></i> Booking to Go
        </a>
        <a href="#" class="btn-link active">
            <i class="fas fa-box"></i> For Delivery
       </a>
        <a href="{{ route('passenger.pending.bookings') }}" class="btn-link">
            <i class="fas fa-hourglass-half"></i> See Pending
        </a>
    </div>

                                                            <!-- Main Container -->
    <div class="main-container">
                                                            <!-- Left Panel: Available Drivers -->
        <div class="left-panel">
            <h2>Available Delivery Drivers</h2>
                                                            <!-- Barangay Filter -->
            <div class="form-group">
                <label for="barangay" class="form-label">Select Barangay:</label>
                <select id="barangay" class="form-control">
                    <option value="all" {{ $barangay == 'all' ? 'selected' : '' }}>All Barangays</option>
                    <option value="Anomar" {{ $barangay == 'Anomar' ? 'selected' : '' }}>Anomar</option>
                    <option value="Balibayon" {{ $barangay == 'Balibayon' ? 'selected' : '' }}>Balibayon</option>
                    <option value="Bonifacio" {{ $barangay == 'Bonifacio' ? 'selected' : '' }}>Bonifacio</option>
                    <option value="Cabongbongan" {{ $barangay == 'Cabongbongan' ? 'selected' : '' }}>Cabongbongan</option>
                    <option value="Cagniog" {{ $barangay == 'Cagniog' ? 'selected' : '' }}>Cagniog</option>
                    <option value="Canlanipa" {{ $barangay == 'Canlanipa' ? 'selected' : '' }}>Canlanipa</option>
                    <option value="Capalayan" {{ $barangay == 'Capalayan' ? 'selected' : '' }}>Capalayan</option>
                    <option value="Danao" {{ $barangay == 'Danao' ? 'selected' : '' }}>Danao</option>
                    <option value="Day-asan" {{ $barangay == 'Day-asan' ? 'selected' : '' }}>Day-asan</option>
                    <option value="Ipil" {{ $barangay == 'Ipil' ? 'selected' : '' }}>Ipil</option>
                    <option value="Lipata" {{ $barangay == 'Lipata' ? 'selected' : '' }}>Lipata</option>
                    <option value="Luna" {{ $barangay == 'Luna' ? 'selected' : '' }}>Luna</option>
                    <option value="Mabini" {{ $barangay == 'Mabini' ? 'selected' : '' }}>Mabini</option>
                    <option value="Mabua" {{ $barangay == 'Mabua' ? 'selected' : '' }}>Mabua</option>
                    <option value="Mapawa" {{ $barangay == 'Mapawa' ? 'selected' : '' }}>Mapawa</option>
                    <option value="Mat-i" {{ $barangay == 'Mat-i' ? 'selected' : '' }}>Mat-i</option>
                    <option value="Nabago" {{ $barangay == 'Nabago' ? 'selected' : '' }}>Nabago</option>
                    <option value="Orok" {{ $barangay == 'Orok' ? 'selected' : '' }}>Orok</option>
                    <option value="Poctoy" {{ $barangay == 'Poctoy' ? 'selected' : '' }}>Poctoy</option>
                    <option value="Quezon" {{ $barangay == 'Quezon' ? 'selected' : '' }}>Quezon</option>
                    <option value="Rizal" {{ $barangay == 'Rizal' ? 'selected' : '' }}>Rizal</option>
                    <option value="Sabang" {{ $barangay == 'Sabang' ? 'selected' : '' }}>Sabang</option>
                    <option value="San Isidro" {{ $barangay == 'San Isidro' ? 'selected' : '' }}>San Isidro</option>
                    <option value="San Juan" {{ $barangay == 'San Juan' ? 'selected' : '' }}>San Juan</option>
                    <option value="San Roque" {{ $barangay == 'San Roque' ? 'selected' : '' }}>San Roque</option>
                    <option value="Serna" {{ $barangay == 'Serna' ? 'selected' : '' }}>Serna</option>
                    <option value="Silop" {{ $barangay == 'Silop' ? 'selected' : '' }}>Silop</option>
                    <option value="Sukailang" {{ $barangay == 'Sukailang' ? 'selected' : '' }}>Sukailang</option>
                    <option value="Taft" {{ $barangay == 'Taft' ? 'selected' : '' }}>Taft</option>
                    <option value="Togbongon" {{ $barangay == 'Togbongon' ? 'selected' : '' }}>Togbongon</option>
                    <option value="Trinidad" {{ $barangay == 'Trinidad' ? 'selected' : '' }}>Trinidad</option>
                    <option value="Washington" {{ $barangay == 'Washington' ? 'selected' : '' }}>Washington</option>
                </select>
            </div>
            <div>
                <button id="searchDriversBtn" class="btn btn-primary" style="margin-bottom: 16px;">
                    <i class="fas fa-search"></i> Search Delivery Drivers
                </button>
            </div>
                                                            <!-- Driver List -->
            <div id="driverList">
                @forelse($availableDrivers as $driver)
                    @if($driver->serviceType === 'Delivery')
                    <div class="driver-card">
                        <strong>{{ $driver->fullname }}</strong><br>
                        <i class="fas fa-motorcycle text-success"></i> {{ $driver->vehicleMake }} - {{ $driver->vehicleModel }}<br>
                        Plate: {{ $driver->plateNumber }}<br>
                        Completed Bookings: {{ $driver->completedBooking }}<br>
                        Status: <span class="{{ $driver->availStatus ? 'status-available' : 'status-unavailable' }}">
                            {{ $driver->availStatus ? 'Available' : 'Unavailable' }}
                        </span><br>
                        Service Type: {{ $driver->serviceType }}<br>
                        <small class="text-muted">Location: {{ $driver->currentLocation }}</small>
                    </div>
                    @endif
                @empty
                    <div class="driver-card">
                        <p>No available delivery drivers at the moment.</p>
                        <small class="text-muted">Please check back later or try a different barangay.</small>
                    </div>
                @endforelse
            </div>
        </div>

                                                            <!-- Right Panel: Map and Delivery Booking -->
        <div class="right-panel">
            <div class="map-title">Set Pickup and Delivery Location in Surigao City</div>
            <div id="map-container">
                                                            <!-- Loading overlay -->
                <div id="map-loading">
                    <div class="spinner"></div>
                    <p>Loading map, please wait...</p>
                </div>
                                                            <!-- Map -->
                <div id="map"></div>
            </div>
            <div style="margin-bottom: 1rem;">
                <button type="button" id="resetMapBtn" class="btn btn-danger">
                    <i class="fas fa-redo"></i> Reset Map
                </button>
            </div>
            
                                                            <!-- Location Info -->
            <div class="map-info">
                <p><strong>Pickup:</strong> <span id="pickupDisplay">Click on map to set pickup</span></p>
                <p><strong>Delivery:</strong> <span id="dropoffDisplay">Click again to set delivery location</span></p>
                <p><strong>Estimated Distance:</strong> <span id="distanceDisplay">-</span></p>
                <p><strong>Estimated Duration:</strong> <span id="durationDisplay">-</span></p>
            </div>
            
                                                            <!-- Additional Notes -->
            <div class="notes-section">
                <h4><i class="fas fa-info-circle"></i> Delivery Instructions</h4>
                <p>1. Click on the map to set your pickup location</p>
                <p>2. Click again to set your delivery location</p>
                <p>3. Fill in the barangay names for both locations</p>
                <p>4. Describe the item you want to deliver</p>
                <p>5. Click "Book Delivery" to confirm your delivery</p>
            </div>
            
                                                            <!-- Delivery Booking Form -->
            <form action="{{ route('passenger.book.ride') }}" method="POST" class="booking-form" id="bookingForm">
                @csrf
                <!-- Hidden fields -->
                <input type="hidden" name="pickupLatitude" id="pickupLatitude">
                <input type="hidden" name="pickupLongitude" id="pickupLongitude">
                <input type="hidden" name="dropoffLatitude" id="dropoffLatitude">
                <input type="hidden" name="dropoffLongitude" id="dropoffLongitude">
                <input type="hidden" name="fare" id="fare">
                <input type="hidden" name="serviceType" id="serviceType" value="for_delivery">

                <div class="form-group">
                    <label for="pickupLocation" class="form-label"><strong>Pickup Barangay:</strong></label>
                    <input type="text" name="pickupLocation" id="pickupLocation" class="form-control" placeholder="Type pickup barangay example:(Ipil, near the park and the church)" required>
                </div>

                <div class="form-group">
                    <label for="dropoffLocation" class="form-label"><strong>Delivery Barangay:</strong></label>
                    <input type="text" name="dropoffLocation" id="dropoffLocation" class="form-control" placeholder="Type delivery barangay example:(Surigao, Jolibee near the luneta)" required>
                </div>

                <div class="form-group">
                    <label for="description" class="form-label"><strong>Item Description: </strong></label>
                    <textarea name="description" id="description" class="form-control" placeholder="Describe the item you want to deliver (size, weight, fragile items, etc.)..." rows="3" required></textarea>
                </div>

                <div class="form-group">
                    <label for="paymentMethod" class="form-label"><strong>Payment Method:</strong></label>
                    <select name="paymentMethod" id="paymentMethod" class="form-control" required>
                        <option value="cash">Cash</option>
                        <option value="gcash">GCash</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="scheduleTime"><strong>Scheduled Time:</strong></label>
                    <input type="datetime-local" name="scheduleTime" id="scheduleTime" class="form-control">
                </div>

                <hr>

                <div class="mb-3">
                    <p class="h5"><strong>Estimated Delivery Fee (₱ with service fee):</strong> <span id="fareDisplay" class="text-danger">₱0.00</span></p>
                </div>

                <button type="submit" class="btn btn-success w-100">
                    <i class="fas fa-box"></i> Book Delivery
                </button>
            </form>
        </div>
    </div>
<script>
                                                            // Search Delivery Drivers Function
    document.addEventListener('DOMContentLoaded', function() {
        const barangaySelect = document.getElementById('barangay');
        const driverList = document.getElementById('driverList');
        const searchDriversBtn = document.getElementById('searchDriversBtn');
                                                            // Function to search/filter delivery drivers
        function searchDrivers() {
            const selectedBarangay = barangaySelect.value;          
                                                             // Show loading state
            driverList.innerHTML = '<div class="driver-card"><p>Searching for delivery drivers...</p></div>';
                                                            // Make AJAX request to delivery endpoint
            fetch(`{{ route('passenger.available.delivery.drivers') }}?barangay=${selectedBarangay}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        updateDriverList(data.drivers, selectedBarangay);
                    } else {
                        driverList.innerHTML = `
                            <div class="driver-card">
                                <p>Error: ${data.message}</p>
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    driverList.innerHTML = `
                        <div class="driver-card">
                            <p>Error loading delivery drivers</p>
                            <small class="text-muted">Please check your connection and try again</small>
                        </div>
                    `;
                });
        }
                                                            // Function to update the driver list display
        function updateDriverList(drivers, barangay) {
            if (drivers.length === 0) {
                const locationText = barangay === 'all' ? 'in any barangay' : `in ${barangay}`;
                driverList.innerHTML = `
                    <div class="driver-card">
                        <p>No available delivery drivers ${locationText} at the moment.</p>
                        <small class="text-muted">Please check back later or try a different barangay.</small>
                    </div>
                `;
                return;
            }
            driverList.innerHTML = drivers.map(driver => {
                const locationText = driver.currentLocation === 'all' 
                    ? '<span class="text-success">Available for All Locations</span>' 
                    : driver.currentLocation;
                    
                return `
                    <div class="driver-card">
                        <strong>${driver.fullname}</strong><br>
                        <i class="fas fa-motorcycle text-success"></i> ${driver.vehicleMake} - ${driver.vehicleModel}<br>
                        Plate: ${driver.plateNumber}<br>
                        Completed Bookings: ${driver.completedBooking}<br>
                        Status: <span class="status-available">Available</span><br>
                        Service Type: ${driver.serviceType}<br>
                        <small class="text-muted">Location: ${locationText}</small>
                    </div>
                `;
            }).join('');
        }

                                                            // Event listener for search drivers button
        searchDriversBtn.addEventListener('click', searchDrivers);

                                                            // Event listener for delivery booking form submission
        document.getElementById('bookingForm').addEventListener('submit', function(e) {
                                                            // Validate that both pickup and delivery locations are set
            const pickupLat = document.getElementById('pickupLatitude').value;
            const dropoffLat = document.getElementById('dropoffLatitude').value;
            
            if (!pickupLat || !dropoffLat) {
                e.preventDefault();
                alert('Please set both pickup and delivery locations on the map before booking.');
                return false;
            }
            
                                                            // Validate that barangay names are filled
            const pickupLocation = document.getElementById('pickupLocation').value;
            const dropoffLocation = document.getElementById('dropoffLocation').value;
            
            if (!pickupLocation || !dropoffLocation) {
                e.preventDefault();
                alert('Please fill in both pickup and delivery barangay names.');
                return false;
            }
            
                                                            // Validate item description
            const description = document.getElementById('description').value;
            if (!description) {
                e.preventDefault();
                alert('Please describe the item you want to deliver.');
                return false;
            }
            
            return true;
        });

                                                            // Initial load - show drivers based on current barangay selection
        searchDrivers();
    });

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
        const BASE_FARE = 13;
        const BASE_DISTANCE_KM = 2.0;
        const PER_KM_CHARGE = 1;
        const SERVICE_CHARGE = 10;

        let totalFare = BASE_FARE;

        if (distanceKm > BASE_DISTANCE_KM) {
            const extraDistance = distanceKm - BASE_DISTANCE_KM;
            totalFare += Math.ceil(extraDistance) * PER_KM_CHARGE;
        }

        totalFare += SERVICE_CHARGE;
        return Math.max(totalFare, BASE_FARE + SERVICE_CHARGE);
    }

    function showRoute(start, end) {
        if (routeControl) {
            map.removeControl(routeControl);
        }
        
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

        routeControl.on('routesfound', function(e) {
            const route = e.routes[0];
            const distanceKm = route.summary.totalDistance / 1000;
            const totalSeconds = route.summary.totalTime;
            const durationMin = Math.round(totalSeconds / 60);

            let durationDisplay;
            if (durationMin >= 60) {
                const hours = Math.floor(durationMin / 60);
                const minutes = durationMin % 60;
                durationDisplay = `${hours} hr${hours > 1 ? 's' : ''} ${minutes} min`;
            } else {
                durationDisplay = `${durationMin} min`;
            }

            document.getElementById('distanceDisplay').textContent = distanceKm.toFixed(1) + ' km';
            document.getElementById('durationDisplay').textContent = durationDisplay;

            const fare = calculateFare(distanceKm);
            document.getElementById('fareDisplay').textContent = "₱" + fare.toFixed(2);
            document.getElementById('fare').value = fare.toFixed(2);

            currentRoute = route;
        });
    }

                                                            // Click to set pickup and delivery locations
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
                                                                                    dropoffMarker = L.marker(e.latlng, { 
                draggable: true,
                icon: L.divIcon({
                    className: 'dropoff-marker',
                    html: '<div style="background: #dc3545; width: 20px; height: 20px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.3);"></div>',
                    iconSize: [20, 20]
                })
            }).addTo(map).bindPopup('Delivery Location');

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
        document.getElementById('dropoffDisplay').textContent = 'Click again to set delivery location';
        document.getElementById('distanceDisplay').textContent = '-';
        document.getElementById('durationDisplay').textContent = '-';
        document.getElementById('fareDisplay').textContent = '₱0.00';
        document.getElementById('fare').value = '';
        map.setView(surigaoCity, 13);
    });
            document.getElementById('userProfileDropdown').addEventListener('click', function(e) {
            e.stopPropagation();
            document.getElementById('dropdownMenu').classList.toggle('show');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.user-profile-dropdown')) {
                document.getElementById('dropdownMenu').classList.remove('show');
            }
        });

        // Simulate map loading
        setTimeout(function() {
            document.getElementById('map-loading').style.display = 'none';
        }, 2000);
</script>
</body>
</html>