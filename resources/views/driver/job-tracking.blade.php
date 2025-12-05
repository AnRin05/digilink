<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Tracking - FastLan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link href="{{ asset('css/driver/job-track.css') }}" rel="stylesheet">
    @yield('styles')
    <link rel="icon" href="{{ asset('images/fastlan1.png') }}">
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
            z-index: 1002;
            position: relative;
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
            font-size: 1rem;
        }

        .nav-link:hover {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        .job-tracking-wrapper {
            display: flex;
            flex-direction: column;
            height: calc(100vh - 80px);
            position: relative;
        }

        .map-section {
            height: 70vh;
            position: relative;
            transition: height 0.4s ease;
            z-index: 1;
            background: white;
        }

        .map-section.collapsed {
            height: 40vh;
        }

        .map-container {
            position: relative;
            width: 100%;
            height: 100%;
        }

        #jobMap {
            width: 100%;
            height: 100%;
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
            font-size: 0.95rem;
            font-weight: 600;
            color: #212529;
            border: 1px solid rgba(0,0,0,0.08);
            max-width: calc(100% - 40px);
        }

        .tracking-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #28a745;
            animation: pulse 2s infinite;
            flex-shrink: 0;
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

        .sidebar-section {
            flex: 1;
            background: white;
            border-top-left-radius: 24px;
            border-top-right-radius: 24px;
            box-shadow: 0 -4px 30px rgba(0,0,0,0.15);
            position: relative;
            z-index: 1001;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .drag-handle {
            width: 60px;
            height: 6px;
            background: #e9ecef;
            border-radius: 3px;
            margin: 12px auto;
            cursor: grab;
            transition: background 0.3s ease;
        }

        .drag-handle:hover {
            background: #dc3545;
        }

        .job-sidebar {
            flex: 1;
            overflow-y: auto;
            padding: 0 24px 24px;
        }

        .job-header {
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 2px solid #f8f9fa;
        }

        .job-header h1 {
            font-size: 1.4rem;
            color: #212529;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
        }

        .job-header h1 i {
            color: #dc3545;
            font-size: 1.3rem;
        }

        .job-header p {
            color: #6c757d;
            font-size: 0.9rem;
            line-height: 1.4;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            background: rgba(255, 193, 7, 0.1);
            color: #ffc107;
        }

        .info-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: px;
            padding: 18px;
            margin-bottom: 16px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .info-card:hover {
            border-color: #dc3545;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .info-card h3 {
            color: #212529;
            margin-bottom: 14px;
            font-size: 1.05rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-card h3 i {
            color: #dc3545;
            font-size: 1.1rem;
        }

        .info-card p {
            margin: 8px 0;
            color: #495057;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .info-card p strong {
            color: #212529;
            font-weight: 600;
        }

        .job-actions {
            display: flex;
            gap: 12px;
            margin-top: 20px;
            padding: 20px 24px;
            background: white;
            border-top: 1px solid #e9ecef;
        }

        .btn {
            padding: 14px 28px;
            border: none;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
            flex: 1;
        }

        .btn-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.2);
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #218838 0%, #1e9e8a 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(40, 167, 69, 0.3);
        }

        .btn-danger {
            background: transparent;
            color: #495057;
            border: 2px solid #e9ecef;
        }

        .btn-danger:hover {
            background: rgba(220, 53, 69, 0.05);
            color: #dc3545;
            border-color: #dc3545;
            transform: translateY(-2px);
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .location-status {
            background: #f8f9fa;
            padding: 12px;
            border-radius: 8px;
            border-left: 3px solid #28a745;
        }

        .location-status p {
            margin: 6px 0;
            font-size: 0.85rem;
        }

        .distance-info {
            background: #f8f9fa;
            padding: 12px;
            border-radius: 8px;
            border-left: 3px solid #dc3545;
            margin-top: 10px;
        }

        .distance-info p {
            margin: 6px 0;
            font-size: 0.85rem;
        }

        .job-sidebar::-webkit-scrollbar {
            width: 10px;
        }

        .job-sidebar::-webkit-scrollbar-track {
            background: #f8f9fa;
        }

        .job-sidebar::-webkit-scrollbar-thumb {
            background: #dc3545;
            border-radius: 10px;
        }

        /* Cancellation Alert Styles */
        .alert-section {
            margin-top: 16px;
        }

        .alert {
            border-radius: 12px;
            padding: 18px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .alert-danger {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            border: 2px solid #f1b0b7;
            border-left: 6px solid #dc3545;
        }

        .alert-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }

        .alert-header h3 {
            color: #721c24;
            margin: 0;
            font-size: 1.1rem;
            font-weight: 700;
        }

        .alert-header i {
            color: #dc3545;
            font-size: 1.3rem;
        }

        .alert-body {
            color: #721c24;
            margin-bottom: 12px;
            font-size: 0.9rem;
        }

        .alert-body p {
            margin: 6px 0;
            line-height: 1.4;
        }

        .alert-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }

        /* Status badge styles */
        .status-badge.cancelled {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            border: 1px solid #dc3545;
        }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 10000;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        .modal-content {
            background: white;
            padding: 24px;
            border-radius: 12px;
            max-width: 480px;
            width: 100%;
            max-height: 75vh;
            overflow-y: auto;
            box-shadow: 0 8px 32px rgba(0,0,0,0.2);
        }

        .modal-header {
            border-bottom: 2px solid #f8f9fa;
            padding-bottom: 16px;
            margin-bottom: 20px;
        }

        .modal-header h3 {
            color: #dc3545;
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0;
            font-size: 1.3rem;
            font-weight: 700;
        }

        .modal-header h3 i {
            font-size: 1.4rem;
        }

        .modal-header p {
            color: #6c757d;
            margin-top: 8px;
            font-size: 0.9rem;
            line-height: 1.4;
        }

        .modal-body {
            margin-bottom: 20px;
        }

        .modal-footer {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            border-top: 1px solid #e9ecef;
            padding-top: 20px;
        }

        .alert-warning {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 14px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        .alert-warning i {
            color: #e0a800;
            margin-right: 8px;
        }

        .alert-warning strong {
            color: #856404;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #495057;
            font-size: 0.9rem;
        }

        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            resize: vertical;
            min-height: 100px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
        }

        .data-preview {
            background: #f8f9fa;
            padding: 16px;
            border-radius: 8px;
            margin-top: 16px;
        }

        .data-preview h4 {
            margin-bottom: 10px;
            font-size: 0.9rem;
            color: #495057;
            font-weight: 600;
        }

        .data-preview ul {
            font-size: 0.85rem;
            color: #6c757d;
            list-style: none;
            padding: 0;
            line-height: 1.5;
        }

        .btn-secondary {
            padding: 10px 20px;
            border: 1px solid #6c757d;
            background: transparent;
            color: #6c757d;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .modal .btn-danger {
            padding: 10px 20px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .modal .btn-warning {
            padding: 10px 20px;
            background: #ffc107;
            color: #212529;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            font-size: 0.9rem;
        }

        @media (min-width: 768px) {
            .job-tracking-wrapper {
                flex-direction: row;
            }

            .map-section {
                height: 100%;
                width: 60%;
                transition: width 0.4s ease;
            }

            .map-section.collapsed {
                height: 100%;
                width: 40%;
            }

            .sidebar-section {
                width: 40%;
                border-top-left-radius: 0;
                border-top-right-radius: 0;
                border-left: 1px solid #e9ecef;
                box-shadow: none;
            }

            .sidebar-section.expanded {
                width: 60%;
            }

            .drag-handle {
                display: none;
            }

            .tracking-status {
                max-width: 280px;
            }
            
            .modal-content {
                max-width: 500px;
                max-height: 70vh;
            }
        }

        @media (min-width: 1024px) {
            .map-section {
                width: 65%;
            }

            .map-section.collapsed {
                width: 35%;
            }

            .sidebar-section {
                width: 35%;
            }

            .sidebar-section.expanded {
                width: 65%;
            }
            
            .modal-content {
                max-width: 520px;
            }
        }

        @media (max-width: 767px) {
            .navbar {
                padding: 1rem;
            }

            .nav-brand {
                font-size: 1.5rem;
            }

            .nav-link {
                padding: 8px 12px;
                font-size: 0.9rem;
            }

            .map-section {
                height: 50vh;
            }

            .map-section.collapsed {
                height: 30vh;
            }

            .tracking-status {
                top: 15px;
                left: 15px;
                right: 15px;
                padding: 12px 16px;
                font-size: 0.85rem;
            }

            .map-controls {
                top: 60px;
                right: 15px;
            }

            .info-card {
                padding: 16px;
            }

            .btn {
                padding: 12px 20px;
                font-size: 0.9rem;
            }

            .job-actions {
                padding: 16px;
                flex-direction: column;
            }
            
            .job-sidebar {
                padding: 0 16px 16px;
            }
            
            .modal-content {
                padding: 20px;
                max-height: 80vh;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="#" class="nav-brand">Fast<span>Lan</span></a>
        <div class="nav-links">
            <a href="{{ route('driver.dashboard') }}" class="nav-link">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </nav>

    <div class="job-tracking-wrapper">
        <!-- Map Section -->
        <div class="map-section" id="mapSection">
            <div class="map-container">
                <div class="tracking-status">
                    <div class="tracking-indicator"></div>
                    <span>Live GPS Tracking Active</span>
                </div>
                
                <div class="map-controls">
                    <button class="zoom-control" onclick="driverMap.zoomIn()">+</button>
                    <button class="zoom-control" onclick="driverMap.zoomOut()">-</button>
                </div>
                
                <div id="jobMap"></div>
            </div>
        </div>

        <!-- Sidebar Section -->
        <div class="sidebar-section" id="sidebarSection">
            <div class="drag-handle" id="dragHandle"></div>
            <div class="job-sidebar">
                <!-- Cancellation Alert Section -->
                <div id="cancellationAlert" class="alert-section" style="display: none;">
                    <div class="alert alert-danger">
                        <div class="alert-header">
                            <i class="fas fa-exclamation-triangle"></i>
                            <h3>Booking Cancelled</h3>
                        </div>
                        <div class="alert-body">
                            <p id="cancellationMessage"></p>
                            <p><strong>This trip has been cancelled by the passenger.</strong></p>
                        </div>
                        <div class="alert-actions">
                            <button class="btn btn-primary" onclick="handleCancellation()">
                                <i class="fas fa-check"></i>
                                Acknowledge
                            </button>
                        </div>
                    </div>
                </div>

                <div class="job-header">
                    <h1>
                        <i class="fas fa-route"></i>
                        Active Job
                    </h1>
                    <span class="status-badge">IN PROGRESS</span>
                    <p style="margin-top: 10px;">Real-time location tracking active</p>
                </div>

                <!-- Passenger Info -->
                <div class="info-card">
                    <h3><i class="fas fa-user"></i> Passenger Details</h3>
                    <p>
                        <strong><i class="fas fa-user-circle"></i> Name:</strong> 
                        {{ $booking->passenger->fullname ?? 'N/A' }}
                    </p>
                    <p>
                        <strong><i class="fas fa-phone"></i> Phone:</strong> 
                        {{ $booking->passenger->phone ?? 'N/A' }}
                    </p>
                    <p>
                        <strong><i class="fas fa-car"></i> Service:</strong> 
                        {{ $booking->getServiceTypeDisplay() }}
                    </p>
                </div>

                <!-- Trip Info -->
                <div class="info-card">
                    <h3><i class="fas fa-route"></i> Trip Details</h3>
                    <p>
                        <strong><i class="fas fa-map-marker-alt" style="color: #28a745;"></i> Pickup:</strong> 
                        {{ $booking->pickupLocation }}
                    </p>
                    <p>
                        <strong><i class="fas fa-flag-checkered" style="color: #dc3545;"></i> Drop-off:</strong> 
                        {{ $booking->dropoffLocation }}
                    </p>
                    <p>
                        <strong><i class="fas fa-money-bill-wave"></i> Fare:</strong> 
                        ₱{{ number_format($booking->fare, 2) }}
                    </p>
                    <p>
                        <strong><i class="fas fa-credit-card"></i> Payment:</strong> 
                        {{ $booking->getPaymentMethodDisplay() }}
                    </p>
                    @if($booking->description)
                    <p>
                        <strong><i class="fas fa-sticky-note"></i> Notes:</strong> 
                        {{ $booking->description }}
                    </p>
                    @endif
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
                <div id="urgentHelpModal" class="modal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3>
                                <i class="fas fa-life-ring"></i>
                                Request Urgent Help
                            </h3>
                            <p>
                                This will immediately notify administrators with your current location and booking details.
                            </p>
                        </div>
                        
                        <div class="modal-body">
                            <div class="alert-warning">
                                <i class="fas fa-exclamation-triangle"></i>
                                <strong>Emergency Contact:</strong> If this is a life-threatening emergency, please call local emergency services immediately.
                            </div>
                            
                            <div class="form-group">
                                <label>Additional Information (Optional)</label>
                                <textarea id="urgentHelpNotes" placeholder="Describe what kind of help you need..."></textarea>
                            </div>
                            
                            <div class="data-preview">
                                <h4>What will be sent to admin:</h4>
                                <ul>
                                    <li>✓ Your current location and booking route</li>
                                    <li>✓ Driver and vehicle information</li>
                                    <li>✓ Trip details and status</li>
                                    <li>✓ Timestamp of the incident</li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="modal-footer">
                            <button onclick="hideUrgentHelpModal()" class="btn-secondary">
                                Cancel
                            </button>
                            <button onclick="sendUrgentHelp()" class="btn-danger">
                                <i class="fas fa-paper-plane"></i>
                                Send Urgent Help Request
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Complaint Modal -->
                <div id="complaintModal" class="modal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3>
                                <i class="fas fa-flag"></i>
                                Submit Complaint
                            </h3>
                        </div>
                        
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Complaint Type</label>
                                <select id="complaintType" style="width: 100%; padding: 12px; border: 1px solid #e9ecef; border-radius: 6px; font-size: 0.9rem;">
                                    <option value="service_issue">Service Quality</option>
                                    <option value="safety_concern">Safety Concern</option>
                                    <option value="payment_issue">Payment Issue</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Severity Level</label>
                                <select id="complaintSeverity" style="width: 100%; padding: 12px; border: 1px solid #e9ecef; border-radius: 6px; font-size: 0.9rem;">
                                    <option value="low">Low - Minor Issue</option>
                                    <option value="medium">Medium - Concerning</option>
                                    <option value="high">High - Serious Issue</option>
                                    <option value="critical">Critical - Requires Immediate Attention</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Description</label>
                                <textarea id="complaintDescription" placeholder="Please describe the issue in detail..."></textarea>
                            </div>
                        </div>
                        
                        <div class="modal-footer">
                            <button onclick="hideComplaintModal()" class="btn-secondary">
                                Cancel
                            </button>
                            <button onclick="sendComplaint()" class="btn-warning">
                                <i class="fas fa-paper-plane"></i>
                                Submit Complaint
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Completion Status -->
                <div class="info-card">
                    <h3><i class="fas fa-check-circle"></i> Trip Completion</h3>
                    <div id="completionStatus">
                        <p><i class="fas fa-info-circle"></i> Trip in progress...</p>
                    </div>
                        <div class="modal-footer">
                        <button class="btn btn-success" onclick="confirmCompletion()" id="confirmCompletionBtn">
                        <i class="fas fa-check-circle"></i>
                            Confirm Completion
                        </button>
                        <a href="{{ route('driver.dashboard') }}" class="btn btn-danger">
                            <i class="fas fa-times"></i>
                             Cancel Job
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
    // Add this section for the collapsible UI functionality
    document.addEventListener('DOMContentLoaded', function() {
        const mapSection = document.getElementById('mapSection');
        const sidebarSection = document.getElementById('sidebarSection');
        const dragHandle = document.getElementById('dragHandle');
        const jobSidebar = document.querySelector('.job-sidebar');
        let isCollapsed = false;
        let startY = 0;
        let startHeight = 0;
        
        // Initialize with expanded view on mobile
        if (window.innerWidth < 768) {
            mapSection.classList.remove('collapsed');
            sidebarSection.classList.remove('expanded');
        } else {
            mapSection.classList.remove('collapsed');
            sidebarSection.classList.remove('expanded');
        }
        
        // Drag handle functionality
        dragHandle.addEventListener('touchstart', startDrag);
        dragHandle.addEventListener('mousedown', startDrag);
        
        function startDrag(e) {
            if (window.innerWidth >= 768) return;
            
            e.preventDefault();
            const clientY = e.type.includes('touch') ? e.touches[0].clientY : e.clientY;
            startY = clientY;
            startHeight = mapSection.offsetHeight;
            
            document.addEventListener('touchmove', drag);
            document.addEventListener('mousemove', drag);
            document.addEventListener('touchend', endDrag);
            document.addEventListener('mouseup', endDrag);
        }
        
        function drag(e) {
            if (window.innerWidth >= 768) return;
            
            e.preventDefault();
            const clientY = e.type.includes('touch') ? e.touches[0].clientY : e.clientY;
            const deltaY = startY - clientY;
            const newHeight = startHeight + deltaY;
            const windowHeight = window.innerHeight;
            const navbarHeight = document.querySelector('.navbar').offsetHeight;
            const maxHeight = windowHeight - navbarHeight - 100;
            const minHeight = 150;
            
            if (newHeight > maxHeight) {
                mapSection.style.height = maxHeight + 'px';
            } else if (newHeight < minHeight) {
                mapSection.style.height = minHeight + 'px';
            } else {
                mapSection.style.height = newHeight + 'px';
            }
            
            // Toggle collapsed class based on height
            const currentHeight = parseInt(mapSection.style.height);
            const threshold = (maxHeight + minHeight) / 3;
            
            if (currentHeight < threshold) {
                if (!isCollapsed) {
                    mapSection.classList.add('collapsed');
                    isCollapsed = true;
                }
            } else {
                if (isCollapsed) {
                    mapSection.classList.remove('collapsed');
                    isCollapsed = false;
                }
            }
        }
        
        function endDrag() {
            document.removeEventListener('touchmove', drag);
            document.removeEventListener('mousemove', drag);
            document.removeEventListener('touchend', endDrag);
            document.removeEventListener('mouseup', endDrag);

            if (window.innerWidth < 768) {
                const currentHeight = mapSection.offsetHeight;
                const windowHeight = window.innerHeight;
                const navbarHeight = document.querySelector('.navbar').offsetHeight;
                const maxHeight = windowHeight - navbarHeight - 100;
                
                if (currentHeight < maxHeight * 0.4) {
                    mapSection.style.height = '40vh';
                    mapSection.classList.add('collapsed');
                    isCollapsed = true;
                } else if (currentHeight > maxHeight * 0.6) {
                    mapSection.style.height = '70vh';
                    mapSection.classList.remove('collapsed');
                    isCollapsed = false;
                } else {
                    mapSection.style.height = '50vh';
                    mapSection.classList.remove('collapsed');
                    isCollapsed = false;
                }
            }
        }

        let lastScrollTop = 0;
        jobSidebar.addEventListener('scroll', function() {
            if (window.innerWidth >= 768) return;
            
            const scrollTop = this.scrollTop;
            const scrollHeight = this.scrollHeight;
            const clientHeight = this.clientHeight;

            if (scrollTop > lastScrollTop && scrollTop > 50) {
                if (!isCollapsed) {
                    mapSection.classList.add('collapsed');
                    mapSection.style.height = '30vh';
                    isCollapsed = true;
                }
            } 

            else if (scrollTop < lastScrollTop && scrollTop < 30) {
                if (isCollapsed) {
                    mapSection.classList.remove('collapsed');
                    mapSection.style.height = '70vh';
                    isCollapsed = false;
                }
            }
            
            lastScrollTop = scrollTop;
        });
        
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                mapSection.style.height = '';
                mapSection.classList.remove('collapsed');
                sidebarSection.classList.remove('expanded');
                isCollapsed = false;
            } else {
                mapSection.style.height = '70vh';
                mapSection.classList.remove('collapsed');
                isCollapsed = false;
            }
        });
    });

    // Modal handling functions
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
        document.getElementById('complaintDescription').value = '';
    }

    // Close modal when clicking outside
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = 'none';
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            document.getElementById('urgentHelpModal').style.display = 'none';
            document.getElementById('complaintModal').style.display = 'none';
        }
    });
    </script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="{{ asset('js/driver/job-tracking.js') }}"></script>
    <script>
    const DRIVER_CONFIG = {
        UPDATE_INTERVAL: 3000,
        HIGH_ACCURACY: true,
        MAX_AGE: 0,
        TIMEOUT: 10000
    };

    let driverMap;
    let driverMarker;
    let locationWatchId;
    let currentPosition = null;
    let cancellationCheckInterval;
    let completionCheckInterval;
    let notificationCheckInterval;

    // URL configuration - will work on both local and Railway
    const APP_URLS = {
        base: "{{ url('/') }}",
        driver: {
            updateLocation: "{{ route('driver.update.location') }}",
            getBookingStatus: "{{ url('/driver/get-booking-status') }}",
            confirmCompletion: "{{ url('/driver/confirm-completion') }}",
            notifications: "{{ url('/driver/notifications') }}",
            markNotificationRead: "{{ url('/driver/notifications') }}",
            dashboard: "{{ route('driver.dashboard') }}",
            urgentHelp: "{{ url('/driver/report/urgent-help') }}",
            complaint: "{{ url('/driver/report/complaint') }}"
        }
    };

    const bookingData = {
        id: {{ $booking->bookingID }},
        pickup: {
            lat: {{ $booking->pickupLatitude }},
            lng: {{ $booking->pickupLongitude }},
            address: `{{ $booking->pickupLocation }}`
        },
        dropoff: {
            lat: {{ $booking->dropoffLatitude }},
            lng: {{ $booking->dropoffLongitude }},
            address: `{{ $booking->dropoffLocation }}`
        },
        passengerName: `{{ $booking->passenger->fullname ?? 'Passenger' }}`,
        csrfToken: '{{ csrf_token() }}'
    };

    document.addEventListener('DOMContentLoaded', function() {
        console.log('🚗 Initializing driver tracking...');
        console.log('Base URL:', APP_URLS.base);
        console.log('Driver URLs:', APP_URLS.driver);
        
        initializeDriverTracking();
        startNotificationMonitoring();
        startCompletionMonitoring();
    });

    function initializeDriverTracking() {
        initDriverMap();
        startAutomaticLocationUpdates();
    }

    function initDriverMap() {
        console.log('🗺️ Initializing driver map...');
        
        driverMap = L.map('jobMap', {
            zoomControl: false
        }).setView([bookingData.pickup.lat, bookingData.pickup.lng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(driverMap);

        // Pickup marker
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

        L.marker([bookingData.pickup.lat, bookingData.pickup.lng], { icon: pickupIcon })
            .addTo(driverMap)
            .bindPopup(`<strong>📍 PICKUP LOCATION</strong><br>${bookingData.pickup.address}`)
            .openPopup();

        // Dropoff marker
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

        L.marker([bookingData.dropoff.lat, bookingData.dropoff.lng], { icon: dropoffIcon })
            .addTo(driverMap)
            .bindPopup(`<strong>🏁 DROP-OFF LOCATION</strong><br>${bookingData.dropoff.address}`);
    }

    function startAutomaticLocationUpdates() {
        console.log('📍 Starting automatic location updates...');
        
        if (!navigator.geolocation) {
            console.error('❌ Geolocation not supported');
            showLocationStatus('error', 'Geolocation is not supported by your browser');
            return;
        }

        navigator.geolocation.getCurrentPosition(
            (position) => {
                handleNewPosition(position);
                startWatchingPosition();
            },
            (error) => {
                console.error('❌ Initial position error:', error);
                handleLocationError(error);
                tryFallbackLocation();
            },
            {
                enableHighAccuracy: DRIVER_CONFIG.HIGH_ACCURACY,
                timeout: DRIVER_CONFIG.TIMEOUT,
                maximumAge: DRIVER_CONFIG.MAX_AGE
            }
        );
    }

    function startWatchingPosition() {
        locationWatchId = navigator.geolocation.watchPosition(
            (position) => {
                handleNewPosition(position);
            },
            (error) => {
                console.error('❌ Watch position error:', error);
                handleLocationError(error);
            },
            {
                enableHighAccuracy: DRIVER_CONFIG.HIGH_ACCURACY,
                timeout: DRIVER_CONFIG.TIMEOUT,
                maximumAge: DRIVER_CONFIG.MAX_AGE
            }
        );
    }

    function handleNewPosition(position) {
        const lat = position.coords.latitude;
        const lng = position.coords.longitude;
        const accuracy = position.coords.accuracy;
        
        console.log('📍 New position:', { lat, lng, accuracy });
        
        updateDriverMarker(lat, lng);
        sendLocationToServer(lat, lng, accuracy);
        
        showLocationStatus('success', 
            `Location updated - Accuracy: ${accuracy.toFixed(1)}m`,
            `Lat: ${lat.toFixed(6)}, Lng: ${lng.toFixed(6)}`
        );
        
        currentPosition = { lat, lng, accuracy };
    }

    function updateDriverMarker(lat, lng) {
        const driverIcon = L.divIcon({
            className: 'driver-marker',
            html: `
                <div style="position: relative;">
                    <div style="background:#007bff; border:3px solid white; border-radius:50%; width:16px; height:16px; box-shadow:0 2px 8px rgba(0,0,0,0.3);"></div>
                    <div style="position: absolute; top: -22px; left: 50%; transform: translateX(-50%); background: #007bff; color: white; padding: 2px 6px; border-radius: 8px; font-size: 9px; font-weight: bold; white-space: nowrap;">
                        YOU
                    </div>
                </div>
            `,
            iconSize: [16, 38],
            iconAnchor: [8, 16]
        });

        if (!driverMarker) {
            driverMarker = L.marker([lat, lng], { icon: driverIcon })
                .addTo(driverMap)
                .bindPopup(`
                    <div style="text-align: center; min-width: 200px;">
                        <strong>🚗 YOUR LOCATION</strong><br>
                        <hr style="margin: 5px 0;">
                        Real-time GPS position<br>
                        <small>Last update: ${new Date().toLocaleTimeString()}</small>
                    </div>
                `);
        } else {
            driverMarker.setLatLng([lat, lng]);
        }
    }

    function sendLocationToServer(lat, lng, accuracy) {
        const payload = {
            latitude: lat,
            longitude: lng,
            accuracy: accuracy,
            booking_id: bookingData.id,
            _token: bookingData.csrfToken
        };

        fetch(APP_URLS.driver.updateLocation, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': bookingData.csrfToken
            },
            body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('✅ Location saved to database');
            }
        })
        .catch(error => {
            console.error('❌ Error sending location:', error);
        });
    }

    // ==================== CANCELLATION & NOTIFICATION MONITORING ====================
    function startNotificationMonitoring() {
        console.log('🔔 Starting notification monitoring...');
        checkForCancellations();
        checkForNotifications();
        
        cancellationCheckInterval = setInterval(checkForCancellations, 5000);
        notificationCheckInterval = setInterval(checkForNotifications, 10000);
    }

    function checkForCancellations() {
        const url = `${APP_URLS.driver.getBookingStatus}/${bookingData.id}?_t=${Date.now()}`;
        
        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.success && data.booking) {
                    if (data.booking.status === 'cancelled') {
                        handleBookingCancellation(data.booking);
                    }
                }
            })
            .catch(error => {
                console.error('Error checking booking status:', error);
            });
    }

    function checkForNotifications() {
        fetch(APP_URLS.driver.notifications)
            .then(response => response.json())
            .then(data => {
                if (data.success && data.notifications) {
                    data.notifications.forEach(notification => {
                        if (notification.type === 'booking_cancelled' && !notification.read_at) {
                            showCancellationNotification(notification);
                            markNotificationAsRead(notification.id);
                        } else if (notification.type === 'passenger_completed' && !notification.read_at) {
                            showCompletionNotification(notification);
                            markNotificationAsRead(notification.id);
                        }
                    });
                }
            })
            .catch(error => {
                console.error('Error checking notifications:', error);
            });
    }

    function handleBookingCancellation(booking) {
        console.log('❌ Booking cancelled by passenger');
        
        stopAllTracking();
        showCancellationAlert('This booking has been cancelled by the passenger.');
        updateBookingStatus('cancelled');
        
        const confirmBtn = document.getElementById('confirmCompletionBtn');
        if (confirmBtn) {
            confirmBtn.disabled = true;
            confirmBtn.innerHTML = '<i class="fas fa-ban"></i> Trip Cancelled';
            confirmBtn.style.background = '#6c757d';
        }
    }

    function showCancellationAlert(message) {
        let alertSection = document.getElementById('cancellationAlert');
        if (!alertSection) {
            alertSection = document.createElement('div');
            alertSection.id = 'cancellationAlert';
            alertSection.style.cssText = `
                background: #f8d7da;
                color: #721c24;
                padding: 15px;
                border-radius: 8px;
                border: 1px solid #f5c6cb;
                margin: 15px 0;
                text-align: center;
            `;
            document.querySelector('.container').insertBefore(alertSection, document.querySelector('.container').firstChild);
        }
        
        alertSection.innerHTML = `
            <div style="display: flex; align-items: center; justify-content: center; gap: 10px;">
                <i class="fas fa-exclamation-triangle" style="font-size: 24px;"></i>
                <div>
                    <h4 style="margin: 0; color: #721c24;">Booking Cancelled</h4>
                    <p style="margin: 5px 0 0 0;">${message}</p>
                </div>
            </div>
        `;
        alertSection.style.display = 'block';
    }

    function showCancellationNotification(notification) {
        showToast('error', notification.title, notification.message);
    }

    function showCompletionNotification(notification) {
        showToast('success', notification.title, notification.message);
        checkCompletionStatus();
    }

    function showToast(type, title, message) {
        const toast = document.createElement('div');
        toast.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${type === 'error' ? '#f8d7da' : '#d4edda'};
            color: ${type === 'error' ? '#721c24' : '#155724'};
            padding: 15px;
            border-radius: 8px;
            border: 1px solid ${type === 'error' ? '#f5c6cb' : '#c3e6cb'};
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            z-index: 10000;
            max-width: 400px;
            animation: slideIn 0.3s ease-out;
        `;
        
        toast.innerHTML = `
            <div style="display: flex; align-items: flex-start; gap: 10px;">
                <i class="fas fa-${type === 'error' ? 'exclamation-triangle' : 'check-circle'}" style="font-size: 18px;"></i>
                <div>
                    <strong>${title}</strong>
                    <div style="font-size: 0.9rem; margin-top: 5px;">${message}</div>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" style="background: none; border: none; font-size: 16px; cursor: pointer; color: inherit;">
                    &times;
                </button>
            </div>
        `;
        
        document.body.appendChild(toast);
        setTimeout(() => {
            if (toast.parentNode) {
                toast.style.animation = 'slideOut 0.3s ease-in';
                setTimeout(() => toast.remove(), 300);
            }
        }, 8000);
    }

    function markNotificationAsRead(notificationId) {
        const url = `${APP_URLS.driver.markNotificationRead}/${notificationId}/read`;
        
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': bookingData.csrfToken
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('✅ Notification marked as read');
            }
        })
        .catch(error => {
            console.error('Error marking notification as read:', error);
        });
    }

    // ==================== COMPLETION SYSTEM ====================
    function startCompletionMonitoring() {
        console.log('✅ Starting completion monitoring...');
        checkCompletionStatus();
        completionCheckInterval = setInterval(checkCompletionStatus, 8000);
    }

    function checkCompletionStatus() {
        const url = `${APP_URLS.driver.getBookingStatus}/${bookingData.id}?_t=${Date.now()}`;
        
        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.success && data.booking) {
                    updateCompletionStatus(data.booking);
                }
            })
            .catch(error => {
                console.error('Error checking completion status:', error);
            });
    }

    function updateCompletionStatus(booking) {
        const status = booking.status;
        const driverCompleted = booking.driver_completed_at;
        const passengerCompleted = booking.passenger_completed_at;
        
        let completionStatus = 'pending';
        
        if (driverCompleted && passengerCompleted) {
            completionStatus = 'both_confirmed';
        } else if (driverCompleted && !passengerCompleted) {
            completionStatus = 'driver_confirmed';
        } else if (!driverCompleted && passengerCompleted) {
            completionStatus = 'passenger_confirmed';
        }
        
        updateCompletionUI(completionStatus, status === 'completed');
    }

    function updateCompletionUI(status, isCompleted) {
        const statusContainer = document.getElementById('completionStatus');
        const confirmBtn = document.getElementById('confirmCompletionBtn');
        
        if (!statusContainer) return;
        
        const statusMessages = {
            'pending': `
                <div style="color: #6c757d;">
                    <i class="fas fa-clock"></i> <strong>Status:</strong> Waiting for completion confirmation...
                </div>
            `,
            'driver_confirmed': `
                <div style="color: #007bff;">
                    <i class="fas fa-user-check"></i> <strong>Status:</strong> You have confirmed completion
                </div>
                <div style="font-size: 0.8rem; color: #6c757d; margin-top: 5px;">
                    Waiting for passenger confirmation...
                </div>
            `,
            'passenger_confirmed': `
                <div style="color: #28a745;">
                    <i class="fas fa-user-check"></i> <strong>Status:</strong> Passenger has confirmed completion
                </div>
                <div style="font-size: 0.8rem; color: #6c757d; margin-top: 5px;">
                    Please confirm completion to finish the trip
                </div>
            `,
            'both_confirmed': `
                <div style="color: #28a745;">
                    <i class="fas fa-check-double"></i> <strong>Status:</strong> Trip completed successfully!
                </div>
                <div style="font-size: 0.8rem; color: #6c757d; margin-top: 5px;">
                    Redirecting to dashboard...
                </div>
            `
        };
        
        statusContainer.innerHTML = statusMessages[status] || statusMessages.pending;
        
        if (confirmBtn) {
            if (isCompleted || status === 'both_confirmed') {
                confirmBtn.innerHTML = '<i class="fas fa-check-double"></i> Trip Completed';
                confirmBtn.disabled = true;
                confirmBtn.style.background = '#6c757d';

                setTimeout(() => {
                    window.location.href = APP_URLS.driver.dashboard;
                }, 3000);
            } else if (status === 'driver_confirmed') {
                confirmBtn.innerHTML = '<i class="fas fa-clock"></i> Waiting for Passenger';
                confirmBtn.disabled = true;
                confirmBtn.style.background = '#ffc107';
                confirmBtn.style.color = '#212529';
            } else if (status === 'passenger_confirmed') {
                confirmBtn.innerHTML = '<i class="fas fa-check-circle"></i> Confirm Completion';
                confirmBtn.disabled = false;
                confirmBtn.style.background = '#28a745';
            } else {
                confirmBtn.innerHTML = '<i class="fas fa-check-circle"></i> Confirm Completion';
                confirmBtn.disabled = false;
                confirmBtn.style.background = '#28a745';
            }
        }
    }

    function confirmCompletion() {
        if (!confirm('Are you sure you want to confirm job completion?\n\nThis will notify the passenger to confirm. The trip will only be completed when both you and the passenger confirm.')) {
            return;
        }

        const confirmBtn = document.getElementById('confirmCompletionBtn');
        const originalText = confirmBtn.innerHTML;
        const originalBackground = confirmBtn.style.background;
        
        confirmBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Confirming...';
        confirmBtn.disabled = true;

        const url = `${APP_URLS.driver.confirmCompletion}/${bookingData.id}`;
        
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': bookingData.csrfToken
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            if (data.success) {
                showCompletionMessage(data.message, 'success');
                updateCompletionStatus(data.booking);
                
                if (data.is_completed) {
                    stopAllTracking();
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
            confirmBtn.style.background = originalBackground;
        });
    }

    function showCompletionMessage(message, type) {
        let messageContainer = document.getElementById('completionMessage');
        if (!messageContainer) {
            messageContainer = document.createElement('div');
            messageContainer.id = 'completionMessage';
            const completionSection = document.querySelector('.completion-section');
            if (completionSection) {
                completionSection.appendChild(messageContainer);
            }
        }
        
        const colors = {
            'success': '#28a745',
            'error': '#dc3545'
        };
        const backgrounds = {
            'success': '#d4edda',
            'error': '#f8d7da'
        };
        const borders = {
            'success': '#c3e6cb',
            'error': '#f5c6cb'
        };

        messageContainer.innerHTML = `
            <div style="color: ${colors[type]}; font-weight: 600; padding: 10px; background: ${backgrounds[type]}; border-radius: 8px; border: 1px solid ${borders[type]}; margin-top: 10px;">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'}"></i> ${message}
            </div>
        `;
    }

    // ==================== REPORTING FUNCTIONS ====================
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
        document.getElementById('complaintDescription').value = '';
    }

    async function safeApiCall(url, options = {}) {
        try {
            console.log('🔗 Making API call to:', url);
            
            const response = await fetch(url, {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': bookingData.csrfToken,
                    ...options.headers
                },
                ...options
            });

            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                const text = await response.text();
                console.error('❌ Non-JSON response received:', text.substring(0, 200));
                
                if (text.includes('<!DOCTYPE html>') || text.includes('<html')) {
                    throw new Error('API route not found or returns HTML page');
                }
                
                throw new Error('Server returned non-JSON response');
            }

            const data = await response.json();
            console.log('✅ API response:', data);
            return data;
            
        } catch (error) {
            console.error('❌ API call failed:', error);
            throw error;
        }
    }

    async function sendUrgentHelp() {
        const notes = document.getElementById('urgentHelpNotes').value;
        
        const btn = event.target;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
        btn.disabled = true;

        try {
            console.log('🚨 Sending urgent help request...');
            
            // Try multiple possible endpoints
            const endpoints = [
                APP_URLS.driver.urgentHelp,
                `${APP_URLS.base}/driver/report/urgent-help`,
                `${APP_URLS.base}/driver/urgent-help`,
                `${APP_URLS.base}/report/urgent-help`
            ];

            let lastError = null;
            
            for (const endpoint of endpoints) {
                try {
                    console.log(`🔄 Trying endpoint: ${endpoint}`);
                    
                    const data = await safeApiCall(endpoint, {
                        method: 'POST',
                        body: JSON.stringify({
                            booking_id: bookingData.id,
                            additional_notes: notes,
                            user_type: 'driver'
                        })
                    });
                    
                    if (data.success) {
                        showNotification('success', data.message || 'Help request sent successfully! Administrators have been notified.');
                        hideUrgentHelpModal();
                        return;
                    } else {
                        lastError = new Error(data.message || 'Request failed');
                    }
                } catch (error) {
                    console.log(`❌ Endpoint ${endpoint} failed:`, error.message);
                    lastError = error;
                    continue;
                }
            }
            
            throw lastError || new Error('All API endpoints failed');

        } catch (error) {
            console.error('❌ Error sending urgent help:', error);
            
            let userMessage = 'Failed to send help request. ';
            
            if (error.message.includes('route not found') || error.message.includes('HTML page')) {
                userMessage += 'The reporting system is currently unavailable. Please contact support directly.';
            } else if (error.message.includes('Network error')) {
                userMessage += 'Please check your internet connection and try again.';
            } else {
                userMessage += 'Please try again or contact support.';
            }
            
            showNotification('error', userMessage);
        } finally {
            btn.innerHTML = originalText;
            btn.disabled = false;
        }
    }

    async function sendComplaint() {
        const type = document.getElementById('complaintType').value;
        const severity = document.getElementById('complaintSeverity').value;
        const description = document.getElementById('complaintDescription').value;

        if (!description.trim()) {
            showNotification('error', 'Please provide a description of the issue');
            return;
        }

        const btn = event.target;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';
        btn.disabled = true;

        try {
            console.log('📝 Sending complaint...', {
                booking_id: bookingData.id,
                complaint_type: type,
                severity: severity,
                description: description
            });

            // Try multiple possible endpoints
            const endpoints = [
                APP_URLS.driver.complaint,
                `${APP_URLS.base}/driver/report/complaint`,
                `${APP_URLS.base}/driver/complaint`,
                `${APP_URLS.base}/report/complaint`
            ];

            let lastError = null;
            
            for (const endpoint of endpoints) {
                try {
                    console.log(`🔄 Trying endpoint: ${endpoint}`);
                    
                    const data = await safeApiCall(endpoint, {
                        method: 'POST',
                        body: JSON.stringify({
                            booking_id: bookingData.id,
                            complaint_type: type,
                            severity: severity,
                            description: description,
                            user_type: 'driver'
                        })
                    });
                    
                    if (data.success) {
                        showNotification('success', data.message || 'Complaint submitted successfully! We will review it shortly.');
                        hideComplaintModal();
                        return;
                    } else {
                        lastError = new Error(data.message || 'Submission failed');
                    }
                } catch (error) {
                    console.log(`❌ Endpoint ${endpoint} failed:`, error.message);
                    lastError = error;
                    continue;
                }
            }
            
            throw lastError || new Error('All API endpoints failed');

        } catch (error) {
            console.error('❌ Error sending complaint:', error);
            
            let userMessage = 'Failed to submit complaint. ';
            
            if (error.message.includes('route not found') || error.message.includes('HTML page')) {
                userMessage += 'The complaint system is currently unavailable. Please contact support directly.';
            } else if (error.message.includes('Network error')) {
                userMessage += 'Please check your internet connection and try again.';
            } else {
                userMessage += 'Please try again or contact support.';
            }
            
            showNotification('error', userMessage);
        } finally {
            btn.innerHTML = originalText;
            btn.disabled = false;
        }
    }

    function storeReportLocally(type, data) {
        try {
            const reports = JSON.parse(localStorage.getItem('pending_reports') || '[]');
            reports.push({
                type: type,
                data: data,
                timestamp: new Date().toISOString(),
                booking_id: bookingData.id
            });
            localStorage.setItem('pending_reports', JSON.stringify(reports));
            console.log('💾 Report stored locally:', type);
            return true;
        } catch (error) {
            console.error('Failed to store report locally:', error);
            return false;
        }
    }

    function showNotification(type, message) {
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
        `;
        
        notification.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'}"></i>
            <span>${message}</span>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 300);
        }, 5000);
    }

    // ==================== UTILITY FUNCTIONS ====================
    function updateBookingStatus(status) {
        const statusBadge = document.querySelector('.status-badge');
        const trackingIndicator = document.querySelector('.tracking-indicator');
        const trackingStatus = document.querySelector('.tracking-status span');
        
        if (statusBadge) {
            statusBadge.textContent = status.toUpperCase();
            statusBadge.className = `status-badge ${status}`;
        }
        
        if (trackingIndicator) {
            trackingIndicator.style.background = status === 'cancelled' ? '#dc3545' : 
                                            status === 'completed' ? '#6c757d' : '#28a745';
        }
        
        if (trackingStatus) {
            trackingStatus.textContent = status === 'cancelled' ? 'Trip Cancelled' : 
                                    status === 'completed' ? 'Trip Completed' : 'Live Tracking Active';
        }
    }

    function stopAllTracking() {
        if (locationWatchId && navigator.geolocation) {
            navigator.geolocation.clearWatch(locationWatchId);
        }
        if (cancellationCheckInterval) {
            clearInterval(cancellationCheckInterval);
        }
        if (completionCheckInterval) {
            clearInterval(completionCheckInterval);
        }
        if (notificationCheckInterval) {
            clearInterval(notificationCheckInterval);
        }
    }

    function redirectToDashboard() {
        window.location.href = APP_URLS.driver.dashboard;
    }

    function tryFallbackLocation() {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                handleNewPosition(position);
            },
            (error) => {
                console.error('❌ Fallback also failed:', error);
                showLocationStatus('error', 
                    'Cannot access your location. Please check browser permissions and ensure location services are enabled.'
                );
            },
            {
                enableHighAccuracy: false,
                timeout: 15000,
                maximumAge: 300000
            }
        );
    }

    function handleLocationError(error) {
        let errorMessage = 'Location error: ';
        
        switch(error.code) {
            case error.PERMISSION_DENIED:
                errorMessage = 'Location access denied. Please enable location permissions in your browser settings.';
                break;
            case error.POSITION_UNAVAILABLE:
                errorMessage = 'Location unavailable. Please check your GPS signal and try again.';
                break;
            case error.TIMEOUT:
                errorMessage = 'Location request timed out. Please check your internet connection.';
                break;
            default:
                errorMessage = 'An unknown location error occurred.';
                break;
        }
        
        showLocationStatus('error', errorMessage);
    }

    function showLocationStatus(type, message, details = '') {
        const statusIcons = {
            'success': '<i class="fas fa-check-circle" style="color: #28a745;"></i>',
            'error': '<i class="fas fa-exclamation-triangle" style="color: #dc3545;"></i>',
            'warning': '<i class="fas fa-info-circle" style="color: #ffc107;"></i>'
        };

        let locationStatus = document.getElementById('locationStatus');
        if (!locationStatus) {
            locationStatus = document.createElement('div');
            locationStatus.id = 'locationStatus';
            locationStatus.className = 'location-status';
            document.querySelector('.info-card').appendChild(locationStatus);
        }

        let statusHTML = `<p>${statusIcons[type]} ${message}</p>`;
        if (details) {
            statusHTML += `<p style="font-size: 0.8rem; color: #6c757d; margin-top: 5px;">${details}</p>`;
        }

        locationStatus.innerHTML = statusHTML;
    }

    function addManualControls() {
        const controls = document.createElement('div');
        controls.style.cssText = `
            position: fixed;
            top: 10px;
            right: 10px;
            background: white;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            z-index: 1000;
        `;
        

    }

    function simulateMovement() {
        if (!currentPosition) {
            currentPosition = {
                lat: bookingData.pickup.lat,
                lng: bookingData.pickup.lng,
                accuracy: 10
            };
        }
        
        currentPosition.lat += (Math.random() - 0.5) * 0.001;
        currentPosition.lng += (Math.random() - 0.5) * 0.001;
        
        updateDriverMarker(currentPosition.lat, currentPosition.lng);
        sendLocationToServer(currentPosition.lat, currentPosition.lng, currentPosition.accuracy);
        
        console.log('🎮 Simulated movement:', currentPosition);
    }

    function forceLocationUpdate() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    handleNewPosition(position);
                },
                (error) => {
                    console.error('Force update failed:', error);
                },
                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                }
            );
        }
    }

    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = 'none';
        }
    });

    window.addEventListener('beforeunload', stopAllTracking);
    
    // Add CSS animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOutRight {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
        
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 10000;
            align-items: center;
            justify-content: center;
        }
        
        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 12px;
            max-width: 500px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
        }
        
        .modal-header {
            border-bottom: 2px solid #f8f9fa;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        
        .modal-footer {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 20px;
            border-top: 1px solid #e9ecef;
            padding-top: 20px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #e9ecef;
            border-radius: 6px;
            resize: vertical;
        }
        
        .form-group textarea {
            min-height: 100px;
        }
        
        .data-preview {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            margin-top: 15px;
        }
        
        .data-preview h4 {
            margin-bottom: 10px;
            font-size: 0.9rem;
            color: #495057;
        }
        
        .data-preview ul {
            font-size: 0.8rem;
            color: #6c757d;
            list-style: none;
            padding: 0;
        }
        
        .btn-secondary {
            padding: 10px 20px;
            border: 1px solid #6c757d;
            background: transparent;
            color: #6c757d;
            border-radius: 6px;
            cursor: pointer;
        }
        
        .btn-warning {
            padding: 10px 20px;
            background: #ffc107;
            color: #212529;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .alert-warning {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }
    `;
    document.head.appendChild(style);

    setTimeout(addManualControls, 2000);
    </script>
</body>
</html>