<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FastLan - Driver Signup</title>
    <link rel="shortcut icon" href="images/fastlan.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite('resources/css/driversign.css')
    @vite('resources/css/nav.css')
    <link rel="icon" href="{{ asset('images/fastlan1.png') }}">
</head>
<body>
                                                            <!-- Navigation -->
    <nav>
         @include('nav')
    </nav>

                                                            <!-- Main Content -->
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
                                                            <!-- Personal Information -->
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
                        
                                                            <!-- License Information -->
                        <div class="form-step">
                            <div class="step-number">2</div>
                            <h3 class="step-title">License Information</h3>
                            
                            <div class="form-group">
                                <label for="licenseNumber">Driver’s License Number *</label>
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
                        
                                                            <!-- Vehicle Information -->
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
                        
                                                            <!-- Documents & Security -->
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

                                                            <!-- Footer -->
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
            let feedback = "";
            
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
                passwordFeedback.style.color = "#e63946";
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