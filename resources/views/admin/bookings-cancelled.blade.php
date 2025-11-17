<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancelled Bookings</title>
    <style>
        /* Cancelled Bookings Styles - Red, Black & White Theme */
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

        /* Page Header */
        .page-header {
            margin-bottom: 2rem;
        }

        .page-header h1 {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--black);
            margin-bottom: 0.5rem;
            position: relative;
            display: inline-block;
        }

        .page-header h1::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 60px;
            height: 3px;
            background: var(--primary-red);
            border-radius: 2px;
        }

        .page-header p {
            color: #6b7280;
            font-size: 1.1rem;
            opacity: 0.8;
        }

        /* Bookings Table */
        .bookings-section {
            margin-bottom: 3rem;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .section-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--black);
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 60px;
            height: 3px;
            background: var(--primary-red);
            border-radius: 2px;
        }

        .section-badge {
            background: var(--primary-red);
            color: var(--white);
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
        }

        .bookings-table-container {
            background: var(--white);
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 2px solid var(--border-color);
            overflow: hidden;
        }

        .bookings-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
        }

        .bookings-table th {
            background: var(--hover-bg);
            color: var(--black);
            font-weight: 600;
            padding: 1rem;
            text-align: left;
            border-bottom: 2px solid var(--border-color);
        }

        .bookings-table td {
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
            color: var(--black);
            opacity: 0.8;
        }

        .bookings-table tr:last-child td {
            border-bottom: none;
        }

        .bookings-table tr:hover {
            background: var(--hover-bg);
        }

        /* Status Badges */
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Service Type Badges */
        .service-badge {
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .service-ride {
            background: #007bff;
            color: white;
        }

        .service-delivery {
            background: #28a745;
            color: white;
        }

        /* Payment Method */
        .payment-method {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
        }

        .payment-cash {
            color: #28a745;
        }

        .payment-gcash {
            color: #007bff;
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

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            color: var(--black);
            opacity: 0.6;
        }

        .empty-icon {
            font-size: 4rem;
            color: var(--border-color);
            margin-bottom: 1rem;
        }

        .empty-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--black);
        }

        .empty-text {
            margin-bottom: 1.5rem;
            color: var(--black);
            opacity: 0.7;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .admin-main {
                padding: 0 1.5rem;
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
            
            .bookings-table-container {
                padding: 1rem;
                overflow-x: auto;
            }
            
            .bookings-table {
                min-width: 800px;
            }
            
            .section-header {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        @media (max-width: 480px) {
            .page-header h1 {
                font-size: 1.8rem;
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
            <h1>Admin Booking</h1>
        </div>
        <nav class="admin-nav">
            <a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="{{ route('admin.passengers') }}"><i class="fas fa-users"></i> Passengers</a>
            <a href="{{ route('admin.drivers') }}"><i class="fas fa-id-card"></i> Drivers</a>
            <a href="{{ route('admin.analytics') }}"><i class="fas fa-chart-bar"></i> Analytics</a>
        </nav>
    </header>

    <main class="admin-main">
        <div class="page-header">
            <h1>Cancelled Bookings</h1>
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

        <section class="bookings-section">
            <div class="section-header">
                <span class="section-badge">{{ $cancelledBookings->count() }} Total</span>
            </div>
            
            @if($cancelledBookings->count() > 0)
                <div class="bookings-table-container">
                    <table class="bookings-table">
                        <thead>
                            <tr>
                                <th>Passenger</th>
                                <th>Driver</th>
                                <th>Pickup Location</th>
                                <th>Dropoff Location</th>
                                <th>Status</th>
                                <th>Service Type</th>
                                <th>Payment Method</th>
                                <th>Fare</th>
                                <th>Cancelled At</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cancelledBookings as $booking)
                            <tr>
                                <td>
                                    <strong>{{ $booking->passenger->fullname ?? 'N/A' }}</strong>
                                    <br>
                                    <small>{{ $booking->passenger->email ?? 'N/A' }}</small>
                                </td>
                                <td>
                                    @if($booking->driver)
                                        <strong>{{ $booking->driver->fullname }}</strong>
                                        <br>
                                        <small>{{ $booking->driver->email }}</small>
                                    @else
                                        <span style="color: #6b7280; font-style: italic;">Not assigned</span>
                                    @endif
                                </td>
                                <td>{{ $booking->pickupLocation }}</td>
                                <td>{{ $booking->dropoffLocation }}</td>
                                <td>
                                    <span class="status-badge status-cancelled">Cancelled</span>
                                </td>
                                <td>
                                    @if($booking->serviceType === \App\Models\Booking::SERVICE_BOOKING_TO_GO)
                                        <span class="service-badge service-ride">Ride</span>
                                    @elseif($booking->serviceType === \App\Models\Booking::SERVICE_FOR_DELIVERY)
                                        <span class="service-badge service-delivery">Delivery</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="payment-method">
                                        @if($booking->paymentMethod === \App\Models\Booking::PAYMENT_CASH)
                                            <i class="fas fa-money-bill-wave payment-cash"></i>
                                            <span>Cash</span>
                                        @elseif($booking->paymentMethod === \App\Models\Booking::PAYMENT_GCASH)
                                            <i class="fas fa-mobile-alt payment-gcash"></i>
                                            <span>GCash</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <strong>{{ $booking->getFormattedFare() }}</strong>
                                </td>
                                <td>
                                    <small>{{ $booking->updated_at->format('M d, Y h:i A') }}</small>
                                </td>
                                <td>
                                    <small>{{ $booking->created_at->format('M d, Y h:i A') }}</small>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <h3 class="empty-title">No Cancelled Bookings</h3>
                    <p class="empty-text">There are no cancelled bookings in the system yet.</p>
                </div>
            @endif
        </section>
    </main>
</body>
</html>