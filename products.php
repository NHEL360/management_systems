<?php
// Include database connection
include('db.connection.php');

// Query to fetch products, along with their category and supplier details
$sql = "SELECT p.id, p.name, p.description, p.price, c.name AS category, s.name AS supplier
        FROM products p
        JOIN categories c ON p.category_id = c.id
        JOIN suppliers s ON p.supplier_id = s.id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Include CSS -->
</head>
<body>
    <h1>Products List</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Category</th>
                <th>Price</th>
                <th>Supplier</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['id'] . "</td>
                            <td>" . $row['name'] . "</td>
                            <td>" . $row['description'] . "</td>
                            <td>" . $row['category'] . "</td>
                            <td>" . $row['price'] . "</td>
                            <td>" . $row['supplier'] . "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No products found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

<?php
// Close connection
$conn->close();
?>
