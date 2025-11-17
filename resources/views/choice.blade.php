<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FastLan - Sign Up</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite('resources/css/choice.css')
    @vite('resources/css/nav.css')
    <link rel="icon" href="{{ asset('images/fastlan1.png') }}">
</head>
<body>
                                                            <!-- Navigation -->
    <nav>
        @include('nav')
    </nav>

                                                            <!-- Main Content -->
<div class="container">
    <div class="card">
        <h1>Join <span>FastLan</span></h1>
        <p>Select the type of account that best describes you.</p>
        
        <div class="options-container">
            <!-- Passenger Option -->
            <a href="{{ route('passign') }}" class="option-card" id="passenger-btn">
                <div class="icon-container">
                    <i class="fas fa-user icon"></i>
                </div>
                <h3>Passenger</h3>
                <p>Book rides & deliveries</p>
            </a>

            <!-- Driver Option -->
            <a href="{{ route('driversign') }}" class="option-card" id="driver-btn">
                <div class="icon-container">
                    <i class="fas fa-motorcycle icon"></i>
                </div>
                <h3>Driver</h3>
                <p>Provide ride & delivery services</p>
            </a>
        </div>

        <div class="login-link">
            Already have an account? <a href="{{ route('login') }}">Log in here</a>
        </div>
    </div>
</div>

<!-- Footer -->
<footer>
    @include('footer')
</footer>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const passengerBtn = document.getElementById('passenger-btn');
        const driverBtn = document.getElementById('driver-btn');

        passengerBtn.addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = '{{ route("passign") }}'; 
        });

        driverBtn.addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = '{{ route("driversign") }}'; 
        });
    });
</script>
</body>
</html>