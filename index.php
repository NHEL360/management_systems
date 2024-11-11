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
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- Login Form -->
        <div class="login-form">
            <h2>Login</h2>
            <?php if (isset($error_message)) { echo "<p class='error'>$error_message</p>"; } ?>
            <form action="index.php" method="POST">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
                
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
                
                <button type="submit" name="login">Login</button>
            </form>
            <p>Don't have an account? <a href="javascript:void(0);" id="show-register-modal">Register here</a></p>
        </div>
    </div>

    <!-- Register Modal -->
    <div id="register-modal" class="modal">
        <div class="modal-content">
            <span id="close-register-modal" class="close">&times;</span>
            <h2>Register</h2>
            <form action="register.php" method="POST">
                <label for="new-username">Username:</label>
                <input type="text" name="username" id="new-username" required>
                
                <label for="new-password">Password:</label>
                <input type="password" name="password" id="new-password" required>
                
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
                
                <button type="submit" name="register">Register</button>
            </form>
        </div>
    </div>

    <script src="assets/js/script.js"></script>
</body>
</html>
