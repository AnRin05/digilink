<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passengers Management</title>
    @vite('resources/css/admin/passenger.css')
</head>
<body>
    <header>
        <h1>Passengers Management</h1>
        <nav>
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

        <section>
            <h2>All Passengers</h2>
            @if($passengers->count() > 0)
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($passengers as $passenger)
                            <tr>
                                <td>{{ $passenger->fullname }}</td>
                                <td>{{ $passenger->email }}</td>
                                <td>{{ $passenger->phone }}</td>
                                <td>{{ $passenger->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('admin.passenger.show', $passenger->id) }}" class="btn btn-view">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        <a href="{{ route('admin.passenger.delete', $passenger->id) }}" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this passenger?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </a>
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
                        <i class="fas fa-users-slash"></i>
                    </div>
                    <h3 class="empty-title">No Passengers Found</h3>
                    <p class="empty-text">There are no passengers in the system yet.</p>
                </div>
            @endif
        </section>
    </main>

    <script>
        // Simple confirmation for actions
        function confirmAction(message) {
            return confirm(message || 'Are you sure?');
        }
    </script>
</body>
</html>