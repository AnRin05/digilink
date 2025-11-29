<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Details - {{ $driver->fullname }}</title>
        <link href="{{ asset('css/admin/driver-details.css') }}" rel="stylesheet">
    @yield('styles')
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
        </nav>
    </header>
    

    <main>
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

        <section>
            <h2>Driver Profile</h2>
            <div class="driver-profile">
                <!-- Driver Image Card -->
                <div class="image-card">
                        <div class="image-placeholder" style="padding: 0.1cm">
                            <span class="info-label">DRIVER PROFILE PICTURE</span>
                        </div>
                     <img id="profileImage" 
                         src="{{ $driver->getProfileImageUrl() }}" 
                         alt="Profile Picture" 
                         class="profile-image">
                    <hr>
                    <div>
                        <span class="info-label">Completed Bookings:</span>
                        <span class="info-value">{{ $driver->completedBooking}}</span>
                    </div>
                    <div>
                        <span class="info-label">Cuurent Location:</span>
                        <span class="info-value">{{ $driver->currentLocation}}</span>
                    </div>
                    <div>
                        <span class="info-label">Service Type:</span>
                        <span class="info-value">{{ $driver->serviceType}}</span>
                    </div>
                </div>

                

                <!-- Driver Information Card -->
                <div class="info-card">
                    <div class="driver-info">
                        <div class="info-item">
                            <span class="info-label">Full Name</span>
                            <span class="info-value">{{ $driver->fullname }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Email Address</span>
                            <span class="info-value">{{ $driver->email }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Phone Number</span>
                            <span class="info-value">{{ $driver->phone }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">License Number</span>
                            <span class="info-value">{{ $driver->licenseNumber }}</span>
                        </div>
                        <div class="info-item">
                            <a href="{{ asset('storage/' . $driver->licensePhoto) }}" target="_blank" class="info-value" style="text-decoration:none;">
                            <i class="fas fa-eye"></i> View Current License Photo
                            <a href="{{ asset('storage/' . $driver->orcrUpload) }}" target="_blank" class="info-value" style="text-decoration:none;">
                            <i class="fas fa-eye"></i> View Current ORCR
                        </a>
                        </div>
                        <div class="info-item">
                            <span class="info-label">License Expiry</span>
                            <span class="info-value">{{ $driver->licenseExpiry }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Vehicle</span>
                            <span class="info-value">{{ $driver->vehicleMake }} {{ $driver->vehicleModel }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Plate Number</span>
                            <span class="info-value">{{ $driver->plateNumber }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Account Created</span>
                            <span class="info-value">{{ $driver->created_at->format('M d, Y \\a\\t H:i') }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Status</span>
                            <span class="info-value">
                                @if($driver->is_approved)
                                    <span class="status-badge status-approved">
                                        <i class="fas fa-check-circle"></i> Approved
                                    </span>
                                @else
                                    <span class="status-badge status-pending">
                                        <i class="fas fa-clock"></i> Pending Approval
                                    </span>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="driver-actions-section">
            <h3>Driver Actions</h3>
            <div class="actions-container">
                <div class="actions-grid">
                    @if(!$driver->is_approved)
                        <form action="{{ route('admin.driver.approve', $driver->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-approve" onclick="return confirmApprove()">
                                <i class="fas fa-check-circle"></i> Approve Driver
                            </button>
                        </form>
                        <form action="{{ route('admin.driver.reject', $driver->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-reject" onclick="return confirmReject()">
                                <i class="fas fa-times-circle"></i> Reject Driver
                            </button>
                        </form>
                    @endif
                    <form action="{{ route('admin.driver.delete', $driver->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete" onclick="return confirmDelete()">
                            <i class="fas fa-trash-alt"></i> Delete Driver
                        </button>
                    </form>
                    <a href="{{ route('admin.drivers') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Drivers List
                    </a>
                </div>
            </div>
        </section>
    </main>

    <script>
        function confirmDelete() {
            const driverName = "{{ $driver->fullname }}";
            return confirm(`Are you sure you want to delete ${driverName}? This action cannot be undone.`);
        }

        function confirmApprove() {
            const driverName = "{{ $driver->fullname }}";
            return confirm(`Are you sure you want to approve ${driverName}?`);
        }

        function confirmReject() {
            const driverName = "{{ $driver->fullname }}";
            return confirm(`Are you sure you want to reject ${driverName}?`);
        }

        // Add event listeners for confirmation
        document.addEventListener('DOMContentLoaded', function() {
            const approveBtn = document.querySelector('.btn-approve');
            const rejectBtn = document.querySelector('.btn-reject');
            const deleteBtn = document.querySelector('.btn-delete');

            if (approveBtn) {
                approveBtn.addEventListener('click', function(e) {
                    if (!confirmApprove()) {
                        e.preventDefault();
                    }
                });
            }

            if (rejectBtn) {
                rejectBtn.addEventListener('click', function(e) {
                    if (!confirmReject()) {
                        e.preventDefault();
                    }
                });
            }

            if (deleteBtn) {
                deleteBtn.addEventListener('click', function(e) {
                    if (!confirmDelete()) {
                        e.preventDefault();
                    }
                });
            }
        });
    </script>
</body>
</html>