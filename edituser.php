<?php
// edit_user.php - Edit user details
include('db.connection.php');

// Check if the ID is provided in the URL
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Fetch user details from the database
    $query = "SELECT * FROM users WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':id' => $userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if user exists
    if (!$user) {
        echo "<script>alert('User not found!'); window.location='users.php';</script>";
        exit();
    }

    // Handle form submission for updating user details
    if (isset($_POST['updateUser'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $user['password']; // Update only if a new password is provided

        // Update user details in the database
        $updateQuery = "UPDATE users SET username = :username, email = :email, password = :password WHERE id = :id";
        $stmt = $pdo->prepare($updateQuery);
        if ($stmt->execute([':username' => $username, ':email' => $email, ':password' => $password, ':id' => $userId])) {
            echo "<script>alert('User updated successfully!'); window.location='users.php';</script>";
        } else {
            echo "<script>alert('Error updating user.');</script>";
        }
    }
} else {
    echo "<script>alert('User ID is missing.'); window.location='users.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
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
            max-width: 600px;
            margin: auto;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        /* Form Styling */
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"], input[type="email"], input[type="password"] {
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #04AA6D;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #039a5f;
        }

        /* Back to Dashboard Button */
        .back-btn {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            position: absolute;
            top: 20px;
            right: 20px;
            transition: background-color 0.3s;
        }

        .back-btn:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <!-- Back to Dashboard Button -->
    <button class="back-btn" onclick="window.location.href='dashboard.php';">Back to Dashboard 🏠</button>

    <div class="container">
        <h2>Edit User</h2>

        <!-- Edit User Form -->
        <form action="edit_user.php?id=<?php echo $user['id']; ?>" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br>

            <label for="password">New Password (Leave blank to keep existing):</label>
            <input type="password" id="password" name="password"><br>

            <button type="submit" name="updateUser">Update User</button>
        </form>
    </div>
</body>
</html>
