<?php
$servername = "localhost";
$username = "root"; // default XAMPP/MAMP username
$password = ""; // default password is empty for XAMPP/MAMP
$dbname = "management_systems";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
