<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin History and Report</title>
    @vite('resources/css/admin/report.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .reports-container {
            margin-top: 2rem;
        }
        
        .reports-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
            gap: 1.5rem;
        }
        
        .report-card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 1.5rem;
            background: white;
        }
        
        .report-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .report-type-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: bold;
        }
        
        .report-type-badge.urgent_help {
            background: #dc3545;
            color: white;
        }
        
        .report-type-badge.complaint {
            background: #ffc107;
            color: #212529;
        }
        
        .report-status {
            padding: 0.25rem 0.75rem;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: bold;
        }
        
        .report-status.pending {
            background: #ffc107;
            color: #212529;
        }
        
        .report-status.reviewed {
            background: #17a2b8;
            color: white;
        }
        
        .report-status.resolved {
            background: #28a745;
            color: white;
        }
        
        .report-title {
            margin: 0 0 1rem 0;
            color: #333;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .urgent-icon {
            color: #dc3545;
        }
        
        .complaint-icon {
            color: #ffc107;
        }
        
        .report-meta p {
            margin: 0.25rem 0;
            color: #666;
            font-size: 0.9rem;
        }
        
        .report-description, .admin-notes {
            margin: 1rem 0;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 4px;
        }
        
        .report-description strong, .admin-notes strong {
            color: #333;
            display: block;
            margin-bottom: 0.5rem;
        }
        
        .description-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .description-list li {
            padding: 0.25rem 0;
            border-bottom: 1px solid #e9ecef;
        }
        
        .description-list li:last-child {
            border-bottom: none;
        }
        
        .description-list .list-label {
            font-weight: 600;
            color: #495057;
            display: inline-block;
            min-width: 120px;
        }
        
        .description-list .list-value {
            color: #6c757d;
        }
        
        .report-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #f0f0f0;
        }
        
        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.9rem;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-primary {
            background: #007bff;
            color: white;
        }
        
        .urgent-badge {
            background: #dc3545;
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: bold;
        }
        
        .hidden {
            display: none !important;
        }
        
        .report-stats {
            display: flex;
            gap: 1rem;
            margin-top: 0.5rem;
        }
        
        .stat {
            padding: 0.25rem 0.75rem;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: bold;
        }
        
        .stat.pending {
            background: #ffc107;
            color: #212529;
        }
        
        .stat.reviewed {
            background: #17a2b8;
            color: white;
        }
        
        .stat.resolved {
            background: #28a745;
            color: white;
        }

        /* Pagination Styles */
        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 2rem;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .pagination-info {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .pagination-controls {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .pagination-btn {
            padding: 0.5rem 1rem;
            border: 1px solid #dee2e6;
            background: white;
            color: #007bff;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .pagination-btn:hover:not(:disabled) {
            background: #007bff;
            color: white;
        }

        .pagination-btn:disabled {
            color: #6c757d;
            cursor: not-allowed;
            opacity: 0.6;
        }

        .pagination-indicators {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .page-indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #dee2e6;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .page-indicator.active {
            background: #007bff;
            transform: scale(1.2);
        }

        .section-content {
            min-height: 400px;
        }

        .users-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
        }

        .user-card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 1.5rem;
            background: white;
        }

        .no-results {
            text-align: center;
            padding: 3rem;
            color: #6c757d;
        }

        .no-results i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #dee2e6;
        }
    </style>
</head>
<body>
    <header class="admin-header">
        <div class="header-left">
            <h1>Admin History and Reports</h1>
        </div>
        <nav class="admin-nav">
            <a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="{{ route('admin.passengers') }}"><i class="fas fa-users"></i> Passengers</a>
            <a href="{{ route('admin.drivers') }}"><i class="fas fa-id-card"></i> Drivers</a>
            
            <div class="more-menu-container">
                <button class="more-menu-trigger" id="moreMenuTrigger">
                    <i class="fas fa-ellipsis-h"></i> More
                </button>
                
                <div class="more-menu-dropdown" id="moreMenuDropdown">
                    <div class="more-menu-header">
                        <h3>More Options</h3>
                        <button class="back-btn" id="backButton">
                            <i class="fas fa-arrow-left"></i> Back
                        </button>
                    </div>
                    
                    <nav class="vertical-nav">
                        <a href="{{ route('admin.analytics') }}" class="nav-item">
                            <i class="fas fa-chart-bar"></i>
                            <span>Analytics</span>
                        </a>
                        
                        <div class="nav-section">
                            <h4>Booking Management</h4>
                            <a href="{{ route('admin.bookings.current') }}" class="nav-item">
                                <i class="fas fa-clock"></i>
                                <span>Current Bookings</span>
                            </a>
                            <a href="{{ route('admin.bookings.completed') }}" class="nav-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Completed Bookings</span>
                            </a>
                            <a href="{{ route('admin.bookings.cancelled') }}" class="nav-item">
                                <i class="fas fa-times-circle"></i>
                                <span>Cancelled Bookings</span>
                            </a>
                        </div>
                        
                        <a href="{{ route('admin.reports') }}" class="nav-item">
                            <i class="fas fa-file-alt"></i>
                            <span>Reports / History</span>
                        </a>
                        
                        <a href="{{ route('admin.notifications') }}" class="nav-item">
                            <i class="fas fa-bell"></i>
                            <span>Notifications</span>
                        </a>
                    </nav>
                </div>
            </div>
        </nav>
    </header>

    <main class="admin-main">
        <div class="search-container">
            <div class="search-box">
                <input type="text" id="searchInput" class="search-input" placeholder="Search passengers and drivers by name...">
            </div>
            <button class="search-button" id="searchButton">
                <i class="fas fa-search"></i> Search
            </button>
        </div>

        <div class="tab-content active" id="history-tab">
            <!-- Passengers Section -->
            <section class="history-section">
                <div class="section-header">
                    <h2 class="section-title">Passengers History</h2>
                    <span class="section-badge" id="passengers-count">{{ $passengers->count() }} Passengers</span>
                </div>
                
                <div class="section-content">
                    <div class="users-grid" id="passengers-grid">
                        @foreach($passengers as $passenger)
                        <div class="user-card passenger-card" data-name="{{ strtolower($passenger->fullname) }}">
                            <div class="user-header">
                                <div class="user-info">
                                    <h3>{{ $passenger->fullname }}</h3>
                                    <p><i class="fas fa-envelope"></i> {{ $passenger->email }}</p>
                                    <p><i class="fas fa-phone"></i> {{ $passenger->phone ?? 'N/A' }}</p>
                                    <p><i class="fas fa-calendar"></i> Joined {{ $passenger->created_at->format('M d, Y') }}</p>
                                </div>
                                <div class="user-stats">
                                    <div class="user-badge">Passenger</div>
                                    <div class="bookings-count">{{ $passenger->ongoing_bookings_count + $passenger->completed_bookings_count + $passenger->cancelled_bookings_count }}</div>
                                    <div class="bookings-label">Total Bookings</div>
                                </div>
                            </div>
                            
                            <div class="booking-stats">
                                <div class="stat-row">
                                    <span class="stat-label">Ongoing:</span>
                                    <span class="stat-value">{{ $passenger->ongoing_bookings_count }}</span>
                                    @if($passenger->ongoing_bookings_count > 0)
                                    <a href="{{ route('admin.ongoing.bookings', ['type' => 'passenger', 'id' => $passenger->id]) }}" class="stat-link">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    @endif
                                </div>
                                <div class="stat-row">
                                    <span class="stat-label">Completed:</span>
                                    <span class="stat-value">{{ $passenger->completed_bookings_count }}</span>
                                    @if($passenger->completed_bookings_count > 0)
                                    <a href="{{ route('admin.view.completed.bookings', ['type' => 'passenger', 'id' => $passenger->id]) }}" class="stat-link">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    @endif
                                </div>
                                <div class="stat-row">
                                    <span class="stat-label">Cancelled:</span>
                                    <span class="stat-value">{{ $passenger->cancelled_bookings_count }}</span>
                                    @if($passenger->cancelled_bookings_count > 0)
                                    <a href="{{ route('admin.view.cancelled.bookings', ['type' => 'passenger', 'id' => $passenger->id]) }}" class="stat-link">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    @endif
                                </div>
                            </div>
                            
                            @if($passenger->ongoing_bookings_count == 0 && $passenger->completed_bookings_count == 0 && $passenger->cancelled_bookings_count == 0)
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="fas fa-clipboard-list"></i>
                                    </div>
                                    <h4 class="empty-title">No Bookings</h4>
                                    <p class="empty-text">This passenger hasn't made any bookings yet.</p>
                                </div>
                            @endif
                        </div>
                        @endforeach
                    </div>

                    @if($passengers->count() === 0)
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-users-slash"></i>
                            </div>
                            <h3 class="empty-title">No Passengers Found</h3>
                            <p class="empty-text">There are no passengers in the system yet.</p>
                        </div>
                    @endif

                    <!-- Passengers Pagination -->
                    @if($passengers->count() > 6)
                    <div class="pagination-container" id="passengers-pagination">
                        <div class="pagination-info" id="passengers-pagination-info">
                            Showing 1-6 of {{ $passengers->count() }} passengers
                        </div>
                        <div class="pagination-controls">
                            <button class="pagination-btn" id="passengers-prev-btn" disabled>
                                <i class="fas fa-chevron-left"></i> Previous
                            </button>
                            <div class="pagination-indicators" id="passengers-indicators">
                                <!-- Indicators will be generated by JavaScript -->
                            </div>
                            <button class="pagination-btn" id="passengers-next-btn">
                                Next <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                    @endif
                </div>
            </section>

            <!-- Drivers Section -->
            <section class="history-section">
                <div class="section-header">
                    <h2 class="section-title">Drivers History</h2>
                    <span class="section-badge" id="drivers-count">{{ $drivers->count() }} Drivers</span>
                </div>
                
                <div class="section-content">
                    <div class="users-grid" id="drivers-grid">
                        @foreach($drivers as $driver)
                        <div class="user-card driver-card" data-name="{{ strtolower($driver->fullname) }}">
                            <div class="user-header">
                                <div class="user-info">
                                    <h3>{{ $driver->fullname }}</h3>
                                    <p><i class="fas fa-envelope"></i> {{ $driver->email }}</p>
                                    <p><i class="fas fa-phone"></i> {{ $driver->phone ?? 'N/A' }}</p>
                                    <p><i class="fas fa-car"></i> {{ $driver->vehicleMake ?? 'N/A' }} {{ $driver->vehicleModel ?? '' }}</p>
                                    <p><i class="fas fa-id-card"></i> {{ $driver->is_approved ? 'Approved' : 'Pending Approval' }}</p>
                                </div>
                                <div class="user-stats">
                                    <div class="user-badge">Driver</div>
                                    <div class="bookings-count">{{ $driver->ongoing_bookings_count + $driver->completed_bookings_count + $driver->cancelled_bookings_count }}</div>
                                    <div class="bookings-label">Total Bookings</div>
                                </div>
                            </div>
                            
                            <div class="booking-stats">
                                <div class="stat-row">
                                    <span class="stat-label">Assigned:</span>
                                    <span class="stat-value">{{ $driver->ongoing_bookings_count }}</span>
                                    @if($driver->ongoing_bookings_count > 0)
                                    <a href="{{ route('admin.ongoing.bookings', ['type' => 'driver', 'id' => $driver->id]) }}" class="stat-link">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    @endif
                                </div>
                                <div class="stat-row">
                                    <span class="stat-label">Completed:</span>
                                    <span class="stat-value">{{ $driver->completed_bookings_count }}</span>
                                    @if($driver->completed_bookings_count > 0)
                                    <a href="{{ route('admin.view.completed.bookings', ['type' => 'driver', 'id' => $driver->id]) }}" class="stat-link">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    @endif
                                </div>
                                <div class="stat-row">
                                    <span class="stat-label">Cancelled:</span>
                                    <span class="stat-value">{{ $driver->cancelled_bookings_count }}</span>
                                    @if($driver->cancelled_bookings_count > 0)
                                    <a href="{{ route('admin.view.cancelled.bookings', ['type' => 'driver', 'id' => $driver->id]) }}" class="stat-link">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    @endif
                                </div>
                            </div>
                            
                            @if($driver->ongoing_bookings_count == 0 && $driver->completed_bookings_count == 0 && $driver->cancelled_bookings_count == 0)
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="fas fa-clipboard-list"></i>
                                    </div>
                                    <h4 class="empty-title">No Assignments</h4>
                                    <p class="empty-text">This driver doesn't have any bookings assigned.</p>
                                </div>
                            @endif
                        </div>
                        @endforeach
                    </div>

                    @if($drivers->count() === 0)
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-id-card-alt"></i>
                            </div>
                            <h3 class="empty-title">No Drivers Found</h3>
                            <p class="empty-text">There are no drivers in the system yet.</p>
                        </div>
                    @endif

                    <!-- Drivers Pagination -->
                    @if($drivers->count() > 6)
                    <div class="pagination-container" id="drivers-pagination">
                        <div class="pagination-info" id="drivers-pagination-info">
                            Showing 1-6 of {{ $drivers->count() }} drivers
                        </div>
                        <div class="pagination-controls">
                            <button class="pagination-btn" id="drivers-prev-btn" disabled>
                                <i class="fas fa-chevron-left"></i> Previous
                            </button>
                            <div class="pagination-indicators" id="drivers-indicators">
                                <!-- Indicators will be generated by JavaScript -->
                            </div>
                            <button class="pagination-btn" id="drivers-next-btn">
                                Next <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                    @endif
                </div>
            </section>

            <!-- REPORTS SECTION -->
            <section class="history-section">
                <div class="section-header">
                    <h2 class="section-title">Reports & Notifications</h2>
                    <span class="section-badge" id="reports-count">{{ $reports->count() }} Reports</span>
                </div>
                
                <div class="section-content">
                    <div class="reports-container">
                        <div class="reports-grid" id="reports-grid">
                            @foreach($reports as $report)
                            <div class="report-card" data-status="{{ $report->status }}">
                                <div class="report-header">
                                    <div class="report-type-badge {{ $report->report_type }}">
                                        {{ $report->getReportTypeDisplay() }}
                                    </div>
                                    <div class="report-status {{ $report->status }}">
                                        {{ ucfirst($report->status) }}
                                    </div>
                                </div>
                                
                                <div class="report-content">
                                    <h3 class="report-title">
                                        @if($report->report_type === 'urgent_help')
                                            <i class="fas fa-exclamation-triangle urgent-icon"></i>
                                        @else
                                            <i class="fas fa-flag complaint-icon"></i>
                                        @endif
                                        Report #{{ $report->id }}
                                    </h3>
                                    
                                    <div class="report-meta">
                                        <p><strong>Booking:</strong> {{ $report->booking_id }}</p>
                                        <p><strong>Reporter:</strong> 
                                            {{ $report->reporter->fullname ?? 'Unknown' }} 
                                            ({{ $report->reporter_type }})
                                        </p>
                                        <p><strong>Reported:</strong> {{ $report->created_at->format('M d, Y H:i') }}</p>
                                    </div>
                                    
                                    <div class="report-description">
                                        <strong>Description:</strong>
                                        @php
                                            $description = $report->description;
                                            $lines = explode("\n", $description);
                                            $filteredLines = [];
                                            
                                            foreach ($lines as $line) {
                                                $line = trim($line);
                                                if (empty($line)) continue;
                                                
                                                if (str_contains($line, 'COMPLAINT REPORT') || 
                                                    str_contains($line, 'URGENT HELP REQUESTED') ||
                                                    str_contains($line, 'Booking:') && str_contains($description, 'Booking:') ||
                                                    str_contains($line, 'Reporter:') && str_contains($description, 'Reporter:') ||
                                                    str_contains($line, 'Status:') ||
                                                    str_contains($line, 'Service:')) {
                                                    continue;
                                                }
                                                
                                                $line = str_replace('Description:', '', $line);
                                                $line = trim($line);
                                                
                                                if (!empty($line)) {
                                                    $filteredLines[] = $line;
                                                }
                                            }
                                            
                                            if (!empty($filteredLines)) {
                                                echo '<ul class="description-list">';
                                                foreach ($filteredLines as $line) {
                                                    if (strpos($line, ':') !== false) {
                                                        $parts = explode(':', $line, 2);
                                                        $key = trim($parts[0]);
                                                        $value = trim($parts[1] ?? '');
                                                        echo '<li><span class="list-label">' . e($key) . ':</span> <span class="list-value">' . e($value) . '</span></li>';
                                                    } else {
                                                        echo '<li><span class="list-label">Details:</span> <span class="list-value">' . e($line) . '</span></li>';
                                                    }
                                                }
                                                echo '</ul>';
                                            } else {
                                                echo '<p>' . nl2br(e($description)) . '</p>';
                                            }
                                        @endphp
                                    </div>
                                    
                                    @if($report->admin_notes)
                                    <div class="admin-notes">
                                        <strong>Admin Notes:</strong>
                                        <p>{{ $report->admin_notes }}</p>
                                    </div>
                                    @endif
                                </div>
                                
                                <div class="report-actions">
                                    <a href="{{ route('admin.reports.show', $report->id) }}" class="btn btn-primary">
                                        <i class="fas fa-eye"></i> View Details
                                    </a>
                                    
                                    @if($report->status === 'pending')
                                    <span class="urgent-badge">NEEDS ATTENTION</span>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>

                        @if($reports->count() === 0)
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-flag"></i>
                                </div>
                                <h3 class="empty-title">No Reports Yet</h3>
                                <p class="empty-text">There are no reports or notifications at this time.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Reports Pagination -->
                    @if($reports->count() > 3)
                    <div class="pagination-container" id="reports-pagination">
                        <div class="pagination-info" id="reports-pagination-info">
                            Showing 1-3 of {{ $reports->count() }} reports
                        </div>
                        <div class="pagination-controls">
                            <button class="pagination-btn" id="reports-prev-btn" disabled>
                                <i class="fas fa-chevron-left"></i> Previous
                            </button>
                            <div class="pagination-indicators" id="reports-indicators">
                                <!-- Indicators will be generated by JavaScript -->
                            </div>
                            <button class="pagination-btn" id="reports-next-btn">
                                Next <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                    @endif
                </div>
            </section>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize pagination for all sections
            initializePagination('passengers', 6);
            initializePagination('drivers', 6);
            initializePagination('reports', 3);

            // Search functionality
            setupSearch();

            // More menu functionality
            setupMoreMenu();

            function initializePagination(section, itemsPerPage) {
                const grid = document.getElementById(`${section}-grid`);
                if (!grid) return;
                
                const cards = grid.querySelectorAll(`.${section}-card, .report-card`);
                const totalItems = cards.length;
                const totalPages = Math.ceil(totalItems / itemsPerPage);
                
                // Hide pagination if not needed
                const paginationContainer = document.getElementById(`${section}-pagination`);
                if (totalPages <= 1 && paginationContainer) {
                    paginationContainer.style.display = 'none';
                    return;
                }

                // Initialize state
                let currentPage = 1;

                // Create indicators
                const indicatorsContainer = document.getElementById(`${section}-indicators`);
                if (indicatorsContainer) {
                    indicatorsContainer.innerHTML = '';
                    
                    for (let i = 1; i <= totalPages; i++) {
                        const indicator = document.createElement('div');
                        indicator.className = `page-indicator ${i === 1 ? 'active' : ''}`;
                        indicator.addEventListener('click', () => goToPage(section, i, itemsPerPage));
                        indicatorsContainer.appendChild(indicator);
                    }
                }

                // Show first page initially
                showPage(section, 1, itemsPerPage);
                updatePaginationButtons(section, currentPage, totalPages);
                updatePaginationInfo(section, currentPage, totalItems, itemsPerPage);

                // Event listeners for navigation buttons
                const prevBtn = document.getElementById(`${section}-prev-btn`);
                const nextBtn = document.getElementById(`${section}-next-btn`);

                if (prevBtn) {
                    prevBtn.addEventListener('click', () => {
                        if (currentPage > 1) {
                            goToPage(section, currentPage - 1, itemsPerPage);
                        } else {
                            // Loop to last page
                            goToPage(section, totalPages, itemsPerPage);
                        }
                    });
                }

                if (nextBtn) {
                    nextBtn.addEventListener('click', () => {
                        if (currentPage < totalPages) {
                            goToPage(section, currentPage + 1, itemsPerPage);
                        } else {
                            // Loop to first page
                            goToPage(section, 1, itemsPerPage);
                        }
                    });
                }

                function goToPage(section, page, itemsPerPage) {
                    currentPage = page;
                    showPage(section, page, itemsPerPage);
                    updatePaginationButtons(section, page, totalPages);
                    updatePaginationInfo(section, page, totalItems, itemsPerPage);
                    
                    // Update indicators
                    const indicators = document.querySelectorAll(`#${section}-indicators .page-indicator`);
                    indicators.forEach((indicator, index) => {
                        indicator.classList.toggle('active', index + 1 === page);
                    });
                }

                function showPage(section, page, itemsPerPage) {
                    const startIndex = (page - 1) * itemsPerPage;
                    const endIndex = startIndex + itemsPerPage;
                    
                    cards.forEach((card, index) => {
                        if (index >= startIndex && index < endIndex) {
                            card.classList.remove('hidden');
                        } else {
                            card.classList.add('hidden');
                        }
                    });
                }

                function updatePaginationButtons(section, currentPage, totalPages) {
                    const prevBtn = document.getElementById(`${section}-prev-btn`);
                    const nextBtn = document.getElementById(`${section}-next-btn`);
                    
                    if (prevBtn && nextBtn) {
                        // Always enable buttons for looping
                        prevBtn.disabled = false;
                        nextBtn.disabled = false;
                    }
                }

                function updatePaginationInfo(section, currentPage, totalItems, itemsPerPage) {
                    const startIndex = (currentPage - 1) * itemsPerPage + 1;
                    const endIndex = Math.min(currentPage * itemsPerPage, totalItems);
                    const infoElement = document.getElementById(`${section}-pagination-info`);
                    
                    if (infoElement) {
                        infoElement.textContent = `Showing ${startIndex}-${endIndex} of ${totalItems} ${section}`;
                    }
                }
            }

            function setupSearch() {
                const searchInput = document.getElementById('searchInput');
                const searchButton = document.getElementById('searchButton');
                const passengerCards = document.querySelectorAll('.passenger-card');
                const driverCards = document.querySelectorAll('.driver-card');
                const passengersCount = document.getElementById('passengers-count');
                const driversCount = document.getElementById('drivers-count');
                const reportsCount = document.getElementById('reports-count');

                let originalPassengersCount = {{ $passengers->count() }};
                let originalDriversCount = {{ $drivers->count() }};
                let originalReportsCount = {{ $reports->count() }};

                function performSearch() {
                    const searchTerm = searchInput.value.toLowerCase().trim();
                    let visiblePassengers = 0;
                    let visibleDrivers = 0;

                    if (searchTerm === '') {
                        // Reset to original state
                        passengersCount.textContent = `${originalPassengersCount} Passengers`;
                        driversCount.textContent = `${originalDriversCount} Drivers`;
                        reportsCount.textContent = `${originalReportsCount} Reports`;
                        
                        // Reinitialize pagination with all items
                        initializePagination('passengers', 6);
                        initializePagination('drivers', 6);
                        return;
                    }

                    // Search passengers
                    passengerCards.forEach(card => {
                        const name = card.getAttribute('data-name');
                        if (name.includes(searchTerm)) {
                            card.classList.remove('hidden');
                            visiblePassengers++;
                        } else {
                            card.classList.add('hidden');
                        }
                    });

                    // Search drivers
                    driverCards.forEach(card => {
                        const name = card.getAttribute('data-name');
                        if (name.includes(searchTerm)) {
                            card.classList.remove('hidden');
                            visibleDrivers++;
                        } else {
                            card.classList.add('hidden');
                        }
                    });

                    // Update counts
                    passengersCount.textContent = `${visiblePassengers} Passengers`;
                    driversCount.textContent = `${visibleDrivers} Drivers`;

                    // Reinitialize pagination with search results
                    setTimeout(() => {
                        initializePagination('passengers', 6);
                        initializePagination('drivers', 6);
                    }, 0);
                }

                searchButton.addEventListener('click', performSearch);
                searchInput.addEventListener('keyup', function(event) {
                    if (event.key === 'Enter') {
                        performSearch();
                    }
                });

                // Also search on input for real-time results
                searchInput.addEventListener('input', performSearch);
            }

            function setupMoreMenu() {
                const moreMenuTrigger = document.getElementById('moreMenuTrigger');
                const moreMenuDropdown = document.getElementById('moreMenuDropdown');
                const backButton = document.getElementById('backButton');
                const moreMenuContainer = document.querySelector('.more-menu-container');

                if (moreMenuTrigger && moreMenuDropdown) {
                    moreMenuTrigger.addEventListener('click', function() {
                        moreMenuDropdown.classList.toggle('active');
                    });

                    backButton.addEventListener('click', function() {
                        moreMenuDropdown.classList.remove('active');
                    });

                    document.addEventListener('click', function(event) {
                        if (!moreMenuContainer.contains(event.target)) {
                            moreMenuDropdown.classList.remove('active');
                        }
                    });
                }
            }
        });
    </script>
</body>
</html>