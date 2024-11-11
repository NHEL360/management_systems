<?php
include('includes/db.connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $_POST['email'];

    $stmt = $pdo->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
    $stmt->execute([$username, $password, $email]);

    echo "Registration successful! You can now <a href='login.php'>login</a>";
}
?>

<form method="POST">
    <label for="username">Username</label>
    <input type="text" name="username" required>

    <label for="password">Password</label>
    <input type="password" name="password" required>

    <label for="email">Email</label>
    <input type="email" name="email">

    <button type="submit">Register</button>
</form>
