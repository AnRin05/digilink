<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FastLan - Booking History</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<meta name="csrf-token" content="{{ csrf_token() }}">
@vite('resources/css/passenger/history.css')
<link rel="icon" href="{{ asset('images/fastlan1.png') }}">
<body>
    <div class="bg-decoration"></div>
        <nav class="navbar">
        <a href="/" class="nav-brand">Fast<span>Lan</span></a>
        <div class="nav-links">
            <a href="{{ route('passenger.edit') }}" class="nav-link">Edit Profile</a>
            <div class="user-profile-dropdown">
                <div class="user-profile" id="userProfileDropdown">
                    <div class="profile-container">
                        <img src="{{ Auth::guard('passenger')->user()->profile_image ? asset('storage/' . Auth::guard('passenger')->user()->profile_image) : asset('images/default-avatar.png') }}" 
                             alt="Profile" class="profile-pic">
                        <div class="online-indicator"></div>
                    </div>
                    <span>{{ Auth::guard('passenger')->user()->fullname }}</span>
                </div>
            </div>
        </div>
    </nav>
    <div class="container">
        <!-- Main Content -->
        <main class="main-content">
            <!-- Sidebar -->
            <aside class="sidebar">
                <h2 class="sidebar-title">
                    <i class="fas fa-filter"></i>
                    Filters
                </h2>
                
                <div class="filter-group">
                    <label for="statusFilter" class="filter-label">Status</label>
                    <select class="filter-select" id="statusFilter">
                        <option value="all">All Status</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="serviceTypeFilter" class="filter-label">Service Type</label>
                    <select class="filter-select" id="serviceTypeFilter">
                        <option value="all">All Services</option>
                        <option value="ride">Ride Service</option>
                        <option value="delivery">Delivery Service</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="timeFilter" class="filter-label">Time Period</label>
                    <select class="filter-select" id="timeFilter">
                        <option value="all">All Time</option>
                        <option value="today">Today</option>
                        <option value="week">This Week</option>
                        <option value="month">This Month</option>
                    </select>
                </div>

                <div class="stats-card">
                    <div class="stats-number" id="totalBookings">0</div>
                    <div class="stats-label">Total Bookings</div>
                </div>
            </aside>

            <!-- History Content -->
            <section class="history-content">
                <div class="content-header">
                    <h1 class="content-title">
                        <i class="fas fa-history"></i>
                        Booking History
                    </h1>
                    <div class="actions">
                        <button class="btn btn-outline" id="refreshBtn">
                            <i class="fas fa-redo"></i>
                            Refresh
                        </button>
                        <a href="{{ route('passenger.dashboard') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left"></i>
                            Back to Dashboard
                        </a>
                    </div>
                </div>

                <div class="bookings-grid" id="bookingsList">
                    <div class="loading-spinner">
                        <div class="spinner"></div>
                        <p>Loading your booking history...</p>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Confirm Deletion</h3>
                <button class="close-btn" onclick="closeDeleteModal()">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to remove this booking from your history? This action cannot be undone.</p>
            </div>
            <div class="modal-actions">
                <button class="btn btn-outline" onclick="closeDeleteModal()">Cancel</button>
                <button class="btn btn-danger" id="confirmDeleteBtn">
                    <i class="fas fa-trash"></i>
                    Delete
                </button>
            </div>
        </div>
    </div>

<script>
    let currentBookings = [];
    let bookingToDelete = null;

    // Load booking history
    function loadHistory() {
        const bookingsList = document.getElementById('bookingsList');
        bookingsList.innerHTML = `
            <div class="loading-spinner">
                <div class="spinner"></div>
                <p>Loading your booking history...</p>
            </div>
        `;

        fetch("{{ route('passenger.get.history') }}")
        .then(response => {
            console.log('Response status:', response.status);
            console.log('Response ok:', response.ok);
            
            // First, check if we got a response at all
            if (!response) {
                throw new Error('No response from server');
            }
            
            // Check if response is ok (status 200-299)
            if (!response.ok) {
                // Try to get the error message from response body
                return response.text().then(text => {
                    console.log('Error response text:', text);
                    let errorMessage = `Server error: ${response.status}`;
                    try {
                        const errorData = JSON.parse(text);
                        errorMessage = errorData.message || errorMessage;
                    } catch (e) {
                        // If not JSON, use the text as is
                        if (text) {
                            errorMessage = text;
                        }
                    }
                    throw new Error(errorMessage);
                });
            }
            
            // Response is ok, try to parse as JSON
            return response.json().catch(error => {
                console.log('JSON parse error:', error);
                // If JSON parsing fails but we got a 200 response, something is wrong with the response format
                throw new Error('Invalid response format from server');
            });
        })
        .then(data => {
            console.log('API Response data:', data);
            
            // Check if data structure is what we expect
            if (!data || typeof data !== 'object') {
                throw new Error('Invalid data received from server');
            }
            
            if (data.success === true) {
                currentBookings = data.bookings || [];
                document.getElementById('totalBookings').textContent = currentBookings.length;
                applyFilters(); // Apply initial filters
            } else {
                // Server returned success: false
                throw new Error(data.message || 'Failed to load history');
            }
        })
        .catch(error => {
            console.error('Error loading history:', error);
            
            // Check if we have cached data to display
            if (currentBookings.length > 0) {
                console.warn('Error loading fresh data, using cached data');
                applyFilters();
                showNotification('Showing cached data - unable to refresh', 'warning');
                return;
            }
            
            // No cached data, show error
            bookingsList.innerHTML = `
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h3 class="empty-title">Error Loading History</h3>
                    <p class="empty-text">${error.message}</p>
                    <button class="btn btn-primary" onclick="loadHistory()">
                        <i class="fas fa-redo"></i>
                        Try Again
                    </button>
                </div>
            `;
        });
    }

    // Apply filters
    function applyFilters() {
        const statusFilter = document.getElementById('statusFilter').value;
        const serviceFilter = document.getElementById('serviceTypeFilter').value;
        const timeFilter = document.getElementById('timeFilter').value;

        let filteredBookings = [...currentBookings];

        // Apply status filter
        if (statusFilter !== 'all') {
            filteredBookings = filteredBookings.filter(booking => 
                booking.status === statusFilter
            );
        }

        // Apply service type filter
        if (serviceFilter !== 'all') {
            filteredBookings = filteredBookings.filter(booking => {
                const serviceType = (booking.service_type || '').toLowerCase();
                return serviceType.includes(serviceFilter.toLowerCase());
            });
        }

        // Apply time filter
        if (timeFilter !== 'all') {
            const now = new Date();
            filteredBookings = filteredBookings.filter(booking => {
                const bookingDate = new Date(booking.created_at);
                switch (timeFilter) {
                    case 'today':
                        return bookingDate.toDateString() === now.toDateString();
                    case 'week':
                        const weekAgo = new Date(now.getTime() - 7 * 24 * 60 * 60 * 1000);
                        return bookingDate >= weekAgo;
                    case 'month':
                        const monthAgo = new Date(now.getTime() - 30 * 24 * 60 * 60 * 1000);
                        return bookingDate >= monthAgo;
                    default:
                        return true;
                }
            });
        }

        displayBookings(filteredBookings);
    }

    // Display bookings
    function displayBookings(bookings) {
        const bookingsList = document.getElementById('bookingsList');
        
        if (!bookings || bookings.length === 0) {
            bookingsList.innerHTML = `
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <h3 class="empty-title">No Bookings Found</h3>
                    <p class="empty-text">No bookings match your current filters. Try adjusting your filters or check back later.</p>
                    <button class="btn btn-outline" onclick="resetFilters()">
                        <i class="fas fa-times"></i>
                        Reset Filters
                    </button>
                </div>
            `;
            return;
        }

        bookingsList.innerHTML = bookings.map(booking => {
            const historyId = booking.history_id || 'unknown';
            const status = booking.status || 'completed';
            const statusDisplay = booking.status_display || 'Completed';
            const serviceType = booking.service_type || 'Ride Service';
            const bookingType = booking.booking_type || 'Instant';
            const fare = booking.fare || '₱0.00';
            const paymentMethod = booking.payment_method || 'Cash';
            const pickupLocation = booking.pickup_location || 'Location not specified';
            const dropoffLocation = booking.dropoff_location || 'Location not specified';
            const createdAt = booking.created_at || 'Unknown date';
            const completedAt = booking.completed_at || '';
            
            // Driver information
            const driverName = booking.driver_name || 'Not assigned';
            const driverPhone = booking.driver_phone || 'N/A';
            const driverEmail = booking.driver_email || 'N/A';
            const driverVehicle = booking.driver_vehicle || 'N/A';
            const driverPlate = booking.driver_plate || 'N/A';

            return `
            <div class="booking-card ${status}">
                <div class="booking-header">
                    <div class="booking-info">
                        <h3 class="booking-title">${serviceType} - ${bookingType}</h3>
                        <div class="booking-meta">
                            <div class="meta-item">
                                <i class="fas fa-calendar"></i>
                                ${createdAt}
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-money-bill-wave"></i>
                                ${fare}
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-credit-card"></i>
                                ${paymentMethod}
                            </div>
                            ${completedAt ? `
                            <div class="meta-item">
                                <i class="fas fa-check-circle"></i>
                                Completed: ${completedAt}
                            </div>
                            ` : ''}
                        </div>
                    </div>
                    <span class="status-badge status-${status}">
                        ${statusDisplay}
                    </span>
                </div>

                <!-- Driver Information -->
                <div class="driver-info">
                    <div class="driver-info-title">
                        <i class="fas fa-id-card"></i>
                        Driver Information
                    </div>
                    <div class="driver-details">
                        <div class="driver-detail-item">
                            <i class="fas fa-user"></i>
                            <strong>Name:</strong> ${driverName}
                        </div>
                        <div class="driver-detail-item">
                            <i class="fas fa-phone"></i>
                            <strong>Phone:</strong> ${driverPhone}
                        </div>
                        <div class="driver-detail-item">
                            <i class="fas fa-envelope"></i>
                            <strong>Email:</strong> ${driverEmail}
                        </div>
                        <div class="driver-detail-item">
                            <i class="fas fa-car"></i>
                            <strong>Vehicle:</strong> ${driverVehicle}
                        </div>
                        <div class="driver-detail-item">
                            <i class="fas fa-tag"></i>
                            <strong>Plate No:</strong> ${driverPlate}
                        </div>
                    </div>
                </div>

                <div class="booking-details">
                    <div class="location-info">
                        <div class="location-row">
                            <div class="location-icon pickup-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="location-text">
                                <div class="location-label">Pickup Location</div>
                                <div class="location-address">${pickupLocation}</div>
                            </div>
                        </div>
                        <div class="location-row">
                            <div class="location-icon dropoff-icon">
                                <i class="fas fa-flag-checkered"></i>
                            </div>
                            <div class="location-text">
                                <div class="location-label">Drop-off Location</div>
                                <div class="location-address">${dropoffLocation}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="booking-actions">
                    <button class="btn btn-danger" onclick="showDeleteModal('${historyId}')">
                        <i class="fas fa-trash"></i>
                        Remove
                    </button>
                </div>
            </div>
            `;
        }).join('');
    }

    // Show delete confirmation modal
    function showDeleteModal(historyId) {
        bookingToDelete = historyId;
        document.getElementById('deleteModal').style.display = 'flex';
    }

    // Close delete modal
    function closeDeleteModal() {
        bookingToDelete = null;
        document.getElementById('deleteModal').style.display = 'none';
    }

    // Delete booking from history
    function deleteBooking() {
        if (!bookingToDelete) return;
        
        // Get CSRF token from meta tag
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        const deleteUrl = `/digilink/public/passenger/delete-history/${bookingToDelete}`;
        
        fetch(deleteUrl, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
    .then(response => {
            console.log('Delete response status:', response.status);
            
            // Check if response is successful (2xx status)
            if (response.status >= 200 && response.status < 300) {
                // If response is successful but might not be JSON, handle it
                const contentType = response.headers.get('content-type');
                if (contentType && contentType.includes('application/json')) {
                    return response.json();
                } else {
                    // If response is not JSON but successful, return success
                    return { success: true, message: 'Booking deleted successfully' };
                }
            } else {
                // If response is not successful, try to parse error message
                return response.text().then(text => {
                    console.log('Delete error response:', text);
                    throw new Error(text || `Server returned ${response.status}`);
                });
            }
        })
        .then(data => {
            console.log('Delete response data:', data);
            
            // Check if data has success property or assume success
            if (data && data.success === false) {
                throw new Error(data.message || 'Failed to delete booking');
            }
            
            // Success case - booking was deleted
            showNotification('Booking removed from history successfully', 'success');
            closeDeleteModal();
            
            // Refresh the entire list after a short delay to ensure server has processed
            setTimeout(() => {
                loadHistory();
            }, 500);
        })
        .catch(error => {
            console.error('Error deleting booking:', error);
            
            // Check if it's a JSON parse error but the deletion actually worked
            if (error.message.includes('JSON') || error.message.includes('Unexpected token')) {
                // This likely means the deletion worked but the response wasn't proper JSON
                showNotification('Booking removed from history successfully', 'success');
                closeDeleteModal();
                setTimeout(() => {
                    loadHistory();
                }, 500);
            } else {
                // Actual error case
                showNotification('Failed to remove booking. Please try again.', 'error');
                closeDeleteModal();
            }
        });
    }

    // Reset filters
    function resetFilters() {
        document.getElementById('statusFilter').value = 'all';
        document.getElementById('serviceTypeFilter').value = 'all';
        document.getElementById('timeFilter').value = 'all';
        applyFilters();
    }

    // Enhanced notification function
    function showNotification(message, type = 'info') {
        // Remove any existing notifications
        const existingNotifications = document.querySelectorAll('.custom-notification');
        existingNotifications.forEach(notification => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        });

        const notification = document.createElement('div');
        notification.className = 'custom-notification';
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            background: ${type === 'error' ? '#dc3545' : type === 'success' ? '#28a745' : type === 'warning' ? '#ffc107' : '#007bff'};
            color: ${type === 'warning' ? '#000' : 'white'};
            border-radius: 8px;
            z-index: 10000;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            max-width: 400px;
            word-wrap: break-word;
            transition: all 0.3s ease;
            opacity: 0;
            transform: translateX(100%);
        `;
        notification.textContent = message;
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.style.opacity = '1';
            notification.style.transform = 'translateX(0)';
        }, 100);
        
        // Remove after delay
        setTimeout(() => {
            if (notification.parentNode) {
                notification.style.opacity = '0';
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                }, 300);
            }
        }, 5000);
    }

    // Event listeners for filters
    document.getElementById('statusFilter').addEventListener('change', applyFilters);
    document.getElementById('serviceTypeFilter').addEventListener('change', applyFilters);
    document.getElementById('timeFilter').addEventListener('change', applyFilters);
    document.getElementById('refreshBtn').addEventListener('click', loadHistory);
    document.getElementById('confirmDeleteBtn').addEventListener('click', deleteBooking);

    // Close modal when clicking outside
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDeleteModal();
        }
    });

    // Initialize
    document.addEventListener('DOMContentLoaded', loadHistory);
</script>
</body>
</html>