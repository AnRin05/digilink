<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FastLan - Driver Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
    <link rel="icon" href="{{ asset('images/fastlan1.png') }}">
<style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

:root {
    --primary-red: #dc3545;
    --dark-red: #c82333;
    --black: #212529;
    --dark-gray: #343a40;
    --medium-gray: #6c757d;
    --light-gray: #e9ecef;
    --white: #ffffff;
    --off-white: #f8f9fa;
    --success: #28a745;
    --warning: #ffc107;
    --info: #17a2b8;
}

html, body {
    width: 100%;
    overflow-x: hidden;
}

body {
    background: linear-gradient(135deg, var(--off-white) 0%, var(--light-gray) 100%);
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    position: relative;
    color: var(--black);
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

@keyframes pulse {
    0%, 100% { 
        transform: scale(1); 
        opacity: 1; 
    }
    50% { 
        transform: scale(1.1); 
        opacity: 0.8; 
    }
}

.navbar {
    height: auto;
    min-height: 70px;
    width: 100%;
    padding: 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: linear-gradient(135deg, var(--black) 0%, var(--dark-gray) 100%);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    position: sticky;
    top: 0;
    z-index: 1000;
    flex-wrap: wrap;
    gap: 1rem;
}

.nav-brand {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--primary-red);
    text-decoration: none;
    text-shadow: 0 2px 4px rgba(220, 53, 69, 0.3);
    transition: all 0.3s ease;
}

.nav-brand:hover {
    transform: translateY(-2px);
    text-shadow: 0 4px 8px rgba(220, 53, 69, 0.4);
}

.nav-brand span {
    color: var(--white);
}

.nav-links {
    display: flex;
    align-items: center;
    gap: 0.8rem;
    flex-wrap: wrap;
}

.nav-link {
    color: var(--white);
    text-decoration: none;
    font-weight: 500;
    padding: 8px 12px;
    border-radius: 8px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    font-size: 0.9rem;
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
    background: var(--primary-red);
    transition: width 0.3s ease;
}

.nav-link:hover::after {
    width: 80%;
}

.nav-link:hover {
    color: var(--primary-red);
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
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 3px solid var(--primary-red);
    object-fit: cover;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
}

.online-indicator {
    position: absolute;
    bottom: 2px;
    right: 2px;
    width: 12px;
    height: 12px;
    background: var(--success);
    border-radius: 50%;
    border: 2px solid var(--black);
    animation: pulse 2s ease-in-out infinite;
}

.user-profile span {
    color: var(--white);
    font-weight: 600;
    font-size: 0.9rem;
    display: none;
}

.dropdown-content {
    display: none;
    position: absolute;
    right: 0;
    top: 100%;
    background: linear-gradient(135deg, var(--white) 0%, var(--off-white) 100%);
    min-width: 200px;
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    z-index: 1001;
    overflow: hidden;
    margin-top: 10px;
}

.dropdown-content.show {
    display: block;
}

.dropdown-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    color: var(--medium-gray);
    text-decoration: none;
    transition: all 0.3s ease;
    border-bottom: 1px solid var(--light-gray);
    min-height: 44px;
    cursor: pointer;
}

.dropdown-item:last-child {
    border-bottom: none;
}

.dropdown-item:hover {
    background: rgba(220, 53, 69, 0.08);
    color: var(--primary-red);
}

.dropdown-item i {
    width: 20px;
    text-align: center;
    color: var(--medium-gray);
}

.dropdown-item:hover i {
    color: var(--primary-red);
}

.dropdown-item.logout {
    color: var(--primary-red);
    font-weight: 600;
}

.dashboard-container {
    max-width: 1400px;
    margin: 1.5rem auto;
    padding: 0 1rem;
    width: 100%;
}

.dashboard-header {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-bottom: 1.5rem;
    align-items: flex-start;
}

.dashboard-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: var(--black);
    position: relative;
    display: inline-block;
    word-break: break-word;
}

.dashboard-title::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 0;
    width: 60px;
    height: 3px;
    background: var(--primary-red);
    border-radius: 2px;
}

.dashboard-layout {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
    align-items: start;
}

.status-card {
    background: linear-gradient(135deg, var(--white) 0%, var(--off-white) 100%);
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(0, 0, 0, 0.08);
    margin-bottom: 1.5rem;
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.2rem;
}

.driver-info {
    min-width: 100%;
}

.driver-info h3 {
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--black);
    margin-bottom: 0.5rem;
    line-height: 1.2;
    word-break: break-word;
}

.driver-info p {
    color: var(--medium-gray);
    margin-bottom: 0.4rem;
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.85rem;
}

.driver-info i {
    width: 16px;
    text-align: center;
    color: var(--primary-red);
    flex-shrink: 0;
}

.driver-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 1rem;
    padding: 1rem 0;
    align-items: start;
}

.stat-item {
    text-align: center;
    padding: 0.8rem;
    background: rgba(255, 255, 255, 0.7);
    border-radius: 12px;
    border: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.stat-item:hover {
    background: rgba(255, 255, 255, 0.9);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.stat-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--primary-red);
    line-height: 1;
    margin-bottom: 0.4rem;
    min-height: 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.stat-label {
    font-size: 0.8rem;
    color: var(--medium-gray);
    font-weight: 500;
    white-space: nowrap;
}

.stat-item .dropdown-item {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 1rem 1.5rem;
    text-decoration: none;
    font-weight: 700;
    font-size: 1rem;
    border-radius: 10px;
    transition: all 0.3s ease;
    background: transparent;
    border: none;
    width: 100%;
    text-align: center;
}

.stat-item .dropdown-item:hover {
    background: rgba(220, 53, 69, 0.1);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
}

.stat-item .dropdown-item i {
    color: #FFD700;
    font-size: 1.3rem;
    transition: all 0.3s ease;
}

.stat-item .dropdown-item:hover i {
    transform: scale(1.2) rotate(10deg);
    color: #FFC107;
    text-shadow: 0 2px 8px rgba(255, 193, 7, 0.4);
}

/* Star Rating Styles */
.star-rating-permanent {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 2px;
    margin-bottom: 5px;
}

.star-rating-permanent i {
    color: #FFD700;
    font-size: 1.1rem;
}

.rating-text {
    margin-left: 8px;
    font-weight: 600;
    color: #333;
    font-size: 1.1rem;
}

.total-reviews {
    font-size: 0.85rem;
    color: #666;
    text-align: center;
}

.rating-display {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.stat-item .stat-value.rating-display {
    min-height: 60px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

/* Responsive adjustments */
@media (min-width: 768px) {
    .driver-stats {
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        padding: 1.5rem;
    }
    
    .stat-item:last-child {
        grid-column: 1 / -1;
        margin-top: 0.5rem;
    }
    
    .stat-value {
        font-size: 2rem;
    }
    
    .stat-label {
        font-size: 0.85rem;
    }
    
    .stat-item .dropdown-item {
        font-size: 1.1rem;
        padding: 1.2rem 2rem;
    }
    
    .stat-item .dropdown-item i {
        font-size: 1.4rem;
    }
}

@media (max-width: 767px) {
    .driver-stats {
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
    }
    
    .stat-item:last-child {
        grid-column: 1 / -1;
    }
    
    .stat-item .dropdown-item {
        font-size: 0.9rem;
        padding: 0.8rem 1rem;
    }
}

@media (max-width: 480px) {
    .driver-stats {
        grid-template-columns: 1fr;
        gap: 0.8rem;
    }
    
    .stat-item {
        padding: 1rem;
    }
    
    .stat-item:last-child {
        grid-column: 1 / -1;
    }
    
    .stat-value {
        font-size: 1.8rem;
    }
    
    .stat-item .dropdown-item {
        font-size: 0.95rem;
        padding: 1rem 1.2rem;
    }
}
.location-update {
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 0.8rem;
    align-items: flex-end;
}

.location-update label {
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--medium-gray);
    display: block;
    margin-bottom: 0.3rem;
}

.location-update .form-select {
    padding: 10px 12px;
    border: 2px solid rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    font-size: 0.9rem;
    min-height: 44px;
    width: 100%;
}

.location-update .btn {
    padding: 10px 14px;
    font-size: 0.85rem;
    min-height: 44px;
}

.availability-toggle {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.6rem;
    min-width: 100%;
}

.toggle-label {
    font-weight: 600;
    color: var(--medium-gray);
    font-size: 0.85rem;
    text-align: center;
}

.toggle-switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 30px;
}

.toggle-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.toggle-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: 0.4s;
    border-radius: 34px;
}

.toggle-slider:before {
    position: absolute;
    content: "";
    height: 22px;
    width: 22px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: 0.4s;
    border-radius: 50%;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

input:checked + .toggle-slider {
    background-color: var(--primary-red);
}

input:checked + .toggle-slider:before {
    transform: translateX(30px);
}

.filter-toggle {
    position: fixed;
    right: 20px;
    bottom: 30px;
    z-index: 999;
    background: var(--primary-red);
    color: white;
    border: none;
    border-radius: 50%;
    width: 56px;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 4px 15px rgba(220, 53, 69, 0.4);
    transition: all 0.3s ease;
    min-height: 56px;
    min-width: 56px;
}

.filter-toggle:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(220, 53, 69, 0.6);
}

.filter-toggle i {
    font-size: 1.3rem;
}

.filter-section {
    position: fixed;
    right: 20px;
    bottom: 100px;
    width: calc(100% - 40px);
    max-width: 350px;
    background: linear-gradient(135deg, var(--white) 0%, var(--off-white) 100%);
    border-radius: 20px;
    padding: 1.2rem;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    border: 1px solid rgba(0, 0, 0, 0.08);
    z-index: 998;
    transform: translateY(400px);
    transition: transform 0.3s ease;
    max-height: calc(100vh - 150px);
    overflow-y: auto;
}

.filter-section.expanded {
    transform: translateY(0);
}

.filter-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--black);
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 8px;
}

.filter-title i {
    color: var(--primary-red);
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 0.4rem;
    margin-bottom: 1rem;
}

.filter-label {
    font-weight: 600;
    color: var(--medium-gray);
    font-size: 0.9rem;
}

.filter-select {
    padding: 10px 12px;
    border: 2px solid var(--light-gray);
    border-radius: 12px;
    font-size: 0.9rem;
    color: var(--black);
    background: var(--white);
    transition: all 0.3s ease;
    cursor: pointer;
    appearance: none;
    min-height: 44px;
}

.filter-select:focus {
    border-color: var(--primary-red);
    outline: none;
    box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
}

.btn {
    padding: 10px 18px;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.9rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    min-height: 44px;
    white-space: nowrap;
}

.btn i {
    transition: transform 0.3s ease;
}

.btn:hover i {
    transform: scale(1.1);
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary-red) 0%, var(--dark-red) 100%);
    color: white;
    box-shadow: 0 6px 20px rgba(220, 53, 69, 0.25);
}

.btn-primary:hover {
    background: linear-gradient(135deg, var(--dark-red) 0%, #a71e2a 100%);
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(220, 53, 69, 0.35);
}

.btn-primary:active {
    transform: scale(0.98);
}

.btn-outline {
    background: transparent;
    color: var(--medium-gray);
    border: 2px solid var(--light-gray);
}

.btn-outline:hover {
    background: rgba(220, 53, 69, 0.05);
    color: var(--primary-red);
    border-color: var(--primary-red);
    transform: translateY(-2px);
}

.btn-success {
    background: linear-gradient(135deg, var(--success) 0%, #20c997 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.2);
}

.btn-success:hover {
    background: linear-gradient(135deg, #218838 0%, #1e9e8a 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(40, 167, 69, 0.35);
}

.btn-danger {
    background: linear-gradient(135deg, var(--primary-red) 0%, var(--dark-red) 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(220, 53, 69, 0.2);
}

.btn-danger:hover {
    background: linear-gradient(135deg, var(--dark-red) 0%, #a71e2a 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(220, 53, 69, 0.35);
}

.btn-sm {
    padding: 8px 12px;
    font-size: 0.8rem;
}

.accepted-bookings-sidebar {
    background: linear-gradient(135deg, var(--white) 0%, var(--off-white) 100%);
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(0, 0, 0, 0.08);
    height: fit-content;
}

.sidebar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.2rem;
    padding-bottom: 0.8rem;
    border-bottom: 2px solid var(--light-gray);
}

.sidebar-header h3 {
    margin: 0;
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--black);
    display: flex;
    align-items: center;
    gap: 8px;
}

.sidebar-header .badge {
    background: var(--primary-red);
    color: white;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}

.accepted-bookings-list {
    max-height: 500px;
    overflow-y: auto;
    padding-right: 4px;
}

.accepted-bookings-list::-webkit-scrollbar {
    width: 6px;
}

.accepted-bookings-list::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.accepted-bookings-list::-webkit-scrollbar-thumb {
    background: var(--primary-red);
    border-radius: 10px;
}

.accepted-booking-item {
    background: var(--white);
    border-radius: 12px;
    padding: 1rem;
    margin-bottom: 0.8rem;
    border: 2px solid var(--light-gray);
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.accepted-booking-item:hover {
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
    border-color: var(--primary-red);
}

.accepted-booking-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 0.8rem;
}

.accepted-booking-header h4 {
    margin: 0;
    font-size: 1rem;
    font-weight: 600;
    color: var(--black);
    word-break: break-word;
}

.accepted-booking-details p {
    margin: 6px 0;
    font-size: 0.85rem;
    color: var(--medium-gray);
    display: flex;
    align-items: center;
    gap: 6px;
}

.accepted-booking-details i {
    width: 14px;
    color: var(--primary-red);
    flex-shrink: 0;
}

.accepted-booking-actions {
    display: flex;
    flex-direction: column;
    gap: 0.6rem;
    margin-top: 0.8rem;
}

.accepted-booking-actions .btn {
    width: 100%;
    padding: 8px 12px;
    font-size: 0.8rem;
}

.bookings-section {
    background: linear-gradient(135deg, var(--white) 0%, var(--off-white) 100%);
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(0, 0, 0, 0.08);
}

.section-header {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-bottom: 1.5rem;
    align-items: flex-start;
}

.section-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: var(--black);
    position: relative;
    display: inline-block;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 0;
    width: 60px;
    height: 3px;
    background: var(--primary-red);
    border-radius: 2px;
}

.bookings-count {
    background: var(--primary-red);
    color: white;
    padding: 6px 12px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.8rem;
    align-self: flex-start;
}

.booking-card {
    background: var(--white);
    border-radius: 15px;
    padding: 1.2rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    border: 2px solid var(--light-gray);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    margin-bottom: 1rem;
}

.booking-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(220, 53, 69, 0.05), transparent);
    transition: left 0.6s ease;
}

.booking-card:hover::before {
    left: 100%;
}

.booking-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
    border-color: var(--primary-red);
}

.booking-header {
    display: flex;
    flex-direction: column;
    gap: 0.8rem;
    margin-bottom: 1rem;
    align-items: flex-start;
}

.passenger-info {
    display: flex;
    align-items: center;
    gap: 0.8rem;
    width: 100%;
}

.passenger-avatar {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid var(--light-gray);
    flex-shrink: 0;
}

.passenger-details h4 {
    font-size: 1rem;
    font-weight: 700;
    color: var(--black);
    margin-bottom: 0.2rem;
    word-break: break-word;
}

.passenger-details p {
    color: var(--medium-gray);
    font-size: 0.85rem;
    display: flex;
    align-items: center;
    gap: 4px;
}

.booking-type {
    background: var(--light-gray);
    color: var(--medium-gray);
    padding: 4px 10px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.75rem;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    white-space: nowrap;
}

.booking-type.ride {
    background: rgba(40, 167, 69, 0.1);
    color: var(--success);
}

.booking-details {
    margin-bottom: 1rem;
}

.location-row {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    margin-bottom: 0.8rem;
}

.location-icon {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 0.75rem;
}

.pickup-icon {
    background: rgba(220, 53, 69, 0.1);
    color: var(--primary-red);
}

.dropoff-icon {
    background: rgba(40, 167, 69, 0.1);
    color: var(--success);
}

.location-text {
    flex: 1;
    min-width: 0;
}

.location-label {
    font-weight: 600;
    color: var(--medium-gray);
    font-size: 0.85rem;
    margin-bottom: 0.2rem;
}

.location-address {
    color: var(--medium-gray);
    font-size: 0.85rem;
    word-break: break-word;
}

.booking-meta {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(80px, 1fr));
    gap: 0.8rem;
    margin-bottom: 1rem;
}

.meta-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

.meta-label {
    font-size: 0.75rem;
    color: var(--medium-gray);
    margin-bottom: 0.3rem;
}

.meta-value {
    font-weight: 600;
    color: var(--black);
    font-size: 0.95rem;
}

.meta-value.fare {
    color: var(--primary-red);
    font-size: 1.1rem;
}

.booking-actions {
    display: flex;
    flex-direction: column;
    gap: 0.6rem;
}

.booking-actions .btn {
    width: 100%;
}

.empty-state {
    text-align: center;
    padding: 2rem;
    color: var(--medium-gray);
}

.empty-icon {
    font-size: 3.5rem;
    color: var(--light-gray);
    margin-bottom: 1rem;
}

.empty-title {
    font-size: 1.3rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--medium-gray);
}

.booking-status {
    padding: 4px 10px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.75rem;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.status-accepted {
    background: rgba(255, 193, 7, 0.1);
    color: var(--warning);
}

@media (min-width: 768px) {
    .navbar {
        height: 80px;
        padding: 0 2rem;
        flex-wrap: nowrap;
        gap: 2rem;
    }

    .nav-brand {
        font-size: 1.6rem;
    }

    .nav-links {
        gap: 1.2rem;
    }

    .nav-link {
        padding: 10px 16px;
        font-size: 1rem;
    }

    .user-profile span {
        display: inline;
    }

    .profile-pic {
        width: 45px;
        height: 45px;
    }

    .dashboard-container {
        padding: 0 2rem;
        margin: 2rem auto;
    }

    .dashboard-header {
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .dashboard-title {
        font-size: 1.8rem;
    }

    .dashboard-layout {
        grid-template-columns: 350px 1fr;
        gap: 2rem;
    }

    .status-card {
        grid-template-columns: 1fr auto auto auto;
        padding: 2rem;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .driver-info {
        min-width: 250px;
    }

    .driver-info h3 {
        font-size: 1.3rem;
    }

    .driver-stats {
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
        padding: 0 1.5rem;
        border-left: 2px solid rgba(0, 0, 0, 0.1);
        border-right: 2px solid rgba(0, 0, 0, 0.1);
    }

    .stat-value {
        font-size: 2rem;
    }

    .location-update {
        grid-template-columns: 1fr;
        gap: 0.8rem;
        min-width: 200px;
    }

    .availability-toggle {
        flex-direction: column;
        min-width: 120px;
    }

    .filter-section {
        width: 350px;
        bottom: auto;
        top: 200px;
        right: 30px;
        transform: translateX(400px);
    }

    .filter-toggle {
        right: 30px;
        top: 120px;
        bottom: auto;
        width: 60px;
        height: 60px;
    }

    .filter-toggle i {
        font-size: 1.5rem;
    }

    .accepted-bookings-sidebar {
        padding: 2rem;
        position: sticky;
        top: 100px;
    }

    .bookings-section {
        padding: 2rem;
    }

    .section-header {
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .section-title {
        font-size: 1.6rem;
    }

    .bookings-count {
        padding: 8px 16px;
        font-size: 0.9rem;
        align-self: center;
    }

    .booking-card {
        padding: 1.5rem;
    }

    .booking-header {
        flex-direction: row;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1.5rem;
    }

    .passenger-avatar {
        width: 50px;
        height: 50px;
    }

    .booking-meta {
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
    }

    .booking-meta .meta-item:nth-child(1),
    .booking-meta .meta-item:nth-child(2) {
        grid-column: 2 / 4;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
        justify-items: center;
    }

    .booking-meta .meta-item:nth-child(1) {
        grid-column: 2 / 3;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .booking-meta .meta-item:nth-child(2) {
        grid-column: 3 / 4;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .booking-actions {
        flex-direction: row;
        gap: 1rem;
    }

    .accepted-booking-item {
        padding: 1.5rem;
    }

    .accepted-booking-actions {
        flex-direction: row;
    }

    .btn {
        padding: 12px 24px;
        font-size: 1rem;
    }
}

@media (min-width: 992px) {
    .navbar {
        padding: 0 3rem;
    }

    .nav-brand {
        font-size: 1.8rem;
    }

    .dashboard-container {
        padding: 0 2rem;
    }

    .dashboard-title {
        font-size: 2.2rem;
    }

    .dashboard-title::after {
        width: 80px;
    }

    .status-card {
        padding: 2rem;
    }

    .driver-info h3 {
        font-size: 1.5rem;
    }

    .accepted-bookings-sidebar {
        padding: 2rem;
    }

    .bookings-section {
        padding: 2rem;
    }

    .section-title {
        font-size: 1.8rem;
    }

    .booking-card {
        padding: 1.5rem;
    }
}

@media (max-width: 1200px) {
    .dashboard-layout {
        grid-template-columns: 1fr;
    }

    .status-card {
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    .driver-stats {
        grid-column: 1 / -1;
        justify-content: space-around;
        border-left: none;
        border-right: none;
        border-top: 2px solid rgba(0, 0, 0, 0.1);
        border-bottom: 2px solid rgba(0, 0, 0, 0.1);
        padding: 1.5rem 0;
    }
}

@media (max-width: 992px) {
    .status-card {
        grid-template-columns: 1fr;
        padding: 1.5rem;
        gap: 1.2rem;
    }

    .driver-info,
    .location-update,
    .availability-toggle {
        min-width: 100%;
    }

    .driver-stats {
        gap: 1rem;
        padding: 1rem 0;
    }

    .stat-value {
        font-size: 1.5rem;
    }

    .availability-toggle {
        flex-direction: row;
        justify-content: space-between;
    }
}

@media (max-width: 768px) {
    .nav-brand {
        font-size: 1.5rem;
    }

    .dashboard-container {
        padding: 0 1rem;
    }

    .dashboard-title {
        font-size: 1.5rem;
    }

    .status-card {
        padding: 1.2rem;
    }

    .bookings-section {
        padding: 1.2rem;
    }

    .accepted-bookings-sidebar {
        padding: 1.2rem;
    }

    .filter-section {
        width: calc(100% - 40px);
        right: 20px;
        left: auto;
        max-width: none;
    }

    .section-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .booking-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .booking-meta {
        grid-template-columns: repeat(2, 1fr);
    }

    .booking-actions {
        flex-direction: column;
    }

    .accepted-booking-actions {
        flex-direction: column;
    }
}

@media (max-width: 480px) {
    .nav-brand {
        font-size: 1.3rem;
    }

    .dashboard-title {
        font-size: 1.3rem;
    }

    .status-card {
        padding: 1rem;
    }

    .driver-stats {
        flex-direction: column;
        gap: 0.8rem;
    }

    .stat-item {
        width: 100%;
        padding: 0.8rem;
        background: rgba(255, 255, 255, 0.5);
        border-radius: 10px;
    }

    .driver-info h3 {
        font-size: 1.1rem;
    }

    .bookings-section {
        padding: 1rem;
    }

    .section-title {
        font-size: 1.3rem;
    }

    .accepted-bookings-sidebar {
        padding: 1rem;
    }

    .accepted-booking-item {
        padding: 0.8rem;
    }

    .booking-card {
        padding: 1rem;
    }

    .booking-meta {
        grid-template-columns: 1fr;
    }

    .passenger-details h4 {
        font-size: 0.95rem;
    }

    .location-address {
        font-size: 0.8rem;
    }
}

@media (hover: none) and (pointer: coarse) {
    .nav-link,
    .btn,
    .filter-select,
    .dropdown-item {
        min-height: 48px;
    }

    .filter-toggle {
        min-height: 56px;
        min-width: 56px;
    }

    .location-update .btn {
        min-height: 48px;
    }

    .passenger-avatar {
        min-width: 45px;
    }

    .location-icon {
        min-width: 24px;
    }
}
/* Star Rating Styles */
.star-rating-permanent {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 2px;
    margin-bottom: 5px;
}

.star-rating-permanent i {
    color: #FFD700;
    font-size: 1.1rem;
}

.rating-text {
    margin-left: 8px;
    font-weight: 600;
    color: #333;
    font-size: 1.1rem;
}

.total-reviews {
    font-size: 0.85rem;
    color: #666;
    text-align: center;
}

.rating-display {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.stat-item .stat-value.rating-display {
    min-height: 60px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
</style>
<body>
    <nav class="navbar">
        @include('logo')
        <div class="nav-links">
            <a href="{{ route('driver.dashboard') }}" class="nav-link">Driver Dashboard</a>
            <a href="{{ route('driver.edit') }}" class="nav-link">Edit Account</a>
            <div class="user-profile-dropdown">
            <div class="user-profile" id="userProfileDropdown">
                <div class="profile-container">
                    <img src="{{ Auth::guard('driver')->user()->getProfileImageUrl() }}" 
                         alt="Profile" class="profile-pic">
                    <div class="online-indicator {{ Auth::guard('driver')->user()->availStatus ? 'online' : 'offline' }}"></div>
                </div>
                <span>{{ Auth::guard('driver')->user()->fullname }}</span>
                <i class="fas fa-chevron-down" style="font-size: 0.8rem; color: #ffffff;"></i>
            </div>
                <div class="dropdown-content" id="dropdownMenu">
                    <a href="{{ route('driver.dashboard') }}" class="dropdown-item">
                        <i class="fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('driver.edit') }}" class="dropdown-item">
                        <i class="fas fa-user-edit"></i>
                        Edit Account
                    </a>
                    <a href="{{ route('driver.history') }}" class="dropdown-item">
                        <i class="fas fa-history"></i>
                        Booking History
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

    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1 class="dashboard-title">Driver Dashboard</h1>
            <div class="current-time" id="currentTime"></div>
        </div>
            <div class="status-card">
                <div class="driver-info">
                    <h3>{{ Auth::guard('driver')->user()->fullname }}</h3>
                    <p><i class="fas fa-car"></i> {{ Auth::guard('driver')->user()->vehicleMake }}
                        {{ Auth::guard('driver')->user()->vehicleModel }} ({{ Auth::guard('driver')->user()->plateNumber }})
                    </p>
                    <p><i class="fas fa-map-marker-alt"></i> {{ Auth::guard('driver')->user()->currentLocation }}</p>
                    <p><i class="fas fa-briefcase"></i> {{ Auth::guard('driver')->user()->serviceType }}</p>
                </div>

                <div class="driver-stats">
                    <div class="stat-item">
                        <div class="stat-value">{{ Auth::guard('driver')->user()->completedBooking }}</div>
                        <div class="stat-label">Completed Rides</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value" id="todayBookings">0</div>
                        <div class="stat-label">Today's Rides</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value" id="totalEarnings">₱0.00</div>
                        <div class="stat-label">Total Earnings</div>
                    </div>
                    <div class="stat-item">
                        <a href="{{ route('driver.rating') }}" class="dropdown-item">
                            <i class="fa-regular fa-star"></i>
                            See Your Ratings!
                        </a>
                    </div>
                </div>
                <div class="location-update">
                    <label for="driverLocation">Current Location:</label>
                    <select id="driverLocation" class="form-select">
                        <option value="">Select Location</option>
                        @foreach(App\Models\Driver::getAvailableLocations() as $key => $loc)
                            <option value="{{ $loc }}" {{ Auth::guard('driver')->user()->currentLocation === $loc ? 'selected' : '' }}>
                                {{ $loc }}
                            </option>
                        @endforeach
                    </select>
                    <button id="updateLocationBtn" class="btn btn-primary mt-2">Update Location</button>
                </div>
                <div class="availability-toggle">
                    <span class="toggle-label">Available for Bookings</span>
                    <label class="toggle-switch">
                        <input type="checkbox" id="availabilityToggle"
                            {{ Auth::guard('driver')->user()->availStatus ? 'checked' : '' }}>
                        <span class="toggle-slider"></span>
                    </label>
                </div>
            </div>
                                                    <!-- Dashboard Layout -->
    <div class="dashboard-layout">
                                                    <!-- Left Sidebar - Accepted Bookings -->
        <div class="accepted-bookings-sidebar">
            <div class="sidebar-header">
                <h3><i class="fas fa-clipboard-check"></i> Accepted Bookings</h3>
                <span class="badge" id="acceptedBookingsCount">0</span>
            </div>
            <div class="accepted-bookings-list" id="acceptedBookingsList">
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <h4 class="empty-title">No Accepted Bookings</h4>
                    <p class="empty-text">Accepted bookings will appear here</p>
                </div>
            </div>
        </div>
                                                    <!-- Right Side Content -->
        <div class="dashboard-main">
                                                    <!-- Driver Status Card -->
            <div class="bookings-section">
            <div class="section-header">
                <h2 class="section-title">Available Bookings</h2>
                <div class="bookings-count" id="bookingsCount">Loading...</div>
            </div>

            <div class="bookings-grid" id="bookingsGrid">
                <div class="empty-state" id="loadingState">
                    <div class="empty-icon">
                        <i class="fas fa-spinner fa-spin"></i>
                    </div>
                    <h3 class="empty-title">Loading Bookings</h3>
                    <p class="empty-text">Please wait while we fetch available bookings...</p>
                </div>
            </div>

            <div class="empty-state" id="emptyState" style="display: none;">
                <div class="empty-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <h3 class="empty-title">No Available Bookings</h3>
                <p class="empty-text">There are currently no bookings available. Please check back later.</p>
                <button class="btn btn-primary" onclick="loadAvailableBookings()">
                    <i class="fas fa-redo"></i>
                    Refresh
                </button>
            </div>
        </div>

    </div>
</div>

    <script>
    function fetchTodayStats() {
        fetch("{{ route('driver.getTodayStats') }}")
            .then(res => {
                if (!res.ok) throw new Error('Network response was not ok');
                return res.json();
            })
            .then(data => {
                if (data.success) {
                    document.getElementById('todayBookings').textContent = data.today_rides;
                    document.getElementById('totalEarnings').textContent = '₱' + data.today_earnings;
                }
            })
            .catch(err => console.error('Error fetching stats:', err));
    }


    fetchTodayStats();
    setInterval(fetchTodayStats, 10000);

    document.getElementById('updateLocationBtn').addEventListener('click', function() {
        const selectedLocation = document.getElementById('driverLocation').value;

        if (!selectedLocation) {
            alert('Please select a location.');
            return;
        }

        fetch("{{ route('driver.updateCurrentLocation') }}", {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                location: selectedLocation
            })
        })
        .then(res => {
            if (!res.ok) throw new Error('Network response was not ok');
            return res.json();
        })
        .then(data => {
            if (data.success) {
                alert('Current location updated to ' + selectedLocation);
                document.querySelector('.driver-info p i.fa-map-marker-alt')
                    .parentElement.innerHTML = `<i class="fas fa-map-marker-alt"></i> ${selectedLocation}`;
            } else {
                alert('Failed to update location: ' + data.message);
            }
        })
        .catch(err => {
            console.error('Error updating location:', err);
            alert('Error updating location. Please try again.');
        });
    });

    document.getElementById('userProfileDropdown').addEventListener('click', function(e) {
        e.stopPropagation();
        document.getElementById('dropdownMenu').classList.toggle('show');
    });

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.user-profile-dropdown')) {
            document.getElementById('dropdownMenu').classList.remove('show');
        }
    });

    function updateTime() {
        const now = new Date();
        const options = { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        };
        document.getElementById('currentTime').textContent = now.toLocaleDateString('en-US', options);
    }

    setInterval(updateTime, 1000);
    updateTime();

    let acceptedBookings = JSON.parse(localStorage.getItem('acceptedBookings') || '[]');

    document.getElementById('availabilityToggle').addEventListener('change', function() {
        const isAvailable = this.checked;
        
        const onlineIndicator = document.querySelector('.online-indicator');
        if (isAvailable) {
            onlineIndicator.style.background = '#28a745';
            loadAvailableBookings();
        } else {
            onlineIndicator.style.background = '#6c757d';
            document.getElementById('bookingsGrid').innerHTML = `
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-power-off"></i>
                    </div>
                    <h3 class="empty-title">Offline Mode</h3>
                    <p class="empty-text">You are currently offline. Turn on availability to see bookings.</p>
                </div>
            `;
            document.getElementById('bookingsCount').textContent = '0 bookings';
            document.getElementById('emptyState').style.display = 'none';
        }
        
        updateDriverAvailability(isAvailable);
    });

    function updateDriverAvailability(isAvailable) {
        fetch("{{ route('driver.update.availability') }}", {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                availStatus: isAvailable
            })
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            if (data.success) {
                console.log('Availability updated successfully');
            } else {
                throw new Error(data.message || 'Failed to update availability');
            }
        })
        .catch(error => {
            console.error('Error updating availability:', error);
            document.getElementById('availabilityToggle').checked = !isAvailable;
            showNotification('Failed to update availability: ' + error.message, 'error');
        });
    }

    function loadBookingStats() {
        fetch("{{ route('driver.booking.stats') }}")
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    document.getElementById('todayBookings').textContent = data.today_bookings;
                    document.getElementById('totalEarnings').textContent = data.total_earnings;
                }
            })
            .catch(error => {
                console.error('Error loading stats:', error);
            });
    }

    function loadAvailableBookings() {
        const grid = document.getElementById('bookingsGrid');
        const countElement = document.getElementById('bookingsCount');
        const emptyState = document.getElementById('emptyState');

        if (!document.getElementById('availabilityToggle').checked) {
            grid.innerHTML = `
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-power-off"></i>
                    </div>
                    <h3 class="empty-title">Offline Mode</h3>
                    <p class="empty-text">You are currently offline. Turn on availability to see bookings.</p>
                </div>
            `;
            countElement.textContent = '0 bookings';
            emptyState.style.display = 'none';
            return;
        }

        grid.innerHTML = `
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-spinner fa-spin"></i>
                </div>
                <h3 class="empty-title">Loading Bookings</h3>
                <p class="empty-text">Please wait while we fetch available bookings...</p>
            </div>
        `;
        emptyState.style.display = 'none';

        console.log('Fetching available bookings...');
        
        fetch("{{ route('driver.getAvailableBookings') }}")
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) throw new Error('Network response was not ok: ' + response.status);
                return response.json();
            })
            .then(data => {
                console.log('Received data:', data);
                
                if (!data.success) throw new Error(data.message || 'Failed to load bookings');
                
                grid.innerHTML = '';
                countElement.textContent = `${data.count} booking${data.count !== 1 ? 's' : ''}`;

                if (data.count === 0) {
                    emptyState.style.display = 'block';
                    return;
                }

                data.bookings.forEach(booking => {
                    console.log('Processing booking:', booking);
                    const bookingCard = document.createElement('div');
                    bookingCard.className = 'booking-card';
                    bookingCard.innerHTML = `
                        <div class="booking-header">
                            <div class="passenger-info">
                                <h4>${booking.passenger_name}</h4>
                                <p><i class="fas fa-phone"></i> ${booking.passenger_phone}</p>
                            </div>
                            <div class="service-badge">
                                <i class="fas ${booking.service_type_raw === 'booking_to_go' ? 'fa-car' : 'fa-box'}"></i>
                                ${booking.service_type}
                            </div>
                        </div>
                        
                        <div class="booking-details">
                            <div class="location-row">
                                <div class="location-icon pickup-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="location-text">
                                    <div class="location-label">Pickup Location</div>
                                    <div class="location-address">${booking.pickup_location}</div>
                                </div>
                            </div>
                            <div class="location-row">
                                <div class="location-icon dropoff-icon">
                                    <i class="fas fa-flag-checkered"></i>
                                </div>
                                <div class="location-text">
                                    <div class="location-label">Drop-off Location</div>
                                    <div class="location-address">${booking.dropoff_location}</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="booking-meta">
                            <div class="meta-item">
                                <div class="meta-label">Fare</div>
                                <div class="meta-value fare">${booking.fare}</div>
                            </div>
                            <div class="meta-item">
                                <div class="meta-label">Type</div>
                                <div class="meta-value">${booking.booking_type}</div>
                            </div>
                        </div>
                        
                        <div class="booking-actions">
                            <a href="/digilink/public/driver/booking-details/${booking.id}" class="btn btn-primary">
                                <i class="fas fa-eye"></i>
                                View Details
                            </a>
                        </div>
                    `;
                    grid.appendChild(bookingCard);
                });
            })
            .catch(error => {
                console.error('Error loading bookings:', error);
                grid.innerHTML = `
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <h3 class="empty-title">Error Loading Bookings</h3>
                        <p class="empty-text">There was a problem loading the available bookings. Please try again.</p>
                        <button class="btn btn-primary" onclick="loadAvailableBookings()">
                            <i class="fas fa-redo"></i>
                            Try Again
                        </button>
                    </div>
                `;
                countElement.textContent = 'Error';
            });
    }

    function loadAcceptedBookings() {
        fetch("{{ route('driver.getAcceptedBookings') }}")
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                const listElement = document.getElementById('acceptedBookingsList');
                const countElement = document.getElementById('acceptedBookingsCount');

                if (data.success && data.bookings) {
                    acceptedBookings = data.bookings;
                    localStorage.setItem('acceptedBookings', JSON.stringify(acceptedBookings));
                }
                
                countElement.textContent = data.count;

                if (data.count === 0) {
                    listElement.innerHTML = `
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <h4 class="empty-title">No Accepted Bookings</h4>
                            <p class="empty-text">Accepted bookings will appear here</p>
                        </div>
                    `;
                    return;
                }

                listElement.innerHTML = '';
                data.bookings.forEach(booking => {
                    const bookingItem = document.createElement('div');
                    bookingItem.className = 'accepted-booking-item';
                    bookingItem.innerHTML = `
                        <div class="accepted-booking-header">
                            <h4>${booking.passenger_name}</h4>
                            <span class="status-badge accepted">Accepted</span>
                        </div>
                        <div class="accepted-booking-details">
                            <p><i class="fas fa-map-marker-alt"></i> ${booking.pickup_location}</p>
                            <p><i class="fas fa-flag-checkered"></i> ${booking.dropoff_location}</p>
                            <p><i class="fas fa-calendar"></i> ${booking.schedule_time}</p>
                            <p><i class="fas fa-money-bill-wave"></i> ${booking.fare}</p>
                        </div>
                        <div class="accepted-booking-actions">
                            <button class="btn btn-success btn-sm start-job-btn" 
                                    onclick="checkAndStartJob(${booking.id})"
                                    data-booking-id="${booking.id}">
                                <i class="fas fa-play"></i>
                                Start Job
                            </button>
                            <button class="btn btn-danger btn-sm cancel-booking-btn" 
                                    onclick="cancelAcceptedBooking(${booking.id})"
                                    data-booking-id="${booking.id}">
                                <i class="fas fa-times"></i>
                                Cancel
                            </button>
                        </div>
                    `;
                    listElement.appendChild(bookingItem);
                });
            })
            .catch(error => {
                console.error('Error loading accepted bookings:', error);
                loadAcceptedBookingsFromStorage();
            });
    }

    function loadAcceptedBookingsFromStorage() {
        const listElement = document.getElementById('acceptedBookingsList');
        const countElement = document.getElementById('acceptedBookingsCount');
        
        countElement.textContent = acceptedBookings.length;

        if (acceptedBookings.length === 0) {
            listElement.innerHTML = `
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <h4 class="empty-title">No Accepted Bookings</h4>
                    <p class="empty-text">Accepted bookings will appear here</p>
                </div>
            `;
            return;
        }

        listElement.innerHTML = '';
        acceptedBookings.forEach(booking => {
            const bookingItem = document.createElement('div');
            bookingItem.className = 'accepted-booking-item';
            bookingItem.innerHTML = `
                <div class="accepted-booking-header">
                    <h4>${booking.passenger_name}</h4>
                    <span class="status-badge accepted">Accepted</span>
                </div>
                <div class="accepted-booking-details">
                    <p><i class="fas fa-map-marker-alt"></i> ${booking.pickup_location}</p>
                    <p><i class="fas fa-flag-checkered"></i> ${booking.dropoff_location}</p>
                    <p><i class="fas fa-calendar"></i> ${booking.schedule_time}</p>
                    <p><i class="fas fa-money-bill-wave"></i> ${booking.fare}</p>
                </div>
                <div class="accepted-booking-actions">
                    <button class="btn btn-success btn-sm start-job-btn" 
                            onclick="checkAndStartJob(${booking.id})"
                            data-booking-id="${booking.id}">
                        <i class="fas fa-play"></i>
                        Start Job
                    </button>
                    <button class="btn btn-danger btn-sm cancel-booking-btn" 
                            onclick="cancelAcceptedBooking(${booking.id})"
                            data-booking-id="${booking.id}">
                        <i class="fas fa-times"></i>
                        Cancel
                    </button>
                </div>
            `;
            listElement.appendChild(bookingItem);
        });
    }

    function checkAndStartJob(bookingId) {
        fetch(`/digilink/public/driver/can-start-job/${bookingId}`)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                if (data.success && data.can_start) {
                    startJob(bookingId);
                } else {
                    showNotification(data.message || 'Cannot start this job yet.', 'error');
                }
            })
            .catch(error => {
                console.error('Error checking job:', error);
                showNotification('Error checking job status: ' + error.message, 'error');
            });
    }

    function startJob(bookingId) {
        if (!confirm('Are you ready to start this job? This will begin tracking your location.')) {
            return;
        }

        fetch(`/digilink/public/driver/start-job/${bookingId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            if (data.success) {
                acceptedBookings = acceptedBookings.filter(booking => booking.id !== bookingId);
                localStorage.setItem('acceptedBookings', JSON.stringify(acceptedBookings));
                
                window.location.href = `/digilink/public/driver/job-tracking/${bookingId}`;
            } else {
                throw new Error(data.message || 'Failed to start job');
            }
        })
        .catch(error => {
            console.error('Error starting job:', error);
            showNotification('Failed to start job: ' + error.message, 'error');
        });
    }

    function cancelAcceptedBooking(bookingId) {
        if (!confirm('Are you sure you want to cancel this accepted booking? It will be returned to the available listings.')) {
            return;
        }

        fetch(`/digilink/public/driver/cancel-accepted-booking/${bookingId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            if (data.success) {
                acceptedBookings = acceptedBookings.filter(booking => booking.id !== bookingId);
                localStorage.setItem('acceptedBookings', JSON.stringify(acceptedBookings));
                
                showNotification('Booking cancelled successfully.', 'success');
                loadAcceptedBookings();
                loadAvailableBookings();
            } else {
                throw new Error(data.message || 'Failed to cancel booking');
            }
        })
        .catch(error => {
            console.error('Error cancelling booking:', error);
            showNotification('Failed to cancel booking: ' + error.message, 'error');
        });
    }

    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            background: ${type === 'error' ? '#dc3545' : type === 'success' ? '#28a745' : '#17a2b8'};
            color: white;
            border-radius: 5px;
            z-index: 10000;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        `;
        notification.textContent = message;
        document.body.appendChild(notification);

        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 5000);
    }

    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded, initializing...');

        loadBookingStats();
        
        loadAcceptedBookings();
        
        if (document.getElementById('availabilityToggle').checked) {
            console.log('Driver is available, loading bookings...');
            loadAvailableBookings();
        }
    
        setInterval(() => {
            if (document.getElementById('availabilityToggle').checked) {
                loadAvailableBookings();
            }
            loadAcceptedBookings();
        }, 30000);
    });
    </script>
</body>
</html>