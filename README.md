# PHP VPNDemo

A PHP-based demo application for managing VPN subscriptions with payment integration using PayPal and Stripe.

This project serves as a demonstration of the core functionalities of a VPN subscription management system. There are plans to develop a fully featured version in the future with additional features.

## Demo Preview
### **[Click here for a live demo](https://www.vpn.birdo.ovh)**  
#### **[vpn.birdo.ovh] serves a different page then [www.vpn.birdo.ovh]**
![VPNDemo](https://github.com/user-attachments/assets/ea3a1973-7b98-4e29-91d1-6755ee696ea6)

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
   git clone https://github.com/Birdo1221/VPNDemo.git
   cd VPNDemo
Set up the environment:

Ensure you have a PHP server running (e.g., XAMPP, WAMP, or a web server with PHP support).
Install Composer if not already installed: Get Composer.
Install dependencies:

```bash
composer install composer.json
```

Database setup:

Create a MySQL database and import the necessary schema.
```mysql
-- Database: vpndemo

CREATE DATABASE IF NOT EXISTS vpndemo;
USE vpndemo;

-- Table for storing user information
CREATE TABLE IF NOT EXISTS userbase (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table for storing subscription information
CREATE TABLE IF NOT EXISTS subscriptions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    plan VARCHAR(50) NOT NULL, -- Plan type (e.g., 'basic', 'premium')
    start_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    end_date TIMESTAMP,
    status ENUM('active', 'inactive') DEFAULT 'active',
    FOREIGN KEY (user_id) REFERENCES userbase(id) ON DELETE CASCADE
);

-- Table for storing CSRF tokens
CREATE TABLE IF NOT EXISTS csrf_tokens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    token VARCHAR(64) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES userbase(id) ON DELETE CASCADE
);
```
Update the db.php file with your database connection details.
Configure PayPal and Stripe:

Update the PayPal and Stripe credentials in the config.php file:
PayPal: Get your CLIENT ID and SECRET from the PayPal Developer Dashboard.
Stripe: Get your API KEY from the Stripe Dashboard.
```
Start the PHP server:

```bash
php -S localhost:8000
Access the application: Open your web browser and go to http://localhost:8000.
```
Configuration
```
PayPal Configuration
PAYPAL_CLIENT_ID: Your PayPal Client ID from the PayPal Dashboard.
PAYPAL_SECRET: Your PayPal Secret from the PayPal Dashboard.
PAYPAL_MODE: Set to 'sandbox' for testing, change to 'live' for production.
Stripe Configuration
STRIPE_API_KEY: Your Stripe API Key from the Stripe Dashboard.
```
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
