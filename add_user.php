<?php
include('db.connection.php');

// Get data from form submission
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
$email = $_POST['email'];
$department_id = $_POST['department_id'];

// Insert new user into the users table
$sql = "INSERT INTO users (username, password, email, department_id) 
        VALUES (:username, :password, :email, :department_id)";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':username' => $username,
    ':password' => $password,
    ':email' => $email,
    ':department_id' => $department_id
]);

header('Location: dashboard.php');
exit();
?>
