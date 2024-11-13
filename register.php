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
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        /* Basic reset */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Roboto', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: #f5f5f5;
        }
        /* Modal container */
        .container {
            background-color: #fff;
            padding: 2rem;
            width: 100%;
            max-width: 400px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        /* Form heading */
        .register-form h2 {
            text-align: center;
            margin-bottom: 1rem;
            color: #333;
        }
        /* Error message */
        .error {
            color: red;
            text-align: center;
            margin-bottom: 1rem;
        }
        /* Form field styling */
        .register-form form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .form-group {
            position: relative;
        }
        .form-group input {
            width: 100%;
            padding: 0.75rem 0.75rem 0.75rem 2.5rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }
        .form-group label {
            font-size: 0.9rem;
            color: #666;
        }
        /* Icon styling */
        .form-group .material-icons {
            position: absolute;
            top: 50%;
            left: 0.75rem;
            transform: translateY(-50%);
            color: #888;
        }
        /* Button styling */
        .register-form button {
            padding: 0.75rem;
            font-size: 1rem;
            font-weight: bold;
            color: #fff;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .register-form button:hover {
            background-color: #45a049;
        }
        /* Link styling */
        .register-form p {
            text-align: center;
            font-size: 0.9rem;
        }
        .register-form p a {
            color: #4CAF50;
            text-decoration: none;
        }
        .register-form p a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="register-form">
            <h2>Register</h2>
            <?php if (isset($error_message)) { echo "<p class='error'>$error_message</p>"; } ?>
            <form action="register.php" method="POST">
                <div class="form-group">
                    <span class="material-icons">person</span>
                    <input type="text" name="username" id="username" placeholder="Username" required>
                </div>
                
                <div class="form-group">
                    <span class="material-icons">lock</span>
                    <input type="password" name="password" id="password" placeholder="Password" required>
                </div>
                
                <div class="form-group">
                    <span class="material-icons">email</span>
                    <input type="email" name="email" id="email" placeholder="Email" required>
                </div>
                
                <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>

                <button type="submit" name="register">Register</button>
            </form>
            <p>Already have an account? <a href="index.php">Login here</a></p>
        </div>
    </div>
</body>
</html>
