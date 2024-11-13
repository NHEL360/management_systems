<?php
// Include database connection
include('db.connection.php');

// Check if an ID is provided
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Prepare delete statement
    $sql = "DELETE FROM products WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([':id' => $id]);
        echo "<script>alert('Inventory item deleted successfully!'); window.location='inventory.php';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Error: Unable to delete inventory item.'); window.location='inventory.php';</script>";
    }
} else {
    echo "<script>alert('Invalid ID.'); window.location='inventory.php';</script>";
}
?>
