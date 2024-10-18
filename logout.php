<?php
session_start();
require_once 'functions.php';

// Perform logout actions
function logout() {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();

    // Clear any additional cookies
    clearCookies();

    // Regenerate session ID for extra security
    session_regenerate_id(true);
}

// Check if the user is actually logged in
if (isset($_SESSION['user_id'])) {
    logout();
    $message = "You have been successfully logged out.";
} else {
    $message = "You were not logged in.";
}

// Delay the redirect to show the logout message
$redirect_delay = 3; // seconds
header("Refresh: $redirect_delay; URL=login.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout - SecureVPN</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --background-color: #ecf0f1;
            --text-color: #333;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: rgb(12 40 70);
            color: var(--text-color);
            line-height: 1.6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }

        .container {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 90%;
        }

        h1 {
            color: var(--secondary-color);
            margin-bottom: 1rem;
        }

        p {
            margin-bottom: 1rem;
        }

        .icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .redirect-message {
            font-size: 0.9rem;
            color: #666;
            margin-top: 1rem;
        }

        a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #2980b9;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <i class="fas fa-sign-out-alt icon"></i>
        <h1>Logged Out</h1>
        <p><?php echo htmlspecialchars($message); ?></p>
        <p>You will be redirected to the login page in <span id="countdown"><?php echo $redirect_delay; ?></span> seconds.</p>
        <p>Click <a href="login.php">here</a> if you're not redirected automatically.</p>
    </div>

    <script>
        // Countdown timer
        let countdown = <?php echo $redirect_delay; ?>;
        const countdownDisplay = document.getElementById('countdown');
        const countdownTimer = setInterval(() => {
            countdown--;
            countdownDisplay.textContent = countdown;
            if (countdown <= 0) clearInterval(countdownTimer);
        }, 1000);
    </script>
</body>
</html>