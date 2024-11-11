<?php
$host = "localhost";         // Database host
$dbname = "management_systems";  // Database name
$username = "root";           // Database username
$password = "";               // Database password (empty for XAMPP default)

try {
    // Creating a PDO instance to connect to MySQL
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception for better error handling
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connection successful";  // Optional success message
} catch (PDOException $e) {
    // In case of connection failure, display the error message
    echo "Connection failed: " . $e->getMessage();
}
?>
