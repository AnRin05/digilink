<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FastLan - Driver Booking History</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
@vite('resources/css/driver/history.css')
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
                        <img src="{{ Auth::guard('driver')->user()->getProfileImageUrl() }}" 
                            alt="Profile" class="profile-pic">
                        <div class="online-indicator {{ Auth::guard('driver')->user()->availStatus ? 'online' : 'offline' }}"></div>
                    </div>
                    <span>{{ Auth::guard('driver')->user()->fullname }}</span>
                    <i class="fas fa-chevron-down" style="font-size: 0.8rem; color: #ffffff;"></i>
                </div>
            </div>
        </div>
    </nav>
    <div class="container">
                                                            <!-- Main Content -->
        <div class="main-content">
                                                            <!-- Sidebar -->
            <div class="sidebar">
                <div class="sidebar-title">
                    <i class="fas fa-filter"></i>
                    Filters
                </div>
                
                <div class="filter-group">
                    <label class="filter-label">Status</label>
                    <select class="filter-select" id="statusFilter">
                        <option value="all">All Status</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label class="filter-label">Service Type</label>
                    <select class="filter-select" id="serviceTypeFilter">
                        <option value="all">All Services</option>
                        <option value="ride">Ride Service</option>
                        <option value="delivery">Delivery Service</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label class="filter-label">Time Period</label>
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
            </div>

                                                            <!-- History Content -->
            <div class="history-content">
                <div class="content-header">
                    <h1 class="content-title">
                        <i class="fas fa-history"></i>
                        Driver Booking History
                    </h1>
                    <div class="actions">
                        <button class="btn btn-outline" id="refreshBtn">
                            <i class="fas fa-redo"></i>
                            Refresh
                        </button>
                        <a href="{{ route('driver.dashboard') }}" class="btn btn-primary">
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
            </div>
        </div>
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
        function loadHistory() {
            const bookingsList = document.getElementById('bookingsList');
            bookingsList.innerHTML = `
                <div class="loading-spinner">
                    <div class="spinner"></div>
                    <p>Loading your booking history...</p>
                </div>
            `;

            fetch("{{ route('driver.get.history') }}")
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                console.log('API Response:', data);
                if (data.success) {
                    currentBookings = data.bookings || [];
                    document.getElementById('totalBookings').textContent = currentBookings.length;
                    applyFilters();
                } else {
                    throw new Error(data.message || 'Failed to load history');
                }
            })
            .catch(error => {
                console.error('Error loading history:', error);
                bookingsList.innerHTML = `
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <h3 class="empty-title">Error Loading History</h3>
                        <p class="empty-text">There was a problem loading your booking history. Please try again.</p>
                        <button class="btn btn-primary" onclick="loadHistory()">
                            <i class="fas fa-redo"></i>
                            Try Again
                        </button>
                    </div>
                `;
            });
        }
        function applyFilters() {
            const statusFilter = document.getElementById('statusFilter').value;
            const serviceFilter = document.getElementById('serviceTypeFilter').value;
            const timeFilter = document.getElementById('timeFilter').value;

            let filteredBookings = [...currentBookings];

            if (statusFilter !== 'all') {
                filteredBookings = filteredBookings.filter(booking => 
                    booking.status === statusFilter
                );
            }

            if (serviceFilter !== 'all') {
                filteredBookings = filteredBookings.filter(booking => {
                    const serviceType = (booking.service_type || '').toLowerCase();
                    return serviceType.includes(serviceFilter.toLowerCase());
                });
            }

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
                
                const passengerName = booking.passenger_name || 'Not assigned';
                const passengerPhone = booking.passenger_phone || 'N/A';
                const passengerEmail = booking.passenger_email || 'N/A';

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

                    <!-- Passenger Information -->
                    <div class="passenger-info">
                        <div class="passenger-info-title">
                            <i class="fas fa-user"></i>
                            Passenger Information
                        </div>
                        <div class="passenger-details">
                            <div class="passenger-detail-item">
                                <i class="fas fa-user"></i>
                                <strong>Name:</strong> ${passengerName}
                            </div>
                            <div class="passenger-detail-item">
                                <i class="fas fa-phone"></i>
                                <strong>Phone:</strong> ${passengerPhone}
                            </div>
                            <div class="passenger-detail-item">
                                <i class="fas fa-envelope"></i>
                                <strong>Email:</strong> ${passengerEmail}
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
        function showDeleteModal(historyId) {
            bookingToDelete = historyId;
            document.getElementById('deleteModal').style.display = 'flex';
        }

        function closeDeleteModal() {
            bookingToDelete = null;
            document.getElementById('deleteModal').style.display = 'none';
        }

        function deleteBooking() {
            if (!bookingToDelete) return;
            
            const deleteUrl = `/digilink/public/driver/delete-history/${bookingToDelete}`;
            
            fetch(deleteUrl, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (response.status >= 200 && response.status < 300) {
                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        return response.json();
                    } else {
                        return { success: true, message: 'Booking deleted successfully' };
                    }
                } else {
                    return response.text().then(text => {
                        throw new Error(text || `Server returned ${response.status}`);
                    });
                }
            })
            .then(data => {
                if (data && data.success === false) {
                    throw new Error(data.message || 'Failed to delete booking');
                }
                
                showNotification('Booking removed from history successfully', 'success');
                closeDeleteModal();
                
                setTimeout(() => {
                    loadHistory();
                }, 500);
            })
            .catch(error => {
                console.error('Error deleting booking:', error);
                
                if (error.message.includes('JSON') || error.message.includes('Unexpected token')) {
                    showNotification('Booking removed from history successfully', 'success');
                    closeDeleteModal();
                    setTimeout(() => {
                        loadHistory();
                    }, 500);
                } else {
                    showNotification('Failed to remove booking. Please try again.', 'error');
                    closeDeleteModal();
                }
            });
        }

        function resetFilters() {
            document.getElementById('statusFilter').value = 'all';
            document.getElementById('serviceTypeFilter').value = 'all';
            document.getElementById('timeFilter').value = 'all';
            applyFilters();
        }

        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 15px 20px;
                background: ${type === 'error' ? '#dc3545' : type === 'success' ? '#28a745' : '#007bff'};
                color: white;
                border-radius: 8px;
                z-index: 10000;
                box-shadow: 0 4px 12px rgba(0,0,0,0.3);
                font-family: 'Poppins', sans-serif;
                font-weight: 500;
            `;
            notification.textContent = message;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 5000);
        }

        document.getElementById('statusFilter').addEventListener('change', applyFilters);
        document.getElementById('serviceTypeFilter').addEventListener('change', applyFilters);
        document.getElementById('timeFilter').addEventListener('change', applyFilters);
        document.getElementById('refreshBtn').addEventListener('click', loadHistory);
        document.getElementById('confirmDeleteBtn').addEventListener('click', deleteBooking);

        document.addEventListener('DOMContentLoaded', loadHistory);
    </script>
</body>
</html>