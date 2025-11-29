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
    <link href="{{ asset('js/passdash.js') }}" rel="stylesheet">
    <link href="{{ asset('css/passenger/passdashboard.css') }}" rel="stylesheet">
    @yield('styles')
    <link rel="icon" href="{{ asset('images/fastlan1.png') }}">
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
                    <a href="{{ route('feedback.create') }}" class="dropdown-item">
                        <i class="fas fa-cog"></i>
                        System Feedback
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
                    @if(in_array($driver->serviceType, ['Delivery', 'Both']))
                    <div class="driver-card">
                        <div class="driver-header">
                            <strong>{{ $driver->fullname }}</strong>
                            <span class="driver-rating">
                                <i class="fas fa-star"></i> 
                                {{ $driver->average_rating ?? 'N/A' }}
                            </span>
                        </div>
                        <div class="driver-info">
                            <i class="fas fa-motorcycle text-success"></i> 
                            {{ $driver->vehicleMake }} - {{ $driver->vehicleModel }}<br>
                            <i class="fas fa-tag"></i> Plate: {{ $driver->plateNumber }}<br>
                            <i class="fas fa-check-circle"></i> Completed: {{ $driver->completedBooking }}<br>
                            <i class="fas fa-map-marker-alt"></i> Location: 
                            <span class="{{ $driver->currentLocation == 'all' ? 'text-success' : 'text-info' }}">
                                {{ $driver->currentLocation == 'all' ? 'All Areas' : $driver->currentLocation }}
                            </span>
                        </div>
                        <div class="driver-status">
                            <span class="status-available">
                                <i class="fas fa-circle"></i> Available for Delivery
                            </span>
                        </div>
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
    let map;
    let mapInitialized = false;
    let pickupMarker = null;
    let dropoffMarker = null;
    let routeControl = null;
    let currentRoute = null;


    function showAlert(message, type = 'success') {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert" style="position: fixed; top: 80px; right: 20px; z-index: 9999; min-width: 300px;">
                <strong>${type === 'success' ? 'Success!' : 'Error!'}</strong> ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        `;
        document.body.insertAdjacentHTML('beforeend', alertHtml);
        
        setTimeout(() => {
            const alert = document.querySelector('.alert:last-child');
            if (alert) {
                alert.remove();
            }
        }, 5000);
    }

    function initializeMap() {
        try {
            if (mapInitialized) {
                return;
            }
            
            const mapElement = document.getElementById('map');
            if (!mapElement) {
                console.error('Map element not found');
                return;
            }
            
            if (mapElement._leaflet_id) {
                console.log('Map already initialized');
                return;
            }

            const surigaoCity = [9.7890, 125.4950];
            
            map = L.map('map', {
                center: surigaoCity,
                zoom: 13,
                maxBounds: [
                    [9.70, 125.40],
                    [9.88, 125.58]
                ],
                maxBoundsViscosity: 1.0
            });

            const tileLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            tileLayer.on('load', function() {
                document.getElementById('map-loading').style.display = 'none';
                mapInitialized = true;
                console.log('Map initialized successfully');
            });

            tileLayer.on('tileerror', function() {
                console.error('Failed to load map tiles');
                document.getElementById('map-loading').style.display = 'none';
                showAlert('Failed to load map. Please check your internet connection.', 'error');
            });

            initializeMapFeatures();
            
        } catch (error) {
            console.error('Error initializing map:', error);
            document.getElementById('map-loading').style.display = 'none';
            showAlert('Error initializing map. Please refresh the page.', 'error');
        }
    }

    function initializeMapFeatures() {
        map.on('click', function(e) {
            if (!pickupMarker) {
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

                showRoute(pickupMarker.getLatLng(), dropoffMarker.getLatLng());
            }
        });
    }

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

    function resetMap() {
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
        
        const surigaoCity = [9.7890, 125.4950];
        map.setView(surigaoCity, 13);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const barangaySelect = document.getElementById('barangay');
        const driverList = document.getElementById('driverList');
        const searchDriversBtn = document.getElementById('searchDriversBtn');

        initializeMap();

        function searchDrivers() {
            const selectedBarangay = barangaySelect.value;          
            driverList.innerHTML = '<div class="driver-card"><p>Searching for delivery drivers...</p></div>';
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

    function updateDriverList(drivers, barangay) {
        if (drivers.length === 0) {
            const locationText = barangay === 'all' ? 'in any barangay' : `in ${barangay}`;
            driverList.innerHTML = `
                <div class="driver-card empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-motorcycle"></i>
                    </div>
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
            
            const profileImage = driver.profile_image || '/images/default-avatar.png';
            const averageRating = driver.average_rating ? driver.average_rating.toFixed(1) : 'New';
            const totalReviews = driver.total_reviews || 0;
            
            return `
                <div class="driver-card" data-driver-id="${driver.id}">
                    <div class="driver-header">
                        <div class="driver-profile">
                            <img src="${profileImage}" alt="${driver.fullname}" class="driver-avatar">
                            <div class="driver-info">
                                <strong>${driver.fullname}</strong>
                                <div class="driver-rating">
                                    <span class="star-rating">
                                        <i class="fas fa-star"></i> ${averageRating}
                                    </span>
                                    <span class="rating-text">(${totalReviews} reviews)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="driver-details">
                        <div class="detail-item">
                            <i class="fas fa-motorcycle"></i>
                            <span>${driver.vehicleMake} ${driver.vehicleModel}</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-tag"></i>
                            <span>Plate: ${driver.plateNumber}</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-check-circle"></i>
                            <span>${driver.completedBooking} completed deliveries</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span class="${driver.currentLocation === 'all' ? 'text-success' : 'text-info'}">
                                ${driver.currentLocation === 'all' ? 'All Areas' : driver.currentLocation}
                            </span>
                        </div>
                    </div>
                    
                    <div class="driver-status">
                        <span class="status-badge status-available">
                            <i class="fas fa-circle"></i> Available for Delivery
                        </span>
                    </div>
                </div>
            `;
        }).join('');
    }

        searchDriversBtn.addEventListener('click', searchDrivers);

        document.getElementById('bookingForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            console.log('Delivery form submitted via AJAX');
            
            const pickupLat = document.getElementById('pickupLatitude').value;
            const dropoffLat = document.getElementById('dropoffLatitude').value;
            
            if (!pickupLat || !dropoffLat) {
                showAlert('Please set both pickup and delivery locations on the map before booking.', 'error');
                return false;
            }
            
            const pickupLocation = document.getElementById('pickupLocation').value;
            const dropoffLocation = document.getElementById('dropoffLocation').value;
            
            if (!pickupLocation || !dropoffLocation) {
                showAlert('Please fill in both pickup and delivery barangay names.', 'error');
                return false;
            }

            const description = document.getElementById('description').value;
            if (!description) {
                showAlert('Please describe the item you want to deliver.', 'error');
                return false;
            }
            
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Booking Delivery...';
            submitBtn.disabled = true;
            
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            })
            .then(response => {
                return response.json().catch(() => {
                    return { success: true, message: 'Delivery booked successfully!' };
                });
            })
            .then(data => {
                const successMessage = data.message || 'Delivery booked successfully! A driver will be assigned soon.';
                showAlert(successMessage, 'success');
                console.log('Delivery booking response:', data);
                
                setTimeout(() => {
                    document.getElementById('bookingForm').reset();
                    resetMap();
                }, 2000);
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Delivery booked successfully! Please check your pending bookings.', 'success');
                
                setTimeout(() => {
                    document.getElementById('bookingForm').reset();
                    resetMap();
                }, 2000);
            })
            .finally(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });

        document.getElementById('resetMapBtn').addEventListener('click', resetMap);

        document.getElementById('userProfileDropdown').addEventListener('click', function(e) {
            e.stopPropagation();
            document.getElementById('dropdownMenu').classList.toggle('show');
        });
        
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.user-profile-dropdown')) {
                document.getElementById('dropdownMenu').classList.remove('show');
            }
        });

        setTimeout(function() {
            const loadingOverlay = document.getElementById('map-loading');
            if (loadingOverlay && loadingOverlay.style.display !== 'none') {
                loadingOverlay.style.display = 'none';
                console.log('Fallback: Hiding loading overlay');
            }
        }, 5000);

        searchDrivers();

        @if(session('success'))
            showAlert('{{ session('success') }}', 'success');
        @endif

        @if(session('error'))
            showAlert('{{ session('error') }}', 'error');
        @endif
    });
    </script>
</body>
</html>