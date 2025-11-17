<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FastLan - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite('resources/css/passign.css')
    <title>FastLan - Passenger Signup</title>
</head>
<body>
    <!-- Navigation -->
    <nav>
        @include('nav')
    </nav>
    
    <!-- Signup Form -->
    <div class="main-container">
        <div class="form-container">
            <div class="form-header">
                <h1>Passenger Signup</h1>
                <p>Create your account to start booking rides and delivery</p>
            </div>
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            <form id="signupForm" method="POST" action="{{ route('passenger.signup') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group">
                    <label for="fullname">Full Name *</label>
                    <input type="text" id="fullname" name="fullname" value="{{ old('fullname') }}" required>
                    @error('fullname')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}">
                    @error('phone')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="password">Password *</label>
                    <input type="password" id="password" name="password" required>
                    <small id="passwordHelp" class="error-message" style="display:none;">
                        Password must be at least 8 characters, include a capital letter and a symbol or number.
                    </small>
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password *</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required>
                    <small id="confirmHelp" class="error-message" style="display:none;">
                        Passwords do not match.
                    </small>
                </div>
                
                <div class="form-group">
                    <label for="profile_image">Profile Picture</label>
                    <input type="file" id="profile_image" name="profile_image" accept="image/*" required>
                    @error('profile_image')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-footer">
                    <button type="submit" class="btn btn-primary">Create Account</button>
                </div>
            </form>
            
            <div class="login-link">
                Already have an account? <a href="{{ route('login') }}">Login here</a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        @include('footer')
    </footer>

    <script>
        const form = document.getElementById("signupForm");
        const password = document.getElementById("password");
        const confirmPassword = document.getElementById("password_confirmation");
        const passwordHelp = document.getElementById("passwordHelp");
        const confirmHelp = document.getElementById("confirmHelp");

        function checkPasswordStrength(pass) {
            const hasUpper = /[A-Z]/.test(pass);
            const hasSymbolOrNumber = /[\d\W]/.test(pass);
            const longEnough = pass.length >= 8; // Changed to 8 characters
            return hasUpper && hasSymbolOrNumber && longEnough;
        }

        form.addEventListener("submit", function(e) {
            let valid = true;

            // Check strength
            if (!checkPasswordStrength(password.value)) {
                passwordHelp.style.display = "block";
                password.value = "";
                confirmPassword.value = "";
                valid = false;
            } else {
                passwordHelp.style.display = "none";
            }

            // Check match
            if (password.value !== confirmPassword.value) {
                confirmHelp.style.display = "block";
                confirmPassword.value = "";
                valid = false;
            } else {
                confirmHelp.style.display = "none";
            }

            if (!valid) {
                e.preventDefault();
            }
        });

        // Real-time password validation
        password.addEventListener('input', function() {
            if (password.value.length > 0 && !checkPasswordStrength(password.value)) {
                passwordHelp.style.display = "block";
            } else {
                passwordHelp.style.display = "none";
            }
        });

        // Real-time confirm password validation
        confirmPassword.addEventListener('input', function() {
            if (confirmPassword.value.length > 0 && password.value !== confirmPassword.value) {
                confirmHelp.style.display = "block";
            } else {
                confirmHelp.style.display = "none";
            }
        });
    </script>
</body>
</html>
