<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FastLan - Driver Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
    <link href="{{ asset('css/driver/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('js/driver/dashboard.js') }}" rel="stylesheet">
    @yield('styles')
    <link rel="icon" href="{{ asset('images/fastlan1.png') }}">
<body>
    <nav class="navbar">
        <a href="#" class="nav-brand">Fast<span>Lan</span></a>
        <div class="nav-links">
            <a href="{{ route('driver.dashboard') }}" class="nav-link">Driver Dashboard</a>
            <a href="{{ route('driver.edit') }}" class="nav-link">Edit Account</a>
            <div class="user-profile-dropdown">
            <div class="user-profile" id="userProfileDropdown">
                <div class="profile-container">
                    <img src="{{ Auth::guard('driver')->user()->getProfileImageUrl() }}" 
                         alt="Profile" class="profile-pic">
                    <div class="online-indicator {{ Auth::guard('driver')->user()->availStatus ? 'online' : 'offline' }}"></div>
                </div>
                <span>{{ Auth::guard('driver')->user()->fullname }}</span>
                <i class="fas fa-chevron-down" style="font-size: 0.8rem; color: #ffffff;"></i>
            </div>
                <div class="dropdown-content" id="dropdownMenu">
                    <a href="{{ route('driver.dashboard') }}" class="dropdown-item">
                        <i class="fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('driver.edit') }}" class="dropdown-item">
                        <i class="fas fa-user-edit"></i>
                        Edit Account
                    </a>
                    <a href="{{ route('driver.history') }}" class="dropdown-item">
                        <i class="fas fa-history"></i>
                        Booking History
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

    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1 class="dashboard-title">Driver Dashboard</h1>
            <div class="current-time" id="currentTime"></div>
        </div>
            <div class="status-card">
                <div class="driver-info">
                    <h3>{{ Auth::guard('driver')->user()->fullname }}</h3>
                    <p><i class="fas fa-car"></i> {{ Auth::guard('driver')->user()->vehicleMake }}
                        {{ Auth::guard('driver')->user()->vehicleModel }} ({{ Auth::guard('driver')->user()->plateNumber }})
                    </p>
                    <p><i class="fas fa-map-marker-alt"></i> {{ Auth::guard('driver')->user()->currentLocation }}</p>
                    <p><i class="fas fa-briefcase"></i> {{ Auth::guard('driver')->user()->serviceType }}</p>
                </div>

                <div class="driver-stats">
                    <div class="stat-item">
                        <div class="stat-value">{{ Auth::guard('driver')->user()->completedBooking }}</div>
                        <div class="stat-label">Completed Rides</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value" id="todayBookings">0</div>
                        <div class="stat-label">Today's Rides</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value" id="totalEarnings">₱0.00</div>
                        <div class="stat-label">Total Earnings</div>
                    </div>
                    <div class="stat-item">
                        <a href="{{ route('driver.rating') }}" class="dropdown-item">
                            <i class="fa-regular fa-star"></i>
                            See Your Ratings!
                        </a>
                    </div>
                </div>
                <div class="location-update">
                    <label for="driverLocation">Current Location:</label>
                    <select id="driverLocation" class="form-select">
                        <option value="">Select Location</option>
                        @foreach(App\Models\Driver::getAvailableLocations() as $key => $loc)
                            <option value="{{ $loc }}" {{ Auth::guard('driver')->user()->currentLocation === $loc ? 'selected' : '' }}>
                                {{ $loc }}
                            </option>
                        @endforeach
                    </select>
                    <button id="updateLocationBtn" class="btn btn-primary mt-2">Update Location</button>
                </div>
                <div class="availability-toggle">
                    <span class="toggle-label">Available for Bookings</span>
                    <label class="toggle-switch">
                        <input type="checkbox" id="availabilityToggle"
                            {{ Auth::guard('driver')->user()->availStatus ? 'checked' : '' }}>
                        <span class="toggle-slider"></span>
                    </label>
                </div>
            </div>
                                                    <!-- Dashboard Layout -->
    <div class="dashboard-layout">
                                                    <!-- Left Sidebar - Accepted Bookings -->
        <div class="accepted-bookings-sidebar">
            <div class="sidebar-header">
                <h3><i class="fas fa-clipboard-check"></i> Accepted Bookings</h3>
                <span class="badge" id="acceptedBookingsCount">0</span>
            </div>
            <div class="accepted-bookings-list" id="acceptedBookingsList">
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <h4 class="empty-title">No Accepted Bookings</h4>
                    <p class="empty-text">Accepted bookings will appear here</p>
                </div>
            </div>
        </div>
                                                    <!-- Right Side Content -->
        <div class="dashboard-main">
                                                    <!-- Driver Status Card -->
            <div class="bookings-section">
            <div class="section-header">
                <h2 class="section-title">Available Bookings</h2>
                <div class="bookings-count" id="bookingsCount">Loading...</div>
            </div>

            <div class="bookings-grid" id="bookingsGrid">
                <div class="empty-state" id="loadingState">
                    <div class="empty-icon">
                        <i class="fas fa-spinner fa-spin"></i>
                    </div>
                    <h3 class="empty-title">Loading Bookings</h3>
                    <p class="empty-text">Please wait while we fetch available bookings...</p>
                </div>
            </div>

            <div class="empty-state" id="emptyState" style="display: none;">
                <div class="empty-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <h3 class="empty-title">No Available Bookings</h3>
                <p class="empty-text">There are currently no bookings available. Please check back later.</p>
                <button class="btn btn-primary" onclick="loadAvailableBookings()">
                    <i class="fas fa-redo"></i>
                    Refresh
                </button>
            </div>
        </div>

    </div>
</div>

<script>
function fetchTodayStats() {
    fetch("{{ route('driver.getTodayStats') }}")
        .then(res => {
            if (!res.ok) throw new Error('Network response was not ok');
            return res.json();
        })
        .then(data => {
            if (data.success) {
                document.getElementById('todayBookings').textContent = data.today_rides;
                document.getElementById('totalEarnings').textContent = '₱' + data.today_earnings;
            }
        })
        .catch(err => console.error('Error fetching stats:', err));
}

fetchTodayStats();
setInterval(fetchTodayStats, 10000);

document.getElementById('updateLocationBtn').addEventListener('click', function() {
    const selectedLocation = document.getElementById('driverLocation').value;

    if (!selectedLocation) {
        alert('Please select a location.');
        return;
    }

    fetch("{{ route('driver.updateCurrentLocation') }}", {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            location: selectedLocation
        })
    })
    .then(res => {
        if (!res.ok) throw new Error('Network response was not ok');
        return res.json();
    })
    .then(data => {
        if (data.success) {
            alert('Current location updated to ' + selectedLocation);
            document.querySelector('.driver-info p i.fa-map-marker-alt')
                .parentElement.innerHTML = `<i class="fas fa-map-marker-alt"></i> ${selectedLocation}`;
        } else {
            alert('Failed to update location: ' + data.message);
        }
    })
    .catch(err => {
        console.error('Error updating location:', err);
        alert('Error updating location. Please try again.');
    });
});

document.getElementById('userProfileDropdown').addEventListener('click', function(e) {
    e.stopPropagation();
    document.getElementById('dropdownMenu').classList.toggle('show');
});

document.addEventListener('click', function(e) {
    if (!e.target.closest('.user-profile-dropdown')) {
        document.getElementById('dropdownMenu').classList.remove('show');
    }
});

function updateTime() {
    const now = new Date();
    const options = { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
    };
    document.getElementById('currentTime').textContent = now.toLocaleDateString('en-US', options);
}

setInterval(updateTime, 1000);
updateTime();

let acceptedBookings = JSON.parse(localStorage.getItem('acceptedBookings') || '[]');

document.getElementById('availabilityToggle').addEventListener('change', function() {
    const isAvailable = this.checked;
    
    const onlineIndicator = document.querySelector('.online-indicator');
    if (isAvailable) {
        onlineIndicator.style.background = '#28a745';
        loadAvailableBookings();
    } else {
        onlineIndicator.style.background = '#6c757d';
        document.getElementById('bookingsGrid').innerHTML = `
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-power-off"></i>
                </div>
                <h3 class="empty-title">Offline Mode</h3>
                <p class="empty-text">You are currently offline. Turn on availability to see bookings.</p>
            </div>
        `;
        document.getElementById('bookingsCount').textContent = '0 bookings';
        document.getElementById('emptyState').style.display = 'none';
    }
    
    updateDriverAvailability(isAvailable);
});

function updateDriverAvailability(isAvailable) {
    fetch("{{ route('driver.update.availability') }}", {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            availStatus: isAvailable
        })
    })
    .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json();
    })
    .then(data => {
        if (data.success) {
            console.log('Availability updated successfully');
        } else {
            throw new Error(data.message || 'Failed to update availability');
        }
    })
    .catch(error => {
        console.error('Error updating availability:', error);
        document.getElementById('availabilityToggle').checked = !isAvailable;
        showNotification('Failed to update availability: ' + error.message, 'error');
    });
}

function loadBookingStats() {
    fetch("{{ route('driver.booking.stats') }}")
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            if (data.success) {
                document.getElementById('todayBookings').textContent = data.today_bookings;
                document.getElementById('totalEarnings').textContent = data.total_earnings;
            }
        })
        .catch(error => {
            console.error('Error loading stats:', error);
        });
}

function loadAvailableBookings() {
    const grid = document.getElementById('bookingsGrid');
    const countElement = document.getElementById('bookingsCount');
    const emptyState = document.getElementById('emptyState');

    if (!document.getElementById('availabilityToggle').checked) {
        grid.innerHTML = `
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-power-off"></i>
                </div>
                <h3 class="empty-title">Offline Mode</h3>
                <p class="empty-text">You are currently offline. Turn on availability to see bookings.</p>
            </div>
        `;
        countElement.textContent = '0 bookings';
        emptyState.style.display = 'none';
        return;
    }

    grid.innerHTML = `
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-spinner fa-spin"></i>
            </div>
            <h3 class="empty-title">Loading Bookings</h3>
            <p class="empty-text">Please wait while we fetch available bookings...</p>
        </div>
    `;
    emptyState.style.display = 'none';

    console.log('Fetching available bookings...');
    
    fetch("{{ route('driver.getAvailableBookings') }}")
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) throw new Error('Network response was not ok: ' + response.status);
            return response.json();
        })
        .then(data => {
            console.log('Received data:', data);
            
            if (!data.success) throw new Error(data.message || 'Failed to load bookings');
            
            grid.innerHTML = '';
            countElement.textContent = `${data.count} booking${data.count !== 1 ? 's' : ''}`;

            if (data.count === 0) {
                emptyState.style.display = 'block';
                return;
            }

            data.bookings.forEach(booking => {
                console.log('Processing booking:', booking);
                const bookingCard = document.createElement('div');
                bookingCard.className = 'booking-card';
                bookingCard.innerHTML = `
                    <div class="booking-header">
                        <div class="passenger-info">
                            <h4>${booking.passenger_name}</h4>
                            <p><i class="fas fa-phone"></i> ${booking.passenger_phone}</p>
                        </div>
                        <div class="service-badge">
                            <i class="fas ${booking.service_type_raw === 'booking_to_go' ? 'fa-car' : 'fa-box'}"></i>
                            ${booking.service_type}
                        </div>
                    </div>
                    
                    <div class="booking-details">
                        <div class="location-row">
                            <div class="location-icon pickup-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="location-text">
                                <div class="location-label">Pickup Location</div>
                                <div class="location-address">${booking.pickup_location}</div>
                            </div>
                        </div>
                        <div class="location-row">
                            <div class="location-icon dropoff-icon">
                                <i class="fas fa-flag-checkered"></i>
                            </div>
                            <div class="location-text">
                                <div class="location-label">Drop-off Location</div>
                                <div class="location-address">${booking.dropoff_location}</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="booking-meta">
                        <div class="meta-item">
                            <div class="meta-label">Fare</div>
                            <div class="meta-value fare">${booking.fare}</div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Type</div>
                            <div class="meta-value">${booking.booking_type}</div>
                        </div>
                    </div>
                    
                    <div class="booking-actions">
                         <a href="{{ url('/driver/booking-details') }}/${booking.id}" class="btn btn-primary">
                            <i class="fas fa-eye"></i>
                            View Details
                        </a>
                    </div>
                `;
                grid.appendChild(bookingCard);
            });
        })
        .catch(error => {
            console.error('Error loading bookings:', error);
            grid.innerHTML = `
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h3 class="empty-title">Error Loading Bookings</h3>
                    <p class="empty-text">There was a problem loading the available bookings. Please try again.</p>
                    <button class="btn btn-primary" onclick="loadAvailableBookings()">
                        <i class="fas fa-redo"></i>
                        Try Again
                    </button>
                </div>
            `;
            countElement.textContent = 'Error';
        });
}

function loadAcceptedBookings() {
    fetch("{{ route('driver.getAcceptedBookings') }}")
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            const listElement = document.getElementById('acceptedBookingsList');
            const countElement = document.getElementById('acceptedBookingsCount');

            if (data.success && data.bookings) {
                acceptedBookings = data.bookings;
                localStorage.setItem('acceptedBookings', JSON.stringify(acceptedBookings));
            }
            
            countElement.textContent = data.count;

            if (data.count === 0) {
                listElement.innerHTML = `
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <h4 class="empty-title">No Accepted Bookings</h4>
                        <p class="empty-text">Accepted bookings will appear here</p>
                    </div>
                `;
                return;
            }

            listElement.innerHTML = '';
            data.bookings.forEach(booking => {
                const bookingItem = document.createElement('div');
                bookingItem.className = 'accepted-booking-item';
                bookingItem.innerHTML = `
                    <div class="accepted-booking-header">
                        <h4>${booking.passenger_name}</h4>
                        <span class="status-badge accepted">Accepted</span>
                    </div>
                    <div class="accepted-booking-details">
                        <p><i class="fas fa-map-marker-alt"></i> ${booking.pickup_location}</p>
                        <p><i class="fas fa-flag-checkered"></i> ${booking.dropoff_location}</p>
                        <p><i class="fas fa-calendar"></i> ${booking.schedule_time}</p>
                        <p><i class="fas fa-money-bill-wave"></i> ${booking.fare}</p>
                    </div>
                    <div class="accepted-booking-actions">
                        <button class="btn btn-success btn-sm start-job-btn" 
                                onclick="checkAndStartJob(${booking.id})"
                                data-booking-id="${booking.id}">
                            <i class="fas fa-play"></i>
                            Start Job
                        </button>
                        <button class="btn btn-danger btn-sm cancel-booking-btn" 
                                onclick="cancelAcceptedBooking(${booking.id})"
                                data-booking-id="${booking.id}">
                            <i class="fas fa-times"></i>
                            Cancel
                        </button>
                    </div>
                `;
                listElement.appendChild(bookingItem);
            });
        })
        .catch(error => {
            console.error('Error loading accepted bookings:', error);
            loadAcceptedBookingsFromStorage();
        });
}

function loadAcceptedBookingsFromStorage() {
    const listElement = document.getElementById('acceptedBookingsList');
    const countElement = document.getElementById('acceptedBookingsCount');
    
    countElement.textContent = acceptedBookings.length;

    if (acceptedBookings.length === 0) {
        listElement.innerHTML = `
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <h4 class="empty-title">No Accepted Bookings</h4>
                <p class="empty-text">Accepted bookings will appear here</p>
            </div>
        `;
        return;
    }

    listElement.innerHTML = '';
    acceptedBookings.forEach(booking => {
        const bookingItem = document.createElement('div');
        bookingItem.className = 'accepted-booking-item';
        bookingItem.innerHTML = `
            <div class="accepted-booking-header">
                <h4>${booking.passenger_name}</h4>
                <span class="status-badge accepted">Accepted</span>
            </div>
            <div class="accepted-booking-details">
                <p><i class="fas fa-map-marker-alt"></i> ${booking.pickup_location}</p>
                <p><i class="fas fa-flag-checkered"></i> ${booking.dropoff_location}</p>
                <p><i class="fas fa-calendar"></i> ${booking.schedule_time}</p>
                <p><i class="fas fa-money-bill-wave"></i> ${booking.fare}</p>
            </div>
            <div class="accepted-booking-actions">
                <button class="btn btn-success btn-sm start-job-btn" 
                        onclick="checkAndStartJob(${booking.id})"
                        data-booking-id="${booking.id}">
                    <i class="fas fa-play"></i>
                    Start Job
                </button>
                <button class="btn btn-danger btn-sm cancel-booking-btn" 
                        onclick="cancelAcceptedBooking(${booking.id})"
                        data-booking-id="${booking.id}">
                    <i class="fas fa-times"></i>
                    Cancel
                </button>
            </div>
        `;
        listElement.appendChild(bookingItem);
    });
}

function checkAndStartJob(bookingId) {
    // FIXED: Use proper URL format
    fetch(`{{ url('/driver/can-start-job') }}/${bookingId}`)
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            if (data.success && data.can_start) {
                startJob(bookingId);
            } else {
                showNotification(data.message || 'Cannot start this job yet.', 'error');
            }
        })
        .catch(error => {
            console.error('Error checking job:', error);
            showNotification('Error checking job status: ' + error.message, 'error');
        });
}

function startJob(bookingId) {
    if (!confirm('Are you ready to start this job? This will begin tracking your location.')) {
        return;
    }

    // FIXED: Use proper URL format
    fetch(`{{ url('/driver/start-job') }}/${bookingId}`, {
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
            acceptedBookings = acceptedBookings.filter(booking => booking.id !== bookingId);
            localStorage.setItem('acceptedBookings', JSON.stringify(acceptedBookings));
            
            // FIXED: Use proper URL format
            window.location.href = `{{ url('/driver/job-tracking') }}/${bookingId}`;
        } else {
            throw new Error(data.message || 'Failed to start job');
        }
    })
    .catch(error => {
        console.error('Error starting job:', error);
        showNotification('Failed to start job: ' + error.message, 'error');
    });
}

function cancelAcceptedBooking(bookingId) {
    if (!confirm('Are you sure you want to cancel this accepted booking? It will be returned to the available listings.')) {
        return;
    }

    // FIXED: Use proper URL format
    fetch(`{{ url('/driver/cancel-accepted-booking') }}/${bookingId}`, {
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
            acceptedBookings = acceptedBookings.filter(booking => booking.id !== bookingId);
            localStorage.setItem('acceptedBookings', JSON.stringify(acceptedBookings));
            
            showNotification('Booking cancelled successfully.', 'success');
            loadAcceptedBookings();
            loadAvailableBookings();
        } else {
            throw new Error(data.message || 'Failed to cancel booking');
        }
    })
    .catch(error => {
        console.error('Error cancelling booking:', error);
        showNotification('Failed to cancel booking: ' + error.message, 'error');
    });
}

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        background: ${type === 'error' ? '#dc3545' : type === 'success' ? '#28a745' : '#17a2b8'};
        color: white;
        border-radius: 5px;
        z-index: 10000;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    `;
    notification.textContent = message;
    document.body.appendChild(notification);

    setTimeout(() => {
        if (notification.parentNode) {
            notification.parentNode.removeChild(notification);
        }
    }, 5000);
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing...');

    loadBookingStats();
    
    loadAcceptedBookings();
    
    if (document.getElementById('availabilityToggle').checked) {
        console.log('Driver is available, loading bookings...');
        loadAvailableBookings();
    }

    setInterval(() => {
        if (document.getElementById('availabilityToggle').checked) {
            loadAvailableBookings();
        }
        loadAcceptedBookings();
    }, 30000);
});
</script>
</body>
</html>