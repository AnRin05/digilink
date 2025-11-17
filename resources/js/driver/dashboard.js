    // Toggle dropdown menu
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

    // Update current time
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

    // Availability toggle
    document.getElementById('availabilityToggle').addEventListener('change', function() {
        const isAvailable = this.checked;
        
        // Update online indicator
        const onlineIndicator = document.querySelector('.online-indicator');
        if (isAvailable) {
            onlineIndicator.style.background = '#28a745';
            // Load available bookings when going online
            loadAvailableBookings();
            loadAcceptedBookings();
        } else {
            onlineIndicator.style.background = '#6c757d';
            // Clear bookings when going offline
            document.getElementById('bookingsGrid').innerHTML = getLoadingHTML();
            document.getElementById('bookingsCount').textContent = '0 bookings';
            document.getElementById('acceptedBookingsSection').style.display = 'none';
        }
        
        // Send AJAX request to update availability
        updateDriverAvailability(isAvailable);
    });

    // Update driver availability
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
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Availability updated successfully');
                showNotification('You are now ' + (isAvailable ? 'online' : 'offline'), 'success');
            }
        })
        .catch(error => {
            console.error('Error updating availability:', error);
            // Revert toggle on error
            document.getElementById('availabilityToggle').checked = !isAvailable;
            showNotification('Error updating availability', 'error');
        });
    }

    // Load available bookings
    function loadAvailableBookings() {
        const pickupFilter = document.getElementById('pickupFilter').value;
        const dropoffFilter = document.getElementById('dropoffFilter').value;
        const serviceTypeFilter = document.getElementById('serviceTypeFilter').value;
        const bookingTypeFilter = document.getElementById('bookingTypeFilter').value;

        // Show loading state
        document.getElementById('bookingsGrid').innerHTML = getLoadingHTML();

        const params = new URLSearchParams({
            pickup_location: pickupFilter,
            dropoff_location: dropoffFilter,
            service_type: serviceTypeFilter,
            booking_type: bookingTypeFilter
        });

        fetch(`{{ route('driver.available.bookings') }}?${params}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    displayBookings(data.bookings);
                    document.getElementById('bookingsCount').textContent = `${data.count} booking${data.count !== 1 ? 's' : ''}`;
                    
                    // Show/hide empty state
                    if (data.count === 0) {
                        document.getElementById('bookingsGrid').style.display = 'none';
                        document.getElementById('emptyState').style.display = 'block';
                    } else {
                        document.getElementById('bookingsGrid').style.display = 'grid';
                        document.getElementById('emptyState').style.display = 'none';
                    }
                } else {
                    throw new Error('Failed to load bookings');
                }
            })
            .catch(error => {
                console.error('Error loading bookings:', error);
                document.getElementById('bookingsGrid').innerHTML = getErrorHTML('Error loading bookings. Please try again.');
            });
    }

    // Load accepted bookings
    function loadAcceptedBookings() {
        fetch("{{ route('driver.accepted.bookings') }}")
            .then(response => response.json())
            .then(data => {
                if (data.success && data.count > 0) {
                    displayAcceptedBookings(data.accepted_bookings);
                    document.getElementById('acceptedBookingsCount').textContent = `${data.count} booking${data.count !== 1 ? 's' : ''}`;
                    document.getElementById('acceptedBookingsSection').style.display = 'block';
                } else {
                    document.getElementById('acceptedBookingsSection').style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Error loading accepted bookings:', error);
            });
    }

    // Display bookings in the grid
    function displayBookings(bookings) {
        const bookingsGrid = document.getElementById('bookingsGrid');
        
        if (bookings.length === 0) {
            bookingsGrid.innerHTML = '';
            return;
        }

        const bookingsHTML = bookings.map(booking => `
            <div class="booking-card" data-booking-id="${booking.id}">
                <div class="booking-header">
                    <div class="passenger-info">
                        <img src="${booking.passenger_avatar}" alt="Passenger" class="passenger-avatar">
                        <div class="passenger-details">
                            <h4>${booking.passenger_name}</h4>
                            <p><i class="fas fa-phone"></i> ${booking.passenger_phone}</p>
                        </div>
                    </div>
                    <div class="booking-type ${booking.service_type_raw === 'booking_to_go' ? 'ride' : 'delivery'}">
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
                    ${booking.description ? `
                    <div class="location-row">
                        <div class="location-icon" style="background: rgba(255, 193, 7, 0.1); color: #ffc107;">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div class="location-text">
                            <div class="location-label">Description</div>
                            <div class="location-address">${booking.description}</div>
                        </div>
                    </div>
                    ` : ''}
                </div>
                <div class="booking-meta">
                    <div class="meta-item">
                        <div class="meta-label">Fare</div>
                        <div class="meta-value fare">${booking.fare}</div>
                    </div>
                    <div class="meta-item">
                        <div class="meta-label">Payment</div>
                        <div class="meta-value">${booking.payment_method}</div>
                    </div>
                    <div class="meta-item">
                        <div class="meta-label">Type</div>
                        <div class="meta-value">${booking.booking_type}</div>
                    </div>
                </div>
                ${booking.booking_type_raw === 'scheduled' ? `
                <div class="booking-meta">
                    <div class="meta-item">
                        <div class="meta-label">Scheduled For</div>
                        <div class="meta-value">${booking.schedule_time}</div>
                    </div>
                </div>
                ` : ''}
                <div class="booking-actions">
                    <button class="btn btn-accept" onclick="acceptBooking(${booking.id})">
                        <i class="fas fa-check-circle"></i>
                        Accept Booking
                    </button>
                    <button class="btn btn-details" onclick="showBookingDetails(${booking.id})">
                        <i class="fas fa-info-circle"></i>
                        Details
                    </button>
                </div>
            </div>
        `).join('');

        bookingsGrid.innerHTML = bookingsHTML;
    }

    // Display accepted bookings
    function displayAcceptedBookings(bookings) {
        const acceptedBookingsGrid = document.getElementById('acceptedBookingsGrid');
        
        const bookingsHTML = bookings.map(booking => `
            <div class="booking-card" data-booking-id="${booking.id}">
                <div class="booking-header">
                    <div class="passenger-info">
                        <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(booking.passenger_name)}&background=28a745&color=fff" 
                             alt="Passenger" class="passenger-avatar">
                        <div class="passenger-details">
                            <h4>${booking.passenger_name}</h4>
                            <p><i class="fas fa-map-marker-alt"></i> ${booking.pickup_location}</p>
                        </div>
                    </div>
                    <div class="booking-status ${booking.status === 'accepted' ? 'status-accepted' : 'status-in-progress'}">
                        <i class="fas ${booking.status === 'accepted' ? 'fa-clock' : 'fa-car'}"></i> 
                        ${booking.status === 'accepted' ? 'Accepted' : 'In Progress'}
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
                        <div class="meta-label">Status</div>
                        <div class="meta-value">${booking.status === 'accepted' ? 'Waiting' : 'On Trip'}</div>
                    </div>
                </div>
                <div class="booking-actions">
                    ${booking.status === 'accepted' ? `
                    <button class="btn btn-primary" onclick="startRide(${booking.id})">
                        <i class="fas fa-play-circle"></i>
                        Start Ride
                    </button>
                    ` : `
                    <button class="btn btn-success" onclick="completeRide(${booking.id})">
                        <i class="fas fa-flag-checkered"></i>
                        Complete Ride
                    </button>
                    `}
                    <button class="btn btn-details" onclick="showBookingDetails(${booking.id})">
                        <i class="fas fa-info-circle"></i>
                        Details
                    </button>
                </div>
            </div>
        `).join('');

        acceptedBookingsGrid.innerHTML = bookingsHTML;
    }

    // Show booking details modal
    function showBookingDetails(bookingId) {
        fetch(`/driver/booking-details/${bookingId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showBookingDetailsModal(data.booking);
                } else {
                    showNotification('Failed to load booking details', 'error');
                }
            })
            .catch(error => {
                console.error('Error loading booking details:', error);
                showNotification('Error loading booking details', 'error');
            });
    }

    // Display booking details in modal
    function showBookingDetailsModal(booking) {
        // Create modal HTML
        const modalHTML = `
            <div class="modal-overlay" id="bookingDetailsModal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 9999;">
                <div class="modal-content" style="background: white; padding: 2rem; border-radius: 15px; max-width: 500px; width: 90%; max-height: 80vh; overflow-y: auto;">
                    <div class="modal-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                        <h3 style="margin: 0; color: #212529;">Booking Details</h3>
                        <button onclick="closeModal()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #6c757d;">&times;</button>
                    </div>
                    <div class="passenger-info" style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 1px solid #e9ecef;">
                        <img src="${booking.passenger.avatar}" alt="Passenger" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover;">
                        <div>
                            <h4 style="margin: 0 0 0.5rem 0; color: #212529;">${booking.passenger.name}</h4>
                            <p style="margin: 0.2rem 0; color: #6c757d;"><i class="fas fa-phone"></i> ${booking.passenger.phone}</p>
                            <p style="margin: 0.2rem 0; color: #6c757d;"><i class="fas fa-envelope"></i> ${booking.passenger.email}</p>
                        </div>
                    </div>
                    <div class="booking-details">
                        <div class="detail-section" style="margin-bottom: 1.5rem;">
                            <h4 style="margin-bottom: 1rem; color: #495057; display: flex; align-items: center; gap: 0.5rem;">
                                <i class="fas fa-route" style="color: #dc3545;"></i>
                                Trip Details
                            </h4>
                            <div class="location-detail" style="display: flex; align-items: flex-start; gap: 1rem; margin-bottom: 1rem;">
                                <div style="background: rgba(220, 53, 69, 0.1); color: #dc3545; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div>
                                    <strong style="color: #495057;">Pickup:</strong>
                                    <p style="margin: 0.2rem 0; color: #6c757d;">${booking.locations.pickup.address}</p>
                                </div>
                            </div>
                            <div class="location-detail" style="display: flex; align-items: flex-start; gap: 1rem; margin-bottom: 1rem;">
                                <div style="background: rgba(40, 167, 69, 0.1); color: #28a745; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <i class="fas fa-flag-checkered"></i>
                                </div>
                                <div>
                                    <strong style="color: #495057;">Drop-off:</strong>
                                    <p style="margin: 0.2rem 0; color: #6c757d;">${booking.locations.dropoff.address}</p>
                                </div>
                            </div>
                        </div>
                        <div class="detail-section" style="margin-bottom: 1.5rem;">
                            <h4 style="margin-bottom: 1rem; color: #495057; display: flex; align-items: center; gap: 0.5rem;">
                                <i class="fas fa-receipt" style="color: #dc3545;"></i>
                                Payment Details
                            </h4>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                                <div>
                                    <strong style="color: #495057;">Fare:</strong>
                                    <p style="margin: 0.2rem 0; color: #dc3545; font-size: 1.2rem; font-weight: bold;">${booking.fare}</p>
                                </div>
                                <div>
                                    <strong style="color: #495057;">Payment Method:</strong>
                                    <p style="margin: 0.2rem 0; color: #6c757d;">${booking.payment_method}</p>
                                </div>
                                <div>
                                    <strong style="color: #495057;">Service Type:</strong>
                                    <p style="margin: 0.2rem 0; color: #6c757d;">${booking.service_type}</p>
                                </div>
                                <div>
                                    <strong style="color: #495057;">Booking Type:</strong>
                                    <p style="margin: 0.2rem 0; color: #6c757d;">${booking.booking_type}</p>
                                </div>
                            </div>
                        </div>
                        ${booking.description ? `
                        <div class="detail-section" style="margin-bottom: 1.5rem;">
                            <h4 style="margin-bottom: 1rem; color: #495057; display: flex; align-items: center; gap: 0.5rem;">
                                <i class="fas fa-info-circle" style="color: #ffc107;"></i>
                                Additional Information
                            </h4>
                            <p style="color: #6c757d; background: #f8f9fa; padding: 1rem; border-radius: 8px; margin: 0;">${booking.description}</p>
                        </div>
                        ` : ''}
                        <div class="detail-section">
                            <h4 style="margin-bottom: 1rem; color: #495057; display: flex; align-items: center; gap: 0.5rem;">
                                <i class="fas fa-clock" style="color: #6c757d;"></i>
                                Booking Information
                            </h4>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                                <div>
                                    <strong style="color: #495057;">Created:</strong>
                                    <p style="margin: 0.2rem 0; color: #6c757d;">${booking.created_at}</p>
                                </div>
                                ${booking.schedule_time !== 'Immediate' ? `
                                <div>
                                    <strong style="color: #495057;">Scheduled For:</strong>
                                    <p style="margin: 0.2rem 0; color: #6c757d;">${booking.schedule_time}</p>
                                </div>
                                ` : ''}
                            </div>
                        </div>
                    </div>
                    <div class="modal-actions" style="display: flex; gap: 1rem; margin-top: 2rem;">
                        ${booking.status === 'pending' ? `
                        <button class="btn btn-accept" onclick="acceptBooking(${booking.id}); closeModal();" style="flex: 1;">
                            <i class="fas fa-check-circle"></i>
                            Accept Booking
                        </button>
                        ` : ''}
                        <button class="btn btn-outline" onclick="closeModal()" style="flex: 1;">
                            <i class="fas fa-times"></i>
                            Close
                        </button>
                    </div>
                </div>
            </div>
        `;

        // Add modal to body
        document.body.insertAdjacentHTML('beforeend', modalHTML);
    }

    // Close modal
    function closeModal() {
        const modal = document.getElementById('bookingDetailsModal');
        if (modal) {
            modal.remove();
        }
    }

    // Accept booking function
    function acceptBooking(bookingId) {
        if (confirm('Are you sure you want to accept this booking?')) {
            // Send AJAX request to accept booking
            fetch(`/driver/accept-booking/${bookingId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Booking accepted successfully!', 'success');
                    // Remove the booking card from the UI
                    const bookingCard = document.querySelector(`[data-booking-id="${bookingId}"]`);
                    if (bookingCard) {
                        bookingCard.style.opacity = '0';
                        setTimeout(() => {
                            bookingCard.remove();
                            // Update bookings count
                            const currentCount = parseInt(document.getElementById('bookingsCount').textContent);
                            document.getElementById('bookingsCount').textContent = `${currentCount - 1} booking${currentCount - 1 !== 1 ? 's' : ''}`;
                            
                            // Reload stats and accepted bookings
                            loadBookingStats();
                            loadAcceptedBookings();
                        }, 300);
                    }
                } else {
                    showNotification('Failed to accept booking: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error accepting booking:', error);
                showNotification('An error occurred while accepting the booking.', 'error');
            });
        }
    }

    // Start ride function
    function startRide(bookingId) {
        fetch(`/driver/start-ride/${bookingId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Ride started successfully!', 'success');
                loadAcceptedBookings();
            } else {
                showNotification('Failed to start ride: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error starting ride:', error);
            showNotification('Error starting ride', 'error');
        });
    }

    // Complete ride function
    function completeRide(bookingId) {
        if (confirm('Are you sure you want to complete this ride?')) {
            fetch(`/driver/complete-booking/${bookingId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Ride completed successfully!', 'success');
                    loadAcceptedBookings();
                    loadBookingStats();
                } else {
                    showNotification('Failed to complete ride: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error completing ride:', error);
                showNotification('Error completing ride', 'error');
            });
        }
    }

    // Filter functionality
    document.getElementById('applyFilters').addEventListener('click', function() {
        applyFilters();
    });

    document.getElementById('resetFilters').addEventListener('click', function() {
        resetFilters();
    });

    document.getElementById('resetFiltersEmpty').addEventListener('click', function() {
        resetFilters();
    });

    function applyFilters() {
        loadAvailableBookings();
    }

    function resetFilters() {
        document.getElementById('pickupFilter').value = 'all';
        document.getElementById('dropoffFilter').value = 'all';
        document.getElementById('serviceTypeFilter').value = 'all';
        document.getElementById('bookingTypeFilter').value = 'all';
        loadAvailableBookings();
    }

    // Load booking statistics
    function loadBookingStats() {
        fetch("{{ route('driver.booking.stats') }}")
            .then(response => response.json())
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

    // Helper functions
    function getLoadingHTML() {
        return `
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-spinner fa-spin"></i>
                </div>
                <h3 class="empty-title">Loading Bookings</h3>
                <p class="empty-text">Please wait while we fetch available bookings...</p>
            </div>
        `;
    }

    function getErrorHTML(message) {
        return `
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h3 class="empty-title">Error Loading Bookings</h3>
                <p class="empty-text">${message}</p>
                <button class="btn btn-primary" onclick="loadAvailableBookings()">
                    <i class="fas fa-redo"></i>
                    Try Again
                </button>
            </div>
        `;
    }

    function showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <div class="notification-content">
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
                <span>${message}</span>
            </div>
        `;

        // Add styles
        notification.style.cssText = `
            position: fixed;
            top: 100px;
            right: 20px;
            background: ${type === 'success' ? '#28a745' : type === 'error' ? '#dc3545' : '#17a2b8'};
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 10000;
            animation: slideInRight 0.3s ease;
        `;

        document.body.appendChild(notification);

        // Remove after 3 seconds
        setTimeout(() => {
            notification.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // Auto-refresh bookings every 30 seconds
    function startAutoRefresh() {
        setInterval(() => {
            if (document.getElementById('availabilityToggle').checked) {
                loadAvailableBookings();
                loadAcceptedBookings();
            }
        }, 30000); // 30 seconds
    }

    // Initialize page
    document.addEventListener('DOMContentLoaded', function() {
        // Load initial data if driver is available
        if (document.getElementById('availabilityToggle').checked) {
            loadAvailableBookings();
            loadAcceptedBookings();
        }
        
        loadBookingStats();
        startAutoRefresh();
    });