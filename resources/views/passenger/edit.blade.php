<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Passenger</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="{{ asset('css/passenger/edit.css') }}" rel="stylesheet">
    @yield('styles')
    <link rel="icon" href="{{ asset('images/fastlan1.png') }}">
</head>
<body>
                                                            <!-- Navbar -->
    <nav class="navbar">
        <a href="#" class="nav-brand">Fast<span>Lan</span></a>
        <a href="{{ route('passenger.dashboard') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
        <h1 class="page-title">Edit Profile</h1>
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
                         src="{{ $passenger->profile_image ? asset('storage/' . $passenger->profile_image) : asset('images/default-avatar.png') }}" 
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
            <form action="{{ route('passenger.update') }}" method="POST" enctype="multipart/form-data" class="form-section">
                @csrf
                @method('PUT')
                                                            <!-- Full Name -->
                <div class="form-group">
                    <label for="fullname" class="form-label">
                        Full Name<span class="required">*</span>
                    </label>
                    <input type="text" 
                           id="fullname" 
                           name="fullname" 
                           value="{{ old('fullname', $passenger->fullname) }}" 
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
                           value="{{ old('email', $passenger->email) }}" 
                           required
                           class="form-input">
                </div>

                                                            <!-- Phone -->
                <div class="form-group">
                    <label for="phone" class="form-label">
                        Phone Number<span class="required">*</span>
                    </label>
                    <input type="text" 
                           id="phone" 
                           name="phone" 
                           value="{{ old('phone', $passenger->phone) }}" 
                           required
                           class="form-input">
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
                <a href="{{ route('passenger.dashboard') }}" class="cancel-link">
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
                <form action="{{ route('passenger.delete') }}" method="POST" style="display: inline;">
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
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profileImage').src = e.target.result;
                    document.getElementById('profile_image_input').files = input.files;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function confirmDelete() {
            document.getElementById('deleteModal').classList.add('active');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('active');
        }

        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDeleteModal();
            }
        });
    </script>
</body>
</html>