    <style>
        footer {
            background: #1a1a1a;
            color: white;
            padding: 30px 0 15px;
            width: 100%;
            text-align: center;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 20px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .footer-section {
            flex: 1;
            min-width: 200px;
            text-align: left;
        }

        .footer-section h3 {
            font-size: 20px;
            margin-bottom: 15px;
            color: #e63946;
        }

        .footer-section p,
        .footer-section li {
            margin-bottom: 8px;
            color: #ccc;
            font-size: 0.9rem;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section a {
            color: #ccc;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-section a:hover {
            color: #e63946;
        }

        .social-icons a {
            display: inline-block;
            margin-right: 10px;
            font-size: 18px;
        }

        .copyright {
            text-align: center;
            padding-top: 15px;
            border-top: 1px solid #444;
            color: #ccc;
            font-size: 12px;
            margin-top: 20px;
        }
    </style>
    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>About Us</h3>
                <p>FastLan is a leading provider of motorcycle ride and delivery services, operating in Surigao and nearby areas.</p>
            </div>
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="{{ route(name: 'home') }}">Home</a></li>
                    <li><a href="login">Login</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Contact Us</h3>
                <p><i class="fas fa-phone"></i> +63 (955) 123-4567</p>
                <p><i class="fas fa-envelope"></i> info@fastlan.com</p>
            </div>
            <div class="footer-section">
                <h3>Follow Us</h3>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; 2023 FastLan. All rights reserved.</p>
        </div>
    </footer>