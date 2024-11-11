<?php
// Verification code when user clicks on the verification link with the token
$token = $_GET['token'];

// Check if the token exists in the user_registration table
$sql = "SELECT * FROM user_registration WHERE registration_token = :token";
$stmt = $pdo->prepare($sql);
$stmt->execute([':token' => $token]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);
if ($user) {
    // Move the user data from user_registration to users table
    $sqlInsert = "INSERT INTO users (username, password, email) 
                  VALUES (:username, :password, :email)";
    $stmtInsert = $pdo->prepare($sqlInsert);
    $stmtInsert->execute([
        ':username' => $user['username'],
        ':password' => $user['password'], // Already hashed
        ':email' => $user['email']
    ]);
    
    // Optionally, delete from the registration table
    $sqlDelete = "DELETE FROM user_registration WHERE registration_token = :token";
    $stmtDelete = $pdo->prepare($sqlDelete);
    $stmtDelete->execute([':token' => $token]);

    echo "Account successfully verified!";
} else {
    echo "Invalid verification token!";
}
?>