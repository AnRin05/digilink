<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FastLan - Motorcycle Ride & Delivery</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="{{ asset('images/fastlan1.png') }}">
</head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    body {
        background-color: #ffffff;
        display: flex;
        flex-direction: column;
        align-items: center;
        transition: background-color 0.3s, color 0.3s;
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

    .welcome {
        height: 50vh;
        min-height: 400px;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding: 20px;
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1558981806-ec527fa84c39?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80') no-repeat center center/cover;
        color: white;
    }

    .welcome-content {
        max-width: 700px;
        padding: 20px;
    }

    .welcome h1 {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .welcome p {
        font-size: 1.1rem;
        margin-bottom: 20px;
    }

    .welcome-buttons {
        display: flex;
        justify-content: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .btn-red {
        transition: all 0.3s ease;
        background-color: #e63946;
        color: #fff;
        border: none;
        padding: 12px 30px;
        border-radius: 25px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        position: relative;
        overflow: hidden;
    }

    .btn-red::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .btn-red:hover::before {
        left: 100%;
    }

    .btn-red:hover {
        background-color: #ac1313;
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }

    .btn-dark {
        transition: all 0.3s ease;
        background-color: #1b1b1b;
        color: #fff;
        border: none;
        padding: 12px 30px;
        border-radius: 25px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        position: relative;
        overflow: hidden;
    }

    .btn-dark::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .btn-dark:hover::before {
        left: 100%;
    }

    .btn-dark:hover {
        background-color: #000000;
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }

    .features {
        background: #fff;
        padding: 60px 20px;
        width: 100%;
        text-align: center;
    }

    .features h2 {
        font-size: 2.5rem;
        color: #e63946;
        margin-bottom: 40px;
    }

    .features-container {
        display: flex;
        justify-content: center;
        gap: 30px;
        flex-wrap: wrap;
        max-width: 1200px;
        margin: 0 auto;
    }

    .feature-item {
        opacity: 0;
        transform: translateY(50px);
        transition: all 0.6s ease-out;
        background: white;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        padding: 30px;
        width: 300px;
        min-height: 250px;
        text-align: center;
    }

    .feature-item.show {
        opacity: 1;
        transform: translateY(0);
    }

    .feature-item:hover {
        animation: bounce 0.5s ease;
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        30% { transform: translateY(-15px); }
        50% { transform: translateY(0); }
        70% { transform: translateY(-7px); }
    }

    .feature-item i {
        color: #e63946;
        transition: transform 0.3s;
        font-size: 40px;
        margin-bottom: 20px;
    }

    .feature-item i:hover {
        transform: scale(1.2);
    }

    .feature-item h5 {
        font-weight: bold;
        margin-bottom: 15px;
        font-size: 1.4rem;
    }

    .feature-item p {
        color: #666;
        line-height: 1.6;
    }

    .description {
        min-height: 50vh;
        width: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        background: linear-gradient(135deg, #e63946, #840d0d);
        color: white;
        padding: 60px 20px;
        position: relative;
        overflow: hidden;
    }

    .description.expanded {
        min-height: 80vh;
    }

    .floating-elements {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        pointer-events: none;
        z-index: 1;
        overflow: hidden;
    }

    .floating-icon {
        position: absolute;
        color: rgba(255, 255, 255, 0.15);
        animation: float 8s ease-in-out infinite;
        opacity: 0;
        animation-fill-mode: both;
    }

    .floating-icon:nth-child(1) {
        font-size: 2.8rem;
        top: 15%;
        left: 8%;
        animation-delay: 0s;
        animation-duration: 9s;
    }

    .floating-icon:nth-child(2) {
        font-size: 2rem;
        top: 25%;
        right: 10%;
        animation-delay: 1.5s;
        animation-duration: 8s;
    }

    .floating-icon:nth-child(3) {
        font-size: 3.2rem;
        bottom: 20%;
        left: 12%;
        animation-delay: 3s;
        animation-duration: 10s;
    }

    .floating-icon:nth-child(4) {
        font-size: 1.8rem;
        top: 40%;
        left: 5%;
        animation-delay: 4.5s;
        animation-duration: 7s;
    }

    .floating-icon:nth-child(5) {
        font-size: 2.5rem;
        bottom: 35%;
        right: 8%;
        animation-delay: 6s;
        animation-duration: 9s;
    }

    .floating-icon:nth-child(6) {
        font-size: 2.2rem;
        top: 60%;
        right: 15%;
        animation-delay: 7.5s;
        animation-duration: 8s;
    }

    .floating-icon:nth-child(7) {
        font-size: 3rem;
        bottom: 50%;
        left: 85%;
        animation-delay: 9s;
        animation-duration: 11s;
    }

    .floating-icon:nth-child(8) {
        font-size: 1.5rem;
        top: 70%;
        left: 80%;
        animation-delay: 10.5s;
        animation-duration: 7s;
    }

    @keyframes float {
        0% {
            transform: translate(0, 0) rotate(0deg) scale(1);
            opacity: 0;
        }
        10% {
            opacity: 0.15;
        }
        50% {
            transform: translate(30px, -40px) rotate(15deg) scale(1.1);
            opacity: 0.2;
        }
        100% {
            transform: translate(60px, -20px) rotate(30deg) scale(1);
            opacity: 0;
        }
    }

    .description-content {
        max-width: 800px;
        position: relative;
        z-index: 2;
    }

    .description h2 {
        font-size: 2.5rem;
        margin-bottom: 20px;
        background: linear-gradient(45deg, #ffffff, #f8f9fa);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: glow 2s ease-in-out infinite alternate;
    }

    @keyframes glow {
        from { text-shadow: 0 0 10px rgba(255, 255, 255, 0.3); }
        to { text-shadow: 0 0 20px rgba(255, 255, 255, 0.6); }
    }

    .description p {
        font-size: 1.1rem;
        margin-bottom: 30px;
        line-height: 1.6;
        opacity: 0.9;
    }

    .expanded-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.8s ease, padding 0.8s ease, opacity 0.5s ease;
        opacity: 0;
        padding: 0 20px;
        width: 100%;
        position: relative;
    }

    .expanded-content.show {
        max-height: 1800px;
        opacity: 1;
        padding: 30px 20px 50px;
    }

    .expanded-content h3 {
        font-size: 2rem;
        margin-bottom: 20px;
        color: #fff;
    }

    .expanded-content p {
        margin-bottom: 30px;
    }

    .feature-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
        margin: 30px 0;
        max-width: 1200px;
        margin-left: auto;
        margin-right: auto;
    }

    .expanded-feature {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        padding: 25px;
        text-align: left;
        transform: translateY(30px);
        opacity: 0;
        transition: all 0.6s ease;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .expanded-feature.animate {
        transform: translateY(0);
        opacity: 1;
    }

    .expanded-feature:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .expanded-feature i {
        font-size: 2rem;
        margin-bottom: 15px;
        color: #fff;
    }

    .expanded-feature h4 {
        font-size: 1.3rem;
        margin-bottom: 10px;
        color: #fff;
    }

    .expanded-feature p {
        font-size: 0.95rem;
        line-height: 1.6;
        color: rgba(255, 255, 255, 0.8);
    }

    .btn-container {
        display: flex;
        justify-content: center;
        margin-top: 30px;
        padding-bottom: 20px;
    }

    .action-btn {
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        padding: 12px 30px;
        border-radius: 25px;
        cursor: pointer;
        margin: 10px;
        transition: all 0.3s ease;
        font-weight: 500;
        display: inline-block;
        min-width: 150px;
    }

    .action-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    @media (max-width: 1024px) {
        .welcome h1 {
            font-size: 2.2rem;
        }
        
        .features h2,
        .description h2 {
            font-size: 2.2rem;
        }
        
        .feature-item {
            width: 280px;
        }
        
        .expanded-content.show {
            max-height: 2000px;
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
        
        .expanded-content.show {
            max-height: 2200px;
        }
    }

    @media (max-width: 768px) {
        nav {
            padding: 0 1rem;
            height: auto;
            min-height: 60px;
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
        
        .welcome {
            height: 60vh;
            min-height: 500px;
            padding: 40px 20px;
        }
        
        .welcome h1 {
            font-size: 2rem;
        }
        
        .welcome p {
            font-size: 1rem;
        }
        
        .welcome-buttons {
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }
        
        .btn-red,
        .btn-dark {
            width: 200px;
            text-align: center;
        }
        
        .features {
            padding: 40px 20px;
        }
        
        .features h2 {
            font-size: 2rem;
            margin-bottom: 30px;
        }
        
        .feature-item {
            width: 100%;
            max-width: 400px;
            padding: 25px;
        }
        
        .description {
            padding: 40px 20px;
            min-height: 60vh;
        }
        
        .description.expanded {
            min-height: 90vh;
        }
        
        .description h2 {
            font-size: 2rem;
        }
        
        .description p {
            font-size: 1rem;
        }
        
        .feature-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        .expanded-content h3 {
            font-size: 1.8rem;
        }
        
        .expanded-content.show {
            max-height: 2400px;
            padding: 25px 15px 40px;
        }
        
        .btn-container {
            margin-top: 20px;
            padding-bottom: 10px;
        }
    }

    @media (max-width: 580px) {
        nav {
            flex-direction: column;
            padding: 10px;
            height: auto;
        }
        
        nav .nav-left,
        nav .nav-right {
            width: 100%;
            justify-content: center;
            margin: 5px 0;
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
        
        .welcome {
            height: 70vh;
            padding: 30px 15px;
        }
        
        .welcome h1 {
            font-size: 1.8rem;
        }
        
        .welcome p {
            font-size: 0.9rem;
        }
        
        .features {
            padding: 30px 15px;
        }
        
        .features h2 {
            font-size: 1.8rem;
        }
        
        .feature-item h5 {
            font-size: 1.2rem;
        }
        
        .description {
            padding: 30px 15px;
            min-height: 70vh;
        }
        
        .description.expanded {
            min-height: 100vh;
        }
        
        .description h2 {
            font-size: 1.8rem;
        }
        
        .btn-container {
            flex-direction: column;
            align-items: center;
            margin-top: 15px;
        }
        
        .action-btn {
            width: 200px;
            margin: 8px 0;
            padding: 10px 25px;
        }
        
        .expanded-content.show {
            max-height: 2600px;
            padding: 20px 10px 35px;
        }
        
        .expanded-feature {
            padding: 20px;
        }
        
        .floating-icon {
            font-size: 1.8rem !important;
        }
        
        .floating-icon:nth-child(n+7) {
            display: none;
        }
    }

    @media (max-width: 400px) {
        .nav-right a {
            font-size: 0.85rem;
            padding: 5px 6px;
        }
        
        .welcome h1 {
            font-size: 1.6rem;
        }
        
        .features h2 {
            font-size: 1.6rem;
        }
        
        .description h2 {
            font-size: 1.6rem;
        }
        
        .feature-item {
            padding: 20px;
        }
        
        .description {
            min-height: 80vh;
        }
        
        .description.expanded {
            min-height: 110vh;
        }
        
        .expanded-content.show {
            max-height: 2800px;
            padding: 15px 8px 30px;
        }
        
        .btn-red,
        .btn-dark,
        .action-btn {
            padding: 10px 20px;
            font-size: 0.9rem;
        }
    }

    @media (max-height: 700px) and (max-width: 768px) {
        .description.expanded {
            min-height: 120vh;
        }
        
        .expanded-content.show {
            max-height: 3000px;
        }
    }

    @media (max-height: 600px) and (max-width: 768px) {
        .description.expanded {
            min-height: 140vh;
        }
        
        .expanded-content.show {
            max-height: 3200px;
        }
        
        .btn-container {
            position: sticky;
            bottom: 20px;
            z-index: 10;
        }
    }

    @media (max-width: 375px) {
        .description.expanded {
            min-height: 130vh;
        }
        
        .expanded-content.show {
            max-height: 3000px;
        }
        
        .action-btn {
            min-width: 180px;
            padding: 12px 20px;
        }
    }

    @media (orientation: landscape) and (max-height: 500px) {
        .description.expanded {
            min-height: 200vh;
        }
        
        .expanded-content.show {
            max-height: 4000px;
        }
        
        .btn-container {
            margin-top: 40px;
            padding-bottom: 30px;
        }
    }
</style>
<body>
    <nav>
        <div class="nav-left">
           <a class="nav-brand">Fast<span>Lan</span></a>
        </div>
        <div class="nav-right">
            <ul>
                <li><a href="#" class="active">Home</a></li>
                <li><a href="login">Login</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </div>
    </nav>

    <section class="welcome">
        <div class="welcome-content">
            <h1>Fastlan tayo sa Surigao!</h1>
            <p>Experience the fast and efficient motorcycle ride booking today!</p>
            <div class="welcome-buttons">
                <a href="{{ route('passign') }}" class="btn-red">Book a Ride</a>
                <a href="{{ route('driversign') }}" class="btn-dark">Be a Rider</a>
            </div>
        </div>
    </section>

    <section class="features">
        <h2>Why Choose FastLan?</h2>
        <div class="features-container">
            <div class="feature-item">
                <i class="fas fa-bolt"></i>
                <h5>Fast Service</h5>
                <p>Our motorcycle riders can navigate through traffic to get you or your items to the destination faster.</p>
            </div>
            <div class="feature-item">
                <i class="fas fa-shield-alt"></i>
                <h5>Safe & Secure</h5>
                <p>All our drivers are verified and trained. Your safety and privacy are our top priorities.</p>
            </div>
            <div class="feature-item">
                <i class="fas fa-dollar-sign"></i>
                <h5>Affordable Pricing</h5>
                <p>Enjoy competitive prices for both rides and delivery services without hidden fees.</p>
            </div>
        </div>
    </section>

    <section class="description" id="description-section">
        <div class="floating-elements">
            <i class="fas fa-motorcycle floating-icon"></i>
            <i class="fas fa-shipping-fast floating-icon"></i>
            <i class="fas fa-map-marked-alt floating-icon"></i>
            <i class="fas fa-bolt floating-icon"></i>
            <i class="fas fa-shield-alt floating-icon"></i>
            <i class="fas fa-clock floating-icon"></i>
            <i class="fas fa-leaf floating-icon"></i>
            <i class="fas fa-handshake floating-icon"></i>
            <!-- Add these two for larger screens only -->
            <i class="fas fa-tachometer-alt floating-icon"></i>
            <i class="fas fa-users floating-icon"></i>
        </div>
        
        <div class="description-content">
            <h2>How FastLan Works</h2>
            <p>Experience the revolution in urban mobility! Simply book a ride or delivery through our intuitive platform, track your rider in real-time with GPS precision, and enjoy lightning-fast service that beats traffic every time.</p>
            <button class="btn-dark" id="learn-more-btn">
                <i class="fas fa-rocket"></i> Learn More
            </button>
            
            <div class="expanded-content" id="expanded-content">
                <h3>Discover What Makes FastLan Special</h3>
                <p>FastLan isn't just another ride-hailing service – we're your trusted partner in navigating the bustling streets of Surigao with unmatched speed and reliability.</p>
                
                <div class="feature-grid">
                    <div class="expanded-feature">
                        <i class="fas fa-clock"></i>
                        <h4>24/7 Availability</h4>
                        <p>Rain or shine, day or night – FastLan drivers are always ready to serve you. Our round-the-clock service ensures you're never stranded.</p>
                    </div>
                    
                    <div class="expanded-feature">
                        <i class="fas fa-mobile-alt"></i>
                        <h4>User-Friendly App</h4>
                        <p>Book rides in seconds with our intuitive mobile app. Features include live tracking and fare estimation</p>
                    </div>
                    
                    <div class="expanded-feature">
                        <i class="fas fa-leaf"></i>
                        <h4>Eco-Friendly Choice</h4>
                        <p>Choose sustainability without compromising speed. Our motorcycle fleet reduces carbon emissions while providing efficient transportation.</p>
                    </div>
                    
                    <div class="expanded-feature">
                        <i class="fas fa-handshake"></i>
                        <h4>Community-Driven</h4>
                        <p>Supporting local drivers and businesses in Surigao. When you choose FastLan, you're contributing to your community's economic growth.</p>
                    </div>
                </div>
                
                <div class="btn-container">
                    <button class="action-btn" id="show-less-btn">
                        <i class="fas fa-chevron-up"></i> Show Less
                    </button>
                </div>
            </div>
        </div>
    </section>

    <footer>
        @include('footer') 
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const learnMoreBtn = document.getElementById('learn-more-btn');
            const showLessBtn = document.getElementById('show-less-btn');
            const expandedContent = document.getElementById('expanded-content');
            const descriptionSection = document.getElementById('description-section');
            
            learnMoreBtn.addEventListener('click', function(e) {
                e.preventDefault();
                expandedContent.classList.add('show');
                learnMoreBtn.style.display = 'none';
                
                setTimeout(() => {
                    const expandedFeatures = document.querySelectorAll('.expanded-feature');
                    expandedFeatures.forEach((feature, index) => {
                        setTimeout(() => {
                            feature.classList.add('animate');
                        }, index * 150);
                    });
                }, 400);
                
                setTimeout(() => {
                    expandedContent.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }, 300);
            });
            
            showLessBtn.addEventListener('click', function() {
                descriptionSection.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                
                setTimeout(() => {
                    expandedContent.classList.remove('show');
                    setTimeout(() => {
                        learnMoreBtn.style.display = 'inline-block';
                    }, 400);
                    
                    const expandedFeatures = document.querySelectorAll('.expanded-feature');
                    expandedFeatures.forEach(feature => {
                        feature.classList.remove('animate');
                    });
                }, 500);
            });
            
            const featureItems = document.querySelectorAll('.feature-item');
            
            function checkScroll() {
                featureItems.forEach(item => {
                    const rect = item.getBoundingClientRect();
                    if (rect.top < window.innerHeight - 100) {
                        item.classList.add('show');
                    }
                });
            }
            
            checkScroll();
            window.addEventListener('scroll', checkScroll);
        });
    </script>
</body>
</html>