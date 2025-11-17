<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FastLan - Motorcycle Ride & Delivery</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite('resources/css/app.css')
    @vite('resources/css/nav.css')
    @vite('resources/js/app.js')
    <link rel="icon" href="{{ asset('images/fastlan1.png') }}">
</head>
<body>
                                                            <!-- Navigation -->
    <nav>
        <div class="nav-left">
           <a class="nav-brand">Fast<span>Lan</span></a>
        </div>
        <div class="nav-middle">
        </div>
        <div class="nav-right">
            <ul>
                <li><a href="#"><a class="active">Home</a></a></li>
                <li><a href="login">Login</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </div>
    </nav>
                                                            <!-- Welcome Section -->
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

                                                            <!-- Features Section -->
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

                                                            <!-- Description Section -->
    <section class="description" id="description-section">
        <div class="floating-elements">
            <i class="fas fa-motorcycle floating-icon" style="font-size: 3rem;"></i>
            <i class="fas fa-shipping-fast floating-icon" style="font-size: 2.5rem;"></i>
            <i class="fas fa-map-marked-alt floating-icon" style="font-size: 2rem;"></i>
        </div>
        
        <div class="description-content">
            <h2>How FastLan Works</h2>
            <p>Experience the revolution in urban mobility! Simply book a ride or delivery through our intuitive platform, track your rider in real-time with GPS precision, and enjoy lightning-fast service that beats traffic every time. Our cutting-edge technology connects you with verified drivers for a seamless, reliable experience that transforms your daily commute.</p>
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

                                                            <!-- Footer -->
    <footer>
        @include('footer')
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const learnMoreBtn = document.getElementById('learn-more-btn');
            const closeBtn = document.getElementById('close-btn');
            const showLessBtn = document.getElementById('show-less-btn');
            const expandedContent = document.getElementById('expanded-content');
            const descriptionSection = document.getElementById('description-section');
            
            // Learn More button functionality
            learnMoreBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Add expanded class to section
                descriptionSection.classList.add('expanded');
                
                // Show expanded content
                expandedContent.classList.add('show');
                
                // Hide the learn more button
                learnMoreBtn.style.opacity = '0';
                learnMoreBtn.style.transform = 'translateY(-20px)';
                
                setTimeout(() => {
                    learnMoreBtn.style.display = 'none';
                }, 300);
                
                // Animate expanded features
                setTimeout(() => {
                    const expandedFeatures = document.querySelectorAll('.expanded-feature');
                    expandedFeatures.forEach((feature, index) => {
                        setTimeout(() => {
                            feature.classList.add('animate');
                        }, index * 150);
                    });
                }, 400);
                
                // Smooth scroll to show expanded content
                setTimeout(() => {
                    const expandedContent = document.getElementById('expanded-content');
                    expandedContent.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }, 800);
            });
            
            // Show Less button functionality
            showLessBtn.addEventListener('click', function() {
                // Smooth scroll to top of description section first
                descriptionSection.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                
                // Then collapse after scroll completes
                setTimeout(() => {
                    expandedContent.classList.remove('show');
                    descriptionSection.classList.remove('expanded');
                    
                    setTimeout(() => {
                        learnMoreBtn.style.display = 'inline-block';
                        setTimeout(() => {
                            learnMoreBtn.style.opacity = '1';
                            learnMoreBtn.style.transform = 'translateY(0)';
                        }, 50);
                    }, 400);
                    
                    const expandedFeatures = document.querySelectorAll('.expanded-feature');
                    expandedFeatures.forEach(feature => {
                        feature.classList.remove('animate');
                    });
                }, 500);
            });
            
            // Close button functionality (immediate close)
            closeBtn.addEventListener('click', function() {
                expandedContent.classList.remove('show');
                descriptionSection.classList.remove('expanded');
                
                setTimeout(() => {
                    learnMoreBtn.style.display = 'inline-block';
                    setTimeout(() => {
                        learnMoreBtn.style.opacity = '1';
                        learnMoreBtn.style.transform = 'translateY(0)';
                    }, 50);
                }, 400);
                
                const expandedFeatures = document.querySelectorAll('.expanded-feature');
                expandedFeatures.forEach(feature => {
                    feature.classList.remove('animate');
                });
            });
            
            // Enhanced button hover effects with ripple
            function createRipple(event, button) {
                const ripple = document.createElement('span');
                const rect = button.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = event.clientX - rect.left - size / 2;
                const y = event.clientY - rect.top - size / 2;
                
                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.classList.add('ripple');
                
                const rippleContainer = button.querySelector('.ripple-container') || button;
                rippleContainer.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            }
            
            // Add ripple effect to buttons
            const buttons = document.querySelectorAll('.btn-dark, .action-btn');
            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    createRipple(e, this);
                });
                
                button.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-3px) scale(1.05)';
                });
                
                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });
            
            // Floating icons animation enhancement
            const floatingIcons = document.querySelectorAll('.floating-icon');
            floatingIcons.forEach((icon, index) => {
                icon.style.animationDelay = `${index * 2}s`;
                
                // Add random movement on hover
                icon.addEventListener('mouseenter', function() {
                    this.style.animation = 'none';
                    this.style.transform = `translateY(-30px) rotate(15deg) scale(1.2)`;
                    this.style.color = 'rgba(255, 255, 255, 0.3)';
                });
                
                icon.addEventListener('mouseleave', function() {
                    this.style.animation = '';
                    this.style.color = 'rgba(255, 255, 255, 0.1)';
                });
            });
            
            // Scroll-triggered animations for description section
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-in');
                    }
                });
            }, {
                threshold: 0.3
            });
            
            observer.observe(descriptionSection);
        });
        // Animation for feature items
        document.addEventListener('DOMContentLoaded', function() {
            const featureItems = document.querySelectorAll('.feature-item');
            
            // Function to check if element is in viewport
            function isInViewport(element) {
                const rect = element.getBoundingClientRect();
                return (
                    rect.top >= 0 &&
                    rect.left >= 0 &&
                    rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                    rect.right <= (window.innerWidth || document.documentElement.clientWidth)
                );
            }
            
            // Function to handle scroll event
            function checkScroll() {
                featureItems.forEach(item => {
                    if (isInViewport(item)) {
                        item.classList.add('show');
                    }
                });
            }
            
            // Initial check
            checkScroll();
            
            // Listen for scroll events
            window.addEventListener('scroll', checkScroll);
            
            // Button hover effects
            const buttons = document.querySelectorAll('.btn-red, .btn-dark');
            
            buttons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                });
                
                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
</body>
</html>