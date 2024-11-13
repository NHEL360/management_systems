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
</head>
<body>
    <!-- Button to trigger modal for adding department -->
    <button id="addDepartmentBtn">Add Department</button>

    <!-- Modal for adding department -->
    <div id="addDepartmentModal" class="modal" style="display:none;">
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

    <!-- Departments Table -->
    <h2>Departments</h2>
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
                        <a href="editdepartment.php?id=<?php echo $row['id']; ?>">Edit</a>
                        <a href="deletedepartment.php?id=<?php echo $row['id']; ?>">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Link to the external JS file -->
    <script src="assets/js/script.js"></script>
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
