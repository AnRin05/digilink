<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FastLan - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="{{ asset('css/nav.css') }}" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <link href="{{ asset('js/login.js') }}" rel="stylesheet">
    @yield('styles')
    
    <link rel="icon" href="{{ asset('images/fastlan1.png') }}">
</head>
<body>
                                                  <!-- Navigation -->
    <nav>
        <div class="nav-left">
            <a class="nav-brand">Fast<span>Lan</span></a>
        </div>
        <div class="nav-middle">
        </div>
        <div class="nav-right">
            <ul>
                <li><a href="{{ route(name: 'home') }}">Home</a></li>
                <li><a href="#" class="active">Login</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </div>
    </nav>
                                                   <!-- Login Section -->
    <section class="login-container">
        @if ($errors->any())
            <div class="alert alert-error global-error">
                <i class="fas fa-exclamation-circle"></i>
                {{ $errors->first('email') }}
            </div>
        @endif

        @if (session('status'))
            <div class="alert alert-success global-success">
                <i class="fas fa-check-circle"></i>
                {{ session('status') }}
            </div>
        @endif

        <div class="login-box">
            <div class="login-logo">Fast<span style="color: #1b1b1b;">Lan</span></div>
            <h2>Login to Your Account</h2>
            
            <form id="login-form" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="input-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required>
                </div>
                
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    @error('password')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="login-options">
                    <div class="remember-me">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Remember me</label>
                    </div>
                    <a href="#" class="forgot-password">Forgot Password?</a>
                </div>
                
                <button type="submit" class="login-btn">Login</button>
                <div class="signup-link">
                    Don't have an account? <a href="choice">Sign up now</a>
                </div>
            </div>
            </form>
        </div>
    </section>

                                                  <!-- Footer -->
    <footer>
        @include('footer')
    </footer>
    
    <script>
        document.querySelector('.social-btn.facebook').addEventListener('click', function() {
            alert('Facebook login not implemented yet');
        });
        
        document.querySelector('.social-btn.google').addEventListener('click', function() {
            alert('Google login not implemented yet');
        });
    </script>
</body>
</html>