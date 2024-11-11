<?php
session_start();
include("db.connection.php");

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$query = "SELECT products.name, categories.name AS category, suppliers.name AS supplier, inventory.quantity
          FROM inventory
          JOIN products ON inventory.product_id = products.id
          JOIN categories ON products.category_id = categories.id
          JOIN suppliers ON products.supplier_id = suppliers.id";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome, <?php echo $_SESSION["username"]; ?></h2>
    <a href="logout.php">Logout</a>
    
    <h3>Inventory</h3>
    <table>
        <tr>
            <th>Product</th>
            <th>Category</th>
            <th>Supplier</th>
            <th>Quantity</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row["name"]; ?></td>
            <td><?php echo $row["category"]; ?></td>
            <td><?php echo $row["supplier"]; ?></td>
            <td><?php echo $row["quantity"]; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
