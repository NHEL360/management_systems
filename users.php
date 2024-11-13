<?php
// users.php - Manage users
include('db.connection.php');

// Fetch users from the database
$query = "SELECT * FROM users";
$result = $pdo->query($query);

// Add user functionality
if (isset($_POST['addUser'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashing password

    // Insert new user into the database
    $insertQuery = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
    $stmt = $pdo->prepare($insertQuery);
    if ($stmt->execute([':username' => $username, ':email' => $email, ':password' => $password])) {
        echo "<script>alert('User added successfully!'); window.location='users.php';</script>";
    } else {
        echo "<script>alert('Error adding user.');</script>";
    }
}

// Delete user functionality
if (isset($_GET['delete'])) {
    $userId = $_GET['delete'];
    $deleteQuery = "DELETE FROM users WHERE id = :id";
    $stmt = $pdo->prepare($deleteQuery);
    if ($stmt->execute([':id' => $userId])) {
        echo "<script>alert('User deleted successfully!'); window.location='users.php';</script>";
    } else {
        echo "<script>alert('Error deleting user.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        /* General Layout */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 20px;
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
        <h2>Users</h2>

        <!-- Add User Button -->
        <div class="button-container">
            <button id="addUserBtn">Add User</button>
        </div>

        <!-- Users Table -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td>
                            <a href="edituser.php?id=<?php echo $row['id']; ?>">Edit</a> |
                            <a href="users.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Add User Modal -->
    <div id="addUserModal" class="modal">
        <div class="modal-content">
            <span id="closeAddUserModal" class="close">&times;</span>
            <h2>Add User</h2>
            <form action="users.php" method="POST">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required><br><br>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br><br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required><br><br>
                <button type="submit" name="addUser">Add User</button>
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
                <button onclick="closeBackToDashboardModal();">Cancel</button>
            </div>
        </div>
    </div>

    <script>
        // Function to open the add user modal
        document.getElementById("addUserBtn").onclick = function() {
            document.getElementById("addUserModal").style.display = "block";
        }

        // Function to close the add user modal
        function closeAddUserModal() {
            document.getElementById("addUserModal").style.display = "none";
        }

        // Function to open the back to dashboard modal
        document.getElementById("backToDashboardBtn").onclick = function() {
            document.getElementById("backToDashboardModal").style.display = "block";
        }

        // Function to close the back to dashboard modal
        function closeBackToDashboardModal() {
            document.getElementById("backToDashboardModal").style.display = "none";
        }

        // Close modal on clicking the close button
        document.getElementById("closeAddUserModal").onclick = function() {
            closeAddUserModal();
        }

        // Close modal when clicking outside of it
        window.onclick = function(event) {
            if (event.target == document.getElementById("addUserModal")) {
                closeAddUserModal();
            }
            if (event.target == document.getElementById("backToDashboardModal")) {
                closeBackToDashboardModal();
            }
        }
    </script>
</body>
</html>
