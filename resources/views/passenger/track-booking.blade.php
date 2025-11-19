<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FastLan - Track Booking</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            color: #212529;
            height: 100vh;
            overflow: hidden;
        }

        .navbar {
            background: linear-gradient(135deg, #212529 0%, #343a40 100%);
            padding: 1.2rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }

        .nav-brand {
            font-size: 1.8rem;
            font-weight: 700;
            color: #dc3545;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .nav-brand:hover {
            transform: translateY(-2px);
        }

        .nav-brand span {
            color: white;
        }

        .nav-link {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
        }

        .nav-link:hover {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        .cancel-section {
            margin-top: 20px;
            padding: 20px;
            background: linear-gradient(135deg, #fff9e6 0%, #fff3cd 100%);
            border: 2px solid #ffeaa7;
            border-radius: 12px;
            border-left: 4px solid #fdcb6e;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .cancel-warning {
            color: #e17055;
            font-size: 0.95rem;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
        }

        .cancel-warning i {
            font-size: 1.1rem;
            color: #e74c3c;
        }

        .cancel-note {
            color: #6c757d;
            font-size: 0.85rem;
            margin-top: 8px;
            line-height: 1.4;
            text-align: center;
        }

        .btn-warning {
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 0.9rem;
            width: 100%;
            box-shadow: 0 2px 8px rgba(243, 156, 18, 0.3);
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, #e67e22 0%, #d35400 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(243, 156, 18, 0.4);
        }

        .btn-warning:disabled {
            background: #bdc3c7;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
            opacity: 0.7;
        }

        #cancelMessage {
            margin-top: 15px;
            padding: 12px;
            border-radius: 8px;
            font-size: 0.9rem;
            text-align: center;
            font-weight: 500;
        }

        .cancel-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
            border: 1px solid #b8dfc1;
            box-shadow: 0 2px 5px rgba(21, 87, 36, 0.1);
        }

        .cancel-error {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
            border: 1px solid #f1b0b7;
            box-shadow: 0 2px 5px rgba(114, 28, 36, 0.1);
        }

        .tracking-container {
            display: grid;
            grid-template-columns: 380px 1fr;
            height: calc(100vh - 80px);
        }

        .tracking-sidebar {
            background: white;
            border-right: 1px solid #e9ecef;
            padding: 24px;
            overflow-y: auto;
        }

        .tracking-header {
            margin-bottom: 24px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f8f9fa;
        }

        .tracking-header h1 {
            font-size: 1.5rem;
            color: #212529;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
        }

        .tracking-header h1 i {
            color: #dc3545;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            background: rgba(0, 123, 255, 0.1);
            color: #007bff;
        }

        .status-badge.in-progress {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }

        .status-badge.completed {
            background: rgba(108, 117, 125, 0.1);
            color: #6c757d;
        }

        .status-badge.cancelled {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        .info-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 16px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .rating-section {
    margin-top: 15px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
    border-left: 3px solid #ffc107;
}

.rating-section h4 {
    color: #212529;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.rating-section p {
    color: #495057;
    margin-bottom: 15px;
    font-size: 0.9rem;
}

.stars-container {
    display: flex;
    gap: 5px;
    margin: 15px 0;
    justify-content: center;
}

.rating-star {
    font-size: 32px;
    cursor: pointer;
    color: #ddd;
    transition: all 0.2s ease;
    margin: 0 2px;
}

.rating-star:hover,
.rating-star.active {
    color: #ffc107;
    transform: scale(1.2);
}

.rate-btn {
    background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
    color: #212529;
    border: none;
    padding: 12px 20px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-size: 0.9rem;
    width: 100%;
    margin-top: 10px;
}

.rate-btn:hover {
    background: linear-gradient(135deg, #e0a800 0%, #c69500 100%);
    transform: translateY(-2px);
}

.rate-btn:disabled {
    background: #bdc3c7;
    cursor: not-allowed;
    transform: none;
}

.rating-message {
    margin-top: 10px;
    padding: 10px;
    border-radius: 6px;
    text-align: center;
    font-weight: 500;
    font-size: 0.9rem;
}

.rating-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.rating-error {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

        .info-card:hover {
            border-color: #007bff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .info-card h3 {
            color: #212529;
            margin-bottom: 16px;
            font-size: 1.05rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-card h3 i {
            color: #007bff;
        }

        .info-card p {
            margin: 8px 0;
            color: #495057;
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .info-card p strong {
            color: #212529;
            font-weight: 600;
        }

        .map-container {
            position: relative;
            background: white;
        }

        #trackingMap {
            height: 100%;
            width: 100%;
        }

        .tracking-status {
            position: absolute;
            top: 20px;
            left: 20px;
            background: linear-gradient(135deg, rgba(255,255,255,0.98) 0%, rgba(248,249,250,0.98) 100%);
            padding: 14px 18px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.12);
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
            font-weight: 600;
            color: #212529;
            border: 1px solid rgba(0,0,0,0.08);
        }

        .tracking-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #28a745;
            animation: pulse 2s infinite;
        }

        .tracking-indicator.completed {
            background: #6c757d;
            animation: none;
        }

        .tracking-indicator.cancelled {
            background: #dc3545;
            animation: none;
        }

        @keyframes pulse {
            0%, 100% { 
                opacity: 1; 
                transform: scale(1);
            }
            50% { 
                opacity: 0.6;
                transform: scale(1.15);
            }
        }

        .driver-info {
            background: #f8f9fa;
            padding: 12px;
            border-radius: 8px;
            border-left: 3px solid #007bff;
            margin-top: 10px;
        }

        .driver-info p {
            margin: 6px 0;
            font-size: 0.85rem;
        }

        .back-link {
            color: #6c757d;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }

        .back-link:hover {
            color: #007bff;
        }

        .location-status {
            background: #f8f9fa;
            padding: 12px;
            border-radius: 8px;
            border-left: 3px solid #28a745;
            margin-top: 10px;
        }

        .distance-info {
            background: #f8f9fa;
            padding: 12px;
            border-radius: 8px;
            border-left: 3px solid #007bff;
            margin-top: 10px;
        }

        .map-controls {
            position: absolute;
            top: 70px;
            right: 20px;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .zoom-control {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 6px;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: all 0.2s ease;
        }

        .zoom-control:hover {
            background: #f8f9fa;
            transform: translateY(-1px);
        }

        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 0.9rem;
        }

        .btn-success {
            background: #28a745;
            color: white;
        }

        .btn-success:hover {
            background: #218838;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
        }

        .btn:disabled {
            background: #6c757d;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .status-timeline {
            margin-top: 15px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 3px solid #007bff;
        }

        .status-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            padding: 8px;
            border-radius: 6px;
            background: white;
        }

        .status-item.active {
            background: #e7f3ff;
            border-left: 3px solid #007bff;
        }

        .status-icon {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            font-size: 0.8rem;
        }

        .status-icon.pending {
            background: #ffc107;
            color: #212529;
        }

        .status-icon.accepted {
            background: #17a2b8;
            color: white;
        }

        .status-icon.in-progress {
            background: #28a745;
            color: white;
        }

        .status-icon.completed {
            background: #6c757d;
            color: white;
        }

        .status-details {
            flex: 1;
        }

        .status-time {
            font-size: 0.75rem;
            color: #6c757d;
            margin-top: 2px;
        }

        .tracking-sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .tracking-sidebar::-webkit-scrollbar-track {
            background: #f8f9fa;
        }

        .tracking-sidebar::-webkit-scrollbar-thumb {
            background: #007bff;
            border-radius: 10px;
        }

        @media (max-width: 768px) {
            .tracking-container {
                grid-template-columns: 1fr;
                grid-template-rows: auto 1fr;
            }

            .tracking-sidebar {
                border-right: none;
                border-bottom: 1px solid #e9ecef;
                max-height: 40vh;
            }

            .tracking-status {
                top: 10px;
                left: 10px;
                right: 10px;
                padding: 10px 14px;
                font-size: 0.85rem;
            }

            .map-controls {
                top: 60px;
                right: 10px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="/" class="nav-brand">Fast<span>Lan</span></a>
        <div class="nav-links">
            <a href="{{ route('passenger.pending.bookings') }}" class="nav-link">
                <i class="fas fa-arrow-left"></i> Back to Bookings
            </a>
        </div>
    </nav>

    <div class="tracking-container">
        <div class="tracking-sidebar">
            <a href="{{ route('passenger.pending.bookings') }}" class="back-link">
                <i class="fas fa-arrow-left"></i>
                Back to My Bookings
            </a>

            <div class="tracking-header">
                <h1>
                    <i class="fas fa-route"></i>
                    Active Trip
                </h1>
                <span class="status-badge in-progress" id="overallStatusBadge">IN PROGRESS</span>
                <p style="margin-top: 10px;">Real-time driver location tracking</p>
            </div>
                            <!-- Report/Help Section -->
            <div class="info-card">
                <h3><i class="fas fa-exclamation-triangle"></i> Need Help?</h3>
                <div class="help-actions" style="display: flex; flex-direction: column; gap: 10px;">
                    <!-- Urgent Help Button -->
                    <button class="btn btn-danger" onclick="showUrgentHelpModal()" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);">
                        <i class="fas fa-life-ring"></i>
                        Request Urgent Help
                    </button>
                    
                    <!-- Complaint Button -->
                    <button class="btn btn-warning" onclick="showComplaintModal()" style="background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%); color: #212529;">
                        <i class="fas fa-flag"></i>
                        Submit Complaint
                    </button>
                </div>
            </div>

            <!-- Urgent Help Modal -->
            <div id="urgentHelpModal" class="modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 10000; align-items: center; justify-content: center;">
                <div class="modal-content" style="background: white; padding: 30px; border-radius: 12px; max-width: 500px; width: 90%; max-height: 80vh; overflow-y: auto;">
                    <div class="modal-header" style="border-bottom: 2px solid #f8f9fa; padding-bottom: 15px; margin-bottom: 20px;">
                        <h3 style="color: #dc3545; display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-life-ring"></i>
                            Request Urgent Help
                        </h3>
                        <p style="color: #6c757d; margin-top: 8px; font-size: 0.9rem;">
                            This will immediately notify administrators with your current location and booking details.
                        </p>
                    </div>
                    
                    <div class="modal-body">
                        <div class="alert alert-warning" style="background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 8px; padding: 15px; margin-bottom: 20px;">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Emergency Contact:</strong> If this is a life-threatening emergency, please call local emergency services immediately.
                        </div>
                        
                        <div class="form-group">
                            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Additional Information (Optional)</label>
                            <textarea id="urgentHelpNotes" placeholder="Describe what kind of help you need..." style="width: 100%; padding: 12px; border: 1px solid #e9ecef; border-radius: 6px; resize: vertical; min-height: 100px;"></textarea>
                        </div>
                        
                        <div class="data-preview" style="background: #f8f9fa; padding: 15px; border-radius: 6px; margin-top: 15px;">
                            <h4 style="margin-bottom: 10px; font-size: 0.9rem; color: #495057;">What will be sent to admin:</h4>
                            <ul style="font-size: 0.8rem; color: #6c757d; list-style: none; padding: 0;">
                                <li>✓ Your current location and booking route</li>
                                <li>✓ Driver and vehicle information</li>
                                <li>✓ Trip details and status</li>
                                <li>✓ Timestamp of the incident</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="modal-footer" style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px; border-top: 1px solid #e9ecef; padding-top: 20px;">
                        <button onclick="hideUrgentHelpModal()" class="btn btn-secondary" style="padding: 10px 20px; border: 1px solid #6c757d; background: transparent; color: #6c757d; border-radius: 6px; cursor: pointer;">
                            Cancel
                        </button>
                        <button onclick="sendUrgentHelp()" class="btn btn-danger" style="padding: 10px 20px; background: #dc3545; color: white; border: none; border-radius: 6px; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-paper-plane"></i>
                            Send Urgent Help Request
                        </button>
                    </div>
                </div>
            </div>

                                                                        <!-- Complaint Modal -->
            <div id="complaintModal" class="modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 10000; align-items: center; justify-content: center;">
                <div class="modal-content" style="background: white; padding: 30px; border-radius: 12px; max-width: 600px; width: 90%; max-height: 80vh; overflow-y: auto;">
                    <div class="modal-header" style="border-bottom: 2px solid #f8f9fa; padding-bottom: 15px; margin-bottom: 20px;">
                        <h3 style="color: #ffc107; display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-flag"></i>
                            Submit Complaint
                        </h3>
                    </div>
                    
                    <div class="modal-body">
                        <div class="form-group" style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Complaint Type</label>
                            <select id="complaintType" style="width: 100%; padding: 12px; border: 1px solid #e9ecef; border-radius: 6px;">
                                <option value="driver_behavior">Driver Behavior</option>
                                <option value="service_issue">Service Quality</option>
                                <option value="safety_concern">Safety Concern</option>
                                <option value="payment_issue">Payment Issue</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        
                        <div class="form-group" style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Severity Level</label>
                            <select id="complaintSeverity" style="width: 100%; padding: 12px; border: 1px solid #e9ecef; border-radius: 6px;">
                                <option value="low">Low - Minor Issue</option>
                                <option value="medium">Medium - Concerning</option>
                                <option value="high">High - Serious Issue</option>
                                <option value="critical">Critical - Requires Immediate Attention</option>
                            </select>
                        </div>
                        
                        <div class="form-group" style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Description</label>
                            <textarea id="complaintDescription" placeholder="Please describe the issue in detail..." style="width: 100%; padding: 12px; border: 1px solid #e9ecef; border-radius: 6px; resize: vertical; min-height: 150px;"></textarea>
                        </div>
                    </div>
                    
                    <div class="modal-footer" style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px; border-top: 1px solid #e9ecef; padding-top: 20px;">
                        <button onclick="hideComplaintModal()" class="btn btn-secondary" style="padding: 10px 20px; border: 1px solid #6c757d; background: transparent; color: #6c757d; border-radius: 6px; cursor: pointer;">
                            Cancel
                        </button>
                        <button onclick="sendComplaint()" class="btn btn-warning" style="padding: 10px 20px; background: #ffc107; color: #212529; border: none; border-radius: 6px; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-paper-plane"></i>
                            Submit Complaint
                        </button>
                    </div>
                </div>
            </div>

            <div class="info-card">
                <h3><i class="fas fa-history"></i> Trip Status</h3>
                <div id="statusTimeline">
                    <div class="status-item active">
                        <div class="status-icon in-progress">
                            <i class="fas fa-sync-alt fa-spin"></i>
                        </div>
                        <div class="status-details">
                            <strong>Loading status...</strong>
                            <div class="status-time">Updating...</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="info-card">
                <h3><i class="fas fa-user"></i> Driver Details</h3>
                <p><strong><i class="fas fa-user-circle"></i> Name:</strong> {{ $booking->driver->fullname ?? 'N/A' }}</p>
                <p><strong><i class="fas fa-phone"></i> Phone:</strong> {{ $booking->driver->phone ?? 'N/A' }}</p>
                <p><strong><i class="fas fa-car"></i> Vehicle:</strong> {{ $booking->driver->vehicleMake ?? 'N/A' }} {{ $booking->driver->vehicleModel ?? '' }} ({{ $booking->driver->plateNumber ?? 'N/A' }})</p>
                <p><strong><i class="fas fa-chart-line"></i> Completed Trips:</strong> {{ $booking->driver->completedBooking ?? '0' }}</p>
            </div>

            <div class="info-card">
                <h3><i class="fas fa-route"></i> Trip Details</h3>
                <p><strong><i class="fas fa-car"></i> Service:</strong> {{ $booking->getServiceTypeDisplay() }}</p>
                <p><strong><i class="fas fa-map-marker-alt" style="color: #28a745;"></i> Pickup:</strong> {{ $booking->pickupLocation }}</p>
                <p><strong><i class="fas fa-flag-checkered" style="color: #dc3545;"></i> Drop-off:</strong> {{ $booking->dropoffLocation }}</p>
                <p><strong><i class="fas fa-money-bill-wave"></i> Fare:</strong> ₱{{ number_format($booking->fare, 2) }}</p>
                <p><strong><i class="fas fa-credit-card"></i> Payment:</strong> {{ $booking->getPaymentMethodDisplay() }}</p>
                @if($booking->description)
                <p><strong><i class="fas fa-sticky-note"></i> Notes:</strong> {{ $booking->description }}</p>
                @endif
            </div>

<div class="info-card">
    <h3><i class="fas fa-check-circle"></i> Trip Completion</h3>
    <div id="completionStatus">
        <p><i class="fas fa-info-circle"></i> Trip in progress...</p>
    </div>
    <div id="completionActions" style="margin-top: 15px;">
        <button class="btn btn-success" onclick="confirmCompletion()" id="confirmCompletionBtn" style="width: 100%;">
            <i class="fas fa-check"></i>
            Confirm Trip Completion
        </button>
        <div id="completionMessage" style="margin-top: 10px; font-size: 0.9rem;"></div>
    </div>

    <!-- ADD THE RATING SECTION RIGHT HERE -->
    <div id="ratingSection" style="display: none;">
        <div class="rating-section">
            <h4><i class="fas fa-star"></i> Rate Your Driver</h4>
            <p>How was your experience with {{ $booking->driver->fullname ?? 'the driver' }}?</p>
            
            <div class="stars-container">
                @for($i = 1; $i <= 5; $i++)
                    <span class="rating-star" data-rating="{{ $i }}">☆</span>
                @endfor
            </div>
            <input type="hidden" id="selectedRating" value="5">
            
            <button class="rate-btn" onclick="submitRating()" id="submitRatingBtn">
                <i class="fas fa-paper-plane"></i>
                Submit Rating
            </button>
            
            <div id="ratingMessage" class="rating-message"></div>
        </div>
    </div>
                <div class="cancel-section">
                    <div class="cancel-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        Need to cancel this trip?
                    </div>
                    <p class="cancel-note">
                        This action will immediately end the trip and notify the driver.
                    </p>
                    <button class="btn-warning" onclick="cancelOngoingBooking()" id="cancelBookingBtn">
                        <i class="fas fa-times-circle"></i>
                        Cancel Ongoing Trip
                    </button>
                    <div id="cancelMessage"></div>
                </div>
            </div>
        </div>

        <div class="map-container">
            <div class="tracking-status">
                <div class="tracking-indicator" id="trackingIndicator"></div>
                <span id="trackingStatusText">Live Driver Tracking Active</span>
            </div>
            
        <div class="map-controls">
            <button class="zoom-control" onclick="map.zoomIn()">+</button>
            <button class="zoom-control" onclick="map.zoomOut()">-</button>
            <button class="zoom-control" onclick="testDriverLocation()" style="background: #007bff; color: white;">⟳</button>
        </div>
            <div id="trackingMap"></div>
        </div>
    </div>
<script>
    let map;
    let driverMarker;
    let pickupMarker;
    let dropoffMarker;
    let updateInterval;
    let statusInterval;

    const bookingData = {
        id: {{ $booking->bookingID }},
        driver_id: {{ $booking->driver->id ?? 0 }},
        pickup: {
            lat: {{ $booking->pickupLatitude }},
            lng: {{ $booking->pickupLongitude }},
            address: `{{ $booking->pickupLocation }}`
        },
        dropoff: {
            lat: {{ $booking->dropoffLatitude }},
            lng: {{ $booking->dropoffLongitude }},
            address: `{{ $booking->dropoffLocation }}`
        }
    };

    const statusConfig = {
        'pending': {
            badge: 'pending',
            text: 'PENDING',
            indicator: 'pending',
            timeline: {
                icon: 'pending',
                title: 'Booking Request Sent',
                description: 'Waiting for driver to accept your booking'
            }
        },
        'accepted': {
            badge: 'in-progress',
            text: 'ACCEPTED',
            indicator: 'in-progress',
            timeline: {
                icon: 'accepted',
                title: 'Booking Accepted',
                description: 'Driver is on the way to pickup location'
            }
        },
        'in_progress': {
            badge: 'in-progress',
            text: 'IN PROGRESS',
            indicator: 'in-progress',
            timeline: {
                icon: 'in-progress',
                title: 'Trip in Progress',
                description: 'Driver is taking you to your destination'
            }
        },
        'completed': {
            badge: 'completed',
            text: 'COMPLETED',
            indicator: 'completed',
            timeline: {
                icon: 'completed',
                title: 'Trip Completed',
                description: 'You have reached your destination'
            }
        },
        'cancelled': {
            badge: 'cancelled',
            text: 'CANCELLED',
            indicator: 'cancelled',
            timeline: {
                icon: 'cancelled',
                title: 'Trip Cancelled',
                description: 'This trip has been cancelled'
            }
        }
    };

    function initMap() {
        console.log('Initializing map for booking:', bookingData.id);
        
        map = L.map('trackingMap', {
            zoomControl: false
        }).setView([bookingData.pickup.lat, bookingData.pickup.lng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19,
            detectRetina: true
        }).addTo(map);

        const pickupIcon = L.divIcon({
            className: 'pickup-marker',
            html: `
                <div style="position: relative;">
                    <div style="background:#28a745; border:3px solid white; border-radius:50%; width:20px; height:20px; box-shadow:0 2px 8px rgba(0,0,0,0.3);"></div>
                    <div style="position: absolute; top: -25px; left: 50%; transform: translateX(-50%); background: #28a745; color: white; padding: 2px 8px; border-radius: 10px; font-size: 10px; font-weight: bold; white-space: nowrap;">
                        PICKUP
                    </div>
                </div>
            `,
            iconSize: [20, 45],
            iconAnchor: [10, 20]
        });

        pickupMarker = L.marker([bookingData.pickup.lat, bookingData.pickup.lng], { icon: pickupIcon })
            .addTo(map)
            .bindPopup(`
                <div style="text-align: center; min-width: 200px;">
                    <strong style="color: #28a745;">📍 PICKUP LOCATION</strong><br>
                    <hr style="margin: 5px 0;">
                    ${bookingData.pickup.address}
                </div>
            `);

        const dropoffIcon = L.divIcon({
            className: 'dropoff-marker',
            html: `
                <div style="position: relative;">
                    <div style="background:#dc3545; border:3px solid white; border-radius:50%; width:20px; height:20px; box-shadow:0 2px 8px rgba(0,0,0,0.3);"></div>
                    <div style="position: absolute; top: -25px; left: 50%; transform: translateX(-50%); background: #dc3545; color: white; padding: 2px 8px; border-radius: 10px; font-size: 10px; font-weight: bold; white-space: nowrap;">
                        DROP-OFF
                    </div>
                </div>
            `,
            iconSize: [20, 45],
            iconAnchor: [10, 20]
        });

        dropoffMarker = L.marker([bookingData.dropoff.lat, bookingData.dropoff.lng], { icon: dropoffIcon })
            .addTo(map)
            .bindPopup(`
                <div style="text-align: center; min-width: 200px;">
                    <strong style="color: #dc3545;">🏁 DROP-OFF LOCATION</strong><br>
                    <hr style="margin: 5px 0;">
                    ${bookingData.dropoff.address}
                </div>
            `);

        // Initialize rating system
        initRatingSystem();
        startTrackingUpdates();
        startStatusUpdates();
    }

    // RATING SYSTEM FUNCTIONS
    function initRatingSystem() {
        const stars = document.querySelectorAll('.rating-star');
        const selectedRating = document.getElementById('selectedRating');
        
        // Initialize with 5 stars selected
        if (stars.length > 0) {
            setRating(5);
        }
        
        // Add click events to stars
        stars.forEach(star => {
            star.addEventListener('click', function() {
                const rating = parseInt(this.getAttribute('data-rating'));
                setRating(rating);
            });
        });
        
        function setRating(rating) {
            selectedRating.value = rating;
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.add('active');
                    star.textContent = '★';
                } else {
                    star.classList.remove('active');
                    star.textContent = '☆';
                }
            });
        }
    }

    function submitRating() {
        const rating = document.getElementById('selectedRating').value;
        const bookingId = bookingData.id;
        const driverId = bookingData.driver_id;
        const btn = document.getElementById('submitRatingBtn');
        const messageDiv = document.getElementById('ratingMessage');
        
        if (!rating) {
            messageDiv.innerHTML = '<div class="rating-error">Please select a rating</div>';
            return;
        }
        
        // Show loading state
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';
        btn.disabled = true;
        
        // Submit rating
        fetch('/digilink/public/passenger/submit-rating', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                booking_id: bookingId,
                driver_id: driverId,
                rating: parseInt(rating)
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                messageDiv.innerHTML = `<div class="rating-success">${data.message}</div>`;
                btn.style.display = 'none';
                
                // Show success message and option to go back
                setTimeout(() => {
                    document.getElementById('ratingSection').innerHTML = `
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i> 
                            <strong>Thank you for your rating!</strong><br>
                            You rated: ${'★'.repeat(rating)}${'☆'.repeat(5-rating)} (${rating}/5)
                        </div>
                        <button class="btn btn-primary" onclick="goToBookings()" style="width: 100%; margin-top: 10px;">
                            <i class="fas fa-arrow-left"></i> Back to My Bookings
                        </button>
                    `;
                }, 1500);
            } else {
                throw new Error(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            messageDiv.innerHTML = '<div class="rating-error">Failed to submit rating. Please try again.</div>';
        })
        .finally(() => {
            btn.innerHTML = '<i class="fas fa-paper-plane"></i> Submit Rating';
            btn.disabled = false;
        });
    }

    function goToBookings() {
        window.location.href = "{{ route('passenger.pending.bookings') }}";
    }

    // MODIFIED COMPLETION FUNCTION - Doesn't redirect automatically
    function confirmCompletion() {
        if (!confirm('Are you sure you want to confirm trip completion?\n\nPlease ensure you have reached your destination safely and received your service.')) {
            return;
        }

        const confirmBtn = document.getElementById('confirmCompletionBtn');
        const originalText = confirmBtn.innerHTML;
        confirmBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Confirming...';
        confirmBtn.disabled = true;

        fetch(`/digilink/public/passenger/confirm-completion/${bookingData.id}`, {
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
                updateCompletionStatus(data.completion_status, data.is_completed);
                showCompletionMessage(data.message, 'success');
                
                if (data.is_completed) {
                    stopTracking();
                    updateStatusDisplay('completed');
                    
                    // Show rating section instead of redirecting
                    document.getElementById('ratingSection').style.display = 'block';
                    
                    // Show message about rating
                    showCompletionMessage('Trip completed! Please rate your driver below.', 'success');
                }
            } else {
                throw new Error(data.message || 'Failed to confirm completion');
            }
        })
        .catch(error => {
            console.error('Error confirming completion:', error);
            showCompletionMessage(error.message, 'error');
            confirmBtn.innerHTML = originalText;
            confirmBtn.disabled = false;
        });
    }

    function startTrackingUpdates() {
        console.log('Starting tracking updates...');
        updateDriverLocation();
        updateInterval = setInterval(updateDriverLocation, 3000);
    }

    function startStatusUpdates() {
        updateBookingStatus();
        statusInterval = setInterval(updateBookingStatus, 10000);
    }

    function updateBookingStatus() {
        fetch(`/digilink/public/passenger/get-booking-location/${bookingData.id}?_t=${Date.now()}`)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                console.log('Status update response:', data);
                if (data.success) {
                    updateStatusDisplay(data.booking.status);
                    
                    // Show rating section if booking is completed and not already rated
                    if (data.booking.status === 'completed' && data.booking.completion_verified === 'both_confirmed') {
                        document.getElementById('ratingSection').style.display = 'block';
                        document.getElementById('confirmCompletionBtn').style.display = 'none';
                    }
                    
                    if (['completed', 'cancelled'].includes(data.booking.status)) {
                        stopTracking();
                    }
                }
            })
            .catch(error => {
                console.error('Error fetching booking status:', error);
            });
    }

    function updateStatusDisplay(status) {
        const config = statusConfig[status] || statusConfig.in_progress;
        
        const statusBadge = document.getElementById('overallStatusBadge');
        if (statusBadge) {
            statusBadge.textContent = config.text;
            statusBadge.className = `status-badge ${config.badge}`;
        }
        
        const trackingIndicator = document.getElementById('trackingIndicator');
        if (trackingIndicator) {
            trackingIndicator.className = `tracking-indicator ${config.indicator}`;
        }
        
        const trackingStatusText = document.getElementById('trackingStatusText');
        if (trackingStatusText) {
            trackingStatusText.textContent = getStatusText(status);
        }
        
        updateStatusTimeline(status);
        
        const cancelBtn = document.getElementById('cancelBookingBtn');
        if (cancelBtn && (status === 'completed' || status === 'cancelled')) {
            cancelBtn.style.display = 'none';
        }
    }

    function getStatusText(status) {
        const statusTexts = {
            'pending': 'Waiting for Driver Acceptance',
            'accepted': 'Driver is Coming to Pickup',
            'in_progress': 'Live Driver Tracking Active',
            'completed': 'Trip Completed',
            'cancelled': 'Trip Cancelled'
        };
        return statusTexts[status] || 'Live Driver Tracking Active';
    }

    function updateStatusTimeline(currentStatus) {
        const timeline = document.getElementById('statusTimeline');
        if (!timeline) return;

        const statuses = ['pending', 'accepted', 'in_progress', 'completed'];
        
        let timelineHTML = '';
        
        statuses.forEach(status => {
            const config = statusConfig[status];
            const isActive = status === currentStatus;
            const isPast = statuses.indexOf(status) < statuses.indexOf(currentStatus);
            
            timelineHTML += `
                <div class="status-item ${isActive ? 'active' : ''}">
                    <div class="status-icon ${config.timeline.icon} ${isPast ? 'completed' : ''}">
                        ${isActive && status !== 'completed' ? '<i class="fas fa-sync-alt fa-spin"></i>' : 
                          isPast ? '<i class="fas fa-check"></i>' : 
                          `<i class="fas fa-${getStatusIcon(status)}"></i>`}
                    </div>
                    <div class="status-details">
                        <strong>${config.timeline.title}</strong>
                        <div class="status-time">${config.timeline.description}</div>
                    </div>
                </div>
            `;
        });
        
        timeline.innerHTML = timelineHTML;
    }

    function getStatusIcon(status) {
        const icons = {
            'pending': 'clock',
            'accepted': 'user-check',
            'in_progress': 'car',
            'completed': 'flag-checkered'
        };
        return icons[status] || 'info-circle';
    }

    function updateDriverLocation() {
        const url = `/digilink/public/passenger/get-driver-location/${bookingData.id}?_t=${Date.now()}`;
        console.log('Fetching driver location from:', url);

        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Driver location API response:', data);
                
                if (data.success) {
                    updateStatusDisplay(data.booking.status);
                    
                    if (data.driver && data.driver.current_lat != null && data.driver.current_lng != null) {
                        const driverLat = parseFloat(data.driver.current_lat);
                        const driverLng = parseFloat(data.driver.current_lng);
                        
                        if (!isNaN(driverLat) && !isNaN(driverLng)) {
                            updateDriverPosition(driverLat, driverLng);
                            updateDistanceInfo(data.distance_info);
                            updateLocationStatus('success', `Live GPS tracking active - ${data.driver.name}`);
                        }
                    } else {
                        updateLocationStatus('waiting', 'Waiting for driver location updates...');
                    }
                }
            })
            .catch(error => {
                console.error('Error fetching driver location:', error);
                updateLocationStatus('error', 'Unable to fetch driver location');
            });
    }

    function updateDriverPosition(lat, lng) {
        if (!driverMarker) {
            const driverIcon = L.divIcon({
                className: 'driver-marker',
                html: `
                    <div style="position: relative;">
                        <div style="background:#212529; border:3px solid white; border-radius:50%; width:16px; height:16px; box-shadow:0 2px 8px rgba(0,0,0,0.3);"></div>
                        <div style="position: absolute; top: -22px; left: 50%; transform: translateX(-50%); background: #212529; color: white; padding: 2px 6px; border-radius: 8px; font-size: 9px; font-weight: bold; white-space: nowrap;">
                            DRIVER
                        </div>
                    </div>
                `,
                iconSize: [16, 38],
                iconAnchor: [8, 16]
            });

            driverMarker = L.marker([lat, lng], { icon: driverIcon })
                .addTo(map)
                .bindPopup(`
                    <div style="text-align: center; min-width: 200px;">
                        <strong>🚗 YOUR DRIVER</strong><br>
                        <hr style="margin: 5px 0;">
                        {{ $booking->driver->fullname ?? 'Driver' }}<br>
                        {{ $booking->driver->vehicleMake ?? '' }} {{ $booking->driver->vehicleModel ?? '' }}
                    </div>
                `);

            const group = new L.featureGroup([pickupMarker, dropoffMarker, driverMarker]);
            map.fitBounds(group.getBounds().pad(0.2));
        } else {
            driverMarker.setLatLng([lat, lng]);
        }
    }

    function updateLocationStatus(type, message) {
        const locationStatus = document.getElementById('locationStatus');
        if (!locationStatus) return;

        const statusIcons = {
            'success': '<i class="fas fa-check-circle" style="color: #28a745;"></i>',
            'waiting': '<i class="fas fa-clock" style="color: #6c757d;"></i>',
            'error': '<i class="fas fa-exclamation-triangle" style="color: #dc3545;"></i>'
        };

        locationStatus.innerHTML = `<p>${statusIcons[type]} ${message}</p>`;
    }

    function updateDistanceInfo(distanceInfo) {
        const distanceInfoElement = document.getElementById('distanceInfo');
        if (distanceInfoElement && distanceInfo) {
            distanceInfoElement.innerHTML = `
                <div class="location-status">
                    <p><i class="fas fa-route" style="color: #28a745;"></i> <strong>Driver to Pickup:</strong> ${distanceInfo.to_pickup_km || 'N/A'} km</p>
                    <p><i class="fas fa-clock" style="color: #6c757d;"></i> <strong>Est. Time:</strong> ${distanceInfo.est_time_to_pickup_min || 'N/A'} min</p>
                </div>
                <div class="distance-info">
                    <p><i class="fas fa-flag-checkered" style="color: #dc3545;"></i> <strong>Driver to Drop-off:</strong> ${distanceInfo.to_dropoff_km || 'N/A'} km</p>
                    <p><i class="fas fa-clock" style="color: #6c757d;"></i> <strong>Est. Time:</strong> ${distanceInfo.est_time_to_dropoff_min || 'N/A'} min</p>
                </div>
            `;
        }
    }

    function updateCompletionStatus(status, isCompleted) {
        const completionStatus = document.getElementById('completionStatus');
        if (!completionStatus) return;

        const statusMessages = {
            'pending': `<div style="color: #6c757d;"><i class="fas fa-clock"></i> <strong>Status:</strong> Waiting for completion confirmation...</div>`,
            'driver_confirmed': `<div style="color: #007bff;"><i class="fas fa-user-check"></i> <strong>Status:</strong> Driver has confirmed completion</div>`,
            'passenger_confirmed': `<div style="color: #28a745;"><i class="fas fa-user-check"></i> <strong>Status:</strong> You have confirmed completion</div>`,
            'both_confirmed': `<div style="color: #28a745;"><i class="fas fa-check-double"></i> <strong>Status:</strong> Trip completed successfully!</div>`
        };

        completionStatus.innerHTML = statusMessages[status] || statusMessages.pending;

        if (isCompleted || status === 'both_confirmed') {
            document.getElementById('confirmCompletionBtn').style.display = 'none';
        }
    }

    function showCompletionMessage(message, type) {
        const completionMessage = document.getElementById('completionMessage');
        if (!completionMessage) return;

        completionMessage.innerHTML = `
            <div style="color: ${type === 'success' ? '#28a745' : '#dc3545'}; font-weight: 600; padding: 10px; background: ${type === 'success' ? '#d4edda' : '#f8d7da'}; border-radius: 8px; border: 1px solid ${type === 'success' ? '#c3e6cb' : '#f5c6cb'};">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'}"></i> ${message}
            </div>
        `;
    }

    function stopTracking() {
        if (updateInterval) {
            clearInterval(updateInterval);
            updateInterval = null;
        }
        if (statusInterval) {
            clearInterval(statusInterval);
            statusInterval = null;
        }
    }

    function cancelOngoingBooking() {
        if (!confirm('Are you sure you want to cancel this ongoing trip?\n\n⚠️ This action cannot be undone. The driver will be notified immediately.')) {
            return;
        }

        const cancelBtn = document.getElementById('cancelBookingBtn');
        const originalText = cancelBtn.innerHTML;
        cancelBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Cancelling...';
        cancelBtn.disabled = true;

        fetch(`/digilink/public/passenger/cancel-ongoing-booking/${bookingData.id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('cancelMessage').innerHTML = `<div class="cancel-success"><i class="fas fa-check-circle"></i> ${data.message}</div>`;
                stopTracking();
                updateStatusDisplay('cancelled');
                document.getElementById('confirmCompletionBtn').disabled = true;
                document.getElementById('cancelBookingBtn').style.display = 'none';
            } else {
                throw new Error(data.message);
            }
        })
        .catch(error => {
            console.error('Error cancelling booking:', error);
            document.getElementById('cancelMessage').innerHTML = `<div class="cancel-error"><i class="fas fa-exclamation-triangle"></i> ${error.message}</div>`;
            cancelBtn.innerHTML = originalText;
            cancelBtn.disabled = false;
        });
    }

    // Report/Help Functions
    function showUrgentHelpModal() {
        document.getElementById('urgentHelpModal').style.display = 'flex';
    }

    function hideUrgentHelpModal() {
        document.getElementById('urgentHelpModal').style.display = 'none';
        document.getElementById('urgentHelpNotes').value = '';
    }

    function showComplaintModal() {
        document.getElementById('complaintModal').style.display = 'flex';
    }

    function hideComplaintModal() {
        document.getElementById('complaintModal').style.display = 'none';
        document.getElementById('complaintType').value = 'driver_behavior';
        document.getElementById('complaintSeverity').value = 'medium';
        document.getElementById('complaintDescription').value = '';
    }

    function sendUrgentHelp() {
        const notes = document.getElementById('urgentHelpNotes').value;
        
        const btn = event.target;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
        btn.disabled = true;

        fetch('{{ route("report.urgent.help") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                booking_id: {{ $booking->bookingID }},
                additional_notes: notes
            })
        })
        .then(response => {
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                throw new Error('Server returned non-JSON response');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                showNotification('success', data.message || 'Help request sent successfully!');
                hideUrgentHelpModal();
            } else {
                throw new Error(data.message || 'Failed to send help request');
            }
        })
        .catch(error => {
            console.error('Error sending urgent help:', error);
            showNotification('error', error.message || 'Failed to send help request. Please try again.');
        })
        .finally(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
        });
    }

    function sendComplaint() {
        const type = document.getElementById('complaintType').value;
        const severity = document.getElementById('complaintSeverity').value;
        const description = document.getElementById('complaintDescription').value;

        if (!description.trim()) {
            showNotification('error', 'Please provide a description of the issue');
            return;
        }

        if (description.trim().length < 10) {
            showNotification('error', 'Please provide a more detailed description (at least 10 characters)');
            return;
        }

        const btn = event.target;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';
        btn.disabled = true;

        fetch('{{ route("report.complaint") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                booking_id: {{ $booking->bookingID }},
                complaint_type: type,
                severity: severity,
                description: description
            })
        })
        .then(response => {
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                throw new Error('Server returned non-JSON response');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                showNotification('success', data.message || 'Complaint submitted successfully!');
                hideComplaintModal();
            } else {
                throw new Error(data.message || 'Failed to submit complaint');
            }
        })
        .catch(error => {
            console.error('Error submitting complaint:', error);
            showNotification('error', error.message || 'Failed to submit complaint. Please try again.');
        })
        .finally(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
        });
    }

    function showNotification(type, message, duration = 5000) {
        const existingNotifications = document.querySelectorAll('.custom-notification');
        existingNotifications.forEach(notification => notification.remove());

        const notification = document.createElement('div');
        notification.className = 'custom-notification';
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${type === 'success' ? '#28a745' : '#dc3545'};
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 10001;
            max-width: 400px;
            animation: slideInRight 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
        `;
        
        notification.innerHTML = `
            <div style="display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'}"></i>
                <span>${message}</span>
            </div>
            <button onclick="this.parentElement.remove()" style="background: none; border: none; color: inherit; cursor: pointer; margin-left: auto; padding: 0; font-size: 1rem;">
                <i class="fas fa-times"></i>
            </button>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            if (notification.parentElement) {
                notification.style.animation = 'slideOutRight 0.3s ease';
                setTimeout(() => notification.remove(), 300);
            }
        }, duration);
    }

    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = 'none';
        }
    });

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                modal.style.display = 'none';
            });
        }
    });

    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOutRight {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
        
        .modal {
            transition: opacity 0.3s ease;
        }
        
        .modal-content {
            animation: modalSlideIn 0.3s ease;
        }
        
        @keyframes modalSlideIn {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    `;
    document.head.appendChild(style);

    window.addEventListener('beforeunload', stopTracking);

    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded, initializing tracking...');
        initMap();
        updateBookingStatus();
        
        console.log('Report system initialized for booking:', {{ $booking->bookingID }});
    });
</script>
</body>
</html>