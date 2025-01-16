# PHP VPNDemo

A PHP-based demo application for managing VPN subscriptions with integrated payment processing using PayPal and Stripe.
This project demonstrates a VPN subscription management system.

## Demo Preview
### **[Live Demo](https://www.vpn.birdo.ovh)**  
- **Note**: `vpn.birdo.ovh` serves a different page than `www.vpn.birdo.ovh`.

![VPNDemo Screenshot](https://github.com/user-attachments/assets/d848eb32-1c1a-40d4-9145-76c59a3cb0e6)


## Think that need implementing / doing IG
- **OpenVPN and WireGuard Integration**: Automate VPN server management for seamless connectivity.
- **User-Specific Configurations**: Link user accounts to VPN clients for tailored connections.
- **Enhanced Security**: Expand encryption options to provide users with secure and private browsing experiences.
- **VPN Client**: Either a simple APK for android for a vpn or a windows / linux client for it.
  
## Features
- User authentication (login/logout)
- Subscription plan management
- Payment integration with PayPal and Stripe
- CSRF protection for secure transactions
- Responsive and user-friendly design

## Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/Birdo1221/VPNDemo.git
   cd VPNDemo
   ```
2. **Set up the environment:**
   - Ensure you have a PHP server (e.g., XAMPP, WAMP, or similar).
   - Install [Composer](https://getcomposer.org/) if not already installed.

3. **Install dependencies:**
   ```bash
   composer install
   ```

4. **Database setup:**
   - Create a MySQL database and import the following schema:
     ```sql
     CREATE DATABASE IF NOT EXISTS vpndemo;
     USE vpndemo;

     CREATE TABLE IF NOT EXISTS userbase (
         id INT AUTO_INCREMENT PRIMARY KEY,
         email VARCHAR(255) NOT NULL UNIQUE,
         password VARCHAR(255) NOT NULL,
         created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
         updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
     );
     CREATE TABLE IF NOT EXISTS subscriptions (
         id INT AUTO_INCREMENT PRIMARY KEY,
         user_id INT NOT NULL,
         plan VARCHAR(50) NOT NULL, -- Plan type (e.g., 'basic', 'premium')
         start_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
         end_date TIMESTAMP,
         status ENUM('active', 'inactive') DEFAULT 'active',
         FOREIGN KEY (user_id) REFERENCES userbase(id) ON DELETE CASCADE
     );
     CREATE TABLE IF NOT EXISTS csrf_tokens (
         id INT AUTO_INCREMENT PRIMARY KEY,
         user_id INT NOT NULL,
         token VARCHAR(64) NOT NULL,
         created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
         FOREIGN KEY (user_id) REFERENCES userbase(id) ON DELETE CASCADE
     );
     ```

5. **Update the `db.php` file with your database connection details.**

6. **Configure PayPal and Stripe:**
   - Update the PayPal and Stripe credentials in the `config.php` file:
     - **PayPal**: Get your CLIENT ID and SECRET from the [PayPal Developer Dashboard](https://developer.paypal.com/developer/applications).
     - **Stripe**: Get your API KEY from the [Stripe Dashboard](https://dashboard.stripe.com/).

7. **Start the PHP server:**
   ```bash
   php -S localhost:8000
   ```

8. **Access the application:**
   - Open your web browser and go to `http://localhost:8000`.

## Configuration

- **PayPal Configuration:**
  - `PAYPAL_CLIENT_ID`: Your PayPal Client ID from the PayPal Dashboard.
  - `PAYPAL_SECRET`: Your PayPal Secret from the PayPal Dashboard.
  - `PAYPAL_MODE`: Set to 'sandbox' for testing, change to 'live' for production.

- **Stripe Configuration:**
  - `STRIPE_API_KEY`: Your Stripe API Key from the Stripe Dashboard.

## Usage

1. **Login:**
   - Navigate to the login page and enter your credentials to log in.

2. **Select Subscription Plan:**
   - After logging in, choose your desired subscription plan from the dashboard.
   
3. **Payment Processing:**
   - Select your preferred payment method (PayPal or Stripe) and complete the payment process.

4. **Success/Failure Handling:**
   - After payment, you'll be redirected to the dashboard with a success or failure message.

## License
This project is licensed under the MIT License. See the LICENSE file for details.
