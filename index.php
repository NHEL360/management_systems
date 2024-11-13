<?php
// index.php - Login Page
session_start();
include('db.connection.php');

if (isset($_POST['login'])) {
    // Get login details
    $username = $_POST['username']; 
    $password = $_POST['password'];

    // Prepare the query to prevent SQL injection
    $query = "SELECT * FROM users WHERE username = :username";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Set session variables on successful login
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: dashboard.php');
        exit();
    } else {
        $error_message = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
        }

        .login-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 16px;
            box-sizing: border-box;
        }

        .error {
            color: red;
            font-size: 14px;
            text-align: center;
        }

        button {
            padding: 14px;
            background-color: #04AA6D;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        button:hover {
            background-color: #039a5f;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .remember-me input[type="checkbox"] {
            width: auto;
        }

        .actions {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
        }

        .actions a {
            text-decoration: none;
            color: #04AA6D;
        }

        /* Responsive Design */
        @media screen and (max-width: 480px) {
            .container {
                padding: 20px;
                width: 90%;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Login Form -->
        <div class="login-form">
            <h2>Login</h2>

            <?php if (isset($error_message)) { echo "<p class='error'>$error_message</p>"; } ?>

            <form action="index.php" method="POST">
                <div>
                    <label for="username">Username:</label>
                    <input type="text" name="username" id="username" required>
                </div>

                <div>
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" required>
                </div>

                <!-- Login Button -->
                <button type="submit" name="login">Login</button>

                <!-- Remember Me Checkbox -->
                <div class="remember-me">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Remember me</label>
                </div>

                <!-- Forgot Password Link -->
                <div class="actions">
                    <a href="#">Forgot password?</a>
                </div>
            </form>

            <p style="text-align: center;">Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </div>

</body>
</html>
