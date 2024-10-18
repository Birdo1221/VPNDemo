<?php
session_start();
require_once 'functions.php';
require_once 'db.php';
require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_email']) || !isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// CSRF protection
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_password'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('CSRF token validation failed');
    }

    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];
    $userEmail = $_SESSION['user_email'];

    if (empty($newPassword)) {
        $error = "Password cannot be empty.";
    } elseif ($newPassword !== $confirmPassword) {
        $error = "Passwords do not match.";
    } elseif (strlen($newPassword) < 8) {
        $error = "Password must be at least 8 characters long.";
    } else {
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $stmt = $db->prepare("UPDATE userbase SET password = :password WHERE email = :email");
        if ($stmt->execute(['password' => $hashedPassword, 'email' => $userEmail])) {
            $message = "Password updated successfully.";
        } else {
            $error = "Failed to update password. Please try again later.";
        }
    }
}

// Fetch user details
$stmt = $db->prepare("SELECT email FROM userbase WHERE id = :id");
$stmt->execute(['id' => $_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - SecureVPN</title>
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
    --box-shadow-color: rgba(0, 0, 0, 0.1);
    --error-color: #dc3545;
    --success-color: #28a745;
    --input-background: #ffffff;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(180deg, var(--primary-color), var(--secondary-color));
    color: var(--text-color);
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

header {
    background-color: var(--secondary-color);
    color: var(--white);
    padding: 0.5rem 0;
    box-shadow: 0 2px 4px var(--box-shadow-color);
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

nav h1 {
    font-size: 1.25rem;
    margin: 0;
}

nav a {
    color: var(--white);
    text-decoration: none;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

nav a:hover {
    background-color: rgba(255, 255, 255, 0.2);
}

main {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 2rem 0;
    box-shadow: 0px 4px 15px 5px rgb(32 49 46);
}

h1, h2, h3 {
    margin-bottom: 1rem;
    color: snow;
}

.form-section, .user-info {
    background-color: var(--white);
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 4px 6px var(--box-shadow-color);
    margin-bottom: 2rem;
    width: 100%;
    max-width: 600px;
    text-align: center;
}

label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: snow;
}

input[type="password"], select, button {
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
    transition: background-color 0.3s ease, transform 0.2s ease;
    font-weight: 600;
    text-transform: uppercase;
}

button:hover {
    background-color: #2980b9;
    transform: scale(1.02);
}

.message, .error {
    padding: 1rem;
    border-radius: 4px;
    width: 100%;
    max-width: 600px;
    text-align: center;
    margin-bottom: 1rem;
}

.message {
    background-color: #d4edda;
    color: var(--success-color);
    border: 1px solid #c3e6cb;
}

.error {
    background-color: #f8d7da;
    color: var(--error-color);
    border: 1px solid #f5c6cb;
}

footer {
    color: var(--white);
    text-align: center;
    padding: 12px 0;
    margin-top: auto;
}

@media (max-width: 768px) {
    .container {
        padding: 10px;
    }

    nav {
        flex-direction: column;
        align-items: flex-start;
    }

    nav h1 {
        margin-bottom: 1rem;
    }

    nav a {
        padding: 0.75rem;
        font-size: 0.9rem;
    }

    .form-section {
        padding: 1.5rem;
    }
}


    </style>
</head>
<body>
    <header>
        <div class="container">
            <nav>
                <h1>Profile</h1>
                <div>
                    <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </nav>
        </div>
    </header>
    <main class="container">
        <div class="user-info">
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        </div>

        <h2>Update Password</h2>
        <form method="POST" onsubmit="return validateForm()">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            
            <label for="new_password">New Password:</label>
            <input type="password" name="new_password" id="new_password" required>
            
            <label for="confirm_password">Confirm New Password:</label>
            <input type="password" name="confirm_password" id="confirm_password" required>
            
            <button type="submit" name="reset_password">Update Password</button>
        </form>

        <?php if (!empty($message)): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
    </main>

    <script>
        function validateForm() {
            var newPassword = document.getElementById('new_password').value;
            var confirmPassword = document.getElementById('confirm_password').value;

            if (newPassword.length < 8) {
                alert('Password must be at least 8 characters long.');
                return false;
            }

            if (newPassword !== confirmPassword) {
                alert('Passwords do not match.');
                return false;
            }

            return true;
        }
    </script>
    <footer>
        <div class="container">
            <p>&copy; 2024 SecureVPN. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
