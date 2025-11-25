<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Driver</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite('resources/css/driver/edit.css')
    <link rel="icon" href="{{ asset('images/fastlan1.png') }}">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a href="/" class="nav-brand">Fast<span>Lan</span></a>
        <a href="{{ route('driver.dashboard') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
        <h1 class="page-title">Edit Driver Profile</h1>
    </nav>

    <!-- Main Container -->
    <div class="main-container">
        <div class="card">
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <div class="alert-content">
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <div class="alert-content">
                        <p>Please fix the following errors:</p>
                        <ul class="error-list">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Profile Image Section -->
            <div class="profile-section">
                <div class="profile-image-container" onclick="document.getElementById('profile_image').click()">
                    <img id="profileImage" 
                         src="{{ $driver->getProfileImageUrl() }}" 
                         alt="Profile Picture" 
                         class="profile-image">
                    <div class="profile-overlay">
                        <i class="fas fa-camera"></i>
                    </div>
                </div>
                <input type="file" 
                       id="profile_image" 
                       class="hidden" 
                       accept="image/*"
                       onchange="previewImage(this)">
                <p class="profile-hint">Click on the image to change your profile picture</p>
            </div>

            <!-- Edit Form -->
            <form action="{{ route('driver.update') }}" method="POST" enctype="multipart/form-data" class="form-section">
                @csrf
                @method('PUT')

                <!-- Personal Information Section -->
                <h3 style="color: #495057; margin-bottom: 20px; font-size: 1.25rem; font-weight: 600;">
                    <i class="fas fa-user"></i> Personal Information
                </h3>

                <div class="grid-2">
                    <!-- Full Name -->
                    <div class="form-group">
                        <label for="fullname" class="form-label">
                            Full Name<span class="required">*</span>
                        </label>
                        <input type="text" 
                               id="fullname" 
                               name="fullname" 
                               value="{{ old('fullname', $driver->fullname) }}" 
                               required
                               class="form-input">
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email" class="form-label">
                            Email Address<span class="required">*</span>
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', $driver->email) }}" 
                               required
                               class="form-input">
                    </div>
                </div>

                <!-- Phone -->
                <div class="form-group">
                    <label for="phone" class="form-label">
                        Phone Number<span class="required">*</span>
                    </label>
                    <input type="text" 
                           id="phone" 
                           name="phone" 
                           value="{{ old('phone', $driver->phone) }}" 
                           required
                           class="form-input">
                </div>

                <!-- Driver License Information -->
                <h3 style="color: #495057; margin: 40px 0 20px; font-size: 1.25rem; font-weight: 600;">
                    <i class="fas fa-id-card"></i> Driver License Information
                </h3>

                <div class="grid-2">
                    <!-- License Number -->
                    <div class="form-group">
                        <label for="licenseNumber" class="form-label">
                            License Number<span class="required">*</span>
                        </label>
                        <input type="text" 
                               id="licenseNumber" 
                               name="licenseNumber" 
                               value="{{ old('licenseNumber', $driver->licenseNumber) }}" 
                               required
                               class="form-input">
                    </div>

                    <!-- License Expiry -->
                    <div class="form-group">
                        <label for="licenseExpiry" class="form-label">
                            License Expiry<span class="required">*</span>
                        </label>
                        <input type="date" 
                               id="licenseExpiry" 
                               name="licenseExpiry" 
                               value="{{ old('licenseExpiry', $driver->licenseExpiry ? $driver->licenseExpiry->format('Y-m-d') : '') }}" 
                               required
                               class="form-input">
                    </div>
                </div>

                <!-- License Photo -->
                <div class="form-group">
                    <label for="licensePhoto" class="form-label">
                        Driver's License Photo
                    </label>
                    <input type="file" 
                           id="licensePhoto" 
                           name="licensePhoto" 
                           accept="image/*"
                           class="form-input">
                    @if($driver->licensePhoto)
                    <div class="document-preview">
                        <a href="{{ asset('storage/' . $driver->licensePhoto) }}" target="_blank" class="document-link">
                            <i class="fas fa-eye"></i> View Current License Photo
                        </a>
                    </div>
                    @endif
                </div>

                <!-- Vehicle Information -->
                <h3 style="color: #495057; margin: 40px 0 20px; font-size: 1.25rem; font-weight: 600;">
                    <i class="fas fa-car"></i> Vehicle Information
                </h3>

                <div class="grid-2">
                    <!-- Vehicle Make -->
                    <div class="form-group">
                        <label for="vehicleMake" class="form-label">
                            Vehicle Make<span class="required">*</span>
                        </label>
                        <input type="text" 
                               id="vehicleMake" 
                               name="vehicleMake" 
                               value="{{ old('vehicleMake', $driver->vehicleMake) }}" 
                               required
                               class="form-input">
                    </div>

                    <!-- Vehicle Model -->
                    <div class="form-group">
                        <label for="vehicleModel" class="form-label">
                            Vehicle Model<span class="required">*</span>
                        </label>
                        <input type="text" 
                               id="vehicleModel" 
                               name="vehicleModel" 
                               value="{{ old('vehicleModel', $driver->vehicleModel) }}" 
                               required
                               class="form-input">
                    </div>
                </div>

                <div class="grid-2">
                    <!-- Plate Number -->
                    <div class="form-group">
                        <label for="plateNumber" class="form-label">
                            Plate Number<span class="required">*</span>
                        </label>
                        <input type="text" 
                               id="plateNumber" 
                               name="plateNumber" 
                               value="{{ old('plateNumber', $driver->plateNumber) }}" 
                               required
                               class="form-input">
                    </div>

                    <!-- Vehicle Registration -->
                    <div class="form-group">
                        <label for="vehicleReg" class="form-label">
                            Vehicle Registration<span class="required">*</span>
                        </label>
                        <input type="text" 
                               id="vehicleReg" 
                               name="vehicleReg" 
                               value="{{ old('vehicleReg', $driver->vehicleReg) }}" 
                               required
                               class="form-input">
                    </div>
                </div>

                <!-- ORCR Document -->
                <div class="form-group">
                    <label for="orcrUpload" class="form-label">
                        OR/CR Document
                    </label>
                    <input type="file" 
                           id="orcrUpload" 
                           name="orcrUpload" 
                           accept=".pdf,.jpeg,.png,.jpg"
                           class="form-input">
                    @if($driver->orcrUpload)
                    <div class="document-preview">
                        <a href="{{ asset('storage/' . $driver->orcrUpload) }}" target="_blank" class="document-link">
                            <i class="fas fa-eye"></i> View Current OR/CR Document
                        </a>
                    </div>
                    @endif
                </div>

                <!-- Service Settings -->
                <h3 style="color: #495057; margin: 40px 0 20px; font-size: 1.25rem; font-weight: 600;">
                    <i class="fas fa-cog"></i> Service Settings
                </h3>

                <div class="grid-2">
                    <!-- Service Type -->
                    <div class="form-group">
                        <label for="serviceType" class="form-label">
                            Service Type<span class="required">*</span>
                        </label>
                        <select id="serviceType" name="serviceType" required class="form-select">
                            <option value="Ride" {{ old('serviceType', $driver->serviceType) == 'Ride' ? 'selected' : '' }}>Ride Service</option>
                            <option value="Delivery" {{ old('serviceType', $driver->serviceType) == 'Delivery' ? 'selected' : '' }}>Delivery Service</option>
                            <option value="Both" {{ old('serviceType', $driver->serviceType) == 'Both' ? 'selected' : '' }}>Both Services</option>
                        </select>
                    </div>

                    <!-- Current Location -->
                    <div class="form-group">
                        <label for="currentLocation" class="form-label">
                            Service Area<span class="required">*</span>
                        </label>
                        <select id="currentLocation" name="currentLocation" required class="form-select">
                            @foreach($locations as $value => $label)
                                <option value="{{ $value }}" {{ old('currentLocation', $driver->currentLocation) == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Availability Status -->
                <div class="form-group">
                    <label class="form-label">
                        Availability Status
                    </label>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <input type="checkbox" 
                               id="availStatus" 
                               name="availStatus" 
                               value="1" 
                               {{ old('availStatus', $driver->availStatus) ? 'checked' : '' }}
                               style="transform: scale(1.2);">
                        <label for="availStatus" style="margin: 0; font-weight: normal;">
                            Available for bookings
                        </label>
                    </div>
                </div>

                <!-- Hidden Profile Image Input -->
                <input type="file" 
                       name="profile_image" 
                       id="profile_image_input" 
                       class="hidden" 
                       accept="image/jpeg,image/png,image/jpg,image/gif">

                <!-- Action Buttons -->
                <div class="button-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                    
                    <button type="button" onclick="confirmDelete()" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Delete Account
                    </button>
                </div>

                <!-- Cancel Link -->
                <a href="{{ route('driver.dashboard') }}" class="cancel-link">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <h3 class="modal-title">Delete Account</h3>
            <p class="modal-text">Are you sure you want to delete your account? This action cannot be undone and all your data will be permanently removed.</p>
            <div class="modal-buttons">
                <button type="button" onclick="closeDeleteModal()" class="btn-modal btn-cancel">
                    Cancel
                </button>
                <form action="{{ route('driver.delete') }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-modal btn-delete">
                        Delete Account
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Image preview functionality
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profileImage').src = e.target.result;
                    // Also set the hidden input for form submission
                    document.getElementById('profile_image_input').files = input.files;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Delete account confirmation
        function confirmDelete() {
            document.getElementById('deleteModal').classList.add('active');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('active');
        }

        // Close modal when clicking outside
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        // Escape key to close modal
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDeleteModal();
            }
        });

        // Form validation for file sizes
        document.querySelector('form').addEventListener('submit', function(e) {
            const profileImage = document.getElementById('profile_image_input');
            const licensePhoto = document.getElementById('licensePhoto');
            const orcrUpload = document.getElementById('orcrUpload');
            
            // Check profile image size (2MB)
            if (profileImage.files[0] && profileImage.files[0].size > 2 * 1024 * 1024) {
                e.preventDefault();
                alert('Profile image must be less than 2MB');
                return;
            }
            
            // Check license photo size (2MB)
            if (licensePhoto.files[0] && licensePhoto.files[0].size > 2 * 1024 * 1024) {
                e.preventDefault();
                alert('License photo must be less than 2MB');
                return;
            }
            
            // Check ORCR document size (5MB)
            if (orcrUpload.files[0] && orcrUpload.files[0].size > 5 * 1024 * 1024) {
                e.preventDefault();
                alert('OR/CR document must be less than 5MB');
                return;
            }
        });
    </script>
</body>
</html>