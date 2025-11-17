<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics Fastlan</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Analytics Page Styles - Red, Black & White Theme */
        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        :root {
            --primary-red: #dc3545;
            --dark-red: #c82333;
            --black: #212529;
            --white: #ffffff;
            --light-bg: #f1f1f1;
            --border-color: rgba(0, 0, 0, 0.08);
            --hover-bg: rgba(220, 53, 69, 0.1);
        }

        body {
            background-color: var(--light-bg);
            color: var(--black);
            min-height: 100vh;
        }

        /* Admin Dashboard Layout */
        .admin-header {
            background: linear-gradient(135deg, var(--black) 0%, #343a40 100%);
            padding: 1.5rem 3rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 3px solid var(--primary-red);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .admin-header h1 {
            color: var(--primary-red);
            font-size: 2.2rem;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(220, 53, 69, 0.3);
            margin: 0;
        }

        .admin-nav {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: flex-end;
            margin-left: auto;
        }

        .admin-nav a {
            color: var(--white);
            text-decoration: none;
            font-weight: 500;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            background: rgba(255, 255, 255, 0.1);
            white-space: nowrap;
        }

        .admin-nav a::after {
            content: '';
            position: absolute;
            bottom: 5px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: var(--primary-red);
            transition: width 0.3s ease;
        }

        .admin-nav a:hover::after {
            width: 80%;
        }

        .admin-nav a:hover {
            color: var(--primary-red);
            background: var(--hover-bg);
            transform: translateY(-2px);
        }

        .admin-main {
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        /* Analytics Header */
        .analytics-header {
            margin-bottom: 2rem;
        }

        .analytics-header h1 {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--black);
            margin-bottom: 0.5rem;
            position: relative;
            display: inline-block;
        }

        .analytics-header h1::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 60px;
            height: 3px;
            background: var(--primary-red);
            border-radius: 2px;
        }

        .analytics-header p {
            color: #6b7280;
            font-size: 1.1rem;
            opacity: 0.8;
        }

        /* Charts Grid */
        .charts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        /* Chart Cards */
        .chart-card {
            background: var(--white);
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 2px solid var(--border-color);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .chart-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--primary-red);
        }

        .chart-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            border-color: var(--primary-red);
        }

        .chart-header {
            margin-bottom: 1.5rem;
        }

        .chart-header h3 {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--black);
            margin-bottom: 0.5rem;
            position: relative;
            display: inline-block;
        }

        .chart-header h3::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 30px;
            height: 2px;
            background: var(--primary-red);
            border-radius: 2px;
        }

        .chart-header p {
            color: #6b7280;
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }

        /* Time Period Tabs */
        .time-period-tabs {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
            background: var(--hover-bg);
            padding: 0.5rem;
            border-radius: 8px;
        }

        .time-tab {
            padding: 0.5rem 1rem;
            background: transparent;
            border: 1px solid transparent;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            color: var(--black);
            flex: 1;
            text-align: center;
        }

        .time-tab.active {
            background: var(--primary-red);
            color: var(--white);
            border-color: var(--primary-red);
            box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
        }

        .time-tab:hover:not(.active) {
            background: rgba(220, 53, 69, 0.1);
            border-color: var(--primary-red);
        }

        /* Service Type Breakdown */
        .service-type-breakdown {
            display: flex;
            justify-content: space-around;
            align-items: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-color);
        }

        .service-type-item {
            text-align: center;
            padding: 1rem;
            background: var(--hover-bg);
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .service-type-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .service-type-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-red);
            margin-bottom: 0.5rem;
        }

        .service-type-label {
            font-size: 0.9rem;
            color: var(--black);
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .service-type-percentage {
            font-size: 0.8rem;
            color: #6b7280;
            font-weight: 600;
        }

        /* Alert Messages */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-left: 4px solid;
        }

        .alert-success {
            background: rgba(40, 167, 69, 0.1);
            color: #155724;
            border-left-color: #28a745;
        }

        .alert-error {
            background: var(--hover-bg);
            color: var(--primary-red);
            border-left-color: var(--primary-red);
        }

        .alert i {
            font-size: 1.2rem;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .admin-main {
                padding: 0 1.5rem;
            }
            
            .charts-grid {
                grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .admin-header {
                padding: 1rem 1.5rem;
                flex-direction: column;
                align-items: flex-start;
            }
            
            .admin-header h1 {
                font-size: 1.8rem;
            }
            
            .admin-nav {
                width: 100%;
                justify-content: flex-start;
                margin-left: 0;
                gap: 0.5rem;
            }
            
            .admin-nav a {
                padding: 8px 12px;
                font-size: 0.9rem;
                flex: 1;
                text-align: center;
                min-width: 120px;
            }
            
            .admin-main {
                padding: 0 1rem;
            }
            
            .charts-grid {
                grid-template-columns: 1fr;
            }
            
            .chart-card {
                padding: 1rem;
            }
            
            .time-period-tabs {
                flex-direction: column;
            }
            
            .service-type-breakdown {
                flex-direction: column;
                gap: 1rem;
            }
            
            .service-type-item {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .analytics-header h1 {
                font-size: 1.8rem;
            }
            
            .chart-header h3 {
                font-size: 1.1rem;
            }
            
            .chart-container {
                height: 250px;
            }
            
            .admin-header {
                padding: 1rem;
            }
            
            .admin-nav {
                flex-direction: column;
            }
            
            .admin-nav a {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <header class="admin-header">
        <div class="header-left">
            <h1>Analytics</h1>
        </div>
        <nav class="admin-nav">
            <a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="{{ route('admin.passengers') }}"><i class="fas fa-users"></i> Passengers</a>
            <a href="{{ route('admin.drivers') }}"><i class="fas fa-id-card"></i> Drivers</a>
            <a href="{{ route('admin.analytics') }}" class="active"><i class="fas fa-chart-bar"></i> Analytics</a>
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
    </script>
</body>
</html>