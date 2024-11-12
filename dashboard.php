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

// Fetch user data from session
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
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
        <a href="dashboard.php" class="navbar-brand">Dashboard</a>

        <!-- Navbar Links with Icons -->
        <div class="nav-links">
            <a href="#" id="usersBtn"><i class="fa fa-users"></i> Users</a>
            <a href="department.php" id="departmentsBtn"><i class="fa fa-building"></i> Departments</a>
            <a href="products.php" id="productsBtn"><i class="fa fa-cogs"></i> Products</a>
            <a href="categories.php" id="categoriesBtn"><i class="fa fa-list"></i> Categories</a>
            <a href="inventory.php" id="inventoryBtn"><i class="fa fa-archive"></i> Inventory</a>
            <a href="suppliers.php" id="suppliersBtn"><i class="fa fa-truck"></i> Suppliers</a>
        </div>

        <!-- Dark Mode Toggle Icon (Left Center) -->
        <div class="toggle-container">
            <label class="switch">
                <input type="checkbox" id="darkModeToggle">
                <span class="slider round"></span>
            </label>
        </div>

        <!-- Search Bar -->
        <div class="search-container">
            <input type="text" id="searchBar" placeholder="Search..." name="search">
            <button type="submit" id="searchBtn"><i class="fa fa-search"></i></button>
        </div>

        <!-- Logout Button (Right) -->
        <div class="user-info">
            <button id="logoutBtn"><i class="fa fa-user"></i> Logout</button>
        </div>
    </nav>

    <!-- Modals for each button -->
    <div id="usersModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('usersModal')">&times;</span>
            <h2>Users Information</h2>
            <!-- Add content for Users Modal -->
        </div>
    </div>

    <div id="departmentsModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('departmentsModal')">&times;</span>
            <h2>Departments Information</h2>
            <!-- Add content for Departments Modal -->
        </div>
    </div>

    <div id="productsModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('productsModal')">&times;</span>
            <h2>Products Information</h2>
            <!-- Add content for Products Modal -->
        </div>
    </div>

    <div id="categoriesModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('categoriesModal')">&times;</span>
            <h2>Categories Information</h2>
            <!-- Add content for Categories Modal -->
        </div>
    </div>

    <div id="inventoryModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('inventoryModal')">&times;</span>
            <h2>Inventory Information</h2>
            <!-- Add content for Inventory Modal -->
        </div>
    </div>

    <div id="suppliersModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('suppliersModal')">&times;</span>
            <h2>Suppliers Information</h2>
            <!-- Add content for Suppliers Modal -->
        </div>
    </div>

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
            <span class="close" onclick="closeModal('addUserModal')">&times;</span>
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

/* Navbar Links */
.nav-links {
    display: flex;
    gap: 20px;
}

.nav-links a {
    color: #f2f2f2;
    padding: 14px 16px;
    text-decoration: none;
    font-size: 18px;
}

.navbar .navbar-brand {
    color: #f2f2f2;
    font-size: 22px;
    font-weight: bold;
}

/* Dark Mode Toggle */
.toggle-container {
    display: flex;
    align-items: center;
    position: absolute;
    left: 70%;
    transform: translateX(-50%);
}

/* Search Bar */
.search-container {
    display: flex;
    align-items: center;
    margin-right: 10px;
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

/* Logout Button */
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

</style>

<script>
// Modal functionality for Navbar items
document.getElementById('usersBtn').onclick = function() {
    document.getElementById('usersModal').style.display = 'block';
};

document.getElementById('departmentsBtn').onclick = function() {
    document.getElementById('departmentsModal').style.display = 'block';
};

document.getElementById('productsBtn').onclick = function() {
    document.getElementById('productsModal').style.display = 'block';
};

document.getElementById('categoriesBtn').onclick = function() {
    document.getElementById('categoriesModal').style.display = 'block';
};

document.getElementById('inventoryBtn').onclick = function() {
    document.getElementById('inventoryModal').style.display = 'block';
};

document.getElementById('suppliersBtn').onclick = function() {
    document.getElementById('suppliersModal').style.display = 'block';
};

// Close Modals
function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

// Logout functionality
document.getElementById('logoutBtn').onclick = function() {
    document.getElementById('userInfoModal').style.display = 'block';
};

document.getElementById('logoutConfirmBtn').onclick = function() {
    window.location.href = 'logout.php';
};
</script>

</body>
</html>
