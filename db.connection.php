<?php
$host = "localhost";         // Database host
$dbname = "management_systems";  // Database name
$username = "root";           // Database username
$password = "";               // Database password (empty for XAMPP default)

try {
    $pdo = new PDO('mysql:host=localhost;dbname=management_systems', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // No echo statement here
} catch (PDOException $e) {
    // Log or handle connection errors as needed
    die("Database connection failed: " . $e->getMessage());
}
