<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
    @vite('resources/css/admin/dashboard.css')
    <link rel="icon" href="{{ asset('images/fastlan1.png') }}">
<body>
    <header class="admin-header">
        <div class="header-left">
            <h1>Admin Dashboard</h1>
        </div>
        <nav class="admin-nav">
            <a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="{{ route('admin.passengers') }}"><i class="fas fa-users"></i> Passengers</a>
            <a href="{{ route('admin.drivers') }}"><i class="fas fa-id-card"></i> Drivers</a>
            
            <!-- More Menu Trigger -->
            <div class="more-menu-container">
                <button class="more-menu-trigger" id="moreMenuTrigger">
                    <i class="fas fa-ellipsis-h"></i> More
                </button>
                
                <!-- More Menu Dropdown -->
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
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        <section class="admin-stats-section">
            <h2>Statistics</h2>
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Total Passengers</h3>
                    <p>{{ $passengers->count() }}</p>
                </div>
                <div class="stat-card">
                    <h3>Total Drivers</h3>
                    <p>{{ $drivers->count() }}</p>
                </div>
                <div class="stat-card">
                    <h3>Pending Driver Approvals</h3>
                    <p>{{ $pendingDrivers->count() }}</p>
                </div>
                <!-- Add Booking Statistics -->
                <div class="stat-card">
                    <h3>Current Bookings</h3>
                    <p>{{ $currentBookingsCount }}</p>
                    <small class="stat-breakdown">
                        Pending: {{ $pendingBookingsCount }} | 
                        Accepted: {{ $acceptedBookingsCount }} | 
                        In Progress: {{ $inProgressBookingsCount }}
                    </small>
                </div>
                <div class="stat-card">
                    <h3>Completed Bookings</h3>
                    <p>{{ $completedBookingsCount }}</p>
                </div>
                <div class="stat-card">
                    <h3>Cancelled Bookings</h3>
                    <p>{{ $cancelledBookingsCount }}</p>
                </div>
            </div>
        </section>

        <!-- Rest of your existing sections remain the same -->
        <section class="admin-table-section">
            <div class="section-header">
                <h2 class="section-title">Pending Driver Approvals</h2>
                <span class="section-badge">{{ $pendingDrivers->count() }} Pending</span>
            </div>
            
            @if($pendingDrivers->count() > 0)
                <div class="admin-table-container">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingDrivers as $driver)
                            <tr>
                                <td>{{ $driver->fullname }}</td>
                                <td>{{ $driver->email }}</td>
                                <td>{{ $driver->phone }}</td>
                                <td>
                                    <div class="admin-actions">
                                        <a href="{{ route('admin.driver.show', $driver->id) }}" class="admin-btn admin-btn-view">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        
                                        <!-- Approve Form -->
                                        <form action="{{ route('admin.driver.approve', $driver->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="admin-btn admin-btn-approve" onclick="return confirm('Approve this driver?')">
                                                <i class="fas fa-check"></i> Approve
                                            </button>
                                        </form>
                                        
                                        <!-- Reject Form -->
                                        <form action="{{ route('admin.driver.reject', $driver->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="admin-btn admin-btn-reject" onclick="return confirm('Reject this driver?')">
                                                <i class="fas fa-times"></i> Reject
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <h3 class="empty-title">No Pending Approvals</h3>
                    <p class="empty-text">All driver applications have been processed.</p>
                </div>
            @endif
        </section>

        <section class="admin-table-section">
            <div class="section-header">
                <h2 class="section-title">Recent Passengers</h2>
                <span class="section-badge">{{ $passengers->count() }} Total</span>
            </div>
            
            @if($passengers->count() > 0)
                <div class="admin-table-container">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($passengers->take(5) as $passenger)
                            <tr>
                                <td>{{ $passenger->name }}</td>
                                <td>{{ $passenger->email }}</td>
                                <td>{{ $passenger->phone }}</td>
                                <td>
                                    <a href="{{ route('admin.passenger.show', $passenger->id) }}" class="admin-btn admin-btn-view">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-users-slash"></i>
                    </div>
                    <h3 class="empty-title">No Passengers Found</h3>
                    <p class="empty-text">There are no passengers in the system yet.</p>
                </div>
            @endif
        </section>
    </main>

    <script>
        // More Menu Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const moreMenuTrigger = document.getElementById('moreMenuTrigger');
            const moreMenuDropdown = document.getElementById('moreMenuDropdown');
            const backButton = document.getElementById('backButton');
            
            // Toggle more menu
            moreMenuTrigger.addEventListener('click', function(e) {
                e.stopPropagation();
                moreMenuDropdown.classList.toggle('active');
            });
            
            // Back button functionality
            backButton.addEventListener('click', function(e) {
                e.stopPropagation();
                moreMenuDropdown.classList.remove('active');
            });
            
            // Close menu when clicking outside
            document.addEventListener('click', function(e) {
                if (!moreMenuDropdown.contains(e.target) && !moreMenuTrigger.contains(e.target)) {
                    moreMenuDropdown.classList.remove('active');
                }
            });
            
            // Prevent menu close when clicking inside
            moreMenuDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });
        
        // Simple confirmation for actions
        function confirmAction(message) {
            return confirm(message || 'Are you sure?');
        }
    </script>
</body>
</html>