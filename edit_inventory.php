<?php
// Include database connection
include('db.connection.php');

// Check if an ID is provided
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Fetch existing inventory item details
    $sql = "SELECT * FROM products WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Collect and sanitize input data
        $productName = htmlspecialchars($_POST['productName']);
        $description = htmlspecialchars($_POST['description']);
        $category = (int)$_POST['category'];
        $price = (float)$_POST['price'];
        $quantity = (int)$_POST['quantity'];
        $supplier = (int)$_POST['supplier'];

        // Update product details in the database
        $updateSql = "UPDATE products 
                      SET name = :productName, description = :description, category_id = :category, price = :price, quantity = :quantity, supplier_id = :supplier 
                      WHERE id = :id";
        $stmt = $pdo->prepare($updateSql);

        try {
            $stmt->execute([
                ':productName' => $productName,
                ':description' => $description,
                ':category' => $category,
                ':price' => $price,
                ':quantity' => $quantity,
                ':supplier' => $supplier,
                ':id' => $id
            ]);
            echo "<script>alert('Inventory item updated successfully!'); window.location='inventory.php';</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Error: Unable to update inventory item.'); window.location='inventory.php';</script>";
        }
    }
} else {
    echo "<script>alert('Invalid ID.'); window.location='inventory.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Inventory Item</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Edit Inventory Item</h2>
    <form method="POST">
        <label>Product Name:</label>
        <input type="text" name="productName" value="<?php echo htmlspecialchars($product['name']); ?>" required>

        <label>Description:</label>
        <textarea name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea>

        <label>Category:</label>
        <select name="category" required>
            <?php
            $categoryQuery = "SELECT * FROM categories";
            foreach ($pdo->query($categoryQuery) as $category) {
                echo "<option value='{$category['id']}'" . ($product['category_id'] == $category['id'] ? ' selected' : '') . ">{$category['name']}</option>";
            }
            ?>
        </select>

        <label>Price:</label>
        <input type="number" name="price" step="0.01" value="<?php echo $product['price']; ?>" required>

        <label>Quantity:</label>
        <input type="number" name="quantity" value="<?php echo $product['quantity']; ?>" required>

        <label>Supplier:</label>
        <select name="supplier" required>
            <?php
            $supplierQuery = "SELECT * FROM suppliers";
            foreach ($pdo->query($supplierQuery) as $supplier) {
                echo "<option value='{$supplier['id']}'" . ($product['supplier_id'] == $supplier['id'] ? ' selected' : '') . ">{$supplier['name']}</option>";
            }
            ?>
        </select>

        <button type="submit">Update Item</button>
    </form>
</body>
</html>
