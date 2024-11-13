<?php
// Include database connection
include('db.connection.php');

// Query to fetch products along with their category and supplier details
$sql = "SELECT p.id, p.name, p.description, p.price, c.name AS category, s.name AS supplier
        FROM products p
        JOIN categories c ON p.category_id = c.id
        JOIN suppliers s ON p.supplier_id = s.id";

$result = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Include CSS -->
</head>
<body>
    <h1>Inventory List</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Category</th>
                <th>Price</th>
                <th>Supplier</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->rowCount() > 0) {
                while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                            <td>" . $row['id'] . "</td>
                            <td>" . $row['name'] . "</td>
                            <td>" . $row['description'] . "</td>
                            <td>" . $row['category'] . "</td>
                            <td>" . $row['price'] . "</td>
                            <td>" . $row['supplier'] . "</td>
                            <td>
                                <a href='edit_inventory.php?id=" . $row['id'] . "'>Edit</a> |
                                <a href='delete_inventory.php?id=" . $row['id'] . "' onclick=\"return confirm('Are you sure you want to delete this item?');\">Delete</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No inventory items found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
