<?php
session_start();
require_once 'db.php';
require_once 'functions.php';
require_once '../vendor/autoload.php';
require_once 'config.php';
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payer;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

// PayPal configuration
define('PAYPAL_CLIENT_ID', 'Get Paypal CLIENT via Paypal Dashbord');
define('PAYPAL_SECRET', 'Get Paypal SECRET via Paypal Dashbord');
define('PAYPAL_MODE', 'sandbox'); // Change to 'live' for production / get moneyyy

// Stripe configuration
define('STRIPE_API_KEY', 'Get the Stripe API-KEY from the Stripe development dashboard');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// CSRF protection
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Set up PayPal
$paypalApiContext = new ApiContext(
    new OAuthTokenCredential(
        $_ENV['PAYPAL_CLIENT_ID'],
        $_ENV['PAYPAL_SECRET']
    )
);
$paypalApiContext->setConfig([
    'mode' => 'sandbox',
    'log.LogEnabled' => true,
    'log.FileName' => '../PayPal.log',
    'log.LogLevel' => 'INFO',
    'cache.enabled' => true
]);

// Set up Stripe
Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('CSRF token validation failed');
    }

    $plan = sanitizeInput($_POST['subscription_plan']);
    
    $amounts = [
        '1_month' => 200, // £1.00 in pence
        '3_month' => 500  // £5.00 in pence
    ];
    
    $description = [
        '1_month' => '1-Month Subscription',
        '3_month' => '3-Month Subscription'
    ];
    
    if (isset($_POST['paypal_payment'])) {
        // Handle PayPal payment
        try {
            $payer = new Payer();
            $payer->setPaymentMethod('paypal');

            $item = new Item();
            $item->setName($description[$plan])
                ->setCurrency('GBP')
                ->setQuantity(1)
                ->setPrice($amounts[$plan] / 100);

            $itemList = new ItemList();
            $itemList->setItems([$item]);

            $amount = new Amount();
            $amount->setCurrency('GBP')
                ->setTotal($amounts[$plan] / 100);

            $transaction = new \PayPal\Api\Transaction();
            $transaction->setAmount($amount)
                ->setItemList($itemList)
                ->setDescription($description[$plan]);

            $redirectUrls = new RedirectUrls();  //Change this 
            $redirectUrls->setReturnUrl("https://yourwebsite.com/dashboard.php?success=true")   //Change this 
                ->setCancelUrl("https://yourwebsite.com/dashboard.php?cancel=true");

            $payment = new Payment();
            $payment->setIntent('sale')
                ->setPayer($payer)
                ->setRedirectUrls($redirectUrls)
                ->setTransactions([$transaction]);

            $payment->create($paypalApiContext);
            header('Location: ' . $payment->getApprovalLink());
            exit;
        } catch (Exception $ex) {
            $error = 'Error processing PayPal payment: ' . $ex->getMessage();
        }
    } elseif (isset($_POST['stripe_payment'])) {
        // Handle Stripe payment
        try {
            $session = StripeSession::create([
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'gbp',
                            'product_data' => [
                                'name' => $description[$plan],
                            ],
                            'unit_amount' => $amounts[$plan],
                        ],
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'payment', //Change this 
                'success_url' => 'https://yourwebsite.com/dashboard.php? success=true', //Change this 
                'cancel_url' => 'https://yourwebsite.com/dashboard.php?cancel=true',
            ]);

            header('Location: ' . $session->url);
            exit;
        } catch (Exception $e) {
            $error = 'Error processing Stripe payment: ' . $e->getMessage();
        }
    }
}

// Handle success and cancel messages
if (isset($_GET['success']) && $_GET['success'] == 'true') {
    $success = "Payment successful! Your subscription has been activated.";
} elseif (isset($_GET['cancel']) && $_GET['cancel'] == 'true') {
    $error = "Payment cancelled. Please try again or contact support if you need assistance.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SecureVPN</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
      :root {
        --primary-color: #3498db;
        --secondary-color: #2c3e50;
        --accent-color: #e74c3c;
        --background-color: #ecf0f1;
        --text-color: #333;
        --white: #ffffff;
        --light-gray: #f4f4f4;
        --border-color: #ddd;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        main.container {
            background: linear-gradient(180deg, var(--primary-color), var(--secondary-color));
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            line-height: 1.6;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 0 20px;
        }

        header {
            background-color: var(--secondary-color);
            color: var(--white);
            padding: 1rem 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav a {
            color: var(--white);
            text-decoration: none;
            padding: 0.5rem 1rem;
            transition: background-color 0.3s ease;
            border-radius: 4px;
        }

        nav a:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        main {
            flex-grow: 1;
            padding: 2rem 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            
        }

        h1, h2, h3 {
            margin-bottom: 1rem;
        }

        .form-section {
            color:snow;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: inset 0px 0px 12px 0px rgb(32 49 46);
            margin-bottom: 2rem;
            width: 100%;
            max-width: 600px;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        select, button {
            width: 100%;
            padding: 12px;
            margin-bottom: 1rem;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-size: 16px;
        }

        select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%23333' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 12px;
        }

        button {
            background-color: var(--primary-color);
            color: var(--white);
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        button:hover {
            background-color: #2980b9;
        }

        .error, .success {
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
            font-weight: 600;
            width: 100%;
            max-width: 600px;
        }

        .error {
            background-color: #ffebee;
            color: var(--accent-color);
            border: 1px solid var(--accent-color);
        }

        .success {
            background-color: #e8f5e9;
            color: #4caf50;
            border: 1px solid #4caf50;
        }

        .form-header {
            margin-bottom: 1rem;
            font-weight: 700;
            font-size: 1.5rem;
            color:snow;

            text-align: center;
        }

        .form-description {
            margin-bottom: 1.5rem;
            color:snow;
            font-size: 1rem;
            text-align: center;
        }

        footer {
            background-color: var(--secondary-color);
            color: var(--white);
            text-align: center;
            padding: 20px 0;
            margin-top: auto;
            width: 100%;
        }

        @media (max-width: 768px) {
            .form-section {
                padding: 1.5rem;
            }
            
            nav {
                flex-direction: column;
                align-items: flex-start;
            }
            
            nav div {
                margin-top: 1rem;
            }
        }

    </style>
</head>
<body>
    <header>
        <div class="container">
            <nav>
                <h1>SecureVPN Dashboard</h1>
                <div>
                    <a href="profile.php"><i class="fas fa-user"></i> Profile</a>
                    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </nav>
        </div>
    </header>
    <main class="container">
        <?php if (!empty($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if (!empty($success)): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>

        <section class="form-section">
            <div class="form-header">Select Your Subscription Plan</div>
            <form method="POST" action="">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <label for="subscription_plan">Choose Plan:</label>
                <select id="subscription_plan" name="subscription_plan">
                    <option value="1_month">1 Month - £2</option>
                    <option value="3_month">3 Months - £5</option>
                </select>

                <div class="form-description">You can pay using PayPal or Stripe. Select your preferred payment method below.</div>

                <button type="submit" name="paypal_payment">Pay with PayPal</button>
                <button type="submit" name="stripe_payment">Pay with Stripe</button>
            </form>
        </section>
    </main>
    <footer>
        <div class="container">
            <p>&copy; 2024 SecureVPN. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
