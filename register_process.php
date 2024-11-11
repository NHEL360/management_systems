<?php
// register_process.php - Processes the registration form data
session_start();
include('db.connection.php'); // Ensure this file sets up $pdo for database access

if (isset($_POST['register'])) {
    // Get data from registration form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Hash the password and generate a token
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);
    $token = bin2hex(random_bytes(16)); // Generate a unique registration token

    // Check if the username already exists in users or user_registration
    $checkQuery = "SELECT * FROM users WHERE username = :username OR email = :email";
    $checkStmt = $pdo->prepare($checkQuery);
    $checkStmt->execute([':username' => $username, ':email' => $email]);

    if ($checkStmt->rowCount() > 0) {
        $_SESSION['error_message'] = "Username or email already exists.";
        header('Location: register.php');
        exit;
    }

    // Insert user data into the user_registration table with the registration token
    $sql = "INSERT INTO user_registration (username, password, email, registration_token) 
            VALUES (:username, :password, :email, :token)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':username' => $username,
        ':password' => $passwordHash,
        ':email' => $email,
        ':token' => $token
    ]);

    // Generate the verification link (update with your actual domain)
    $verificationLink = "http://yourdomain.com/verify_account.php?token=" . $token;

    // Compose the email
    $subject = "Verify Your Account";
    $message = "
        Hi $username,

        Thank you for registering. Please click the link below to verify your email address:
        $verificationLink

        If you didn’t create an account, please ignore this email.
    ";
    $headers = "From: no-reply@yourdomain.com";

    // Send the verification email
    mail($email, $subject, $message, $headers);

    echo "Registration successful! A verification email has been sent to $email.";
}
?>
