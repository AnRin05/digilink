<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin History and Report</title>
    @vite('resources/css/admin/report.css')
</head>
<body>
    <header class="admin-header">
        <div class="header-left">
            <h1>Admin History Reports</h1>
        </div>
        <nav class="admin-nav">
            <a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="{{ route('admin.passengers') }}"><i class="fas fa-users"></i> Passengers</a>
            <a href="{{ route('admin.drivers') }}"><i class="fas fa-id-card"></i> Drivers</a>
            
            <div class="more-menu-container">
                <button class="more-menu-trigger" id="moreMenuTrigger">
                    <i class="fas fa-ellipsis-h"></i> More
                </button>
                
                <div class="more-menu-dropdown" id="moreMenuDropdown">
                    <div class="more-menu-header">
                        <h3>More Options</h3>
                        <button class="back-btn" id="backButton">
                            <i class="fas fa-arrow-left"></i> Back
                        </button>
                    </div>
                    
                    <nav class="vertical-nav">
                        <a href="{{ route('admin.analytics') }}" class="nav-item">
                            <i class="fas fa-chart-bar"></i>
                            <span>Analytics</span>
                        </a>
                        
                        <div class="nav-section">
                            <h4>Booking Management</h4>
                            <a href="{{ route('admin.bookings.current') }}" class="nav-item">
                                <i class="fas fa-clock"></i>
                                <span>Current Bookings</span>
                            </a>
                            <a href="{{ route('admin.bookings.completed') }}" class="nav-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Completed Bookings</span>
                            </a>
                            <a href="{{ route('admin.bookings.cancelled') }}" class="nav-item">
                                <i class="fas fa-times-circle"></i>
                                <span>Cancelled Bookings</span>
                            </a>
                        </div>
                        
                        <a href="{{ route('admin.reports') }}" class="nav-item">
                            <i class="fas fa-file-alt"></i>
                            <span>Reports / History</span>
                        </a>
                        
                        <a href="{{ route('admin.notifications') }}" class="nav-item">
                            <i class="fas fa-bell"></i>
                            <span>Notifications</span>
                        </a>
                    </nav>
                </div>
            </div>
        </nav>
    </header>

    <main class="admin-main">
        <div class="search-container">
            <div class="search-box">
                <input type="text" id="searchInput" class="search-input" placeholder="Search passengers and drivers by name...">
            </div>
            <button class="search-button" id="searchButton">
                <i class="fas fa-search"></i> Search
            </button>
        </div>

        <div class="tab-content active" id="history-tab">
            <section class="history-section">
                <div class="section-header">
                    <h2 class="section-title">Passengers History</h2>
                    <span class="section-badge" id="passengers-count">{{ $passengers->count() }} Passengers</span>
                </div>
                
                <div id="passengers-results">
                    @if($passengers->count() > 0)
                        <div class="users-grid" id="passengers-grid">
                            @foreach($passengers as $passenger)
                            <div class="user-card passenger-card" data-name="{{ strtolower($passenger->fullname) }}">
                                <div class="user-header">
                                    <div class="user-info">
                                        <h3>{{ $passenger->fullname }}</h3>
                                        <p><i class="fas fa-envelope"></i> {{ $passenger->email }}</p>
                                        <p><i class="fas fa-phone"></i> {{ $passenger->phone ?? 'N/A' }}</p>
                                        <p><i class="fas fa-calendar"></i> Joined {{ $passenger->created_at->format('M d, Y') }}</p>
                                    </div>
                                    <div class="user-stats">
                                        <div class="user-badge">Passenger</div>
                                        <div class="bookings-count">{{ $passenger->ongoing_bookings_count + $passenger->completed_bookings_count + $passenger->cancelled_bookings_count }}</div>
                                        <div class="bookings-label">Total Bookings</div>
                                    </div>
                                </div>
                                
                                <div class="booking-stats">
                                    <div class="stat-row">
                                        <span class="stat-label">Ongoing:</span>
                                        <span class="stat-value">{{ $passenger->ongoing_bookings_count }}</span>
                                        @if($passenger->ongoing_bookings_count > 0)
                                        <a href="{{ route('admin.ongoing.bookings', ['type' => 'passenger', 'id' => $passenger->id]) }}" class="stat-link">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        @endif
                                    </div>
                                    <div class="stat-row">
                                        <span class="stat-label">Completed:</span>
                                        <span class="stat-value">{{ $passenger->completed_bookings_count }}</span>
                                        @if($passenger->completed_bookings_count > 0)
                                        <a href="{{ route('admin.view.completed.bookings', ['type' => 'passenger', 'id' => $passenger->id]) }}" class="stat-link">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        @endif
                                    </div>
                                    <div class="stat-row">
                                        <span class="stat-label">Cancelled:</span>
                                        <span class="stat-value">{{ $passenger->cancelled_bookings_count }}</span>
                                        @if($passenger->cancelled_bookings_count > 0)
                                        <a href="{{ route('admin.view.cancelled.bookings', ['type' => 'passenger', 'id' => $passenger->id]) }}" class="stat-link">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        @endif
                                    </div>
                                </div>
                                
                                @if($passenger->ongoing_bookings_count == 0 && $passenger->completed_bookings_count == 0 && $passenger->cancelled_bookings_count == 0)
                                    <div class="empty-state">
                                        <div class="empty-icon">
                                            <i class="fas fa-clipboard-list"></i>
                                        </div>
                                        <h4 class="empty-title">No Bookings</h4>
                                        <p class="empty-text">This passenger hasn't made any bookings yet.</p>
                                    </div>
                                @endif
                            </div>
                            @endforeach
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
                </div>
            </section>

            <section class="history-section">
                <div class="section-header">
                    <h2 class="section-title">Drivers History</h2>
                    <span class="section-badge" id="drivers-count">{{ $drivers->count() }} Drivers</span>
                </div>
                
                <div id="drivers-results">
                    @if($drivers->count() > 0)
                        <div class="users-grid" id="drivers-grid">
                            @foreach($drivers as $driver)
                            <div class="user-card driver-card" data-name="{{ strtolower($driver->fullname) }}">
                                <div class="user-header">
                                    <div class="user-info">
                                        <h3>{{ $driver->fullname }}</h3>
                                        <p><i class="fas fa-envelope"></i> {{ $driver->email }}</p>
                                        <p><i class="fas fa-phone"></i> {{ $driver->phone ?? 'N/A' }}</p>
                                        <p><i class="fas fa-car"></i> {{ $driver->vehicleMake ?? 'N/A' }} {{ $driver->vehicleModel ?? '' }}</p>
                                        <p><i class="fas fa-id-card"></i> {{ $driver->is_approved ? 'Approved' : 'Pending Approval' }}</p>
                                    </div>
                                    <div class="user-stats">
                                        <div class="user-badge">Driver</div>
                                        <div class="bookings-count">{{ $driver->ongoing_bookings_count + $driver->completed_bookings_count + $driver->cancelled_bookings_count }}</div>
                                        <div class="bookings-label">Total Bookings</div>
                                    </div>
                                </div>
                                
                                <div class="booking-stats">
                                    <div class="stat-row">
                                        <span class="stat-label">Assigned:</span>
                                        <span class="stat-value">{{ $driver->ongoing_bookings_count }}</span>
                                        @if($driver->ongoing_bookings_count > 0)
                                        <a href="{{ route('admin.ongoing.bookings', ['type' => 'driver', 'id' => $driver->id]) }}" class="stat-link">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        @endif
                                    </div>
                                    <div class="stat-row">
                                        <span class="stat-label">Completed:</span>
                                        <span class="stat-value">{{ $driver->completed_bookings_count }}</span>
                                        @if($driver->completed_bookings_count > 0)
                                        <a href="{{ route('admin.view.completed.bookings', ['type' => 'driver', 'id' => $driver->id]) }}" class="stat-link">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        @endif
                                    </div>
                                    <div class="stat-row">
                                        <span class="stat-label">Cancelled:</span>
                                        <span class="stat-value">{{ $driver->cancelled_bookings_count }}</span>
                                        @if($driver->cancelled_bookings_count > 0)
                                        <a href="{{ route('admin.view.cancelled.bookings', ['type' => 'driver', 'id' => $driver->id]) }}" class="stat-link">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        @endif
                                    </div>
                                </div>
                                
                                @if($driver->ongoing_bookings_count == 0 && $driver->completed_bookings_count == 0 && $driver->cancelled_bookings_count == 0)
                                    <div class="empty-state">
                                        <div class="empty-icon">
                                            <i class="fas fa-clipboard-list"></i>
                                        </div>
                                        <h4 class="empty-title">No Assignments</h4>
                                        <p class="empty-text">This driver doesn't have any bookings assigned.</p>
                                    </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-id-card-alt"></i>
                            </div>
                            <h3 class="empty-title">No Drivers Found</h3>
                            <p class="empty-text">There are no drivers in the system yet.</p>
                        </div>
                    @endif
                </div>
            </section>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const searchButton = document.getElementById('searchButton');
            const passengerCards = document.querySelectorAll('.passenger-card');
            const driverCards = document.querySelectorAll('.driver-card');
            const passengersCount = document.getElementById('passengers-count');
            const driversCount = document.getElementById('drivers-count');
            const passengersGrid = document.getElementById('passengers-grid');
            const driversGrid = document.getElementById('drivers-grid');
            const passengersResults = document.getElementById('passengers-results');
            const driversResults = document.getElementById('drivers-results');

            const moreMenuTrigger = document.getElementById('moreMenuTrigger');
            const moreMenuDropdown = document.getElementById('moreMenuDropdown');
            const backButton = document.getElementById('backButton');
            const moreMenuContainer = document.querySelector('.more-menu-container');

            let originalPassengersHTML = passengersResults.innerHTML;
            let originalDriversHTML = driversResults.innerHTML;
            let originalPassengersCount = {{ $passengers->count() }};
            let originalDriversCount = {{ $drivers->count() }};

            moreMenuTrigger.addEventListener('click', function() {
                moreMenuDropdown.classList.toggle('active');
            });

            backButton.addEventListener('click', function() {
                moreMenuDropdown.classList.remove('active');
            });

            document.addEventListener('click', function(event) {
                if (!moreMenuContainer.contains(event.target)) {
                    moreMenuDropdown.classList.remove('active');
                }
            });

            function performSearch() {
                const searchTerm = searchInput.value.toLowerCase().trim();
                let visiblePassengers = 0;
                let visibleDrivers = 0;

                if (searchTerm === '') {
                    passengersResults.innerHTML = originalPassengersHTML;
                    driversResults.innerHTML = originalDriversHTML;
                    passengersCount.textContent = `${originalPassengersCount} Passengers`;
                    driversCount.textContent = `${originalDriversCount} Drivers`;
                    return;
                }

                passengerCards.forEach(card => {
                    const name = card.getAttribute('data-name');
                    if (name.includes(searchTerm)) {
                        card.classList.remove('hidden');
                        visiblePassengers++;
                    } else {
                        card.classList.add('hidden');
                    }
                });

                driverCards.forEach(card => {
                    const name = card.getAttribute('data-name');
                    if (name.includes(searchTerm)) {
                        card.classList.remove('hidden');
                        visibleDrivers++;
                    } else {
                        card.classList.add('hidden');
                    }
                });

                passengersCount.textContent = `${visiblePassengers} Passengers`;
                driversCount.textContent = `${visibleDrivers} Drivers`;

                const visiblePassengerCards = document.querySelectorAll('.passenger-card:not(.hidden)');
                const visibleDriverCards = document.querySelectorAll('.driver-card:not(.hidden)');

                if (visiblePassengerCards.length === 0) {
                    if (!passengersResults.querySelector('.no-results')) {
                        const noResults = document.createElement('div');
                        noResults.className = 'no-results';
                        noResults.innerHTML = `
                            <i class="fas fa-search"></i>
                            <h3>No Passengers Found</h3>
                            <p>No passengers match your search criteria.</p>
                        `;
                        passengersResults.appendChild(noResults);
                    }
                } else {
                    const existingNoResults = passengersResults.querySelector('.no-results');
                    if (existingNoResults) {
                        existingNoResults.remove();
                    }
                }

                if (visibleDriverCards.length === 0) {
                    if (!driversResults.querySelector('.no-results')) {
                        const noResults = document.createElement('div');
                        noResults.className = 'no-results';
                        noResults.innerHTML = `
                            <i class="fas fa-search"></i>
                            <h3>No Drivers Found</h3>
                            <p>No drivers match your search criteria.</p>
                        `;
                        driversResults.appendChild(noResults);
                    }
                } else {
                    const existingNoResults = driversResults.querySelector('.no-results');
                    if (existingNoResults) {
                        existingNoResults.remove();
                    }
                }
            }

            searchInput.addEventListener('input', function() {
                if (this.value.trim() === '') {
                    passengersResults.innerHTML = originalPassengersHTML;
                    driversResults.innerHTML = originalDriversHTML;
                    passengersCount.textContent = `${originalPassengersCount} Passengers`;
                    driversCount.textContent = `${originalDriversCount} Drivers`;
                } else {
                    performSearch();
                }
            });

            searchButton.addEventListener('click', performSearch);

            searchInput.addEventListener('keyup', function(event) {
                if (event.key === 'Enter') {
                    performSearch();
                }
            });

            window.addEventListener('load', function() {
                originalPassengersHTML = passengersResults.innerHTML;
                originalDriversHTML = driversResults.innerHTML;
            });
        });
    </script>
</body>
</html>
