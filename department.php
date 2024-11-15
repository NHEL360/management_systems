<?php
// department.php - Display and manage departments
include('db.connection.php');

// Fetch departments from the database using PDO
$query = "SELECT * FROM departments";
$result = $pdo->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Departments</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        /* General Layout */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            padding: 20px;
            margin-top: 30px;
            max-width: 1200px;
            margin: auto;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
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

        td {
            background-color: #fafafa;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }

        a:hover {
            color: #0056b3;
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
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 20px;
            border-radius: 8px;
            width: 400px;
            text-align: center;
        }

        .modal-header {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .modal-body {
            font-size: 18px;
        }

        .modal-footer {
            margin-top: 20px;
        }

        .modal-footer button {
            background-color: #04AA6D;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .modal-footer button:hover {
            background-color: #039a5f;
        }

        .modal-footer .icon {
            margin-left: 10px;
        }

        /* Button Styling */
        .button-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .button-container button {
            padding: 10px 25px;
            background-color: #04AA6D;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .button-container button:hover {
            background-color: #039a5f;
        }

        /* Floating Back to Dashboard Button */
        #backToDashboardBtn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #007bff;
            color: white;
            font-size: 24px;
            padding: 20px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s;
        }

        #backToDashboardBtn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Departments</h2>

        <!-- Add Department Button -->
        <div class="button-container">
            <button id="addDepartmentBtn">Add Department</button>
        </div>

        <!-- Departments Table -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td>
                            <a href="editdepartment.php?id=<?php echo $row['id']; ?>">Edit</a> |
                            <a href="deletedepartment.php?id=<?php echo $row['id']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Add Department Modal -->
    <div id="addDepartmentModal" class="modal">
        <div class="modal-content">
            <span id="closeAddDepartmentModal" class="close">&times;</span>
            <h2>Add Department</h2>
            <form action="department.php" method="POST">
                <label for="departmentName">Department Name:</label>
                <input type="text" id="departmentName" name="departmentName" required>
                <button type="submit" name="addDepartment">Add Department</button>
            </form>
        </div>
    </div>

    <!-- Back to Dashboard Button -->
    <button id="backToDashboardBtn">🏢</button>

    <!-- Modal for confirming back to dashboard -->
    <div id="backToDashboardModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">Confirm Action</div>
            <div class="modal-body">Are you sure you want to go back to the dashboard?</div>
            <div class="modal-footer">
                <button onclick="window.location.href='dashboard.php';">
                    Yes, Go Back
                    <span class="icon">🏢</span>
                </button>
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

        // Close the modal when the user clicks the close button
        document.getElementById("closeAddDepartmentModal").onclick = function() {
            document.getElementById("addDepartmentModal").style.display = "none";
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

<?php
// Add Department functionality
if (isset($_POST['addDepartment'])) {
    $departmentName = $_POST['departmentName'];

    // Use a prepared statement to insert the department
    $insertQuery = "INSERT INTO departments (name) VALUES (:name)";
    $stmt = $pdo->prepare($insertQuery);
    if ($stmt->execute([':name' => $departmentName])) {
        echo "<script>alert('Department added successfully!'); window.location='department.php';</script>";
    } else {
        echo "<script>alert('Error adding department.');</script>";
    }
}
?>
