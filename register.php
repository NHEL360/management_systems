<?php
// register.php - Registration Page
session_start();
include('db.connection.php');

if (isset($_POST['register'])) {
    // Get registration details
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $_POST['email'];

    // Check if the username already exists
    $query = "SELECT * FROM users WHERE username = :username";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':username' => $username]);

    if ($stmt->rowCount() > 0) {
        $error_message = "Username already exists.";
    } else {
        // Insert new user into the database
        $insertQuery = "INSERT INTO users (username, password, email) VALUES (:username, :password, :email)";
        $stmt = $pdo->prepare($insertQuery);
        if ($stmt->execute([':username' => $username, ':password' => $password, ':email' => $email])) {
            // Redirect to login page after successful registration
            header('Location: index.php');
            exit();
        } else {
            $error_message = "Error registering user.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="register-form">
            <h2>Register</h2>
            <?php if (isset($error_message)) { echo "<p class='error'>$error_message</p>"; } ?>
            <form action="register.php" method="POST">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
                
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
                
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
                
                <button type="submit" name="register">Register</button>
            </form>
            <p>Already have an account? <a href="index.php">Login here</a></p>
        </div>
    </div>
</body>
</html>
