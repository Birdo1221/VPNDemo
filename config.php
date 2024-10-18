<?php
// config/config.php


//          use this for errors
////        ini_set('display_errors', 1);
////        ini_set('display_startup_errors', 1);
////        error_reporting(E_ALL);

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'Api');
define('DB_PASS', 'Password');
define('DB_NAME', 'vpn_store');

// PayPal configuration
define('PAYPAL_CLIENT_ID', 'Get Paypal CLIENT via Paypal Dashbord');
define('PAYPAL_SECRET', 'Get Paypal SECRET via Paypal Dashbord');
define('PAYPAL_MODE', 'sandbox'); // Change to 'live' for production / get moneyyy

// Stripe configuration
define('STRIPE_API_KEY', 'Get the Stripe API-KEY from the Stripe development dashboard');
?>
