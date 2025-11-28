<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - System Feedback</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            --dark-bg: #1a1d23;
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

        /* Header Styles */
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

        /* Page Title Section */
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

        /* Filters Card */
        .filters-card {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border: 2px solid var(--border-color);
        }

        .filter-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            align-items: end;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
        }

        .filter-label {
            font-weight: 600;
            margin-bottom: 0.75rem;
            color: var(--text-primary);
            font-size: 0.9rem;
        }

        .filter-select, .filter-input {
            padding: 0.75rem 1rem;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            font-size: 1rem;
            background: var(--white);
            color: var(--text-primary);
            transition: all 0.3s ease;
        }

        .filter-select:focus, .filter-input:focus {
            outline: none;
            border-color: var(--primary-red);
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
        }

        /* Buttons */
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

        .btn-secondary {
            background: var(--text-secondary);
            color: var(--white);
            border-color: var(--text-secondary);
        }

        .btn-secondary:hover {
            background: #5a6268;
            border-color: #5a6268;
            transform: translateY(-2px);
        }

        /* Stats Grid */
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

        /* Table Styles */
        .feedbacks-table {
            background: var(--card-bg);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
            border: 2px solid var(--border-color);
        }

        .table-header {
            background: linear-gradient(135deg, var(--primary-red) 0%, var(--dark-red) 100%);
            color: var(--white);
            padding: 1.5rem;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            background: var(--light-bg);
            padding: 1.25rem 1rem;
            text-align: left;
            font-weight: 600;
            color: var(--text-primary);
            border-bottom: 2px solid var(--border-color);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table td {
            padding: 1.25rem 1rem;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-primary);
            vertical-align: top;
        }

        .table tr:hover {
            background: var(--hover-bg);
        }

        .table tr:last-child td {
            border-bottom: none;
        }

        /* Rating Stars */
        .rating-stars {
            color: var(--primary-red);
            font-size: 1rem;
        }

        /* Badges */
        .badge {
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-success {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success);
            border: 1px solid rgba(40, 167, 69, 0.3);
        }

        .badge-warning {
            background: rgba(255, 193, 7, 0.1);
            color: #856404;
            border: 1px solid rgba(255, 193, 7, 0.3);
        }

        .badge-danger {
            background: rgba(220, 53, 69, 0.1);
            color: var(--danger);
            border: 1px solid rgba(220, 53, 69, 0.3);
        }

        .badge-info {
            background: rgba(23, 162, 184, 0.1);
            color: var(--info);
            border: 1px solid rgba(23, 162, 184, 0.3);
        }

        /* User Type Badges */
        .user-type {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            background: var(--light-bg);
            border: 1px solid var(--border-color);
        }

        .user-type-passenger {
            color: var(--primary-red);
            border-color: var(--primary-red);
        }

        .user-type-driver {
            color: var(--text-primary);
            border-color: var(--text-primary);
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .btn-sm {
            padding: 0.6rem 1rem;
            font-size: 0.8rem;
            border-radius: 6px;
        }

        .btn-view {
            background: var(--info);
            color: var(--white);
            border-color: var(--info);
        }

        .btn-view:hover {
            background: #138496;
            border-color: #138496;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(23, 162, 184, 0.3);
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            margin-top: 2rem;
            flex-wrap: wrap;
        }

        .pagination-link {
            padding: 0.75rem 1rem;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            text-decoration: none;
            color: var(--text-primary);
            transition: all 0.3s ease;
            font-weight: 500;
            min-width: 44px;
            text-align: center;
        }

        .pagination-link:hover, .pagination-link.active {
            background: var(--primary-red);
            color: var(--white);
            border-color: var(--primary-red);
            transform: translateY(-2px);
        }

        .pagination-link.disabled {
            opacity: 0.5;
            cursor: not-allowed;
            background: var(--light-bg);
            color: var(--text-secondary);
        }

        .pagination-link.disabled:hover {
            transform: none;
            background: var(--light-bg);
            color: var(--text-secondary);
            border-color: var(--border-color);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--text-secondary);
        }

        .empty-state i {
            font-size: 4rem;
            color: var(--border-color);
            margin-bottom: 1.5rem;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--text-primary);
        }

        .empty-state p {
            font-size: 1rem;
            opacity: 0.8;
        }

        /* Text Utilities */
        .text-truncate {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 200px;
        }

        .text-muted {
            color: var(--text-secondary) !important;
            font-style: italic;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .container {
                padding: 15px;
            }
            
            .filter-row {
                grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
                gap: 1rem;
            }
            
            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
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
            
            .filter-row {
                grid-template-columns: 1fr;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .feedbacks-table {
                border-radius: 8px;
            }
            
            .table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
            
            .table th,
            .table td {
                padding: 1rem 0.75rem;
            }
            
            .action-buttons {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .btn-sm {
                width: 100%;
                justify-content: center;
            }
            
            .pagination {
                gap: 0.25rem;
            }
            
            .pagination-link {
                padding: 0.6rem 0.8rem;
                min-width: 40px;
                font-size: 0.9rem;
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
            
            .filters-card {
                padding: 1.5rem;
            }
            
            .stat-card {
                padding: 1.5rem 1rem;
            }
            
            .stat-number {
                font-size: 2rem;
            }
            
            .empty-state {
                padding: 3rem 1rem;
            }
            
            .empty-state i {
                font-size: 3rem;
            }
        }
    </style>
</head>
<body>
                                                            <!-- Header -->
    <header class="admin-header">
        <h1>FastLan Admin</h1>
        <nav class="admin-nav">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a href="{{ route('admin.passengers') }}">Passengers</a>
            <a href="{{ route('admin.drivers') }}">Drivers</a>
            <a href="{{ route('admin.feedback.index') }}" class="active">Feedback</a>
            <a href="{{ route('admin.feedback.analytics') }}">Feedback Analytics</a>
            <a href="{{ route('admin.reports') }}">Reports</a>
        </nav>
    </header>

                                                            <!-- Page Title Section -->
    <div class="page-title-section">
        <div class="page-title-content">
            <h1 class="page-title">System Feedback</h1>
            <p class="page-subtitle">Manage and review user feedback submissions</p>
        </div>
    </div>

    <div class="container">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">{{ $totalFeedbacks ?? 0 }}</div>
                <div class="stat-label">Total Feedbacks</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ number_format($averageRating ?? 0, 1) }}</div>
                <div class="stat-label">Average Rating</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $passengerFeedbacks ?? 0 }}</div>
                <div class="stat-label">Passenger Feedbacks</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $driverFeedbacks ?? 0 }}</div>
                <div class="stat-label">Driver Feedbacks</div>
            </div>
        </div>

        <div class="filters-card">
            <form method="GET" action="{{ route('admin.feedback.index') }}">
                <div class="filter-row">
                    <div class="filter-group">
                        <label class="filter-label">Feedback Type</label>
                        <select name="type" class="filter-select">
                            <option value="">All Types</option>
                            <option value="general" {{ request('type') == 'general' ? 'selected' : '' }}>General</option>
                            <option value="booking" {{ request('type') == 'booking' ? 'selected' : '' }}>Booking</option>
                            <option value="payment" {{ request('type') == 'payment' ? 'selected' : '' }}>Payment</option>
                            <option value="driver" {{ request('type') == 'driver' ? 'selected' : '' }}>Driver</option>
                            <option value="passenger" {{ request('type') == 'passenger' ? 'selected' : '' }}>Passenger</option>
                            <option value="technical" {{ request('type') == 'technical' ? 'selected' : '' }}>Technical</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Rating</label>
                        <select name="rating" class="filter-select">
                            <option value="">All Ratings</option>
                            <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1 Star</option>
                            <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 Stars</option>
                            <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 Stars</option>
                            <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 Stars</option>
                            <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 Stars</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">User Type</label>
                        <select name="user_type" class="filter-select">
                            <option value="">All Users</option>
                            <option value="passenger" {{ request('user_type') == 'passenger' ? 'selected' : '' }}>Passenger</option>
                            <option value="driver" {{ request('user_type') == 'driver' ? 'selected' : '' }}>Driver</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Date Range</label>
                        <input type="date" name="date_from" class="filter-input" value="{{ request('date_from') }}">
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">&nbsp;</label>
                        <input type="date" name="date_to" class="filter-input" value="{{ request('date_to') }}">
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">&nbsp;</label>
                        <button type="submit" class="btn btn-primary">Apply Filters</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="feedbacks-table">
            <div class="table-header">
                User Feedbacks ({{ $feedbacks->total() }} results)
            </div>
            
            @if($feedbacks->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Rating</th>
                            <th>Type</th>
                            <th>Feedback</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($feedbacks as $feedback)
                        <tr>
                            <td>
                                <div>
                                    <strong>{{ $feedback->user_name }}</strong>
                                    <div style="margin-top: 0.5rem; display: flex; gap: 0.5rem; flex-wrap: wrap;">
                                        <span class="user-type user-type-{{ $feedback->user_type }}">
                                            <i class="fas fa-{{ $feedback->user_type == 'passenger' ? 'user' : 'id-card' }}"></i>
                                            {{ ucfirst($feedback->user_type) }}
                                        </span>
                                        @if($feedback->is_anonymous)
                                            <span class="badge badge-info">Anonymous</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="rating-stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star{{ $i <= $feedback->satisfaction_rating ? '' : '-half-alt' }}"></i>
                                    @endfor
                                </div>
                                <small style="color: var(--text-secondary); font-size: 0.8rem; display: block; margin-top: 0.25rem;">
                                    {{ $feedback->satisfaction_rating }}/5
                                </small>
                            </td>
                            <td>
                                <span class="badge badge-info">{{ $feedback->feedback_type_text }}</span>
                            </td>
                            <td>
                                @if($feedback->positive_feedback)
                                    <div class="text-truncate" title="{{ $feedback->positive_feedback }}">
                                        {{ Str::limit($feedback->positive_feedback, 50) }}
                                    </div>
                                @else
                                    <span class="text-muted">No positive feedback</span>
                                @endif
                            </td>
                            <td>{{ $feedback->created_at->format('M d, Y H:i') }}</td>
                            <td>
                                @if($feedback->satisfaction_rating >= 4)
                                    <span class="badge badge-success">Satisfied</span>
                                @elseif($feedback->satisfaction_rating >= 3)
                                    <span class="badge badge-warning">Neutral</span>
                                @else
                                    <span class="badge badge-danger">Unsatisfied</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.feedback.show', $feedback->id) }}" class="btn btn-sm btn-view">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h3>No Feedbacks Found</h3>
                    <p>There are no feedback submissions matching your criteria.</p>
                </div>
            @endif
        </div>

        @if($feedbacks->hasPages())
            <div class="pagination">
                @if($feedbacks->onFirstPage())
                    <span class="pagination-link disabled">&laquo; Previous</span>
                @else
                    <a href="{{ $feedbacks->previousPageUrl() }}" class="pagination-link">&laquo; Previous</a>
                @endif

                @foreach(range(1, $feedbacks->lastPage()) as $page)
                    @if($page == $feedbacks->currentPage())
                        <span class="pagination-link active">{{ $page }}</span>
                    @else
                        <a href="{{ $feedbacks->url($page) }}" class="pagination-link">{{ $page }}</a>
                    @endif
                @endforeach

                @if($feedbacks->hasMorePages())
                    <a href="{{ $feedbacks->nextPageUrl() }}" class="pagination-link">Next &raquo;</a>
                @else
                    <span class="pagination-link disabled">Next &raquo;</span>
                @endif
            </div>
        @endif
    </div>
</body>
</html>