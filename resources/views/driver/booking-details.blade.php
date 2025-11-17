<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Details - FastLan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/driver/booking-details.css')
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="{{ route('driver.dashboard') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i>
                Back to Dashboard
            </a>
            <h1 style="color: white;">Booking Details</h1>
        </div>

        @if(isset($booking) && $booking)
        <div class="booking-card">
            <div class="booking-header">
                <div class="passenger-info">
                    <img src="{{ $booking->passenger->profile_image ? asset('storage/' . $booking->passenger->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($booking->passenger->fullname) . '&background=random' }}" 
                         alt="Passenger" class="passenger-avatar">
                    <div class="passenger-details">
                        <h3>{{ $booking->passenger->fullname }}</h3>
                        <p><i class="fas fa-phone"></i> {{ $booking->passenger->phone }}</p>
                        <p><i class="fas fa-envelope"></i> {{ $booking->passenger->email }}</p>
                    </div>
                </div>
                <div class="booking-type">
                    <i class="fas {{ $booking->serviceType === 'booking_to_go' ? 'fa-car' : 'fa-box' }}"></i>
                    {{ $booking->getServiceTypeDisplay() }}
                </div>
            </div>

            <div class="details-grid">
                <div class="detail-section">
                    <h4><i class="fas fa-route"></i> Trip Details</h4>
                    <div class="location-row">
                        <div class="location-icon pickup-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="location-text">
                            <div class="location-label">Pickup Location</div>
                            <div class="location-address">{{ $booking->pickupLocation }}</div>
                        </div>
                    </div>
                    <div class="location-row">
                        <div class="location-icon dropoff-icon">
                            <i class="fas fa-flag-checkered"></i>
                        </div>
                        <div class="location-text">
                            <div class="location-label">Drop-off Location</div>
                            <div class="location-address">{{ $booking->dropoffLocation }}</div>
                        </div>
                    </div>
                    @if($booking->description)
                    <div class="location-row">
                        <div class="location-icon" style="background: rgba(255, 193, 7, 0.1); color: #ffc107;">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div class="location-text">
                            <div class="location-label">Additional Information</div>
                            <div class="location-address">{{ $booking->description }}</div>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="detail-section">
                    <h4><i class="fas fa-receipt"></i> Payment Details</h4>
                    <div class="meta-grid">
                        <div class="meta-item">
                            <div class="meta-label">Fare</div>
                            <div class="meta-value fare">₱{{ number_format($booking->fare, 2) }}</div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Payment Method</div>
                            <div class="meta-value">{{ $booking->getPaymentMethodDisplay() }}</div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Booking Type</div>
                            <div class="meta-value">{{ $booking->getBookingType() }}</div>
                        </div>
                        @if($booking->scheduleTime)
                        <div class="meta-item">
                            <div class="meta-label">Scheduled Time</div>
                            <div class="meta-value">{{ $booking->getFormattedScheduleTime() }}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="actions">
                <button class="btn btn-accept" onclick="acceptBooking('{{ $booking->bookingID }}')">
                    <i class="fas fa-check-circle"></i>
                    Accept This Booking
                </button>
                <a href="{{ route('driver.dashboard') }}" class="btn btn-back">
                    <i class="fas fa-times"></i>
                    Back to Dashboard
                </a>
            </div>
        </div>
        @else
        <div class="booking-card" style="text-align: center;">
            <div style="font-size: 4rem; color: #dc3545; margin-bottom: 1rem;">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h3 style="color: #2d3748; margin-bottom: 1rem;">Booking Not Found</h3>
            <p style="color: #718096; margin-bottom: 2rem;">The booking you're looking for doesn't exist or is no longer available.</p>
            <a href="{{ route('driver.dashboard') }}" class="btn btn-back">
                <i class="fas fa-arrow-left"></i>
                Back to Dashboard
            </a>
        </div>
        @endif
    </div>

    <script>
        function acceptBooking(bookingId) {
            bookingId = parseInt(bookingId); // optional if you need a number instead of string

            if (confirm('Are you sure you want to accept this booking?')) {
                // Show loading state
                const acceptBtn = document.querySelector('.btn-accept');
                const originalText = acceptBtn.innerHTML;
                acceptBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Accepting...';
                acceptBtn.disabled = true;

                fetch(`/digilink/public/driver/accept-booking/${bookingId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        window.location.href = "{{ route('driver.dashboard') }}";
                    } else {
                        alert('Error: ' + data.message);
                        acceptBtn.innerHTML = originalText;
                        acceptBtn.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while accepting the booking.');
                    acceptBtn.innerHTML = originalText;
                    acceptBtn.disabled = false;
                });
            }
        }
    </script>
</body>
</html>
