<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FastLan - Sign Up</title>
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
    background-color: #f8f9fa;
    color: #333;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    overflow-x: hidden;
}

nav {
    flex-shrink: 0;
    height: 60px;
    width: 100%;
    padding: 0 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: rgb(19, 19, 16);
    box-shadow: 0px 1px 3px #1b1b1b;
    position: sticky;
    top: 0;
    z-index: 100;
}

nav .nav-left {
    display: flex;
    align-items: center;
}

.nav-brand {
    color: white;
    font-size: 1.5rem;
    font-weight: bold;
    text-decoration: none;
}

.nav-brand span {
    color: #e63946;
}

nav .nav-right {
    display: flex;
    align-items: center;
}

.nav-right ul {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
}

.nav-right li {
    margin-left: 15px;
}

.nav-right a {
    color: white;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    padding: 6px 10px;
    border-radius: 4px;
}

.nav-right a.active {
    color: #e63946;
}

.nav-right a:hover {
    color: #e63946;
    background-color: rgba(255, 255, 255, 0.1);
}

.container {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 2rem;
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
}

.card {
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    padding: 2.5rem;
    max-width: 600px;
    width: 100%;
    text-align: center;
}

.card h1 {
    color: #1b1b1b;
    font-size: 2rem;
    margin-bottom: 1rem;
    font-weight: 700;
}

.card h1 span {
    color: #e63946;
}

.card p {
    color: #666;
    margin-bottom: 2rem;
    line-height: 1.6;
}

.options-container {
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem;
    justify-content: center;
    margin-bottom: 2rem;
}

.option-card {
    background-color: #fff;
    border: 2px solid #e63946;
    border-radius: 10px;
    padding: 1.5rem;
    width: 200px;
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
    text-decoration: none;
    display: block;
    color: inherit;
}

.option-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(230, 57, 70, 0.2);
    background-color: #e63946;
}

.option-card:hover .icon-container {
    background-color: white;
}

.option-card:hover .icon {
    color: #e63946;
}

.option-card:hover h3 {
    color: white;
}

.icon-container {
    width: 70px;
    height: 70px;
    background-color: #e63946;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    transition: all 0.3s ease;
}

.icon {
    color: white;
    font-size: 2rem;
    transition: all 0.3s ease;
}

.option-card h3 {
    color: #1b1b1b;
    margin-bottom: 0.5rem;
    transition: all 0.3s ease;
    font-size: 1.3rem;
}

.option-card p {
    color: #666;
    margin-bottom: 0;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.option-card:hover p {
    color: white;
}

.login-link {
    color: #666;
    margin-top: 1.5rem;
    font-size: 0.95rem;
}

.login-link a {
    color: #e63946;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.login-link a:hover {
    text-decoration: underline;
    color: #c1121f;
}

footer {
    background-color: rgb(19, 19, 16);
    color: white;
    padding: 2rem 1rem;
    text-align: center;
    margin-top: auto;
}

@media (max-width: 1024px) {
    .card {
        padding: 2rem;
        max-width: 500px;
    }
    
    .option-card {
        width: 180px;
    }
}

@media (max-width: 900px) {
    nav {
        padding: 0.5rem 1rem;
    }
    
    .nav-brand {
        font-size: 1.3rem;
    }
    
    .nav-right li {
        margin-left: 10px;
    }
    
    .nav-right a {
        font-size: 0.95rem;
        padding: 5px 8px;
    }
    
    .container {
        padding: 1.5rem;
    }
    
    .card {
        padding: 1.8rem;
    }
    
    .card h1 {
        font-size: 1.7rem;
    }
    
    .options-container {
        gap: 1rem;
    }
    
    .option-card {
        width: 160px;
        padding: 1.2rem;
    }
}

@media (max-width: 768px) {
    .container {
        padding: 1.5rem;
        align-items: flex-start;
        min-height: calc(100vh - 140px);
    }
    
    .card {
        padding: 1.8rem;
        margin: 1rem 0;
    }
    
    .card h1 {
        font-size: 1.7rem;
    }
    
    .options-container {
        flex-direction: row;
        gap: 1rem;
    }
    
    .option-card {
        width: 45%;
        max-width: 200px;
        min-width: 160px;
    }
    
    .icon-container {
        width: 60px;
        height: 60px;
    }
    
    .icon {
        font-size: 1.7rem;
    }
}

@media (max-width: 580px) {
    nav {
        flex-direction: column;
        height: auto;
        padding: 0.7rem 0;
    }
    
    nav .nav-left,
    nav .nav-right {
        justify-content: center;
        margin: 5px 0;
        width: 100%;
    }
    
    .nav-right ul {
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .nav-right li {
        margin: 5px 8px;
    }
    
    .nav-brand {
        font-size: 1.2rem;
    }
    
    .nav-right a {
        font-size: 0.9rem;
        padding: 6px 8px;
    }
    
    .container {
        padding: 1rem;
        min-height: calc(100vh - 150px);
    }
    
    .card {
        padding: 1.5rem;
    }
    
    .card h1 {
        font-size: 1.5rem;
    }
    
    .card p {
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
    }
    
    .options-container {
        flex-direction: column;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .option-card {
        width: 100%;
        max-width: 300px;
        margin: 0 auto;
    }
    
    .icon-container {
        width: 60px;
        height: 60px;
    }
    
    .icon {
        font-size: 1.7rem;
    }
    
    .option-card h3 {
        font-size: 1.2rem;
    }
    
    .option-card p {
        font-size: 0.85rem;
    }
    
    .login-link {
        font-size: 0.9rem;
        margin-top: 1rem;
    }
}

@media (max-width: 400px) {
    .nav-right a {
        font-size: 0.85rem;
        padding: 5px 6px;
    }
    
    .container {
        padding: 0.8rem;
    }
    
    .card {
        padding: 1.2rem;
    }
    
    .card h1 {
        font-size: 1.4rem;
    }
    
    .card p {
        font-size: 0.85rem;
        margin-bottom: 1.2rem;
    }
    
    .option-card {
        padding: 1rem;
    }
    
    .icon-container {
        width: 55px;
        height: 55px;
        margin-bottom: 0.8rem;
    }
    
    .icon {
        font-size: 1.5rem;
    }
    
    .option-card h3 {
        font-size: 1.1rem;
        margin-bottom: 0.3rem;
    }
    
    .option-card p {
        font-size: 0.8rem;
    }
    
    .login-link {
        font-size: 0.85rem;
    }
}

@media (max-width: 320px) {
    .container {
        padding: 0.5rem;
    }
    
    .card {
        padding: 1rem;
    }
    
    .card h1 {
        font-size: 1.3rem;
    }
    
    .option-card {
        padding: 0.8rem;
    }
    
    .icon-container {
        width: 50px;
        height: 50px;
    }
    
    .icon {
        font-size: 1.3rem;
    }
}

@media (min-width: 1200px) {
    .container {
        max-width: 1400px;
    }
    
    .card {
        max-width: 700px;
        padding: 3rem;
    }
    
    .card h1 {
        font-size: 2.5rem;
    }
    
    .options-container {
        gap: 2rem;
    }
    
    .option-card {
        width: 220px;
        padding: 2rem;
    }
    
    .icon-container {
        width: 80px;
        height: 80px;
    }
    
    .icon {
        font-size: 2.2rem;
    }
}

@media (orientation: landscape) and (max-height: 600px) {
    .container {
        padding: 1rem;
        min-height: auto;
    }
    
    .card {
        padding: 1.5rem;
        margin: 0.5rem 0;
    }
    
    .options-container {
        flex-direction: row;
        gap: 1rem;
    }
    
    .option-card {
        width: 45%;
        padding: 1rem;
    }
}
    </style>
</head>
<body>
    <nav>
        <div class="nav-left">
            <a class="nav-brand">Fast<span>Lan</span></a>
        </div>
        <div class="nav-right">
            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <h1>Join <span>FastLan</span></h1>
            <p>Select the type of account that best describes you.</p>
            
            <div class="options-container">
                <a href="{{ route('passign') }}" class="option-card" id="passenger-btn">
                    <div class="icon-container">
                        <i class="fas fa-user icon"></i>
                    </div>
                    <h3>Passenger</h3>
                    <p>Book rides & deliveries</p>
                </a>

                <a href="{{ route('driversign') }}" class="option-card" id="driver-btn">
                    <div class="icon-container">
                        <i class="fas fa-motorcycle icon"></i>
                    </div>
                    <h3>Driver</h3>
                    <p>Provide ride & delivery services</p>
                </a>
            </div>

            <div class="login-link">
                Already have an account? <a href="{{ route('login') }}">Log in here</a>
            </div>
        </div>
    </div>

    <footer>
        @include('footer') 
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passengerBtn = document.getElementById('passenger-btn');
            const driverBtn = document.getElementById('driver-btn');

            passengerBtn.addEventListener('click', function(e) {
                e.preventDefault();
                window.location.href = '{{ route("passign") }}';
            });

            driverBtn.addEventListener('click', function(e) {
                e.preventDefault();
                window.location.href = '{{ route("driversign") }}';
            });
        });
    </script>
</body>
</html>