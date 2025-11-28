<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver</title>
    <link rel="icon" href="{{ asset('images/fastlan1.png') }}">
    @vite('resources/css/admin/driver.css')
</head>
<body>
    <header>
        <h1>Drivers Management</h1>
        <nav>
            <a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="{{ route('admin.passengers') }}"><i class="fas fa-users"></i> Passengers</a>
            <a href="{{ route('admin.drivers') }}"><i class="fas fa-id-card"></i> Drivers</a>
            <form action="{{ route('logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit" class="logout-btn" onclick="return confirm('Are you sure you want to logout?')">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </nav>
    </header>
    <main>
        <section>
            <h2>All Driver</h2>
            <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>License Number</th>
                        <th>Vehicle</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($drivers as $driver)
                    <tr>
                        <td>{{ $driver->fullname }}</td>
                        <td>{{ $driver->email }}</td>
                        <td>{{ $driver->phone }}</td>
                        <td>{{ $driver->licenseNumber }}</td>
                        <td>{{ $driver->vehicleMake }} {{ $driver->vehicleModel }}</td>
                        <td>
                            @if($driver->is_approved)
                                <span class="status-badge status-approved">
                                    <i class="fas fa-check-circle"></i> Approved
                                </span>
                            @else
                                <span class="status-badge status-pending">
                                    <i class="fas fa-clock"></i> Pending
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('admin.driver.show', $driver->id) }}" class="btn btn-view">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                @if(!$driver->is_approved)
                                    <form action="{{ route('admin.driver.approve', $driver->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-approve">
                                            <i class="fas fa-check"></i> Approve
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.driver.reject', $driver->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-reject">
                                            <i class="fas fa-times"></i> Reject
                                        </button>
                                    </form>
                                    @endif
                                    <form action="{{ route('admin.driver.delete', $driver->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this driver?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </main>

@if($drivers->count() === 0)
<div class="empty-state">
    <div class="empty-icon">
        <i class="fas fa-user-times"></i>
    </div>
    <h3 class="empty-title">No Drivers Found</h3>
    <p class="empty-text">There are no drivers in the system yet.</p>
</div>
@endif

<script>
function confirmAction(action, name) {
    const messages = {
        'delete': `Are you sure you want to delete ${name}? This action cannot be undone.`,
        'approve': `Are you sure you want to approve ${name}?`,
        'reject': `Are you sure you want to reject ${name}?`
    };
    
    return confirm(messages[action] || 'Are you sure?');
}

document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.btn-delete');
    const approveButtons = document.querySelectorAll('.btn-approve');
    const rejectButtons = document.querySelectorAll('.btn-reject');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const driverName = this.closest('tr').querySelector('td:first-child').textContent;
            if (!confirmAction('delete', driverName)) {
                e.preventDefault();
            }
        });
    });
    
    approveButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const driverName = this.closest('tr').querySelector('td:first-child').textContent;
            if (!confirmAction('approve', driverName)) {
                e.preventDefault();
            }
        });
    });
    
    rejectButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const driverName = this.closest('tr').querySelector('td:first-child').textContent;
            if (!confirmAction('reject', driverName)) {
                e.preventDefault();
            }
        });
    });
});
</script>
</body>
</html>