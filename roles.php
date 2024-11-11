<?php
include('includes/session.php');
include('includes/header.php');
include('includes/db.connection.php');

// Fetch categories
$stmt = $pdo->query("SELECT * FROM categories");
$categories = $stmt->fetchAll();
?>

<h1>Categories</h1>
<ul>
    <?php foreach ($categories as $category): ?>
        <li><?php echo htmlspecialchars($category['name']); ?></li>
    <?php endforeach; ?>
</ul>

<?php include('includes/footer.php'); ?>
