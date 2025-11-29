<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Submitted - FastLan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="{{ asset('css/nav.css') }}" rel="stylesheet">
    <link href="{{ asset('css/waiting.css') }}" rel="stylesheet">
    @yield('styles')
    <link rel="icon" href="{{ asset('images/fastlan1.png') }}">
</head>
<body>
    <nav>
        <div class="nav-left">
            <a href="#" class="nav-brand">Fast<span>Lan</span></a>
        </div>
        <div class="nav-right">
            <ul>
                <li><a href="/digilink/public">Home</a></li>
                <li><a href="login">Login</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </div>
    </nav>

    <div class="main-container">
        <div class="success-container">
            <div class="success-header">
                <div class="success-icon">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <h1>Still Pending!</h1>
                <p>Your driver is still waiting to be approve!</p>
            </div>
            <div class="success-body">
                    <div class="timeline">
                        <h4><i class="fas fa-calendar-alt"></i> Expected Timeline:</h4>
                        <div class="timeline-item">
                            <i class="fas fa-hourglass-start"></i>
                            <span><strong>1-2 days:</strong> Initial document review</span>
                        </div>
                        <div class="timeline-item">
                            <i class="fas fa-search"></i>
                            <span><strong>3-5 days:</strong> Background verification</span>
                        </div>
                        <div class="timeline-item">
                            <i class="fas fa-check"></i>
                            <span><strong>5-7 days:</strong> Final approval and account activation</span>
                        </div>
                    </div>
                    <div class="contact-info">
                        <h4><i class="fas fa-question-circle"></i> Need Help?</h4>
                        <p><i class="fas fa-phone"></i> Call us: +63 (955) 123-4567</p>
                        <p><i class="fas fa-envelope"></i> Email: drivers@fastlan.com</p>
                        <p><i class="fas fa-clock"></i> Support Hours: Mon-Fri, 8:00 AM - 6:00 PM</p>
                    </div>
                </div>
                <div style="margin-bottom: 2rem;">
                    <a href="/digilink/public" class="btn btn-primary">
                        <i class="fas fa-home"></i> Return to Home
                    </a>
                </div>
            </div>
        </div>
    </div>

    <footer>
        @include('footer')
    </footer>
</body>
</html>