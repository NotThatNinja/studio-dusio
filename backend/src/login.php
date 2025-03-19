<?php
session_start();
require_once 'db.php';

// Logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    $_SESSION = array();
    session_destroy();
    header('Location: login.php');
    exit;
}

// Hard-coded admin credentials
$admin_password = password_hash("admin", PASSWORD_DEFAULT);

// Check if user is already logged in
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: admin.php');
    exit;
}

$error = '';

// Process login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    
    if (password_verify($password, $admin_password)) {
        // Set session variables
        $_SESSION['logged_in'] = true;
        
        // Redirect to admin page
        header('Location: admin.php');
        exit;
    } else {
        $error = 'Password errata';
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Studio Dusio - Admin Login</title>
    <style>
        body {
            font-family: system-ui, sans-serif;
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
        }
        .login-form {
            background-color: #f4f4f4;
            padding: 20px;
            border-radius: 5px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="password"] {
            width: calc(100% - 20px);
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .error {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <h1>Admin Login</h1>
    
    <?php if ($error): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <div class="login-form">
        <form method="post" action="login.php">
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
