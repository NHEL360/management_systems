<?php
// Include database connection
include('db.connection.php');

// Query to fetch suppliers
$sql = "SELECT * FROM suppliers";
$result = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suppliers</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Include CSS -->
</head>
<body>
    <h1>Suppliers List</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Check if there are results
            if ($result->rowCount() > 0) {
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['id']) . "</td>
                            <td>" . htmlspecialchars($row['name']) . "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No suppliers found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
