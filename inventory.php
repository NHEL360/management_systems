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
    <style>
        /* General page styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #333;
            padding-top: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #04AA6D;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e2f4e1;
        }

        .button-container {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }

        #backToDashboardBtn {
            background-color: #04AA6D;
            color: white;
            border: none;
            border-radius: 50%;
            padding: 20px;
            font-size: 20px;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s ease;
        }

        #backToDashboardBtn:hover {
            background-color: #039a5f;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: white;
            margin: 15% auto;
            padding: 20px;
            border-radius: 8px;
            width: 300px;
            text-align: center;
        }

        .modal-footer {
            margin-top: 20px;
        }

        .modal-footer button {
            background-color: #04AA6D;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .modal-footer button:hover {
            background-color: #039a5f;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Inventory List</h1>

        <!-- Inventory Table -->
        <table>
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
                                <td>" . htmlspecialchars($row['id']) . "</td>
                                <td>" . htmlspecialchars($row['name']) . "</td>
                                <td>" . htmlspecialchars($row['description']) . "</td>
                                <td>" . htmlspecialchars($row['category']) . "</td>
                                <td>" . htmlspecialchars($row['price']) . "</td>
                                <td>" . htmlspecialchars($row['supplier']) . "</td>
                                <td>
                                    <a href='edit_inventory.php?id=" . $row['id'] . "'>Edit</a> |
                                    <a href='delete_inventory.php?id=" . $row['id'] . "' onclick=\"return confirm('Are you sure you want to delete this item?');\">Delete</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' style='text-align:center;'>No inventory items found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Back to Dashboard Button -->
        <div class="button-container">
            <button id="backToDashboardBtn">🏢</button>
        </div>

    </div>

    <!-- Modal for confirming back to dashboard -->
    <div id="backToDashboardModal" class="modal">
        <div class="modal-content">
            <h3>Confirm Action</h3>
            <p>Are you sure you want to go back to the dashboard?</p>
            <div class="modal-footer">
                <button onclick="window.location.href='dashboard.php';">Yes, Go Back</button>
                <button onclick="closeModal();">Cancel</button>
            </div>
        </div>
    </div>

    <script>
        // Function to open the back to dashboard modal
        document.getElementById("backToDashboardBtn").onclick = function() {
            document.getElementById("backToDashboardModal").style.display = "block";
        }

        // Function to close the modal
        function closeModal() {
            document.getElementById("backToDashboardModal").style.display = "none";
        }

        // Close the modal when the user clicks outside of it
        window.onclick = function(event) {
            if (event.target == document.getElementById("backToDashboardModal")) {
                closeModal();
            }
        }
    </script>
</body>
</html>
