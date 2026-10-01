<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$totalUsersQuery = $conn->query("SELECT COUNT(*) AS total FROM users");
$totalUsers = $totalUsersQuery->fetch_assoc()['total'];

$activeUsersQuery = $conn->query("SELECT COUNT(*) AS active FROM users WHERE role = 'user'");
$activeUsers = $activeUsersQuery->fetch_assoc()['active'];

$adminUsersQuery = $conn->query("SELECT COUNT(*) AS total_admins FROM users WHERE role = 'admin'");
$totalAdmins = $adminUsersQuery->fetch_assoc()['total_admins'];

$archivedUsersQuery = $conn->query("SELECT COUNT(*) AS archived FROM archived_users");
$archivedUsers = $archivedUsersQuery->fetch_assoc()['archived'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Admin Dashboard</title>
</head>

<body>

    <header>
        <div class="email-name">
            <h2>Welcome, <?php echo htmlspecialchars($_SESSION['fullname']); ?></h2>
        </div>
        <div class="nav">
            <div class="nav-link">
                <a href="admin-dashboard.php">Dashboard</a>
            </div>
            <div class="nav-link">
                <a href="manage-user.php">Manage Users</a>
            </div>
            <div class="nav-link">
                <a href="archive.php">Archive</a>
            </div>
            <div class="nav-link">
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
        </div>
    </header>

    <div class="dashboard-container">
        <h2>ADMIN DASHBOARD</h2>
        <p class="dashboard-intro">Monitor client accounts and quickly access user management tools.</p>

        <div class="dashboard-content">
            <div class="card">
                <h3>Total Accounts</h3>
                <p><?php echo $totalUsers; ?></p>
            </div>
            <div class="card">
                <h3>Active Clients</h3>
                <p><?php echo $activeUsers; ?></p>
            </div>
            <div class="card">
                <h3>Admins</h3>
                <p><?php echo $totalAdmins; ?></p>
            </div>
            <div class="card">
                <h3>Archived Clients</h3>
                <p><?php echo $archivedUsers; ?></p>
            </div>
        </div>

        <div class="button-container">
            <a href="manage-user.php" class="add-user-btn">Manage Clients</a>
            <a href="add-user.php" class="add-btn">+ Add Client</a>
            <a href="archive.php" class="archive-btn">View Archive</a>
        </div>
    </div>

</body>

</html>