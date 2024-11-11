<?php
session_start();
include('db.connection.php');

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Fetching users with department names using JOIN
$sql = "SELECT users.id, users.username, users.email, departments.name AS department 
        FROM users 
        JOIN departments ON users.department_id = departments.id";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

$username = $_SESSION['username'];
$email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a href="dashboard.php">Dashboard</a>
        
        <!-- Search Bar -->
        <div class="search-container">
            <input type="text" id="searchBar" placeholder="Search..." name="search">
            <button type="submit" id="searchBtn"><i class="fa fa-search"></i></button>
        </div>

        <!-- Dark Mode Toggle Icon -->
        <div class="toggle-container">
            <label class="switch">
                <input type="checkbox" id="darkModeToggle">
                <span class="slider round"></span>
            </label>
        </div>

        <!-- Logout Button (moved to the right) -->
        <div class="user-info">
            <button id="logoutBtn">Logout</button>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <h2>Welcome to the Dashboard</h2>
        
        <!-- Users Table -->
        <h3>Users and Departments</h3>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Department</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['id']); ?></td>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['department']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <button id="show-add-user-modal">Add New User</button>
    </div>

    <!-- Add User Modal -->
    <div id="addUserModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Add User</h2>
            <form action="add_user.php" method="POST">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="department_id">Department:</label>
                <select id="department_id" name="department_id" required>
                    <?php
                    $deptQuery = "SELECT * FROM departments";
                    foreach ($pdo->query($deptQuery) as $dept) {
                        echo "<option value='{$dept['id']}'>{$dept['name']}</option>";
                    }
                    ?>
                </select>

                <button type="submit">Add User</button>
            </form>
        </div>
    </div>

    <!-- User Info Modal (for logout with username and email) -->
    <div id="userInfoModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeUserInfoModal()">&times;</span>
            <h2>User Information</h2>
            <p><strong>Username:</strong> <?php echo $username; ?></p>
            <p><strong>Email:</strong> <?php echo $email; ?></p>
            <button id="logoutConfirmBtn">Logout</button>
        </div>
    </div>

    <script src="assets/js/script.js"></script>

<style>
/* Navbar */
.navbar {
    background-color: #333;
    overflow: hidden;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
}

.navbar a {
    color: #f2f2f2;
    padding: 14px 16px;
    text-decoration: none;
    font-size: 18px;
}

/* Search Bar */
.search-container {
    display: flex;
    align-items: center;
}

.search-container input[type="text"] {
    padding: 10px;
    width: 200px;
    font-size: 16px;
}

.search-container button {
    background-color: #2196F3;
    color: white;
    padding: 10px 15px;
    border: none;
    cursor: pointer;
}

.search-container button:hover {
    background-color: #0b7dda;
}

/* Dark Mode Toggle */
.toggle-container {
    display: flex;
    align-items: center;
}

.switch {
    position: relative;
    display: inline-block;
    width: 34px;
    height: 20px;
}

.switch input { 
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: 0.4s;
    border-radius: 50px;
}

.slider:before {
    position: absolute;
    content: "";
    height: 12px;
    width: 12px;
    border-radius: 50%;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: 0.4s;
}

input:checked + .slider {
    background-color: #2196F3;
}

input:checked + .slider:before {
    transform: translateX(14px);
}

/* Logout Button (moved to the right) */
.user-info {
    display: flex;
    justify-content: flex-end;
}

button {
    background-color: #4CAF50;
    color: white;
    padding: 10px 15px;
    border: none;
    cursor: pointer;
}

button:hover {
    background-color: #45a049;
}

/* Modal Styling */
.modal {
    display: none;
    position: fixed;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
    background-color: white;
    margin: 15% auto;
    padding: 20px;
    width: 50%;
    border-radius: 5px;
}

.close {
    color: red;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

button#logoutConfirmBtn {
    background-color: red;
    padding: 10px 20px;
    color: white;
    border: none;
    cursor: pointer;
}

button#logoutConfirmBtn:hover {
    background-color: darkred;
}

/* Table Styling */
table {
    width: 100%;
    margin-top: 20px;
    border-collapse: collapse;
}

th, td {
    padding: 10px;
    text-align: left;
    border: 1px solid #ddd;
}

/* Dark Mode Styling */
body.dark-mode {
    background-color: #121212;
    color: #e0e0e0;
}

body.dark-mode .navbar {
    background-color: #1f1f1f;
}

body.dark-mode button {
    background-color: #2196F3;
}

body.dark-mode table {
    background-color: #333;
}

body.dark-mode .modal-content {
    background-color: #424242;
}

</style>

<script>

// Dark Mode Toggle
document.getElementById('darkModeToggle').addEventListener('change', function () {
    if (this.checked) {
        document.body.classList.add('dark-mode');
    } else {
        document.body.classList.remove('dark-mode');
    }
});

// Open User Info Modal (for Logout)
document.getElementById('logoutBtn').onclick = function() {
    document.getElementById('userInfoModal').style.display = 'block';
};

// Close User Info Modal
function closeUserInfoModal() {
    document.getElementById('userInfoModal').style.display = 'none';
}

// Logout Confirmation
document.getElementById('logoutConfirmBtn').onclick = function() {
    window.location.href = 'logout.php';
};

// Close Add User Modal
function closeModal() {
    document.getElementById('addUserModal').style.display = 'none';
}

// Show Add User Modal
document.getElementById('show-add-user-modal').onclick = function() {
    document.getElementById('addUserModal').style.display = 'block';
};

</script>
</body>
</html>