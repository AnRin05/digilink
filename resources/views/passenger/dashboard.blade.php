<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FastLan - Passenger Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
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
    }

    body {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        position: relative;
        color: #212529;
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
            transform: translateY(0px) rotate(0deg);
            opacity: 1;
        }
        50% { 
            transform: translateY(-30px) rotate(180deg);
            opacity: 0.7;
        }
    }

    .navbar {
        height: auto;
        min-height: 70px;
        width: 100%;
        padding: 15px 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: linear-gradient(135deg, #212529 0%, #343a40 100%);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        position: sticky;
        top: 0;
        z-index: 1000;
        flex-wrap: wrap;
        gap: 10px;
    }

    .nav-brand {
        font-size: 1.5rem;
        font-weight: 700;
        color: #dc3545;
        text-decoration: none;
        text-shadow: 0 2px 4px rgba(220, 53, 69, 0.3);
        transition: all 0.3s ease;
    }

    .nav-brand:hover {
        transform: translateY(-2px);
        text-shadow: 0 4px 8px rgba(220, 53, 69, 0.4);
    }

    .nav-brand span {
        color: #ffffff;
    }

    .nav-links {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .nav-link {
        color: #ffffff;
        text-decoration: none;
        font-weight: 500;
        padding: 10px 15px;
        border-radius: 8px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        font-size: 13px;
        min-height: 44px;
        display: flex;
        align-items: center;
    }

    .nav-link::after {
        content: '';
        position: absolute;
        bottom: 5px;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 2px;
        background: #dc3545;
        transition: width 0.3s ease;
    }

    .nav-link:hover::after {
        width: 80%;
    }

    .nav-link:hover {
        color: #dc3545;
        background: rgba(220, 53, 69, 0.1);
    }

    .user-profile-dropdown {
        position: relative;
        display: inline-block;
    }

    .user-profile {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 8px 12px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50px;
        transition: all 0.3s ease;
        cursor: pointer;
        min-height: 44px;
    }

    .user-profile:hover {
        background: rgba(255, 255, 255, 0.15);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .profile-container {
        position: relative;
    }

    .profile-pic {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        border: 3px solid #dc3545;
        object-fit: cover;
        box-shadow: 0 3px 10px rgba(220, 53, 69, 0.3);
        transition: all 0.3s ease;
    }

    .user-profile:hover .profile-pic {
        border-color: #ffffff;
        box-shadow: 0 4px 15px rgba(220, 53, 69, 0.5);
    }

    .online-indicator {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 14px;
        height: 14px;
        background: #28a745;
        border-radius: 50%;
        border: 2px solid #212529;
        animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.2); opacity: 0.8; }
    }

    .user-profile span {
        color: #ffffff;
        font-weight: 600;
        font-size: 0.9rem;
        display: none;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        right: 0;
        top: 100%;
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        min-width: 220px;
        border-radius: 16px;
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.2);
        z-index: 1001;
        overflow: hidden;
        margin-top: 12px;
        animation: dropdownFade 0.3s ease;
        border: 1px solid rgba(220, 53, 69, 0.1);
    }

    @keyframes dropdownFade {
        from { opacity: 0; transform: translateY(-15px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .dropdown-content.show {
        display: block;
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 16px 22px;
        color: #495057;
        text-decoration: none;
        transition: all 0.3s ease;
        border-bottom: 1px solid #f1f3f4;
        min-height: 48px;
        cursor: pointer;
    }

    .dropdown-item:last-child {
        border-bottom: none;
    }

    .dropdown-item:hover,
    .dropdown-item:active {
        background: rgba(220, 53, 69, 0.1);
        color: #dc3545;
        transform: translateX(5px);
    }

    .dropdown-item i {
        width: 22px;
        text-align: center;
        color: #6c757d;
        font-size: 1.1rem;
    }

    .dropdown-item:hover i {
        color: #dc3545;
        transform: scale(1.1);
    }

    .dropdown-item.logout {
        color: #dc3545;
        font-weight: 600;
        background: rgba(220, 53, 69, 0.05);
    }

    .dropdown-item.logout i {
        color: #dc3545;
    }

    .dropdown-item.logout:hover {
        background: rgba(220, 53, 69, 0.15);
    }

    .alert {
        padding: 12px 20px;
        margin: 15px auto;
        max-width: calc(100% - 30px);
        border-radius: 12px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 12px;
        animation: slideDown 0.4s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        flex-wrap: wrap;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .alert-success {
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        border: 2px solid #28a745;
        color: #155724;
    }

    .alert-danger {
        background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
        border: 2px solid #dc3545;
        color: #721c24;
    }

    .alert i {
        font-size: 1.1rem;
    }

    .close {
        margin-left: auto;
        background: none;
        border: none;
        font-size: 1.3rem;
        cursor: pointer;
        opacity: 0.6;
        transition: opacity 0.3s ease;
        min-height: 44px;
        min-width: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .close:hover {
        opacity: 1;
    }

    .booking-nav {
        margin: 20px auto;
        display: flex;
        justify-content: center;
        gap: 0.8rem;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.98) 0%, rgba(248, 249, 250, 0.98) 100%);
        padding: 1rem;
        border-radius: 50px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        border: 1px solid rgba(220, 53, 69, 0.15);
        max-width: 90%;
        flex-wrap: wrap;
    }

    .booking-nav .btn-link {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.6rem;
        border: none;
        background: transparent;
        font-weight: 600;
        font-size: 0.9rem;
        color: #495057;
        padding: 10px 18px;
        border-radius: 25px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        text-decoration: none;
        min-height: 44px;
    }

    .booking-nav .btn-link.active {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: #ffffff;
        box-shadow: 0 6px 20px rgba(220, 53, 69, 0.35);
    }

    .booking-nav .btn-link i {
        font-size: 1rem;
        transition: transform 0.3s ease;
    }

    .booking-nav .btn-link.active i {
        color: #ffffff;
    }

    .booking-nav .btn-link:not(.active) i {
        color: #dc3545;
    }

    .booking-nav .btn-link:hover:not(.active) {
        background: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }

    .main-container {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        margin: 1.5rem auto;
        width: 100%;
        max-width: 1400px;
        padding: 0 1rem;
    }

    .left-panel {
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        border: 1px solid rgba(0, 0, 0, 0.08);
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        height: fit-content;
        max-height: none;
        overflow-y: auto;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .left-panel:hover {
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
    }

    .left-panel h2 {
        color: #212529;
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 1.2rem;
        padding-bottom: 0.8rem;
        border-bottom: 3px solid #dc3545;
        position: relative;
    }

    .left-panel h2::after {
        content: '';
        position: absolute;
        bottom: -3px;
        left: 0;
        width: 50px;
        height: 3px;
        background: #212529;
    }

    .driver-card {
        background: white;
        border-radius: 16px;
        padding: 18px;
        margin-bottom: 14px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        border: 2px solid #e9ecef;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .driver-card:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        transform: translateY(-4px);
        border-color: #dc3545;
    }

    .driver-header {
        margin-bottom: 14px;
    }

    .driver-profile {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .driver-avatar {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #dc3545;
        box-shadow: 0 3px 12px rgba(220, 53, 69, 0.25);
    }

    .driver-info strong {
        font-size: 1.2rem;
        color: #212529;
        margin-bottom: 6px;
        display: block;
    }

    .driver-rating {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .star-rating {
        color: #ffc107;
        font-size: 1rem;
    }

    .rating-text {
        font-size: 0.9rem;
        color: #6c757d;
        font-weight: 500;
    }

    .driver-details {
        margin-bottom: 14px;
    }

    .detail-item {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 8px;
        font-size: 0.95rem;
        color: #495057;
    }

    .detail-item i {
        width: 18px;
        text-align: center;
        color: #dc3545;
    }

    .driver-status {
        text-align: right;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 16px;
        border-radius: 25px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .status-available {
        background: rgba(40, 167, 69, 0.15);
        color: #155724;
        border: 2px solid #28a745;
    }

    .status-unavailable {
        background: rgba(220, 53, 69, 0.15);
        color: #721c24;
        border: 2px solid #dc3545;
    }

    .status-badge i {
        font-size: 0.7rem;
    }

    .text-success {
        color: #28a745;
    }

    .text-muted {
        color: #6c757d;
        font-size: 0.9rem;
    }

    .right-panel {
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        border: 1px solid rgba(0, 0, 0, 0.08);
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
    }

    .map-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: #212529;
        margin-bottom: 1.2rem;
        padding-bottom: 0.8rem;
        border-bottom: 3px solid #dc3545;
        position: relative;
    }

    .map-title::after {
        content: '';
        position: absolute;
        bottom: -3px;
        left: 0;
        width: 60px;
        height: 3px;
        background: #212529;
    }

    #map-container {
        position: relative;
        width: 100%;
        height: 300px;
        border-radius: 18px;
        overflow: hidden;
        margin-bottom: 1.5rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
        border: 3px solid #e9ecef;
        transition: all 0.3s ease;
    }

    #map-container:hover {
        border-color: #dc3545;
        box-shadow: 0 15px 40px rgba(220, 53, 69, 0.18);
    }

    #map {
        width: 100%;
        height: 100%;
        position: relative;
        z-index: 1;
    }

    .leaflet-container {
        height: 100%;
        width: 100%;
        z-index: 1;
    }

    .leaflet-control-zoom a {
        background: #dc3545 !important;
        color: white !important;
        border: none !important;
        transition: all 0.3s ease !important;
    }

    .leaflet-control-zoom a:hover {
        background: #c82333 !important;
    }

    .leaflet-popup-content-wrapper {
        border-radius: 12px !important;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
    }

    #map-loading {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.98);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        z-index: 1000;
        font-size: 1rem;
        color: #495057;
        font-weight: 500;
    }

    .spinner {
        border: 5px solid #f3f3f3;
        border-top: 5px solid #dc3545;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
        margin-bottom: 12px;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .map-info {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 1.2rem;
        border-radius: 18px;
        margin-bottom: 1.5rem;
        border: 2px solid #e9ecef;
        position: relative;
        overflow: hidden;
    }

    .map-info::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 5px;
        height: 100%;
        background: #dc3545;
    }

    .map-info p {
        margin-bottom: 0.8rem;
        color: #495057;
        font-size: 0.95rem;
        padding-left: 1rem;
    }

    .map-info p:last-child {
        margin-bottom: 0;
    }

    .map-info strong {
        color: #212529;
        font-weight: 600;
    }

    .map-info span {
        color: #dc3545;
        font-weight: 600;
    }

    .notes-section {
        background: rgba(220, 53, 69, 0.05);
        padding: 1.2rem;
        border-radius: 18px;
        margin-bottom: 1.5rem;
        border-left: 5px solid #dc3545;
    }

    .notes-section h4 {
        color: #212529;
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.8rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .notes-section h4 i {
        color: #dc3545;
        font-size: 1.1rem;
    }

    .notes-section p {
        color: #495057;
        margin-bottom: 0.5rem;
        padding-left: 1.2rem;
        position: relative;
        font-size: 0.95rem;
    }

    .notes-section p:last-child {
        margin-bottom: 0;
    }

    .notes-section p::before {
        content: '•';
        position: absolute;
        left: 0;
        color: #dc3545;
        font-weight: 700;
    }

    .booking-form {
        background: #ffffff;
        padding: 1.5rem;
        border-radius: 20px;
        border: 2px solid #e9ecef;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .form-group {
        margin-bottom: 1.2rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.6rem;
        color: #212529;
        font-weight: 600;
        font-size: 0.95rem;
    }

    .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e9ecef;
        border-radius: 12px;
        font-size: 1rem;
        color: #212529;
        background: #ffffff;
        transition: all 0.3s ease;
        font-family: 'Poppins', sans-serif;
        min-height: 44px;
    }

    .form-control:focus {
        border-color: #dc3545;
        outline: none;
        box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.15);
    }

    .form-control:hover:not(:focus) {
        border-color: #ced4da;
    }

    select.form-control {
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 14 14'%3E%3Cpath fill='%23dc3545' d='M7 10L2 5h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        padding-right: 40px;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }

    .h5 {
        font-size: 1.3rem;
        font-weight: 700;
        color: #212529;
    }

    .fare-display-container {
        background: linear-gradient(135deg, #fff5f5 0%, #ffeaea 100%);
        padding: 1.5rem;
        border-radius: 18px;
        margin: 1.5rem 0;
        border: 3px solid #dc3545;
        text-align: center;
        box-shadow: 0 8px 25px rgba(220, 53, 69, 0.2);
    }

    .fare-label {
        font-size: 1.1rem;
        color: #495057;
        font-weight: 600;
        margin-bottom: 10px;
        display: block;
    }

    #fareDisplay {
        color: #dc3545;
        font-size: 2.5rem;
        font-weight: 800;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        display: block;
        line-height: 1.2;
    }

    .fare-subtext {
        color: #6c757d;
        font-size: 0.9rem;
        margin-top: 8px;
        font-style: italic;
    }

    .text-danger {
        color: #dc3545;
    }

    .mb-3 {
        margin-bottom: 1.2rem;
    }

    .btn {
        padding: 14px 28px;
        border: none;
        border-radius: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 1rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        min-height: 48px;
        white-space: nowrap;
    }

    .btn i {
        transition: transform 0.3s ease;
    }

    .btn:hover i {
        transform: scale(1.15);
    }

    .btn-primary {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
        box-shadow: 0 8px 25px rgba(220, 53, 69, 0.3);
        width: 100%;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #c82333 0%, #a71e2a 100%);
        transform: translateY(-3px);
        box-shadow: 0 12px 35px rgba(220, 53, 69, 0.4);
    }

    .btn-primary:active {
        transform: scale(0.98);
    }

    .btn-danger {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
        box-shadow: 0 6px 20px rgba(220, 53, 69, 0.25);
        margin-bottom: 0.8rem;
        padding: 12px 24px;
        font-size: 0.95rem;
        width: 100%;
    }

    .btn-danger:hover {
        background: linear-gradient(135deg, #c82333 0%, #a71e2a 100%);
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(220, 53, 69, 0.4);
    }

    .btn-danger:active {
        transform: scale(0.98);
    }

    .w-100 {
        width: 100%;
    }

    hr {
        border: none;
        height: 2px;
        background: linear-gradient(90deg, transparent, #e9ecef, transparent);
        margin: 1.5rem 0;
    }

    @media (min-width: 768px) {
        .navbar {
            height: 80px;
            padding: 0 2rem;
        }

        .nav-brand {
            font-size: 1.8rem;
        }

        .nav-links {
            gap: 1.5rem;
        }

        .nav-link {
            padding: 10px 20px;
            font-size: 14px;
        }

        .user-profile span {
            display: inline;
        }

        .booking-nav {
            gap: 1.5rem;
            padding: 1rem 2rem;
            max-width: fit-content;
        }

        .booking-nav .btn-link {
            font-size: 1rem;
            padding: 12px 25px;
        }

        .main-container {
            flex-direction: row;
            gap: 2rem;
            padding: 0 2rem;
            margin: 2rem auto;
        }

        .left-panel {
            flex: 0 0 320px;
            padding: 2rem;
            max-height: calc(100vh - 200px);
            position: sticky;
            top: 100px;
        }

        .left-panel h2 {
            font-size: 1.6rem;
        }

        .driver-card {
            padding: 1.5rem;
        }

        .driver-avatar {
            width: 60px;
            height: 60px;
        }

        .right-panel {
            flex: 1;
            padding: 2.5rem;
        }

        .map-title {
            font-size: 1.6rem;
        }

        #map-container {
            height: 420px;
        }

        .booking-form {
            padding: 2.5rem;
        }

        .form-control {
            padding: 15px 20px;
        }

        .btn {
            padding: 16px 32px;
            font-size: 1.05rem;
        }

        .fare-display-container {
            padding: 2rem;
            margin: 2rem 0;
        }

        #fareDisplay {
            font-size: 3.5rem;
        }

        .fare-label {
            font-size: 1.3rem;
        }

        .alert {
            padding: 15px 25px;
            margin: 20px auto;
        }

        .alert i {
            font-size: 1.3rem;
        }

        .map-info {
            padding: 1.8rem;
        }

        .notes-section {
            padding: 1.5rem;
        }
    }

    @media (min-width: 992px) {
        .navbar {
            padding: 0 3rem;
        }

        .left-panel {
            flex: 0 0 350px;
        }

        .main-container {
            padding: 0 3rem;
        }

        #fareDisplay {
            font-size: 4rem;
        }
    }

    @media (min-width: 1200px) {
        .nav-brand {
            font-size: 2rem;
        }

        .left-panel {
            flex: 0 0 380px;
        }

        .main-container {
            padding: 0 2rem;
        }

        #map-container {
            height: 500px;
        }

        .fare-display-container {
            padding: 2.5rem;
        }

        #fareDisplay {
            font-size: 4.5rem;
        }
    }

    @media (max-width: 767px) {
        .driver-profile {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .driver-status {
            text-align: left;
            margin-top: 10px;
        }

        .fare-display-container {
            padding: 1.2rem;
        }

        #fareDisplay {
            font-size: 2.2rem;
        }

        .dropdown-content {
            min-width: 200px;
            right: 10px;
        }
    }

    @media (hover: none) and (pointer: coarse) {
        .nav-link::after {
            display: none;
        }

        .btn {
            min-height: 50px;
        }

        .dropdown-item {
            min-height: 50px;
        }

        .form-control {
            min-height: 50px;
            font-size: 16px;
        }

        .user-profile {
            min-height: 50px;
        }

        .booking-nav .btn-link {
            min-height: 50px;
        }

        .driver-card:hover {
            transform: none;
        }

        .btn-primary:hover {
            transform: none;
        }

        .btn-danger:hover {
            transform: none;
        }
    }
</style>
<body>
                                                            <!-- Navbar -->
    <nav class="navbar">
        <a href="#" class="nav-brand">Fast<span>Lan</span></a>
        <div class="nav-links">
            <a href="{{ route('passenger.dashboard') }}" class="nav-link">Dashboard</a>
            <a href="{{ route('passenger.edit') }}" class="nav-link">Edit Profile</a>
            <div class="user-profile-dropdown">
                <div class="user-profile" id="userProfileDropdown">
                    <div class="profile-container">
                        <img src="{{ Auth::guard('passenger')->user()->profile_image ? asset('storage/' . Auth::guard('passenger')->user()->profile_image) : asset('images/default-avatar.png') }}" 
                             alt="Profile" class="profile-pic">
                        <div class="online-indicator"></div>
                    </div>
                    <span>{{ Auth::guard('passenger')->user()->fullname }}</span>
                    <i class="fas fa-chevron-down" style="font-size: 0.8rem; color: #ffffff;"></i>
                </div>
                <div class="dropdown-content" id="dropdownMenu">
                    <a href="{{ route('passenger.dashboard') }}" class="dropdown-item">
                        <i class="fas fa-car"></i>
                        Ride Service
                    </a>
                    <a href="{{ route('passenger.history') }}" class="dropdown-item">
                        <i class="fas fa-history"></i>
                        Ride History
                    </a>
                    <a href="{{ route('feedback.create') }}" class="dropdown-item">
                        <i class="fas fa-cog"></i>
                        System Feedback
                    </a>
                    <a href="#" class="dropdown-item logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </nav>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin: 0; border-radius: 0;">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin: 0; border-radius: 0;">
            <strong>Error!</strong> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
                                                            <!-- Booking Navigation -->
    <div class="booking-nav">
        <a href="#" class="btn-link active">
            <i class="fas fa-motorcycle"></i> Booking to Go
        </a>
        <a href="{{ route('passenger.delivery') }}" class="btn-link">
            <i class="fas fa-box"></i> For Delivery
       </a>
        <a href="{{ route('passenger.pending.bookings') }}" class="btn-link">
            <i class="fas fa-hourglass-half"></i> See Pending
        </a>
    </div>
                                                            <!-- Main Container -->
    <div class="main-container">
                                                            <!-- Left Panel: Available Drivers -->
        <div class="left-panel">
            <h2>Available Motor Drivers</h2>
                                                            <!-- Barangay Filter -->
            <div class="form-group">
                <label for="barangay" class="form-label">Select Barangay:</label>
                <select id="barangay" class="form-control">
                    <option value="all" {{ $barangay == 'all' ? 'selected' : '' }}>All Barangays</option>
                    <option value="Anomar" {{ $barangay == 'Anomar' ? 'selected' : '' }}>Anomar</option>
                    <option value="Balibayon" {{ $barangay == 'Balibayon' ? 'selected' : '' }}>Balibayon</option>
                    <option value="Bonifacio" {{ $barangay == 'Bonifacio' ? 'selected' : '' }}>Bonifacio</option>
                    <option value="Cabongbongan" {{ $barangay == 'Cabongbongan' ? 'selected' : '' }}>Cabongbongan</option>
                    <option value="Cagniog" {{ $barangay == 'Cagniog' ? 'selected' : '' }}>Cagniog</option>
                    <option value="Canlanipa" {{ $barangay == 'Canlanipa' ? 'selected' : '' }}>Canlanipa</option>
                    <option value="Capalayan" {{ $barangay == 'Capalayan' ? 'selected' : '' }}>Capalayan</option>
                    <option value="Danao" {{ $barangay == 'Danao' ? 'selected' : '' }}>Danao</option>
                    <option value="Day-asan" {{ $barangay == 'Day-asan' ? 'selected' : '' }}>Day-asan</option>
                    <option value="Ipil" {{ $barangay == 'Ipil' ? 'selected' : '' }}>Ipil</option>
                    <option value="Lipata" {{ $barangay == 'Lipata' ? 'selected' : '' }}>Lipata</option>
                    <option value="Luna" {{ $barangay == 'Luna' ? 'selected' : '' }}>Luna</option>
                    <option value="Mabini" {{ $barangay == 'Mabini' ? 'selected' : '' }}>Mabini</option>
                    <option value="Mabua" {{ $barangay == 'Mabua' ? 'selected' : '' }}>Mabua</option>
                    <option value="Mapawa" {{ $barangay == 'Mapawa' ? 'selected' : '' }}>Mapawa</option>
                    <option value="Mat-i" {{ $barangay == 'Mat-i' ? 'selected' : '' }}>Mat-i</option>
                    <option value="Nabago" {{ $barangay == 'Nabago' ? 'selected' : '' }}>Nabago</option>
                    <option value="Orok" {{ $barangay == 'Orok' ? 'selected' : '' }}>Orok</option>
                    <option value="Poctoy" {{ $barangay == 'Poctoy' ? 'selected' : '' }}>Poctoy</option>
                    <option value="Quezon" {{ $barangay == 'Quezon' ? 'selected' : '' }}>Quezon</option>
                    <option value="Rizal" {{ $barangay == 'Rizal' ? 'selected' : '' }}>Rizal</option>
                    <option value="Sabang" {{ $barangay == 'Sabang' ? 'selected' : '' }}>Sabang</option>
                    <option value="San Isidro" {{ $barangay == 'San Isidro' ? 'selected' : '' }}>San Isidro</option>
                    <option value="San Juan" {{ $barangay == 'San Juan' ? 'selected' : '' }}>San Juan</option>
                    <option value="San Roque" {{ $barangay == 'San Roque' ? 'selected' : '' }}>San Roque</option>
                    <option value="Serna" {{ $barangay == 'Serna' ? 'selected' : '' }}>Serna</option>
                    <option value="Silop" {{ $barangay == 'Silop' ? 'selected' : '' }}>Silop</option>
                    <option value="Sukailang" {{ $barangay == 'Sukailang' ? 'selected' : '' }}>Sukailang</option>
                    <option value="Taft" {{ $barangay == 'Taft' ? 'selected' : '' }}>Taft</option>
                    <option value="Togbongon" {{ $barangay == 'Togbongon' ? 'selected' : '' }}>Togbongon</option>
                    <option value="Trinidad" {{ $barangay == 'Trinidad' ? 'selected' : '' }}>Trinidad</option>
                    <option value="Washington" {{ $barangay == 'Washington' ? 'selected' : '' }}>Washington</option>
                </select>
            </div>
            <div>
                <button id="searchDriversBtn" class="btn btn-primary" style="margin-bottom: 16px;">
                    <i class="fas fa-search"></i> Search Drivers
                </button>
            </div>
                                                            <!-- Driver List -->
            <div id="driverList" class="driver-list">
                @forelse($availableDrivers as $driver)
                    @if(in_array($driver->serviceType, ['Ride', 'Both']))
                    <div class="driver-card" data-driver-id="{{ $driver->id }}">
                        <div class="driver-header">
                            <div class="driver-profile">
                                <img src="{{ $driver->profile_image ? asset('storage/' . $driver->profile_image) : asset('images/default-driver-avatar.png') }}" 
                                    alt="{{ $driver->fullname }}" class="driver-avatar">
                                <div class="driver-info">
                                    <strong>{{ $driver->fullname }}</strong>
                                    <div class="driver-rating">
                                        <span class="star-rating">
                                            <i class="fas fa-star"></i> 
                                            {{ $driver->average_rating ? number_format($driver->average_rating, 1) : 'New' }}
                                        </span>
                                        <span class="rating-text">({{ $driver->total_reviews ?? 0 }} reviews)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="driver-details">
                            <div class="detail-item">
                                <i class="fas fa-motorcycle"></i>
                                <span>{{ $driver->vehicleMake }} {{ $driver->vehicleModel }}</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-tag"></i>
                                <span>Plate: {{ $driver->plateNumber }}</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-check-circle"></i>
                                <span>{{ $driver->completedBooking }} completed rides</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span class="{{ $driver->currentLocation == 'all' ? 'text-success' : 'text-info' }}">
                                    {{ $driver->currentLocation == 'all' ? 'All Areas' : $driver->currentLocation }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="driver-status">
                            <span class="status-badge {{ $driver->availStatus ? 'status-available' : 'status-unavailable' }}">
                                <i class="fas fa-circle"></i> 
                                {{ $driver->availStatus ? 'Available for Rides' : 'Currently Unavailable' }}
                            </span>
                        </div>
                    </div>
                    @endif
                @empty
                    <div class="driver-card empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-motorcycle"></i>
                        </div>
                        <p>No available drivers at the moment.</p>
                        <small class="text-muted">Please check back later or try a different barangay.</small>
                    </div>
                @endforelse
            </div>
        </div>
                                                            <!-- Right Panel: Map and Booking -->
        <div class="right-panel">
            <div class="map-title">Set Pickup and Drop-off in Surigao City</div>
                <div id="map-container">
                                                            <!-- Loading overlay -->
                    <div id="map-loading">
                        <div class="spinner"></div>
                        <p>Loading map, please wait...</p>
                    </div>
                                                            <!-- Map -->
                    <div id="map"></div>
                </div>
                <div style="margin-bottom: 1rem;">
                    <button type="button" id="resetMapBtn" class="btn btn-danger">
                    <i class="fas fa-redo"></i> Reset Map
                    </button>
                </div>
                                                            <!-- Location Info -->
            <div class="map-info">
                <p><strong>Pickup:</strong> <span id="pickupDisplay">Click on map to set pickup</span></p>
                <p><strong>Drop-off:</strong> <span id="dropoffDisplay">Click again to set drop-off</span></p>
                <p><strong>Estimated Distance:</strong> <span id="distanceDisplay">-</span></p>
                <p><strong>Estimated Duration:</strong> <span id="durationDisplay">-</span></p>
            </div>
                                                            <!-- Additional Notes -->
            <div class="notes-section">
                <h4><i class="fas fa-info-circle"></i> Booking Instructions</h4>
                <p>1. Click on the map to set your pickup location</p>
                <p>2. Click again to set your drop-off location</p>
                <p>3. Fill in the barangay names and then the specific location you want for both locations</p>
                <p>4. Select your service type (Booking to Go or For Delivery)</p>
                <p>5. Click "Book Ride" to confirm your booking</p>
            </div>
                                                            <!-- Booking Form -->
            <form action="{{ route('passenger.book.ride') }}" method="POST" class="booking-form" id="bookingForm">
                @csrf
                                                            <!-- Add these hidden fields to your booking form -->
                <input type="hidden" name="pickupLatitude" id="pickupLatitude">
                <input type="hidden" name="pickupLongitude" id="pickupLongitude">
                <input type="hidden" name="dropoffLatitude" id="dropoffLatitude">
                <input type="hidden" name="dropoffLongitude" id="dropoffLongitude">
                <input type="hidden" name="fare" id="fare">
                <input type="hidden" name="serviceType" id="serviceType" value="booking_to_go">

                <div class="form-group">
                    <label for="pickupLocation" class="form-label"><strong>Pickup Barangay:</strong></label>
                    <input type="text" name="pickupLocation" id="pickupLocation" class="form-control" placeholder="Type pickup barangay example:(Ipil, near the park and the church)" required>
                </div>

                <div class="form-group">
                    <label for="dropoffLocation" class="form-label"><strong>Drop-off Barangay:</strong></label>
                    <input type="text" name="dropoffLocation" id="dropoffLocation" class="form-control" placeholder="Type drop-off barangay example:(Surigao, Jolibee near the luneta)" required>
                </div>

                <div class="form-group">
                    <label for="description" class="form-label"><strong>Description: </strong></label>
                    <textarea name="description" id="description" class="form-control" placeholder="Any special instructions for the driver..." rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label for="paymentMethod" class="form-label"><strong>Payment Method:</strong></label>
                    <select name="paymentMethod" id="paymentMethod" class="form-control" required>
                        <option value="cash">Cash</option>
                        <option value="gcash">GCash</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="scheduleTime"><strong>Scheduled Time:</strong></label>
                    <input type="datetime-local" name="scheduleTime" id="scheduleTime" class="form-control">
                </div>

                <hr>

                <div class="mb-3">
                    <p class="h5"><strong>Estimated Fare (₱ with service fee):</strong> <span id="fareDisplay" class="text-danger">₱0.00</span></p>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-motorcycle"></i> Book Ride
                </button>
            </form>
        </div>
    </div>
<script>
    function setServiceType(type) {
        document.getElementById('serviceType').value = type;

        document.querySelectorAll('.booking-nav button, .booking-nav a').forEach(element => {
            element.classList.remove('active');
        });
        event.currentTarget.classList.add('active');
    }

    let map;
    let mapInitialized = false;
    let pickupMarker = null;
    let dropoffMarker = null;
    let routeControl = null;
    let currentRoute = null;
    let isSubmitting = false;

    function initializeMap() {
        try {
            if (mapInitialized) {
                return;
            }
            
            const mapElement = document.getElementById('map');
            if (!mapElement) {
                console.error('Map element not found');
                return;
            }

            if (mapElement._leaflet_id) {
                console.log('Map already initialized');
                return;
            }

            const surigaoCity = [9.7890, 125.4950];
            
            map = L.map('map', {
                center: surigaoCity,
                zoom: 13,
                maxBounds: [
                    [9.70, 125.40],
                    [9.88, 125.58]
                ],
                maxBoundsViscosity: 1.0
            });

            const tileLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            tileLayer.on('load', function() {
                document.getElementById('map-loading').style.display = 'none';
                mapInitialized = true;
                console.log('Map initialized successfully');
            });

            tileLayer.on('tileerror', function() {
                console.error('Failed to load map tiles');
                document.getElementById('map-loading').style.display = 'none';
                showAlert('Failed to load map. Please check your internet connection.', 'error');
            });

            initializeMapFeatures();
            
        } catch (error) {
            console.error('Error initializing map:', error);
            document.getElementById('map-loading').style.display = 'none';
            showAlert('Error initializing map. Please refresh the page.', 'error');
        }
    }

    function initializeMapFeatures() {
        map.on('click', function(e) {
            if (!pickupMarker) {
                pickupMarker = L.marker(e.latlng, { 
                    draggable: true,
                    icon: L.divIcon({
                        className: 'pickup-marker',
                        html: '<div style="background: #28a745; width: 20px; height: 20px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.3);"></div>',
                        iconSize: [20, 20]
                    })
                }).addTo(map).bindPopup('Pickup Location');

                document.getElementById('pickupLatitude').value = e.latlng.lat.toFixed(6);
                document.getElementById('pickupLongitude').value = e.latlng.lng.toFixed(6);
                document.getElementById('pickupDisplay').textContent = e.latlng.lat.toFixed(4) + ', ' + e.latlng.lng.toFixed(4);

                pickupMarker.on('dragend', function(ev) {
                    let coords = ev.target.getLatLng();
                    updatePickupCoords(coords);
                    if (dropoffMarker) {
                        showRoute(pickupMarker.getLatLng(), dropoffMarker.getLatLng());
                    }
                });

            } else if (!dropoffMarker) {
                dropoffMarker = L.marker(e.latlng, { 
                    draggable: true,
                    icon: L.divIcon({
                        className: 'dropoff-marker',
                        html: '<div style="background: #dc3545; width: 20px; height: 20px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.3);"></div>',
                        iconSize: [20, 20]
                    })
                }).addTo(map).bindPopup('Drop-off Location');

                document.getElementById('dropoffLatitude').value = e.latlng.lat.toFixed(6);
                document.getElementById('dropoffLongitude').value = e.latlng.lng.toFixed(6);
                document.getElementById('dropoffDisplay').textContent = e.latlng.lat.toFixed(4) + ', ' + e.latlng.lng.toFixed(4);

                dropoffMarker.on('dragend', function(ev) {
                    let coords = ev.target.getLatLng();
                    updateDropoffCoords(coords);
                    if (pickupMarker) {
                        showRoute(pickupMarker.getLatLng(), dropoffMarker.getLatLng());
                    }
                });

                showRoute(pickupMarker.getLatLng(), dropoffMarker.getLatLng());
            }
        });
    }

    function calculateFare(distanceKm) {
        const serviceFee = 5; // Fixed service fee
        let fare;
        
        if (distanceKm <= 4) {
            fare = 10;
        } else if (distanceKm <= 6) {
            fare = 15;
        } else if (distanceKm <= 9) {
            fare = 25;
        } else if (distanceKm <= 15) {
            fare = 30;
        } else if (distanceKm <= 19) {
            fare = 50;
        } else if (distanceKm <= 24) {
            fare = 75;
        } else {
            fare = 75 + (distanceKm - 24) * 5;
        }
        
        // Add service fee
        const totalFare = fare + serviceFee;
        
        return {
            baseFare: fare,
            serviceFee: serviceFee,
            totalFare: totalFare,
            distanceKm: distanceKm
        };
    }

    function updateFareDisplay(distanceKm) {
        const fareData = calculateFare(distanceKm);
        document.getElementById('fareDisplay').innerHTML = 
            `<span class="fare-amount">₱${fareData.totalFare.toFixed(2)}</span>`;
    }

    function showRoute(start, end) {
        if (routeControl) {
            map.removeControl(routeControl);
        }
        
        // Check if L.Routing is available
        if (!L.Routing) {
            console.error('Leaflet Routing Machine is not loaded');
            showAlert('Route calculation service is not available.', 'error');
            return;
        }
        
        routeControl = L.Routing.control({
            waypoints: [
                L.latLng(start.lat, start.lng),
                L.latLng(end.lat, end.lng)
            ],
            lineOptions: {
                styles: [{ color: '#007bff', weight: 5, opacity: 0.7 }]
            },
            routeWhileDragging: false,
            addWaypoints: false,
            draggableWaypoints: false,
            fitSelectedRoutes: true,
            showAlternatives: false
        }).addTo(map);

        routeControl.on('routesfound', function(e) {
            const route = e.routes[0];
            const distanceKm = route.summary.totalDistance / 1000;
            const totalSeconds = route.summary.totalTime;
            const durationMin = Math.round(totalSeconds / 60);

            let durationDisplay;
            if (durationMin >= 60) {
                const hours = Math.floor(durationMin / 60);
                const minutes = durationMin % 60;
                durationDisplay = `${hours} hr${hours > 1 ? 's' : ''} ${minutes} min`;
            } else {
                durationDisplay = `${durationMin} min`;
            }

            document.getElementById('distanceDisplay').textContent = distanceKm.toFixed(1) + ' km';
            document.getElementById('durationDisplay').textContent = durationDisplay;

            // Use the new calculateFare function
            const fareData = calculateFare(distanceKm);
            updateFareDisplay(distanceKm);
            document.getElementById('fare').value = fareData.totalFare.toFixed(2);

            currentRoute = route;
        });

        routeControl.on('routingerror', function(e) {
            console.error('Route error:', e.error);
            showAlert('Unable to calculate route. Please check your locations.', 'error');
        });
    }

    function updatePickupCoords(coords) {
        document.getElementById('pickupLatitude').value = coords.lat.toFixed(6);
        document.getElementById('pickupLongitude').value = coords.lng.toFixed(6);
        document.getElementById('pickupDisplay').textContent = coords.lat.toFixed(4) + ', ' + coords.lng.toFixed(4);
    }

    function updateDropoffCoords(coords) {
        document.getElementById('dropoffLatitude').value = coords.lat.toFixed(6);
        document.getElementById('dropoffLongitude').value = coords.lng.toFixed(6);
        document.getElementById('dropoffDisplay').textContent = coords.lat.toFixed(4) + ', ' + coords.lng.toFixed(4);
    }

    function showAlert(message, type = 'success', duration = 5000) {
        // Remove any existing alerts first
        const existingAlerts = document.querySelectorAll('.alert[style*="position: fixed"]');
        existingAlerts.forEach(alert => alert.remove());
        
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert" style="position: fixed; top: 80px; right: 20px; z-index: 9999; min-width: 300px;">
                <strong>${type === 'success' ? 'Success!' : 'Error!'}</strong> ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        `;
        document.body.insertAdjacentHTML('beforeend', alertHtml);
        
        // Auto-dismiss after duration
        setTimeout(() => {
            const alert = document.querySelector('.alert:last-child');
            if (alert) {
                alert.remove();
            }
        }, duration);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const barangaySelect = document.getElementById('barangay');
        const driverList = document.getElementById('driverList');
        const searchDriversBtn = document.getElementById('searchDriversBtn');
        const bookingForm = document.getElementById('bookingForm');

        initializeMap();

        function searchDrivers() {
            const selectedBarangay = barangaySelect.value;
            
            driverList.innerHTML = '<div class="driver-card"><p>Searching for drivers...</p></div>';

            fetch(`{{ route('passenger.available.drivers') }}?barangay=${selectedBarangay}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        updateDriverList(data.drivers, selectedBarangay);
                    } else {
                        driverList.innerHTML = `
                            <div class="driver-card">
                                <p>Error: ${data.message}</p>
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    driverList.innerHTML = `
                        <div class="driver-card">
                            <p>Error loading drivers</p>
                            <small class="text-muted">Please check your connection and try again</small>
                        </div>
                    `;
                });
        }

        function updateDriverList(drivers, barangay) {
            if (drivers.length === 0) {
                const locationText = barangay === 'all' ? 'in any barangay' : `in ${barangay}`;
                driverList.innerHTML = `
                    <div class="driver-card empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-motorcycle"></i>
                        </div>
                        <p>No available delivery drivers ${locationText} at the moment.</p>
                        <small class="text-muted">Please check back later or try a different barangay.</small>
                    </div>
                `;
                return;
            }
            
            driverList.innerHTML = drivers.map(driver => {
                const locationText = driver.currentLocation === 'all' 
                    ? '<span class="text-success">Available for All Locations</span>' 
                    : driver.currentLocation;
                
                const profileImage = driver.profile_image || '/images/default-avatar.png';
                const averageRating = driver.average_rating ? driver.average_rating.toFixed(1) : 'New';
                const totalReviews = driver.total_reviews || 0;
                
                return `
                    <div class="driver-card" data-driver-id="${driver.id}">
                        <div class="driver-header">
                            <div class="driver-profile">
                                <img src="${profileImage}" alt="${driver.fullname}" class="driver-avatar">
                                <div class="driver-info">
                                    <strong>${driver.fullname}</strong>
                                    <div class="driver-rating">
                                        <span class="star-rating">
                                            <i class="fas fa-star"></i> ${averageRating}
                                        </span>
                                        <span class="rating-text">(${totalReviews} reviews)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="driver-details">
                            <div class="detail-item">
                                <i class="fas fa-motorcycle"></i>
                                <span>${driver.vehicleMake} ${driver.vehicleModel}</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-tag"></i>
                                <span>Plate: ${driver.plateNumber}</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-check-circle"></i>
                                <span>${driver.completedBooking} completed deliveries</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span class="${driver.currentLocation === 'all' ? 'text-success' : 'text-info'}">
                                    ${driver.currentLocation === 'all' ? 'All Areas' : driver.currentLocation}
                                </span>
                            </div>
                        </div>
                        
                        <div class="driver-status">
                            <span class="status-badge status-available">
                                <i class="fas fa-circle"></i> Available for Delivery
                            </span>
                        </div>
                    </div>
                `;
            }).join('');
        }

        if (searchDriversBtn) {
            searchDriversBtn.addEventListener('click', searchDrivers);
        }

        if (bookingForm) {
            bookingForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                // Prevent multiple submissions
                if (isSubmitting) {
                    return;
                }
                
                console.log('Form submitted via AJAX');

                // Validate required fields
                const pickupLat = document.getElementById('pickupLatitude').value;
                const dropoffLat = document.getElementById('dropoffLatitude').value;
                
                if (!pickupLat || !dropoffLat) {
                    showAlert('Please set both pickup and drop-off locations on the map before booking.', 'error');
                    return false;
                }
                
                const pickupLocation = document.getElementById('pickupLocation').value;
                const dropoffLocation = document.getElementById('dropoffLocation').value;
                
                if (!pickupLocation || !dropoffLocation) {
                    showAlert('Please fill in both pickup and drop-off barangay names.', 'error');
                    return false;
                }
                
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                submitBtn.disabled = true;
                isSubmitting = true;

                const formData = new FormData(this);
                
                try {
                    const response = await fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        }
                    });
                    
                    const data = await response.json();
                    
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    } else if (data.success) {
                        showAlert(data.message, 'success', 6000);
                        
                        // Reset form after successful booking
                        setTimeout(() => {
                            resetMap();
                            
                            // Clear form fields (but not hidden ones)
                            document.getElementById('pickupLocation').value = '';
                            document.getElementById('dropoffLocation').value = '';
                            document.getElementById('description').value = '';
                            document.getElementById('scheduleTime').value = '';
                            
                            // Show success message with booking info
                            if (data.booking_id) {
                                const serviceType = document.getElementById('serviceType').value === 'for_delivery' ? 'Delivery' : 'Ride';
                                const fare = document.getElementById('fare').value || '0.00';
                                
                                showAlert(`${serviceType} booked successfully! Booking ID: ${data.booking_id} by Passenger: {{ Auth::guard('passenger')->user()->fullname }}`, 'success', 8000);
                            }
                        }, 1500);
                    } else {
                        // Show error message
                        if (data.message) {
                            showAlert(data.message, 'error');
                        } else if (data.errors) {
                            // Handle validation errors
                            const errorMessages = Object.values(data.errors).flat().join(', ');
                            showAlert('Validation error: ' + errorMessages, 'error');
                        } else {
                            showAlert('An error occurred. Please try again.', 'error');
                        }
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showAlert('Network error. Please check your connection and try again.', 'error');
                } finally {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                    isSubmitting = false;
                }
            });
        }

        const resetMapBtn = document.getElementById('resetMapBtn');
        if (resetMapBtn) {
            resetMapBtn.addEventListener('click', resetMap);
        }

        function resetMap() {
            if (pickupMarker) {
                map.removeLayer(pickupMarker);
                pickupMarker = null;
            }
            if (dropoffMarker) {
                map.removeLayer(dropoffMarker);
                dropoffMarker = null;
            }
            if (routeControl) {
                map.removeControl(routeControl);
                routeControl = null;
            }

            document.getElementById('pickupLatitude').value = '';
            document.getElementById('pickupLongitude').value = '';
            document.getElementById('dropoffLatitude').value = '';
            document.getElementById('dropoffLongitude').value = '';
            document.getElementById('pickupLocation').value = '';
            document.getElementById('dropoffLocation').value = '';
            document.getElementById('pickupDisplay').textContent = 'Click on map to set pickup';
            document.getElementById('dropoffDisplay').textContent = 'Click again to set drop-off';
            document.getElementById('distanceDisplay').textContent = '-';
            document.getElementById('durationDisplay').textContent = '-';
            
            // Reset fare display
            document.getElementById('fareDisplay').innerHTML = `<span class="fare-amount">₱0.00</span>`;
            document.getElementById('fare').value = '';
            
            const surigaoCity = [9.7890, 125.4950];
            map.setView(surigaoCity, 13);
        }

        const userProfileDropdown = document.getElementById('userProfileDropdown');
        if (userProfileDropdown) {
            userProfileDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
                document.getElementById('dropdownMenu').classList.toggle('show');
            });
        }
        
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.user-profile-dropdown')) {
                const dropdownMenu = document.getElementById('dropdownMenu');
                if (dropdownMenu) {
                    dropdownMenu.classList.remove('show');
                }
            }
        });
        
        setTimeout(function() {
            const loadingOverlay = document.getElementById('map-loading');
            if (loadingOverlay && loadingOverlay.style.display !== 'none') {
                loadingOverlay.style.display = 'none';
                console.log('Fallback: Hiding loading overlay');
            }
        }, 5000);

        @if(session('success'))
            showAlert('{{ session('success') }}', 'success');
        @endif

        @if(session('error'))
            showAlert('{{ session('error') }}', 'error');
        @endif
    });
</script>
</body>
</html>