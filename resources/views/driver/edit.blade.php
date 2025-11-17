<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Driver</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Navbar Styles */
        .navbar {
            background: linear-gradient(135deg, #212529 0%, #343a40 100%);
            padding: 1.2rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }

        .nav-brand {
            font-size: 1.8rem;
            font-weight: 700;
            color: #dc3545;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .nav-brand:hover {
            transform: translateY(-2px);
        }

        .nav-brand span {
            color: white;
        }

        .back-link {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
        }

        .back-link:hover {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        .page-title {
            color: white;
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0;
        }

        /* Main Container */
        .main-container {
            min-height: calc(100vh - 80px);
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 2rem;
        }

        .card {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        /* Alert Styles */
        .alert {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 16px 20px;
            margin: 20px;
            border-radius: 12px;
            border-left: 4px solid;
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border-left-color: #28a745;
            color: #155724;
        }

        .alert-error {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            border-left-color: #dc3545;
            color: #721c24;
        }

        .alert i {
            font-size: 1.2rem;
            margin-top: 2px;
        }

        .error-list {
            list-style: disc;
            margin-left: 20px;
            margin-top: 8px;
        }

        /* Profile Section */
        .profile-section {
            text-align: center;
            padding: 40px 20px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .profile-image-container {
            position: relative;
            display: inline-block;
            cursor: pointer;
            border-radius: 50%;
            padding: 8px;
            background: rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .profile-image-container:hover {
            transform: scale(1.05);
            background: rgba(255, 255, 255, 0.3);
        }

        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid white;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .profile-overlay {
            position: absolute;
            top: 8px;
            left: 8px;
            right: 8px;
            bottom: 8px;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .profile-image-container:hover .profile-overlay {
            opacity: 1;
        }

        .profile-overlay i {
            color: white;
            font-size: 2rem;
        }

        .profile-hint {
            margin-top: 16px;
            font-size: 0.9rem;
            opacity: 0.9;
        }

        /* Form Section */
        .form-section {
            padding: 40px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #495057;
            font-size: 0.95rem;
        }

        .required {
            color: #dc3545;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-input:focus {
            outline: none;
            border-color: #007bff;
            background: white;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
        }

        .form-select {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
            cursor: pointer;
        }

        .form-select:focus {
            outline: none;
            border-color: #007bff;
            background: white;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
        }

        /* Document Preview */
        .document-preview {
            margin-top: 8px;
            padding: 12px;
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }

        .document-link {
            color: #007bff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
        }

        .document-link:hover {
            text-decoration: underline;
        }

        /* Button Group */
        .button-group {
            display: flex;
            gap: 12px;
            margin: 32px 0 16px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.95rem;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
        }

        .cancel-link {
            color: #6c757d;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .cancel-link:hover {
            color: #495057;
        }

        /* Modal Styles */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            max-width: 400px;
            width: 90%;
            text-align: center;
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #dc3545;
            margin-bottom: 16px;
        }

        .modal-text {
            color: #6c757d;
            line-height: 1.6;
            margin-bottom: 24px;
        }

        .modal-buttons {
            display: flex;
            gap: 12px;
            justify-content: center;
        }

        .btn-modal {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-cancel {
            background: #6c757d;
            color: white;
        }

        .btn-cancel:hover {
            background: #5a6268;
        }

        .btn-delete {
            background: #dc3545;
            color: white;
        }

        .btn-delete:hover {
            background: #c82333;
        }

        /* Utility Classes */
        .hidden {
            display: none;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        @media (max-width: 768px) {
            .grid-2 {
                grid-template-columns: 1fr;
            }
            
            .button-group {
                flex-direction: column;
            }
            
            .navbar {
                flex-direction: column;
                gap: 16px;
                text-align: center;
            }
            
            .form-section {
                padding: 20px;
            }
        }
    </style>
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