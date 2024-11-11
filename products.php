<?php
include('includes/session.php');
include('includes/header.php');
include('includes/db.connection.php');

// Fetch products
$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll();
?>

<h1>Products</h1>

<button id="addProductBtn">Add Product</button>

<!-- Product List -->
<ul>
    <?php foreach ($products as $product): ?>
        <li><?php echo htmlspecialchars($product['name']); ?></li>
    <?php endforeach; ?>
</ul>

<?php include('includes/footer.php'); ?>
