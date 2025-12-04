<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FastLan - Driver Signup</title>
    <link rel="shortcut icon" href="images/fastlan.png" type="image/x-icon">
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
            color: #212529;
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        .main-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 2rem;
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
        }

        .form-container {
            width: 100%;
            max-width: 1200px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.08);
        }

        .form-header {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
            padding: 3rem 2rem;
            text-align: center;
        }

        .form-header h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .form-header p {
            font-size: 1.2rem;
            opacity: 0.95;
        }

        .form-progress {
            padding: 2rem;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #e9ecef;
        }

        .progress-bar {
            flex: 1;
            height: 12px;
            background: #e9ecef;
            border-radius: 6px;
            overflow: hidden;
            margin-right: 1.5rem;
        }

        .progress-fill {
            height: 100%;
            width: 0%;
            background: linear-gradient(135deg, #dc3545 0%, #e63946 100%);
            border-radius: 6px;
            transition: width 0.8s ease;
        }

        .progress-text {
            font-weight: 700;
            color: #212529;
            font-size: 1rem;
            min-width: 100px;
            text-align: right;
        }

        .form-body {
            padding: 2.5rem;
        }

        .form-steps {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .form-step {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            border: 1px solid #e9ecef;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            position: relative;
        }

        .step-number {
            position: absolute;
            top: -20px;
            left: -20px;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.4rem;
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
            border: 3px solid white;
        }

        .step-title {
            font-size: 1.4rem;
            color: #212529;
            margin-bottom: 2rem;
            padding-bottom: 0.8rem;
            border-bottom: 3px solid #dc3545;
            font-weight: 700;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #212529;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 1rem;
            color: #212529;
            background: white;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #dc3545;
            outline: none;
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
        }

        .form-hint {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 0.5rem;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.85rem;
            margin-top: 0.5rem;
            display: none;
            font-weight: 500;
        }

        .file-upload {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .file-upload-label {
            display: block;
            padding: 20px;
            background: #f8f9fa;
            border: 2px dashed #ced4da;
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            color: #495057;
        }

        .file-upload-label:hover {
            background: #e9ecef;
            border-color: #dc3545;
            color: #dc3545;
        }

        .file-upload-label i {
            margin-right: 10px;
            color: #dc3545;
        }

        .file-upload-input {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .password-strength {
            height: 8px;
            background: #e9ecef;
            border-radius: 4px;
            margin-top: 0.5rem;
            overflow: hidden;
        }

        .password-strength-meter {
            height: 100%;
            width: 0;
            border-radius: 4px;
            transition: width 0.4s ease;
        }

        .weak { background: #dc3545; width: 33%; }
        .medium { background: #ffc107; width: 66%; }
        .strong { background: #28a745; width: 100%; }

        .password-feedback {
            font-size: 0.85rem;
            margin-top: 0.5rem;
            font-weight: 500;
        }

        .form-footer {
            padding: 2rem;
            background: #f8f9fa;
            border-top: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .terms-agreement {
            display: flex;
            align-items: center;
            font-size: 0.95rem;
            color: #495057;
        }

        .terms-agreement input[type="checkbox"] {
            margin-right: 12px;
            width: 18px;
            height: 18px;
            accent-color: #dc3545;
        }

        .terms-agreement a {
            color: #dc3545;
            text-decoration: none;
            font-weight: 600;
        }

        .form-buttons {
            display: flex;
            gap: 1rem;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            position: relative;
            overflow: hidden;
        }

        .btn i {
            margin-right: 8px;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-primary {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #c82333 0%, #a71e2a 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(220, 53, 69, 0.3);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #212529 0%, #343a40 100%);
            color: white;
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #343a40 0%, #495057 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(33, 37, 41, 0.3);
        }

        @media (max-width: 1200px) {
            .main-container {
                padding: 1.5rem;
            }
            
            .form-steps {
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                gap: 1.5rem;
            }
        }

        @media (max-width: 992px) {
            .form-container {
                border-radius: 18px;
            }
            
            .form-header {
                padding: 2.5rem 1.5rem;
            }
            
            .form-header h1 {
                font-size: 2.2rem;
            }
            
            .form-progress {
                padding: 1.5rem;
            }
            
            .form-body {
                padding: 1.5rem;
            }
            
            .form-steps {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .form-step {
                padding: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .main-container {
                padding: 1rem;
            }
            
            .form-container {
                border-radius: 16px;
            }
            
            .form-header h1 {
                font-size: 1.8rem;
            }
            
            .form-header p {
                font-size: 1rem;
            }
            
            .form-progress {
                padding: 1.2rem;
            }
            
            .progress-text {
                min-width: 80px;
                font-size: 0.9rem;
            }
            
            .form-steps {
                grid-template-columns: 1fr;
                gap: 1.2rem;
            }
            
            .form-step {
                padding: 1.2rem;
            }
            
            .step-number {
                width: 40px;
                height: 40px;
                font-size: 1.2rem;
                top: -15px;
                left: -15px;
            }
            
            .step-title {
                font-size: 1.2rem;
                margin-bottom: 1.5rem;
            }
            
            .form-footer {
                padding: 1.5rem;
                flex-direction: column;
                align-items: stretch;
                gap: 1.2rem;
            }
            
            .form-buttons {
                width: 100%;
                flex-direction: column;
                gap: 0.8rem;
            }
            
            .btn {
                width: 100%;
                padding: 12px 20px;
            }
        }

        @media (max-width: 480px) {
            .form-header {
                padding: 2rem 1rem;
            }
            
            .form-header h1 {
                font-size: 1.6rem;
            }
            
            .form-header p {
                font-size: 0.9rem;
            }
            
            .form-progress {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.8rem;
            }
            
            .progress-bar {
                width: 100%;
                margin-right: 0;
            }
            
            .progress-text {
                text-align: left;
            }
            
            .form-body {
                padding: 1rem;
            }
            
            .form-step {
                padding: 1rem;
            }
            
            .form-group {
                margin-bottom: 1.2rem;
            }
            
            .form-control {
                padding: 10px 14px;
                font-size: 16px;
            }
            
            .file-upload-label {
                padding: 15px;
            }
            
            .terms-agreement {
                font-size: 0.9rem;
            }
            
            .form-footer {
                padding: 1.2rem;
            }
        }

        @media (max-width: 375px) {
            .main-container {
                padding: 0.8rem;
            }
            
            .form-container {
                border-radius: 14px;
            }
            
            .form-header h1 {
                font-size: 1.4rem;
            }
            
            .form-step {
                padding: 0.8rem;
            }
            
            .step-number {
                width: 35px;
                height: 35px;
                font-size: 1rem;
                top: -12px;
                left: -12px;
            }
            
            .step-title {
                font-size: 1.1rem;
                margin-bottom: 1.2rem;
            }
            
            .form-control {
                padding: 8px 12px;
            }
            
            .btn {
                padding: 10px 16px;
                font-size: 0.9rem;
            }
        }

        @media (min-width: 1400px) {
            .main-container {
                padding: 3rem 2rem;
            }
            
            .form-container {
                max-width: 1300px;
            }
            
            .form-header {
                padding: 3.5rem 2rem;
            }
            
            .form-header h1 {
                font-size: 3rem;
            }
            
            .form-body {
                padding: 3rem;
            }
            
            .form-steps {
                gap: 2.5rem;
            }
            
            .form-step {
                padding: 2.5rem;
            }
            
            .form-footer {
                padding: 2.5rem;
            }
        }

        @media (orientation: landscape) and (max-height: 600px) {
            .main-container {
                padding: 1rem;
                align-items: flex-start;
                min-height: auto;
            }
            
            .form-container {
                margin: 0.5rem 0;
            }
            
            .form-header {
                padding: 1.5rem;
            }
            
            .form-body {
                padding: 1.5rem;
            }
            
            .form-steps {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-height: 700px) and (max-width: 768px) {
            .main-container {
                align-items: flex-start;
                padding-top: 1rem;
                padding-bottom: 1rem;
            }
            
            .form-container {
                max-height: 90vh;
                overflow-y: auto;
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
                <h1>Become a FastLan Driver</h1>
                <p>Join our network of professional drivers and start earning today</p>
            </div>
            
            <div class="form-progress">
                <div class="progress-bar">
                    <div class="progress-fill"></div>
                </div>
                <div class="progress-text">0% Complete</div>
            </div>
            
            <form id="driverForm" method="POST" enctype="multipart/form-data" action="{{ route('driver.signup') }}">
                @csrf
                <div class="form-body">
                    <div class="form-steps">
                        <div class="form-step">
                            <div class="step-number">1</div>
                            <h3 class="step-title">Personal Information</h3>
                            
                            <div class="form-group">
                                <label for="fullname">Full Name *</label>
                                <input type="text" id="fullname" name="fullname" class="form-control" required>
                                <div class="error-message" id="fullnameError">Full name is required</div>
                            </div>
                            
                            <div class="form-group">
                                <label for="email">Email Address *</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                                <div class="error-message" id="emailError">Enter a valid email address</div>
                            </div>
                            
                            <div class="form-group">
                                <label for="phone">Phone Number *</label>
                                <input type="tel" id="phone" name="phone" class="form-control" required pattern="^[0-9]{10,15}$">
                                <div class="form-hint">Format: 10–15 digits</div>
                                <div class="error-message" id="phoneError">Enter a valid phone number</div>
                            </div>
                        </div>
                        
                        <div class="form-step">
                            <div class="step-number">2</div>
                            <h3 class="step-title">License Information</h3>
                            
                            <div class="form-group">
                                <label for="licenseNumber">Driver's License Number *</label>
                                <input type="text" id="licenseNumber" name="licenseNumber" class="form-control" required>
                                <div class="error-message" id="licenseError">License number is required</div>
                            </div>
                            
                            <div class="form-group">
                                <label for="licenseExpiry">License Expiration Date *</label>
                                <input type="date" id="licenseExpiry" name="licenseExpiry" class="form-control" required>
                                <div class="error-message" id="expiryError">Expiration date is required</div>
                            </div>
                            
                            <div class="form-group">
                                <label>Upload License Photo</label>
                                <div class="file-upload">
                                    <label class="file-upload-label" for="licensePhoto">
                                        <i class="fas fa-upload"></i> Choose File
                                    </label>
                                    <input type="file" id="licensePhoto" name="licensePhoto" class="file-upload-input" accept=".jpg,.jpeg,.png,.pdf">
                                </div>
                                <div class="form-hint">Accepted formats: JPG, PNG, PDF</div>
                            </div>
                        </div>
                        
                        <div class="form-step">
                            <div class="step-number">3</div>
                            <h3 class="step-title">Vehicle Information</h3>
                            
                            <div class="form-group">
                                <label for="vehicleMake">Motorcycle Type *</label>
                                <select id="vehicleMake" name="vehicleMake" class="form-control" required>
                                    <option value="">--Select--</option>
                                    <option value="Scooter">Scooter</option>
                                    <option value="Underbone">Underbone</option>
                                    <option value="Big Bike">Big Bike</option>
                                    <option value="Utility">Utility</option>
                                </select>
                                <div class="error-message" id="makeError">Please select a type</div>
                            </div>
                            
                            <div class="form-group">
                                <label for="vehicleModel">Vehicle Brand *</label>
                                <input type="text" id="vehicleModel" name="vehicleModel" class="form-control" required>
                                <div class="error-message" id="modelError">Vehicle model is required</div>
                            </div>
                            
                            <div class="form-group">
                                <label for="plateNumber">Plate Number *</label>
                                <input type="text" id="plateNumber" name="plateNumber" class="form-control" required>
                                <div class="error-message" id="plateError">Plate number is required</div>
                            </div>
                            
                            <div class="form-group">
                                <label for="vehicleReg">Vehicle Registration Number *</label>
                                <input type="text" id="vehicleReg" name="vehicleReg" class="form-control" required>
                                <div class="error-message" id="vehicleRegError">Vehicle registration number is required</div>
                            </div>
                        </div>
                        
                        <div class="form-step">
                            <div class="step-number">4</div>
                            <h3 class="step-title">Documents & Security</h3>
                            
                            <div class="form-group">
                                <label>Upload OR/CR *</label>
                                <div class="file-upload">
                                    <label class="file-upload-label" for="orcrUpload">
                                        <i class="fas fa-upload"></i> Choose File
                                    </label>
                                    <input type="file" id="orcrUpload" name="orcrUpload" class="file-upload-input" accept=".jpg,.jpeg,.png,.pdf" required>
                                </div>
                                <div class="form-hint">Accepted formats: JPG, PNG, PDF</div>
                                <div class="error-message" id="orcrError">Please upload OR/CR</div>
                            </div>
                            
                            <div class="form-group">
                                <label for="password">Password *</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                                <div class="password-strength">
                                    <div class="password-strength-meter" id="passwordStrengthMeter"></div>
                                </div>
                                <div class="password-feedback" id="passwordFeedback"></div>
                                <div class="error-message" id="passwordError">Password is required</div>
                            </div>
                            
                            <div class="form-group">
                                <label for="confirmPassword">Confirm Password *</label>
                                <input type="password" id="confirmPassword" name="password_confirmation" class="form-control" required>
                                <div class="error-message" id="confirmPasswordError">Confirmation is required</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-footer">
                    <div class="terms-agreement">
                        <input type="checkbox" id="terms" name="terms" required>
                        <label for="terms">I agree to the <a href="#">Terms</a> and <a href="#">Privacy Policy</a></label>
                        <div class="error-message" id="termsError">You must agree before submitting</div>
                    </div>
                    
                    <div class="form-buttons">
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Clear
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> Submit Application
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <footer>
        @include('footer')
    </footer>

    <script>
        const form = document.getElementById('driverForm');
        const progressFill = document.querySelector('.progress-fill');
        const progressText = document.querySelector('.progress-text');
        const password = document.getElementById("password");
        const confirmPassword = document.getElementById("confirmPassword");
        const passwordStrengthMeter = document.getElementById("passwordStrengthMeter");
        const passwordFeedback = document.getElementById("passwordFeedback");

        function checkPasswordStrength(pass) {
            let strength = 0;
            
            if (pass.length >= 8) strength += 1;
            if (/[A-Z]/.test(pass)) strength += 1;
            if (/[0-9]/.test(pass)) strength += 1;
            if (/[!@#$%^&*(),.?":{}|<>]/.test(pass)) strength += 1;
            
            if (pass.length === 0) {
                passwordStrengthMeter.className = "password-strength-meter";
                passwordStrengthMeter.style.width = "0";
                passwordFeedback.textContent = "";
            } else if (strength <= 1) {
                passwordStrengthMeter.className = "password-strength-meter weak";
                passwordFeedback.textContent = "Weak password";
                passwordFeedback.style.color = "#dc3545";
            } else if (strength <= 3) {
                passwordStrengthMeter.className = "password-strength-meter medium";
                passwordFeedback.textContent = "Medium strength password";
                passwordFeedback.style.color = "#ffa500";
            } else {
                passwordStrengthMeter.className = "password-strength-meter strong";
                passwordFeedback.textContent = "Strong password";
                passwordFeedback.style.color = "#28a745";
            }
            
            return strength >= 3 && pass.length >= 5;
        }

        function updateProgressBar() {
            const fields = [...form.querySelectorAll('input[required], select[required]')];
            let filled = 0;
            
            fields.forEach(field => {
                if (field.type === 'checkbox') {
                    if (field.checked) filled++;
                } else {
                    if (field.value.trim() !== '') filled++;
                }
            });
            
            const progress = (filled / fields.length) * 100;
            progressFill.style.width = progress + '%';
            progressText.textContent = Math.round(progress) + '% Complete';
        }

        form.addEventListener("reset", function () {
            progressFill.style.width = "0%";
            progressText.textContent = "0% Complete";
            passwordStrengthMeter.className = "password-strength-meter";
            passwordStrengthMeter.style.width = "0";
            passwordFeedback.textContent = "";
        });

        form.addEventListener("input", function(e) {
            updateProgressBar();
            if (e.target.id === "password") {
                checkPasswordStrength(e.target.value);
            }
        });

        form.addEventListener("submit", function(e) {
            let valid = true;

            if (!checkPasswordStrength(password.value)) {
                document.getElementById("passwordError").textContent = "Password must be at least 5 characters and include uppercase, number, and symbol";
                document.getElementById("passwordError").style.display = "block";
                password.value = "";
                confirmPassword.value = "";
                valid = false;
            } else {
                document.getElementById("passwordError").style.display = "none";
            }

            if (password.value !== confirmPassword.value) {
                document.getElementById("confirmPasswordError").textContent = "Passwords do not match";
                document.getElementById("confirmPasswordError").style.display = "block";
                confirmPassword.value = "";
                valid = false;
            } else {
                document.getElementById("confirmPasswordError").style.display = "none";
            }

            form.querySelectorAll('input[required], select[required]').forEach(field => {
                const errorEl = document.getElementById(field.id + 'Error');
                if (field.hasAttribute('required') && !field.value.trim()) {
                    if (errorEl) {
                        errorEl.style.display = 'block';
                        errorEl.textContent = field.type === 'tel' ? 'Enter a valid phone number' : 'This field is required';
                    }
                    valid = false;
                } else if (field.type === 'tel' && !field.value.match(/^[0-9]{10,15}$/)) {
                    if (errorEl) {
                        errorEl.style.display = 'block';
                        errorEl.textContent = 'Enter a valid phone number (10-15 digits)';
                    }
                    valid = false;
                } else {
                    if (errorEl) errorEl.style.display = 'none';
                }
            });

            if (!valid) {
                e.preventDefault();
                const firstError = form.querySelector('.error-message[style="display: block"]');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });

        updateProgressBar();
    </script>
</body>
</html>