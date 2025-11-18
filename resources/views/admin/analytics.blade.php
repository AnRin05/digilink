<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics Fastlan</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite('resources/css/admin/analytics.css')
</head>
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
        <div class="analytics-header">
            <h1>Analytics Dashboard</h1>
        </div>

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

        <div class="charts-grid">
            <!-- Graph 1: Bookings by Status -->
            <div class="chart-card">
                <div class="chart-header">
                    <h3>Bookings by Status</h3>
                    <p>Number of bookings categorized by their current status</p>
                </div>
                <div class="time-period-tabs" id="bookingsTimeTabs">
                    <button class="time-tab active" data-period="today">Today</button>
                    <button class="time-tab" data-period="this_week">This Week</button>
                    <button class="time-tab" data-period="this_month">This Month</button>
                </div>
                <div class="chart-container">
                    <canvas id="bookingsChart"></canvas>
                </div>
            </div>

            <!-- Graph 2: Account Creation -->
            <div class="chart-card">
                <div class="chart-header">
                    <h3>Account Creation</h3>
                    <p>New passenger and driver registrations</p>
                </div>
                <div class="time-period-tabs" id="accountsTimeTabs">
                    <button class="time-tab active" data-period="today">Today</button>
                    <button class="time-tab" data-period="this_week">This Week</button>
                    <button class="time-tab" data-period="this_month">This Month</button>
                </div>
                <div class="chart-container">
                    <canvas id="accountsChart"></canvas>
                </div>
            </div>

            <!-- Graph 3: Service Type Distribution -->
            <div class="chart-card">
                <div class="chart-header">
                    <h3>Service Type Distribution</h3>
                    <p>Comparison between ride and delivery bookings</p>
                </div>
                <div class="chart-container">
                    <canvas id="serviceTypeChart"></canvas>
                </div>
                <div class="service-type-breakdown">
                    <div class="service-type-item">
                        <div class="service-type-value">{{ $serviceTypeData['ride'] }}</div>
                        <div class="service-type-label">Ride Bookings</div>
                        <div class="service-type-percentage">{{ $serviceTypePercentages['ride'] }}%</div>
                    </div>
                    <div class="service-type-item">
                        <div class="service-type-value">{{ $serviceTypeData['delivery'] }}</div>
                        <div class="service-type-label">Delivery Bookings</div>
                        <div class="service-type-percentage">{{ $serviceTypePercentages['delivery'] }}%</div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // PHP data converted to JavaScript
        const bookingsData = @json($bookingsData);
        const accountCreationData = @json($accountCreationData);
        const serviceTypeData = @json($serviceTypeData);

        // Initialize charts
        let bookingsChart, accountsChart, serviceTypeChart;
        let currentBookingsPeriod = 'today';
        let currentAccountsPeriod = 'today';

        // Bookings Chart
        function initBookingsChart(period = 'today') {
            const ctx = document.getElementById('bookingsChart').getContext('2d');
            const data = bookingsData[period];
            
            if (bookingsChart) {
                bookingsChart.destroy();
            }

            bookingsChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Pending', 'Accepted', 'In Progress', 'Completed', 'Cancelled'],
                    datasets: [{
                        label: `Bookings - ${period.replace('_', ' ')}`,
                        data: [data.pending, data.accepted, data.in_progress, data.completed, data.cancelled],
                        backgroundColor: [
                            '#ffc107',
                            '#17a2b8',
                            '#007bff',
                            '#28a745',
                            '#dc3545'
                        ],
                        borderColor: [
                            '#e0a800',
                            '#138496',
                            '#0069d9',
                            '#218838',
                            '#c82333'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }

        // Accounts Chart
        function initAccountsChart(period = 'today') {
            const ctx = document.getElementById('accountsChart').getContext('2d');
            const data = accountCreationData[period];
            
            if (accountsChart) {
                accountsChart.destroy();
            }

            accountsChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Passengers', 'Drivers'],
                    datasets: [{
                        label: `New Accounts - ${period.replace('_', ' ')}`,
                        data: [data.passengers, data.drivers],
                        backgroundColor: [
                            '#6f42c1',
                            '#fd7e14'
                        ],
                        borderColor: [
                            '#5a32a3',
                            '#e56a12'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }

        // Service Type Chart
        function initServiceTypeChart() {
            const ctx = document.getElementById('serviceTypeChart').getContext('2d');
            
            serviceTypeChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Ride', 'Delivery'],
                    datasets: [{
                        data: [serviceTypeData.ride, serviceTypeData.delivery],
                        backgroundColor: [
                            '#007bff',
                            '#28a745'
                        ],
                        borderColor: [
                            '#0069d9',
                            '#218838'
                        ],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true
                            }
                        }
                    },
                    cutout: '60%'
                }
            });
        }

        // Tab functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize charts
            initBookingsChart();
            initAccountsChart();
            initServiceTypeChart();

            // Bookings time tabs
            document.querySelectorAll('#bookingsTimeTabs .time-tab').forEach(tab => {
                tab.addEventListener('click', function() {
                    document.querySelectorAll('#bookingsTimeTabs .time-tab').forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                    currentBookingsPeriod = this.dataset.period;
                    initBookingsChart(currentBookingsPeriod);
                });
            });

            // Accounts time tabs
            document.querySelectorAll('#accountsTimeTabs .time-tab').forEach(tab => {
                tab.addEventListener('click', function() {
                    document.querySelectorAll('#accountsTimeTabs .time-tab').forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                    currentAccountsPeriod = this.dataset.period;
                    initAccountsChart(currentAccountsPeriod);
                });
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
        const moreMenuTrigger = document.getElementById('moreMenuTrigger');
        const moreMenuDropdown = document.getElementById('moreMenuDropdown');
        const backButton = document.getElementById('backButton');

        if (!moreMenuTrigger || !moreMenuDropdown || !backButton) {
            console.error('More menu elements not found');
            return;
        }

        moreMenuTrigger.addEventListener('click', function(e) {
            e.stopPropagation();
            moreMenuDropdown.classList.toggle('active');
        });

        backButton.addEventListener('click', function(e) {
            e.preventDefault();
            moreMenuDropdown.classList.remove('active');
        });

        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', function() {
                moreMenuDropdown.classList.remove('active');
            });
        });

        document.addEventListener('click', function(e) {
            if (!moreMenuTrigger.contains(e.target) && !moreMenuDropdown.contains(e.target)) {
                moreMenuDropdown.classList.remove('active');
            }
        });

        moreMenuDropdown.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    });
    </script>
</body>
</html>