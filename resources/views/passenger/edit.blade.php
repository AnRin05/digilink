<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Passenger</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="{{ asset('images/fastlan1.png') }}">
</head>
<style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

html, body {
    width: 100%;
    overflow-x: hidden;
    min-height: 100vh;
}

body {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    color: #212529;
    position: relative;
    display: flex;
    flex-direction: column;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

body::before {
    content: '';
    position: fixed;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle at 30% 70%, rgba(220, 53, 69, 0.03) 0%, transparent 50%);
    z-index: -1;
    animation: float 30s ease-in-out infinite;
    pointer-events: none;
}

body::after {
    content: '';
    position: fixed;
    bottom: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle at 70% 30%, rgba(220, 53, 69, 0.02) 0%, transparent 50%);
    z-index: -1;
    animation: float 25s ease-in-out infinite reverse;
    pointer-events: none;
}

@keyframes float {
    0%, 100% { 
        transform: translateY(0) rotate(0); 
        opacity: 1; 
    }
    50% { 
        transform: translateY(-30px) rotate(180deg); 
        opacity: 0.7; 
    }
}

.navbar {
    width: 100%;
    padding: 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: linear-gradient(135deg, #212529 0%, #343a40 100%);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    position: sticky;
    top: 0;
    z-index: 1000;
    flex-wrap: wrap;
    gap: 0.8rem;
}

.nav-brand {
    font-size: 1.3rem;
    font-weight: 700;
    color: #dc3545;
    text-decoration: none;
    transition: transform 0.3s ease;
    display: flex;
    align-items: center;
    min-height: 44px;
    flex-shrink: 0;
}

.nav-brand:hover {
    transform: translateY(-2px);
}

.nav-brand span {
    color: white;
    margin-left: 2px;
}

.back-link {
    color: white;
    text-decoration: none;
    font-weight: 500;
    padding: 8px 12px;
    border-radius: 8px;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.9rem;
    min-height: 44px;
}

.back-link:hover {
    color: #ff6b6b;
    background: rgba(255, 255, 255, 0.1);
}

.back-link:active {
    transform: scale(0.95);
}

.page-title {
    color: white;
    font-size: 1.2rem;
    font-weight: 600;
    text-align: center;
    flex: 1;
    margin: 0 0.5rem;
    min-height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.main-container {
    flex: 1;
    width: 100%;
    max-width: 800px;
    margin: 1.5rem auto;
    padding: 0 1rem;
}

.card {
    background: linear-gradient(135deg, white 0%, #f8f9fa 100%);
    border: 2px solid rgba(0, 0, 0, 0.08);
    border-radius: 16px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    animation: slideUp 0.6s ease-out;
    margin-bottom: 2rem;
}

@keyframes slideUp {
    from { 
        opacity: 0; 
        transform: translateY(30px); 
    }
    to { 
        opacity: 1; 
        transform: translateY(0); 
    }
}

.alert {
    padding: 12px 16px;
    margin: 1.2rem;
    border-radius: 10px;
    font-weight: 500;
    display: flex;
    align-items: flex-start;
    gap: 10px;
    animation: slideDown 0.4s ease;
}

@keyframes slideDown {
    from { 
        opacity: 0; 
        transform: translateY(-20px); 
    }
    to { 
        opacity: 1; 
        transform: translateY(0); 
    }
}

.alert-success {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    border: 2px solid #28a745;
    color: #155724;
}

.alert-error {
    background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
    border: 2px solid #dc3545;
    color: #721c24;
}

.alert i {
    font-size: 1.2rem;
    margin-top: 2px;
    flex-shrink: 0;
}

.alert-content {
    flex: 1;
    min-width: 0;
}

.error-list {
    list-style: disc inside;
    margin-top: 8px;
    margin-left: 0;
    padding-left: 0;
}

.error-list li {
    margin-bottom: 4px;
    font-size: 0.9rem;
    line-height: 1.4;
}

.profile-section {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 1.5rem;
    border-bottom: 3px solid #e9ecef;
    text-align: center;
}

.profile-image-container {
    position: relative;
    width: 120px;
    height: 120px;
    margin: 0 auto 1rem;
    border-radius: 50%;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.4s ease;
    border: 5px solid white;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.profile-image-container:hover {
    transform: scale(1.05);
    box-shadow: 0 12px 35px rgba(220, 53, 69, 0.3);
}

.profile-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
    transition: transform 0.3s ease;
}

.profile-image-container:hover .profile-image {
    transform: scale(1.1);
}

.profile-overlay {
    position: absolute;
    inset: 0;
    background: rgba(220, 53, 69, 0.85);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    border-radius: 50%;
}

.profile-image-container:hover .profile-overlay {
    opacity: 1;
}

.profile-overlay i {
    color: white;
    font-size: 1.8rem;
}

.profile-hint {
    color: #6c757d;
    font-size: 0.85rem;
    margin-top: 0.5rem;
    line-height: 1.4;
}

.form-section {
    padding: 1.5rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    margin-bottom: 0.6rem;
    color: #212529;
    font-weight: 600;
    font-size: 0.95rem;
    line-height: 1.4;
}

.required {
    color: #dc3545;
    margin-left: 2px;
}

.form-input {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e9ecef;
    border-radius: 10px;
    font-size: 1rem;
    color: #212529;
    background: white;
    transition: all 0.3s ease;
    min-height: 44px;
}

.form-input:focus {
    border-color: #dc3545;
    outline: none;
    box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
    transform: translateY(-2px);
}

.form-input:hover:not(:focus) {
    border-color: #ced4da;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
}

.button-group {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    padding-top: 1.5rem;
    border-top: 2px solid #e9ecef;
    margin-top: 1.5rem;
}

.btn {
    padding: 14px 24px;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    text-decoration: none;
    min-height: 48px;
    text-align: center;
}

.btn i {
    transition: transform 0.3s ease;
}

.btn:hover i {
    transform: scale(1.1);
}

.btn-primary {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    color: white;
    box-shadow: 0 6px 20px rgba(220, 53, 69, 0.25);
}

.btn-primary:hover {
    background: linear-gradient(135deg, #c82333 0%, #a71e2a 100%);
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(220, 53, 69, 0.35);
}

.btn-primary:active {
    transform: scale(0.98);
}

.btn-danger {
    background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
    color: white;
    box-shadow: 0 6px 20px rgba(108, 117, 125, 0.25);
}

.btn-danger:hover {
    background: linear-gradient(135deg, #5a6268 0%, #495057 100%);
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(108, 117, 125, 0.35);
}

.btn-danger:active {
    transform: scale(0.98);
}

.cancel-link {
    display: block;
    text-align: center;
    margin-top: 1.5rem;
    color: #6c757d;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    padding: 10px;
    border-radius: 8px;
    min-height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.cancel-link:hover {
    color: #dc3545;
    background: rgba(220, 53, 69, 0.05);
}

.cancel-link:active {
    transform: scale(0.95);
}

.modal {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2000;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    padding: 1rem;
}

.modal.active {
    opacity: 1;
    visibility: visible;
}

.modal-content {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    max-width: 500px;
    width: 100%;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    transform: scale(0.9);
    transition: transform 0.3s ease;
    max-height: 90vh;
    overflow-y: auto;
}

.modal.active .modal-content {
    transform: scale(1);
}

.modal-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: #212529;
    margin-bottom: 1rem;
    line-height: 1.3;
}

.modal-text {
    color: #6c757d;
    margin-bottom: 1.5rem;
    line-height: 1.6;
    font-size: 0.95rem;
}

.modal-buttons {
    display: flex;
    flex-direction: column;
    gap: 0.8rem;
}

.btn-modal {
    padding: 12px 20px;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.95rem;
    min-height: 44px;
    text-align: center;
}

.btn-cancel {
    background: transparent;
    color: #6c757d;
    border: 2px solid #e9ecef;
}

.btn-cancel:hover {
    color: #212529;
    border-color: #ced4da;
    background: #f8f9fa;
}

.btn-delete {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
}

.btn-delete:hover {
    background: linear-gradient(135deg, #c82333 0%, #a71e2a 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4);
}

.btn-delete:active {
    transform: scale(0.98);
}

.hidden {
    display: none;
}

@media (min-width: 768px) {
    .navbar {
        padding: 1.2rem 2rem;
        gap: 1.5rem;
    }

    .nav-brand {
        font-size: 1.6rem;
    }

    .back-link {
        padding: 10px 16px;
        font-size: 1rem;
    }

    .page-title {
        font-size: 1.5rem;
    }

    .main-container {
        padding: 0 2rem;
        margin: 2rem auto;
    }

    .alert {
        padding: 15px 25px;
        margin: 1.5rem;
    }

    .alert i {
        font-size: 1.3rem;
    }

    .profile-section {
        padding: 2rem 1.5rem;
    }

    .profile-image-container {
        width: 150px;
        height: 150px;
    }

    .profile-overlay i {
        font-size: 2.2rem;
    }

    .profile-hint {
        font-size: 0.9rem;
    }

    .form-section {
        padding: 2rem;
    }

    .form-group {
        margin-bottom: 2rem;
    }

    .form-label {
        font-size: 1rem;
        margin-bottom: 0.8rem;
    }

    .form-input {
        padding: 14px 18px;
    }

    .button-group {
        flex-direction: row;
        gap: 1rem;
        padding-top: 2rem;
        margin-top: 2rem;
    }

    .button-group .btn {
        flex: 1;
        width: auto;
    }

    .btn {
        padding: 16px 28px;
    }

    .modal-content {
        padding: 2rem;
    }

    .modal-title {
        font-size: 1.5rem;
    }

    .modal-buttons {
        flex-direction: row;
        justify-content: flex-end;
        gap: 1rem;
    }

    .modal-buttons .btn-modal {
        min-width: 120px;
    }
}

@media (min-width: 992px) {
    .navbar {
        padding: 1.2rem 3rem;
    }

    .nav-brand {
        font-size: 1.8rem;
    }

    .page-title {
        font-size: 1.6rem;
    }

    .main-container {
        max-width: 900px;
    }

    .card {
        border-radius: 20px;
    }

    .profile-image-container {
        width: 180px;
        height: 180px;
    }

    .form-section {
        padding: 2.5rem;
    }

    .form-input {
        padding: 15px 20px;
    }

    .modal-content {
        padding: 2.5rem;
    }
}

@media (max-width: 767px) {
    .navbar {
        flex-direction: column;
        align-items: stretch;
        text-align: center;
        padding: 1rem;
        gap: 0.5rem;
    }

    .nav-brand {
        order: 1;
        justify-content: center;
        margin-bottom: 0.5rem;
    }

    .back-link {
        order: 3;
        justify-content: center;
        width: 100%;
        margin-top: 0.5rem;
    }

    .page-title {
        order: 2;
        margin: 0.5rem 0;
        font-size: 1.1rem;
    }

    .profile-image-container {
        width: 140px;
        height: 140px;
    }

    .form-input {
        font-size: 16px;
    }

    .modal-content {
        padding: 1.2rem;
    }

    .modal-buttons .btn-modal {
        width: 100%;
    }
}

@media (hover: none) and (pointer: coarse) {
    .nav-brand,
    .back-link,
    .btn,
    .cancel-link,
    .btn-modal {
        min-height: 48px;
    }

    .form-input {
        min-height: 48px;
        font-size: 16px;
    }

    .profile-image-container:hover {
        transform: none;
    }

    .profile-image-container:active {
        transform: scale(0.98);
    }

    .btn-primary:hover,
    .btn-danger:hover,
    .btn-delete:hover {
        transform: none;
    }

    .btn-primary:active,
    .btn-danger:active,
    .btn-delete:active {
        transform: scale(0.98);
    }
}

input[type="file"] {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    border: 0;
}
</style>
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