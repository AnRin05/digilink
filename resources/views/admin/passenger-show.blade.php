<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passenger Details</title>
    @vite('resources/css/admin/passenger-details.css')
    <link rel="icon" href="{{ asset('images/fastlan1.png') }}">
</head>
<body>
    <header>
        <h1>Passenger Details</h1>
        <nav>
            <a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="{{ route('admin.passengers') }}"><i class="fas fa-users"></i> Passengers</a>
            <a href="{{ route('admin.drivers') }}"><i class="fas fa-id-card"></i> Drivers</a>
        </nav>
    </header>

    <main>
        <section>
            <h2>Passenger Information</h2>
            <div class="info-card">
                <div class="passenger-info">
                    <div class="info-item">
                        <span class="info-label">Full Name</span>
                        <span class="info-value">{{ $passenger->fullname }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Email Address</span>
                        <span class="info-value">{{ $passenger->email }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Phone Number</span>
                        <span class="info-value">{{ $passenger->phone }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Account Created</span>
                        <span class="info-value">{{ $passenger->created_at->format('M d, Y \\a\\t H:i') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Last Updated</span>
                        <span class="info-value">{{ $passenger->updated_at->format('M d, Y \\a\\t H:i') }}</span>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <h3>Actions</h3>
            <div class="actions-container">
                <div class="actions-grid">
                    <a href="{{ route('admin.passenger.delete', $passenger->id) }}" 
                       class="btn btn-danger" 
                       onclick="return confirm('Are you sure you want to delete this passenger? This action cannot be undone.')">
                        <i class="fas fa-trash"></i> Delete Passenger
                    </a>
                    <a href="{{ route('admin.passengers') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Passengers List
                    </a>
                </div>
            </div>
        </section>
    </main>

    <script>
        // Enhanced confirmation for delete action
        function confirmDelete() {
            return confirm('Are you sure you want to delete this passenger? This action cannot be undone.');
        }
        
        // Add event listener for delete button
        document.addEventListener('DOMContentLoaded', function() {
            const deleteBtn = document.querySelector('.btn-danger');
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