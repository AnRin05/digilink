<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FastLan - Passenger Signup</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="{{ asset('images/fastlan1.png') }}">
    <style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    display: flex;
    flex-direction: column;
    align-items: center;
    min-height: 100vh;
    overflow-x: hidden;
}

.main-container {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    padding: 40px 20px;
    flex-grow: 1;
}

.form-container {
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
    padding: 50px 40px;
    width: 100%;
    max-width: 520px;
    position: relative;
}

.form-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 4px;
    background: linear-gradient(90deg, #dc3545, #e63946);
    border-radius: 0 0 2px 2px;
}

.form-header {
    text-align: center;
    margin-bottom: 40px;
}

.form-header h1 {
    color: #212529;
    font-size: 2.4rem;
    font-weight: 700;
    margin-bottom: 10px;
}

.form-header p {
    color: #6c757d;
    font-size: 1.1rem;
    font-weight: 400;
    margin-top: 15px;
}

.form-group {
    margin-bottom: 25px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #212529;
    font-size: 0.95rem;
}

.form-group input {
    width: 100%;
    padding: 15px 20px;
    border: 2px solid #e9ecef;
    border-radius: 12px;
    font-size: 16px;
    color: #212529;
    background: #fff;
    transition: all 0.3s;
}

.form-group input:focus {
    border-color: #dc3545;
    outline: none;
    box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.1);
}

.form-group input[type="file"] {
    padding: 12px 15px;
    background: #f8f9fa;
    border: 2px dashed #dee2e6;
    cursor: pointer;
}

.error-message {
    color: #dc3545;
    font-size: 0.85rem;
    font-weight: 500;
    margin-top: 6px;
    display: flex;
    align-items: center;
}

.error-message::before {
    content: '⚠';
    margin-right: 6px;
    font-size: 0.9rem;
}

.alert {
    padding: 15px 20px;
    border-radius: 12px;
    margin-bottom: 25px;
    font-weight: 500;
}

.alert-danger {
    background: linear-gradient(135deg, #f8d7da, #f5c6cb);
    border: 1px solid #f1aeb5;
    color: #721c24;
}

.alert-success {
    background: linear-gradient(135deg, #d1edff, #b8daff);
    border: 1px solid #9ec5fe;
    color: #0a3622;
}

.alert ul {
    margin: 0;
    padding-left: 20px;
}

.form-footer {
    margin-top: 35px;
}

.btn {
    width: 100%;
    padding: 16px 30px;
    border: none;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    color: white;
    position: relative;
    overflow: hidden;
}

.btn:hover {
    background: linear-gradient(135deg, #c82333 0%, #a71e2a 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(220, 53, 69, 0.3);
}

.login-link {
    text-align: center;
    margin-top: 30px;
    padding-top: 25px;
    border-top: 1px solid #e9ecef;
    color: #6c757d;
    font-size: 0.95rem;
}

.login-link a {
    color: #dc3545;
    text-decoration: none;
    font-weight: 600;
}

.login-link a:hover {
    text-decoration: underline;
}

@media (max-width: 1024px) {
    .form-container {
        padding: 45px 35px;
        max-width: 500px;
    }
    
    .form-header h1 {
        font-size: 2.1rem;
    }
}

@media (max-width: 768px) {
    .main-container {
        padding: 30px 15px;
    }
    
    .form-container {
        padding: 40px 30px;
        border-radius: 18px;
    }
    
    .form-header h1 {
        font-size: 1.9rem;
    }
    
    .form-header p {
        font-size: 1rem;
    }
    
    .form-group input {
        padding: 14px 18px;
    }
    
    .btn {
        padding: 14px 25px;
    }
}

@media (max-width: 480px) {
    .main-container {
        padding: 20px 10px;
    }
    
    .form-container {
        padding: 30px 20px;
        border-radius: 16px;
    }
    
    .form-header h1 {
        font-size: 1.7rem;
    }
    
    .form-header p {
        font-size: 0.95rem;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-group input {
        padding: 12px 15px;
        font-size: 15px;
    }
    
    .btn {
        padding: 12px 20px;
        font-size: 15px;
    }
    
    .login-link {
        margin-top: 25px;
        padding-top: 20px;
        font-size: 0.9rem;
    }
}

@media (max-width: 375px) {
    .form-container {
        padding: 25px 15px;
        border-radius: 14px;
    }
    
    .form-header h1 {
        font-size: 1.5rem;
    }
    
    .form-header p {
        font-size: 0.9rem;
    }
    
    .form-group input {
        padding: 10px 12px;
        font-size: 14px;
    }
    
    .btn {
        padding: 10px 18px;
        font-size: 14px;
    }
}

@media (min-width: 1200px) {
    .form-container {
        max-width: 550px;
        padding: 55px 45px;
    }
    
    .form-header h1 {
        font-size: 2.6rem;
    }
    
    .form-header p {
        font-size: 1.2rem;
    }
}

@media (orientation: landscape) and (max-height: 600px) {
    .main-container {
        padding: 15px 20px;
        align-items: flex-start;
    }
    
    .form-container {
        margin: 10px 0;
    }
}
    </style>
</head>
<body>
    <nav>
        @include('nav')
    </nav>
    
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
                    <button type="submit" class="btn">Create Account</button>
                </div>
            </form>
            
            <div class="login-link">
                Already have an account? <a href="{{ route('login') }}">Login here</a>
            </div>
        </div>
    </div>

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
            const longEnough = pass.length >= 8;
            return hasUpper && hasSymbolOrNumber && longEnough;
        }

        form.addEventListener("submit", function(e) {
            let valid = true;

            if (!checkPasswordStrength(password.value)) {
                passwordHelp.style.display = "block";
                password.value = "";
                confirmPassword.value = "";
                valid = false;
            } else {
                passwordHelp.style.display = "none";
            }

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

        password.addEventListener('input', function() {
            if (password.value.length > 0 && !checkPasswordStrength(password.value)) {
                passwordHelp.style.display = "block";
            } else {
                passwordHelp.style.display = "none";
            }
        });

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