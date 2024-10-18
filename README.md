# PHP VPNDemo

A PHP-based demo application for managing VPN subscriptions with payment integration using PayPal and Stripe.

## Table of Contents

- [Features](#features)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [License](#license)

## Features

- User authentication (login/logout)
- Subscription plans for VPN services
- Payment processing through PayPal and Stripe
- CSRF protection for secure form submissions
- Responsive design for a better user experience

## Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/yourusername/VPNDemo.git
   cd VPNDemo
Set up the environment:

Ensure you have a PHP server running (e.g., XAMPP, WAMP, or a web server with PHP support).
Install Composer if not already installed: Get Composer.
Install dependencies:

bash
Copy code
composer install
Database setup:

Create a MySQL database and import the necessary schema.
Update the db.php file with your database connection details.
Configure PayPal and Stripe:

Update the PayPal and Stripe credentials in the config.php file:
PayPal: Get your CLIENT ID and SECRET from the PayPal Developer Dashboard.
Stripe: Get your API KEY from the Stripe Dashboard.
Start the PHP server:

bash
Copy code
php -S localhost:8000
Access the application: Open your web browser and go to http://localhost:8000.

Configuration
PayPal Configuration
PAYPAL_CLIENT_ID: Your PayPal Client ID from the PayPal Dashboard.
PAYPAL_SECRET: Your PayPal Secret from the PayPal Dashboard.
PAYPAL_MODE: Set to 'sandbox' for testing, change to 'live' for production.
Stripe Configuration
STRIPE_API_KEY: Your Stripe API Key from the Stripe Dashboard.
Usage
Login:

Navigate to the login page and enter your credentials to log in.
Select Subscription Plan:

After logging in, choose your desired subscription plan from the dashboard.
Payment Processing:

Select your preferred payment method (PayPal or Stripe) and complete the payment process.
Success/Failure Handling:

After payment, you'll be redirected to the dashboard with a success or failure message.
License
This project is licensed under the MIT License. See the LICENSE file for details.
