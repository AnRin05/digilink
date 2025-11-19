<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Details - Admin</title>
    @vite('resources/css/admin/report-show.css')
</head>
<body>
    <header class="admin-header">
        <div class="header-left">
            <h1>Report Details #{{ $report->id }}</h1>
            <div class="report-meta">
                <span class="report-type {{ $report->report_type }}">{{ $report->getReportTypeDisplay() }}</span>
                <span class="report-status {{ $report->status }}">{{ ucfirst($report->status) }}</span>
            </div>
        </div>
        <nav class="admin-nav">
            <a href="{{ route('admin.reports') }}"><i class="fas fa-arrow-left"></i> Back to Reports</a>
        </nav>
    </header>

    <main class="admin-main">
        <div class="report-details-container">
            <div class="details-grid">
                <!-- Report Information -->
                <div class="detail-section">
                    <h3>Report Information</h3>
                    <div class="detail-card">
                        <div class="detail-row">
                            <span class="label">Report Type:</span>
                            <span class="value {{ $report->report_type }}">{{ $report->getReportTypeDisplay() }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Status:</span>
                            <span class="status-badge {{ $report->status }}">{{ ucfirst($report->status) }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Reported By:</span>
                            <span class="value">{{ $report->reporter->fullname ?? 'Unknown' }} ({{ $report->reporter_type }})</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Reported At:</span>
                            <span class="value">{{ $report->created_at->format('M d, Y H:i') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Booking Information -->
                <div class="detail-section">
                    <h3>Booking Information</h3>
                    <div class="detail-card">
                        <div class="detail-row">
                            <span class="label">Booking ID:</span>
                            <span class="value">{{ $report->booking_id }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Service Type:</span>
                            <span class="value">{{ $report->booking_data['service_type'] ?? 'N/A' }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Fare:</span>
                            <span class="value">{{ $report->booking_data['fare'] ?? 'N/A' }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Status:</span>
                            <span class="value">{{ $report->booking_data['status'] ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Location Information -->
                <div class="detail-section">
                    <h3>Location Information</h3>
                    <div class="detail-card">
                        <div class="detail-row">
                            <span class="label">Pickup:</span>
                            <span class="value">{{ $report->location_data['booking_pickup']['address'] ?? 'N/A' }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Dropoff:</span>
                            <span class="value">{{ $report->location_data['booking_dropoff']['address'] ?? 'N/A' }}</span>
                        </div>
                        @if(isset($report->location_data['driver_current']))
                        <div class="detail-row">
                            <span class="label">Driver Location:</span>
                            <span class="value">{{ $report->location_data['driver_current']['location_name'] ?? 'N/A' }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Report Description -->
                <div class="detail-section full-width">
                    <h3>Report Description</h3>
                    <div class="detail-card">
                        <div class="description-content">
                            {!! nl2br(e($report->description)) !!}
                        </div>
                    </div>
                </div>

                <!-- Admin Response Form -->
                <div class="detail-section full-width">
                    <h3>Admin Response</h3>
                    <form action="{{ route('admin.reports.update', $report->id) }}" method="POST" class="response-form">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label for="status">Status:</label>
                            <select name="status" id="status" class="form-select">
                                <option value="pending" {{ $report->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="reviewed" {{ $report->status === 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                                <option value="resolved" {{ $report->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="admin_notes">Admin Notes:</label>
                            <textarea name="admin_notes" id="admin_notes" class="form-textarea" 
                                      placeholder="Add internal notes or observations...">{{ old('admin_notes', $report->admin_notes) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="send_email_response" id="send_email_response" value="1">
                                <span>Send email response to reporter</span>
                            </label>
                        </div>

                        <div class="form-group email-response-group" id="email_response_group" style="display: none;">
                            <label for="email_response">Email Response:</label>
                            <textarea name="email_response" id="email_response" class="form-textarea" 
                                      placeholder="Write your response to the reporter...">{{ old('email_response') }}</textarea>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Report
                            </button>
                            <a href="{{ route('admin.reports') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sendEmailCheckbox = document.getElementById('send_email_response');
            const emailResponseGroup = document.getElementById('email_response_group');

            sendEmailCheckbox.addEventListener('change', function() {
                emailResponseGroup.style.display = this.checked ? 'block' : 'none';
            });
        });
    </script>
</body>
</html>