<?php
// Include database connection
include('db.connection.php');

// Query to fetch inventory data with product details, category, and supplier
$sql = "
    SELECT 
        p.id, 
        p.name AS product_name, 
        p.description, 
        p.price, 
        p.quantity, 
        c.name AS category_name, 
        s.name AS supplier_name
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.id
    LEFT JOIN suppliers s ON p.supplier_id = s.id
";
$stmt = $pdo->query($sql); // Execute query using PDO
$inventory = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Include CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Icons for buttons -->
</head>
<body>
    <h1>Inventory List</h1>

    <!-- Button to open Add Product Modal -->
    <button id="addInventoryBtn" class="btn btn-primary" data-toggle="modal" data-target="#addInventoryModal">Add New Inventory Item</button>

    <!-- Inventory Table -->
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Description</th>
                <th>Category</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Supplier</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($inventory) {
                foreach ($inventory as $item) {
                    echo "<tr>
                            <td>" . htmlspecialchars($item['id']) . "</td>
                            <td>" . htmlspecialchars($item['product_name']) . "</td>
                            <td>" . htmlspecialchars($item['description']) . "</td>
                            <td>" . htmlspecialchars($item['category_name']) . "</td>
                            <td>" . htmlspecialchars($item['price']) . "</td>
                            <td>" . htmlspecialchars($item['quantity']) . "</td>
                            <td>" . htmlspecialchars($item['supplier_name']) . "</td>
                            <td>
                                <a href='editinventory.php?id=" . htmlspecialchars($item['id']) . "'><i class='fas fa-edit'></i> Edit</a>
                                <a href='deleteinventory.php?id=" . htmlspecialchars($item['id']) . "'><i class='fas fa-trash'></i> Delete</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No inventory items found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Add Inventory Modal -->
    <div class="modal fade" id="addInventoryModal" tabindex="-1" aria-labelledby="addInventoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addInventoryModalLabel">Add New Inventory Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="add_inventory.php" method="POST">
                        <div class="form-group">
                            <label for="productName">Product Name</label>
                            <input type="text" class="form-control" id="productName" name="productName" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select class="form-control" id="category" name="category" required>
                                <?php
                                // Fetch categories for dropdown
                                $categoryQuery = "SELECT * FROM categories";
                                foreach ($pdo->query($categoryQuery) as $category) {
                                    echo "<option value='{$category['id']}'>{$category['name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" required>
                        </div>
                        <div class="form-group">
                            <label for="supplier">Supplier</label>
                            <select class="form-control" id="supplier" name="supplier" required>
                                <?php
                                // Fetch suppliers for dropdown
                                $supplierQuery = "SELECT * FROM suppliers";
                                foreach ($pdo->query($supplierQuery) as $supplier) {
                                    echo "<option value='{$supplier['id']}'>{$supplier['name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Add Inventory Item</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Include necessary Bootstrap and jQuery for modal functionality -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
