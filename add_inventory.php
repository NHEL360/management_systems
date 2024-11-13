<?php
// Include database connection
include('db.connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $productName = htmlspecialchars($_POST['productName']);
    $description = htmlspecialchars($_POST['description']);
    $category = (int)$_POST['category'];
    $price = (float)$_POST['price'];
    $quantity = (int)$_POST['quantity'];
    $supplier = (int)$_POST['supplier'];

    // Insert data into products table
    $sql = "INSERT INTO products (name, description, category_id, price, quantity, supplier_id) 
            VALUES (:productName, :description, :category, :price, :quantity, :supplier)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            ':productName' => $productName,
            ':description' => $description,
            ':category' => $category,
            ':price' => $price,
            ':quantity' => $quantity,
            ':supplier' => $supplier
        ]);
        echo "<script>alert('Inventory item added successfully!'); window.location='inventory.php';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Error: Unable to add inventory item.'); window.location='inventory.php';</script>";
    }
}
?>
