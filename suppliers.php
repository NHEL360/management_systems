<?php 
// Include database connection
include('db.connection.php');

// Query to fetch suppliers
$sql = "SELECT * FROM suppliers";
$result = $pdo->query($sql);

// Add supplier functionality
if (isset($_POST['add_supplier'])) {
    $name = $_POST['name'];

    // Insert new supplier
    $insert_sql = "INSERT INTO suppliers (name) VALUES (:name)";
    $stmt = $pdo->prepare($insert_sql);
    if ($stmt->execute([':name' => $name])) {
        echo "<script>alert('Supplier added successfully!'); window.location.href = 'suppliers.php';</script>";
    } else {
        echo "<script>alert('Error adding supplier.');</script>";
    }
}

// Delete supplier functionality
if (isset($_GET['delete'])) {
    $supplier_id = $_GET['delete'];
    $delete_sql = "DELETE FROM suppliers WHERE id = :id";
    $stmt = $pdo->prepare($delete_sql);
    if ($stmt->execute([':id' => $supplier_id])) {
        echo "<script>alert('Supplier deleted successfully!'); window.location.href = 'suppliers.php';</script>";
    } else {
        echo "<script>alert('Error deleting supplier.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suppliers</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Include CSS -->
    <style>
        /* Custom styles for modal and layout */
        .button-container {
            margin-bottom: 20px;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 5px;
            max-width: 400px;
            width: 100%;
        }

        /* Styling for table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        /* Highlight ID, Name, Actions columns */
        th {
            background-color: #4CAF50;
            color: white;
        }

        td {
            background-color: #f9f9f9;
        }

        td:first-child, td:nth-child(2), td:last-child {
            background-color: #e1f8d3; /* Light green for highlighted columns */
        }

        /* Hover effects for rows */
        tr:hover {
            background-color: #f1f1f1;
        }

        /* Floating Button */
        #backToDashboardBtn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #007bff;
            color: white;
            font-size: 18px;
            padding: 15px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        #backToDashboardBtn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Suppliers List</h1>

        <!-- Button to trigger add supplier modal -->
        <div class="button-container">
            <button id="addSupplierBtn">Add Supplier</button>
        </div>

        <!-- Suppliers Table -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
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
                                <td>
                                    <a href='edit_supplier.php?id=" . $row['id'] . "'>Edit</a> |
                                    <a href='suppliers.php?delete=" . $row['id'] . "' onclick=\"return confirm('Are you sure you want to delete this supplier?');\">Delete</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3' style='text-align:center;'>No suppliers found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Add Supplier Modal -->
    <div id="addSupplierModal" class="modal">
        <div class="modal-content">
            <h2>Add Supplier</h2>
            <form method="POST" action="suppliers.php">
                <label for="name">Supplier Name:</label>
                <input type="text" id="name" name="name" required>

                <button type="submit" name="add_supplier">Add Supplier</button>
                <button type="button" onclick="closeModal();">Cancel</button>
            </form>
        </div>
    </div>

    <!-- Back to Dashboard Button -->
    <button id="backToDashboardBtn">🏢</button>

    <!-- Confirmation Modal for Back to Dashboard -->
    <div id="backToDashboardModal" class="modal">
        <div class="modal-content">
            <h2>Are you sure you want to go back to the Dashboard?</h2>
            <button onclick="window.location.href='dashboard.php';">Yes</button>
            <button onclick="closeModal();">No</button>
        </div>
    </div>

    <script>
        // Open the modal for Add Supplier
        document.getElementById("addSupplierBtn").onclick = function() {
            document.getElementById("addSupplierModal").style.display = "block";
        }

        // Close the modal
        function closeModal() {
            document.getElementById("addSupplierModal").style.display = "none";
            document.getElementById("backToDashboardModal").style.display = "none";
        }

        // Close the modal when clicking outside
        window.onclick = function(event) {
            if (event.target == document.getElementById("addSupplierModal")) {
                closeModal();
            }
            if (event.target == document.getElementById("backToDashboardModal")) {
                closeModal();
            }
        }

        // Back to Dashboard confirmation
        document.getElementById("backToDashboardBtn").onclick = function() {
            document.getElementById("backToDashboardModal").style.display = "block";
        }
    </script>
</body>
</html>
