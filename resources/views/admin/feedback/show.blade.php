<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Details - Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
            --light-bg: #f1f1f1;
            --border-color: rgba(0, 0, 0, 0.08);
            --hover-bg: rgba(220, 53, 69, 0.1);
            --card-bg: #ffffff;
            --text-primary: #212529;
            --text-secondary: #6c757d;
            --success: #28a745;
            --warning: #ffc107;
            --danger: #dc3545;
        }

        body {
            background-color: var(--light-bg);
            color: var(--text-primary);
            min-height: 100vh;
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

        /* Main Content */
        .admin-main {
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        /* Breadcrumb */
        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 2rem;
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        .breadcrumb a {
            color: var(--primary-red);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .breadcrumb a:hover {
            color: var(--dark-red);
        }

        .breadcrumb span {
            color: var(--text-secondary);
        }

        /* Feedback Details Card */
        .feedback-details-card {
            background: var(--card-bg);
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 2px solid var(--border-color);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .details-header {
            background: linear-gradient(135deg, var(--primary-red) 0%, var(--dark-red) 100%);
            color: var(--white);
            padding: 2rem;
            border-bottom: 2px solid var(--border-color);
        }

        .details-header h2 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .rating-display {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .rating-stars {
            color: var(--white);
            font-size: 1.2rem;
        }

        .rating-badge {
            background: var(--white);
            color: var(--primary-red);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 700;
            font-size: 0.9rem;
        }

        /* Details Content */
        .details-content {
            padding: 2rem;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .info-card {
            background: var(--light-bg);
            border-radius: 10px;
            padding: 1.5rem;
            border: 1px solid var(--border-color);
        }

        .info-card h3 {
            color: var(--primary-red);
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 0.5rem;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--border-color);
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            color: var(--text-secondary);
            font-weight: 500;
        }

        .info-value {
            color: var(--text-primary);
            font-weight: 600;
            text-align: right;
        }

        /* Badges */
        .badge {
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-primary {
            background: var(--primary-red);
            color: var(--white);
        }

        .badge-secondary {
            background: var(--text-secondary);
            color: var(--white);
        }

        .badge-success {
            background: var(--success);
            color: var(--white);
        }

        .badge-warning {
            background: var(--warning);
            color: var(--black);
        }

        .badge-danger {
            background: var(--danger);
            color: var(--white);
        }

        .user-type {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
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

        /* Feedback Content */
        .feedback-content {
            background: var(--light-bg);
            border-radius: 10px;
            padding: 1.5rem;
            border: 1px solid var(--border-color);
            margin-bottom: 2rem;
        }

        .feedback-section {
            margin-bottom: 2rem;
        }

        .feedback-section:last-child {
            margin-bottom: 0;
        }

        .feedback-section h3 {
            color: var(--primary-red);
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .feedback-text {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 1rem;
            color: var(--text-primary);
            line-height: 1.6;
            min-height: 100px;
        }

        .empty-text {
            color: var(--text-secondary);
            font-style: italic;
            text-align: center;
            padding: 2rem;
        }

        /* Contact Info */
        .contact-info {
            background: var(--light-bg);
            border-radius: 10px;
            padding: 1.5rem;
            border: 1px solid var(--border-color);
            margin-bottom: 2rem;
        }

        .contact-info h3 {
            color: var(--primary-red);
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Timeline */
        .timeline {
            background: var(--light-bg);
            border-radius: 10px;
            padding: 1.5rem;
            border: 1px solid var(--border-color);
            margin-bottom: 2rem;
        }

        .timeline h3 {
            color: var(--primary-red);
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .timeline-item {
            display: flex;
            gap: 1rem;
            padding: 1rem 0;
            border-bottom: 1px solid var(--border-color);
        }

        .timeline-item:last-child {
            border-bottom: none;
        }

        .timeline-marker {
            width: 12px;
            height: 12px;
            background: var(--primary-red);
            border-radius: 50%;
            margin-top: 0.5rem;
            flex-shrink: 0;
        }

        .timeline-content {
            flex: 1;
        }

        .timeline-date {
            color: var(--primary-red);
            font-weight: 600;
            font-size: 0.875rem;
            margin-bottom: 0.25rem;
        }

        .timeline-text {
            color: var(--text-primary);
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            flex-wrap: wrap;
            padding: 1.5rem 2rem;
            background: var(--light-bg);
            border-top: 1px solid var(--border-color);
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
            gap: 0.5rem;
            text-align: center;
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
            background: var(--white);
            color: var(--text-primary);
            border-color: var(--border-color);
        }

        .btn-secondary:hover {
            background: var(--light-bg);
            border-color: var(--text-secondary);
            transform: translateY(-2px);
        }

        .btn-back {
            background: var(--text-secondary);
            color: var(--white);
            border-color: var(--text-secondary);
        }

        .btn-back:hover {
            background: #5a6268;
            border-color: #5a6268;
            transform: translateY(-2px);
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

        /* Responsive Design */
        @media (max-width: 1024px) {
            .admin-main {
                padding: 0 1.5rem;
            }
            
            .info-grid {
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                gap: 1.5rem;
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
                margin: 1rem auto;
            }
            
            .details-content {
                padding: 1.5rem;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .info-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.25rem;
            }
            
            .info-value {
                text-align: left;
            }
            
            .action-buttons {
                justify-content: center;
                padding: 1rem;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
            
            .rating-display {
                justify-content: center;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .admin-header {
                padding: 1rem;
            }
            
            .admin-nav {
                flex-direction: column;
            }
            
            .admin-nav a {
                width: 100%;
            }
            
            .details-header {
                padding: 1.5rem;
                text-align: center;
            }
            
            .details-header h2 {
                font-size: 1.5rem;
            }
            
            .feedback-content,
            .contact-info,
            .timeline {
                padding: 1rem;
            }
            
            .feedback-text {
                min-height: 80px;
                padding: 0.75rem;
            }
            
            .breadcrumb {
                font-size: 0.8rem;
            }
        }

        /* Print Styles */
        @media print {
            .admin-header,
            .admin-nav,
            .action-buttons {
                display: none;
            }
            
            .feedback-details-card {
                box-shadow: none;
                border: 1px solid #000;
            }
            
            body {
                background: white;
                color: black;
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
            <a href="{{ route('admin.feedback.analytics') }}">Analytics</a>
            <a href="{{ route('admin.reports') }}">Reports</a>
        </nav>
    </header>

                                                            <!-- Main Content -->
    <main class="admin-main">
        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <span>/</span>
            <a href="{{ route('admin.feedback.index') }}">Feedback</a>
            <span>/</span>
            <span>Details #{{ $feedback->id }}</span>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
            </div>
        @endif

        <!-- Feedback Details Card -->
        <div class="feedback-details-card">
            <div class="details-header">
                <h2>Feedback Details</h2>
                <div class="rating-display">
                    <div class="rating-stars">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star{{ $i <= $feedback->satisfaction_rating ? '' : '-half-alt' }}"></i>
                        @endfor
                    </div>
                    <span class="rating-badge">{{ $feedback->satisfaction_rating }}/5 Rating</span>
                </div>
            </div>

            <div class="details-content">
                <!-- Information Grid -->
                <div class="info-grid">
                    <!-- User Information -->
                    <div class="info-card">
                        <h3><i class="fas fa-user"></i> User Information</h3>
                        <div class="info-item">
                            <span class="info-label">User Type:</span>
                            <span class="info-value">
                                <span class="user-type user-type-{{ $feedback->user_type }}">
                                    <i class="fas fa-{{ $feedback->user_type == 'passenger' ? 'user' : 'id-card' }}"></i>
                                    {{ ucfirst($feedback->user_type) }}
                                </span>
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">User Name:</span>
                            <span class="info-value">{{ $feedback->user_name }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Anonymous:</span>
                            <span class="info-value">
                                @if($feedback->is_anonymous)
                                    <span class="badge badge-secondary">Yes</span>
                                @else
                                    <span class="badge badge-secondary">No</span>
                                @endif
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">User ID:</span>
                            <span class="info-value">
                                @if($feedback->user_type == 'passenger' && $feedback->passenger_id)
                                    {{ $feedback->passenger_id }}
                                @elseif($feedback->user_type == 'driver' && $feedback->driver_id)
                                    {{ $feedback->driver_id }}
                                @else
                                    N/A
                                @endif
                            </span>
                        </div>
                    </div>

                    <!-- Feedback Details -->
                    <div class="info-card">
                        <h3><i class="fas fa-info-circle"></i> Feedback Details</h3>
                        <div class="info-item">
                            <span class="info-label">Feedback Type:</span>
                            <span class="info-value">
                                <span class="badge badge-primary">{{ $feedback->feedback_type_text }}</span>
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Satisfaction Level:</span>
                            <span class="info-value">
                                <span class="badge 
                                    @if($feedback->satisfaction_rating >= 4) badge-success
                                    @elseif($feedback->satisfaction_rating >= 3) badge-warning
                                    @else badge-danger @endif">
                                    {{ $feedback->satisfaction_level_text }}
                                </span>
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Submitted:</span>
                            <span class="info-value">{{ $feedback->created_at->format('F d, Y \a\t H:i') }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Last Updated:</span>
                            <span class="info-value">{{ $feedback->updated_at->format('F d, Y \a\t H:i') }}</span>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="info-card">
                        <h3><i class="fas fa-envelope"></i> Contact Information</h3>
                        <div class="info-item">
                            <span class="info-label">Can Contact:</span>
                            <span class="info-value">
                                @if($feedback->can_contact)
                                    <span class="badge badge-success">Yes</span>
                                @else
                                    <span class="badge badge-secondary">No</span>
                                @endif
                            </span>
                        </div>
                        @if($feedback->can_contact && $feedback->contact_email)
                        <div class="info-item">
                            <span class="info-label">Contact Email:</span>
                            <span class="info-value">
                                <a href="mailto:{{ $feedback->contact_email }}" style="color: var(--primary-red); text-decoration: none;">
                                    {{ $feedback->contact_email }}
                                </a>
                            </span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Feedback Content -->
                <div class="feedback-content">
                    <div class="feedback-section">
                        <h3><i class="fas fa-thumbs-up"></i> Positive Feedback</h3>
                        <div class="feedback-text">
                            @if($feedback->positive_feedback)
                                {{ $feedback->positive_feedback }}
                            @else
                                <div class="empty-text">No positive feedback provided</div>
                            @endif
                        </div>
                    </div>

                    <div class="feedback-section">
                        <h3><i class="fas fa-tools"></i> Improvement Suggestions</h3>
                        <div class="feedback-text">
                            @if($feedback->improvements)
                                {{ $feedback->improvements }}
                            @else
                                <div class="empty-text">No improvement suggestions provided</div>
                            @endif
                        </div>
                    </div>

                    @if($feedback->satisfaction_rating <= 2)
                    <div class="feedback-section">
                        <h3><i class="fas fa-exclamation-triangle"></i> Reason for Low Rating</h3>
                        <div class="feedback-text">
                            @if($feedback->reason)
                                {{ $feedback->reason }}
                            @else
                                <div class="empty-text">No reason provided for low rating</div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Contact Information -->
                @if($feedback->can_contact && $feedback->contact_email)
                <div class="contact-info">
                    <h3><i class="fas fa-envelope"></i> Contact User</h3>
                    <p>The user has agreed to be contacted about their feedback. You can reach them at:</p>
                    <div style="background: var(--card-bg); padding: 1rem; border-radius: 8px; margin-top: 1rem; border: 1px solid var(--border-color);">
                        <strong>Email:</strong> 
                        <a href="mailto:{{ $feedback->contact_email }}" style="color: var(--primary-red); text-decoration: none; font-weight: 600;">
                            {{ $feedback->contact_email }}
                        </a>
                    </div>
                </div>
                @endif

                <!-- Timeline -->
                <div class="timeline">
                    <h3><i class="fas fa-history"></i> Activity Timeline</h3>
                    <div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <div class="timeline-date">{{ $feedback->created_at->format('F d, Y H:i') }}</div>
                            <div class="timeline-text">Feedback submitted</div>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <div class="timeline-date">{{ $feedback->updated_at->format('F d, Y H:i') }}</div>
                            <div class="timeline-text">Last updated</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="{{ route('admin.feedback.index') }}" class="btn btn-back">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
                @if($feedback->can_contact && $feedback->contact_email)
                <a href="mailto:{{ $feedback->contact_email }}" class="btn btn-primary">
                    <i class="fas fa-envelope"></i> Contact User
                </a>
                @endif
                <button onclick="window.print()" class="btn btn-secondary">
                    <i class="fas fa-print"></i> Print Details
                </button>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Feedback details page loaded');
            
            const printButton = document.querySelector('.btn-secondary');
            if (printButton) {
                printButton.addEventListener('click', function() {
                    window.print();
                });
            }
        });
    </script>
</body>
</html>