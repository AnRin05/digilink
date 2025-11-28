<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Analytics - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
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
            --light-bg: #f8f9fa;
            --border-color: #dee2e6;
            --hover-bg: rgba(220, 53, 69, 0.1);
            --card-bg: #ffffff;
            --text-primary: #212529;
            --text-secondary: #6c757d;
            --success: #28a745;
            --warning: #ffc107;
            --danger: #dc3545;
            --info: #17a2b8;
        }

        body {
            background-color: var(--light-bg);
            color: var(--text-primary);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

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

        .admin-nav a.active {
            background: var(--primary-red);
            color: var(--white);
        }

        .admin-nav a.active::after {
            width: 80%;
        }

        .page-title-section {
            background: linear-gradient(135deg, var(--primary-red) 0%, var(--dark-red) 100%);
            color: var(--white);
            padding: 2rem 0;
            margin-bottom: 2rem;
            border-bottom: 2px solid var(--primary-red);
        }

        .page-title-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 3rem;
        }

        .page-title {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .analytics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .analytics-card {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border: 2px solid var(--border-color);
        }

        .analytics-card h3 {
            color: var(--primary-red);
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--card-bg);
            padding: 2rem 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            text-align: center;
            border-top: 4px solid var(--primary-red);
            transition: all 0.3s ease;
            border: 2px solid var(--border-color);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            border-color: var(--primary-red);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-red);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: var(--text-secondary);
            font-weight: 500;
            font-size: 0.9rem;
        }

        .data-list {
            list-style: none;
        }

        .data-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid var(--border-color);
        }

        .data-item:last-child {
            border-bottom: none;
        }

        .data-label {
            color: var(--text-primary);
            font-weight: 500;
        }

        .data-value {
            color: var(--primary-red);
            font-weight: 700;
            font-size: 1.1rem;
        }

        .rating-bar {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .rating-label {
            min-width: 120px;
            color: var(--text-primary);
            font-weight: 500;
        }

        .rating-bar-container {
            flex: 1;
            background: var(--light-bg);
            height: 8px;
            border-radius: 4px;
            overflow: hidden;
        }

        .rating-bar-fill {
            height: 100%;
            background: var(--primary-red);
            border-radius: 4px;
            transition: width 0.3s ease;
        }

        .rating-count {
            min-width: 60px;
            text-align: right;
            color: var(--text-secondary);
            font-weight: 500;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: 2px solid;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-size: 0.9rem;
        }

        .btn-primary {
            background: var(--primary-red);
            color: var(--white);
            border-color: var(--primary-red);
        }

        .btn-primary:hover {
            background: var(--dark-red);
            border-color: var(--dark-red);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
            flex-wrap: wrap;
        }

        @media (max-width: 1024px) {
            .container {
                padding: 15px;
            }
            
            .analytics-grid {
                grid-template-columns: 1fr;
            }
            
            .admin-header {
                padding: 1.5rem 2rem;
            }

            .page-title-content {
                padding: 0 2rem;
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
            
            .page-title-section {
                padding: 1.5rem 0;
            }
            
            .page-title-content {
                padding: 0 1.5rem;
            }
            
            .page-title {
                font-size: 1.8rem;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .analytics-card {
                padding: 1.5rem;
            }
            
            .chart-container {
                height: 250px;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 10px;
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
            
            .page-title-content {
                padding: 0 1rem;
            }
            
            .page-title {
                font-size: 1.5rem;
            }
            
            .page-subtitle {
                font-size: 1rem;
            }
            
            .stat-card {
                padding: 1.5rem 1rem;
            }
            
            .stat-number {
                font-size: 2rem;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <header class="admin-header">
        <h1>FastLan Admin</h1>
        <nav class="admin-nav">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a href="{{ route('admin.passengers') }}">Passengers</a>
            <a href="{{ route('admin.drivers') }}">Drivers</a>
            <a href="{{ route('admin.feedback.index') }}">Feedback</a>
            <a href="{{ route('admin.feedback.analytics') }}" class="active">Analytics</a>
            <a href="{{ route('admin.reports') }}">Reports</a>
        </nav>
    </header>

    <div class="page-title-section">
        <div class="page-title-content">
            <h1 class="page-title">Feedback Analytics</h1>
            <p class="page-subtitle">Comprehensive insights and statistics from user feedback</p>
        </div>
    </div>

    <div class="container">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">{{ number_format($totalFeedbacks) }}</div>
                <div class="stat-label">Total Feedbacks</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ number_format($averageRating, 1) }}</div>
                <div class="stat-label">Average Rating</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ number_format($passengerFeedbacks) }}</div>
                <div class="stat-label">Passenger Feedbacks</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ number_format($driverFeedbacks) }}</div>
                <div class="stat-label">Driver Feedbacks</div>
            </div>
        </div>

        <div class="analytics-grid">
            <div class="analytics-card">
                <h3><i class="fas fa-chart-pie"></i> Feedback by Type</h3>
                <div class="chart-container">
                    <canvas id="feedbackTypeChart"></canvas>
                </div>
            </div>

            <div class="analytics-card">
                <h3><i class="fas fa-star"></i> Rating Distribution</h3>
                <div class="chart-container">
                    <canvas id="ratingDistributionChart"></canvas>
                </div>
            </div>

            <div class="analytics-card">
                <h3><i class="fas fa-chart-bar"></i> Feedback by Rating</h3>
                <div class="data-list">
                    @php
                        $total = $feedbackByRating->sum('count');
                    @endphp
                    @foreach($feedbackByRating->sortBy('satisfaction_rating') as $rating)
                    <div class="rating-bar">
                        <span class="rating-label">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star{{ $i <= $rating->satisfaction_rating ? '' : '-half-alt' }}" style="color: var(--primary-red);"></i>
                            @endfor
                        </span>
                        <div class="rating-bar-container">
                            <div class="rating-bar-fill" style="width: {{ ($rating->count / $total) * 100 }}%"></div>
                        </div>
                        <span class="rating-count">{{ $rating->count }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="analytics-card">
                <h3><i class="fas fa-list"></i> Feedback Types</h3>
                <div class="data-list">
                    @foreach($feedbackByType as $type)
                    <div class="data-item">
                        <span class="data-label">{{ ucfirst($type->feedback_type) }}</span>
                        <span class="data-value">{{ $type->count }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="action-buttons">
            <a href="{{ route('admin.feedback.index') }}" class="btn btn-primary">
                <i class="fas fa-list"></i> View All Feedbacks
            </a>
            <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print"></i> Print Report
            </button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const feedbackTypeData = {
                labels: {!! json_encode($feedbackByType->pluck('feedback_type')->map(fn($type) => ucfirst($type))) !!},
                datasets: [{
                    data: {!! json_encode($feedbackByType->pluck('count')) !!},
                    backgroundColor: [
                        '#dc3545', '#c82333', '#a71e2a', '#721c24', '#491217', '#2c0d10'
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            };

            const ratingDistributionData = {
                labels: ['1 Star', '2 Stars', '3 Stars', '4 Stars', '5 Stars'],
                datasets: [{
                    label: 'Number of Feedbacks',
                    data: {!! json_encode([
                        $feedbackByRating->firstWhere('satisfaction_rating', 1)->count ?? 0,
                        $feedbackByRating->firstWhere('satisfaction_rating', 2)->count ?? 0,
                        $feedbackByRating->firstWhere('satisfaction_rating', 3)->count ?? 0,
                        $feedbackByRating->firstWhere('satisfaction_rating', 4)->count ?? 0,
                        $feedbackByRating->firstWhere('satisfaction_rating', 5)->count ?? 0
                    ]) !!},
                    backgroundColor: 'rgba(220, 53, 69, 0.8)',
                    borderColor: '#dc3545',
                    borderWidth: 2
                }]
            };

            const feedbackTypeChart = new Chart(
                document.getElementById('feedbackTypeChart'),
                {
                    type: 'pie',
                    data: feedbackTypeData,
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
                        }
                    }
                }
            );

            const ratingDistributionChart = new Chart(
                document.getElementById('ratingDistributionChart'),
                {
                    type: 'bar',
                    data: ratingDistributionData,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                }
            );
        });
    </script>
</body>
</html>