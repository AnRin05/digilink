<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - Admin</title>
    <style>
        /* Same layout & theme as ongoing bookings */
        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif}
        :root{
            --primary-red:#dc3545;--dark-red:#c82333;--black:#212529;--white:#fff;
            --light-bg:#f1f1f1;--border-color:rgba(0,0,0,0.08);--hover-bg:rgba(220,53,69,0.1)
        }
        body{background:var(--light-bg);color:var(--black);min-height:100vh}
        .admin-header{background:linear-gradient(135deg,var(--black),#343a40);padding:1.5rem 3rem;
            box-shadow:0 4px 20px rgba(0,0,0,0.15);border-bottom:3px solid var(--primary-red);
            display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem}
        .admin-header h1{color:var(--primary-red);font-size:2.2rem;font-weight:700;text-shadow:0 2px 4px rgba(220,53,69,0.3)}
        .admin-nav{display:flex;gap:1rem;flex-wrap:wrap}
        .admin-nav a{color:var(--white);text-decoration:none;font-weight:500;padding:10px 20px;
            border-radius:8px;background:rgba(255,255,255,0.1);transition:.3s}
        .admin-nav a:hover{color:var(--primary-red);background:var(--hover-bg);transform:translateY(-2px)}
        .admin-main{max-width:1400px;margin:2rem auto;padding:0 2rem}
        .page-header{margin-bottom:2rem;display:flex;justify-content:space-between;flex-wrap:wrap;gap:1rem}
        .page-header-content h1{font-size:2.2rem;font-weight:700;color:var(--black);margin-bottom:.5rem;position:relative;display:inline-block}
        .page-header-content h1::after{content:'';position:absolute;bottom:-8px;left:0;width:60px;height:3px;background:var(--primary-red)}
        .back-button{display:inline-flex;align-items:center;gap:8px;padding:10px 20px;background:var(--primary-red);
            color:var(--white);text-decoration:none;border-radius:8px;font-weight:500;transition:.3s}
        .back-button:hover{background:var(--dark-red);transform:translateY(-2px)}
        .section-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;flex-wrap:wrap}
        .section-title{font-size:1.8rem;font-weight:700;color:var(--black);position:relative;display:inline-block}
        .section-title::after{content:'';position:absolute;bottom:-8px;left:0;width:60px;height:3px;background:var(--primary-red)}
        .section-badge{background:var(--primary-red);color:var(--white);padding:8px 16px;border-radius:20px;font-weight:600}
        .bookings-table-container{background:var(--white);border-radius:15px;padding:1.5rem;
            box-shadow:0 4px 15px rgba(0,0,0,0.05);border:2px solid var(--border-color);overflow:hidden}
        .table-wrapper{overflow-x:auto;border-radius:10px}
        table{width:100%;border-collapse:collapse;min-width:1000px}
        th,td{padding:1rem;text-align:left;border-bottom:1px solid var(--border-color)}
        th{background:var(--hover-bg);font-weight:600}
        tr:hover{background:var(--hover-bg)}
        .status-badge{padding:6px 12px;border-radius:20px;font-size:.8rem;font-weight:600;text-transform:uppercase}
        .status-cancelled{background:#f8d7da;color:#721c24;border:1px solid #f5c6cb}
        .service-badge{padding:4px 8px;border-radius:6px;font-size:.75rem;font-weight:600}
        .service-ride{background:#007bff;color:#fff}
        .service-delivery{background:#28a745;color:#fff}
        .empty-state{text-align:center;padding:3rem 2rem;color:var(--black);opacity:.6}
    </style>
</head>
<body>
<header class="admin-header">
    <h1>Admin</h1>
    <nav class="admin-nav">
        <a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="{{ route('admin.passengers') }}"><i class="fas fa-users"></i> Passengers</a>
        <a href="{{ route('admin.drivers') }}"><i class="fas fa-id-card"></i> Drivers</a>
        <a href="{{ route('admin.analytics') }}"><i class="fas fa-chart-bar"></i> Analytics</a>
        <a href="{{ route('admin.reports') }}"><i class="fas fa-file-alt"></i> Reports & History</a>
    </nav>
</header>

<main class="admin-main">
    <div class="page-header">
        <div class="page-header-content">
            <h1>{{ $title }}</h1>
            <p>Cancelled bookings for this {{ $type }}</p>
        </div>
        <a href="{{ route('admin.reports') }}" class="back-button"><i class="fas fa-arrow-left"></i> Back to Reports</a>
    </div>

    <section class="bookings-section">
        <div class="section-header">
            <h2 class="section-title">Cancelled Bookings</h2>
            <span class="section-badge">{{ $cancelledBookings->count() }} Total</span>
        </div>

        @if($cancelledBookings->count() > 0)
        <div class="bookings-table-container">
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>{{ $type === 'passenger' ? 'Driver' : 'Passenger' }}</th>
                            <th>Pickup Location</th>
                            <th>Dropoff Location</th>
                            <th>Status</th>
                            <th>Service Type</th>
                            <th>Fare</th>
                            <th>Cancelled At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cancelledBookings as $booking)
                        <tr>
                            <td>
                                @if($type === 'passenger')
                                    {{ $booking->driver->fullname ?? 'N/A' }}
                                @else
                                    {{ $booking->passenger->fullname ?? 'N/A' }}
                                @endif
                            </td>
                            <td>{{ $booking->pickupLocation }}</td>
                            <td>{{ $booking->dropoffLocation }}</td>
                            <td><span class="status-badge status-cancelled">Cancelled</span></td>
                            <td>
                                @if($booking->serviceType === 'Ride')
                                    <span class="service-badge service-ride">Ride</span>
                                @else
                                    <span class="service-badge service-delivery">Delivery</span>
                                @endif
                            </td>
                            <td><strong>{{ $booking->getFormattedFare() }}</strong></td>
                            <td><small>{{ $booking->updated_at->format('M d, Y h:i A') }}</small></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <div class="empty-state">
            <i class="fas fa-ban fa-3x"></i>
            <h3>No Cancelled Bookings</h3>
            <p>This {{ $type }} has no cancelled bookings recorded.</p>
        </div>
        @endif
    </section>
</main>
</body>
</html>
