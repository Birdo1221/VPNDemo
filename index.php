<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SecureVPN - Advanced Online Protection</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --accent-color: #e74c3c;
            --text-color: #333;
            --light-bg: #ecf0f1;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            overflow-x: hidden;
        }
        
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        header {
            background-color: var(--secondary-color);
            color: white;
            padding: 1rem 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-size: 1.5rem;
            font-weight: bold;
        }
        
        .nav-links {
            display: flex;
            gap: 20px;
        }
        
        .nav-links a {
            color: white;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .nav-links a:hover {
            color: var(--primary-color);
        }
        
        .hero {
            background: linear-gradient(180deg, var(--primary-color), var(--secondary-color));
            color: white;
            text-align: center;
            padding: 150px 0 100px;
            margin-top: 60px;
        }
        
        .hero h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }
        
        .hero p {
            font-size: 1.2rem;
            max-width: 600px;
            margin: 0 auto 30px;
        }
        
        .cta-button {
            display: inline-block;
            background-color: var(--accent-color);
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        
        .cta-button:hover {
            background-color: #c0392b;
        }
        
       /* Features Section */
       .features {
            padding: 60px 0;
            background: linear-gradient(0deg, var(--primary-color), var(--secondary-color));
        }

        .features h2 {
            color: white;
            text-align: center;
            margin-bottom: 50px;
            font-size: 2rem;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }

        .feature-item {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-align: center;
        }

        .feature-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }

        .feature-icon {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        .pricing {
            padding: 60px 0;
            background: linear-gradient(180deg, var(--primary-color), var(--secondary-color));
        }

        .pricing h2 {
            color: white;
            text-align: center;
            margin-bottom: 50px;
            font-size: 2rem;
        }

        .pricing-table {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            justify-content: center;
        }

        .pricing-item {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: background-color 0.3s ease, box-shadow 0.3s ease, transform 0.3s ease;
        }

        .pricing-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
            background-color: var(--secondary-color);
            color: snow;
            cursor: pointer;
        }

        .pricing-item h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            transition: color 0.3s ease;
        }

        .pricing-item p {
            font-size: 1.2rem;
            margin-bottom: 20px;
            transition: color 0.3s ease;
        }

        .pricing-item .price {
            font-size: 2rem;
            font-weight: bold;
            color: var(--primary-color);
            transition: color 0.3s ease;
        }

        .pricing-item:hover h3,
        .pricing-item:hover p,
        .pricing-item:hover .price {
            color: snow;
        }

        footer {
            background-color: var(--secondary-color);
            color: white;
            text-align: center;
            padding: 20px 0;
        }
        
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }
            
            .hero p {
                font-size: 1rem;
            }
            
            .nav-links {
                display: none;
            }
        }  
        ::-webkit-scrollbar {
            width: 0px;
        }

        ::-webkit-scrollbar-thumb {
            background: #333; 
            border-radius: 30px; 
        }

        ::-webkit-scrollbar-track {
            background: #222; 
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555; 
        } */

    </style>
</head>
<body>
    <header>
        <nav class="container">
            <div class="logo">SecureVPN</div>
            <div class="nav-links">
                <a href="#home">Home</a>
                <a href="#features">Features</a>
                <a href="#pricing">Pricing</a>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            </div>
        </nav>
    </header>

    <section class="hero" id="home">
        <div class="container">
            <h1>Secure Your Digital Life</h1>
            <p>Experience uncompromised privacy and lightning-fast speeds with SecureVPN's cutting-edge technology.</p>
            <a href="register.php" class="cta-button">Start Your Free Trial</a>
        </div>
    </section>

    <section class="features" id="features">
        <div class="container">
            <h2>Why Choose SecureVPN?</h2>
            <div class="feature-grid">
                <div class="feature-item">
                    <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                    <h3>Military-Grade Encryption</h3>
                    <p>Protect your data with the most advanced encryption protocols available.</p>
                </div>
                <div class="feature-item">
                    <div class="feature-icon"><i class="fas fa-tachometer-alt"></i></div>
                    <h3>Lightning-Fast Speeds</h3>
                    <p>Enjoy blazing-fast connections with our optimized global server network.</p>
                </div>
                <div class="feature-item">
                    <div class="feature-icon"><i class="fas fa-globe"></i></div>
                    <h3>Worldwide Access</h3>
                    <p>Bypass geo-restrictions and access content from anywhere in the world.</p>
                </div>
                <div class="feature-item">
                    <div class="feature-icon"><i class="fas fa-user-secret"></i></div>
                    <h3>No-Logs Policy</h3>
                    <p>Your online activities are never tracked, logged, or shared with third parties.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="pricing" id="pricing">
        <div class="container">
            <h2>Our Pricing Plans</h2>
            <div class="pricing-table">
                <div class="pricing-item">
                    <h3>Monthly Plan</h3>
                    <p class="price">£2.00</p>
                    <p>Perfect for short-term use with our full range of features.</p>
                    <a href="register.php" class="cta-button">Subscribe Now</a>
                </div>
                <div class="pricing-item">
                    <h3>Quarterly Plan</h3>
                    <p class="price">£5.00</p>
                    <p>Enjoy a 10% discount on our monthly rate with this plan.</p>
                    <a href="register.php" class="cta-button">Subscribe Now</a>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>&copy; 2024 SecureVPN. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
