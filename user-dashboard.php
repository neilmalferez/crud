<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}

$userId = (int) $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT fullname, email, role FROM users WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $userId);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$fullname = $user ? $user['fullname'] : $_SESSION['fullname'];
$email = $user ? $user['email'] : 'Not available';
$role = $user ? $user['role'] : $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>User Dashboard</title>
</head>

<body class="user-page">

    <header>
        <div class="email-name">
            <h2>Welcome, <?php echo htmlspecialchars($fullname); ?></h2>
        </div>
        <div class="nav">
            <div class="nav-link">
                <a href="user-dashboard.php">Dashboard</a>
            </div>
            <div class="nav-link">
                <a href="profile.php">Profile</a>
            </div>
            <div class="nav-link">
                <a href="settings.php">Settings</a>
            </div>
            <div class="nav-link">
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
        </div>
    </header>

    <main class="dashboard-container user-panel">
        <div class="panel-heading">
            <p>User Area</p>
            <h2>USER DASHBOARD</h2>
        </div>
        <p class="dashboard-intro">Review your account summary and quickly access your profile and settings.</p>

        <div class="dashboard-content user-card-grid">
            <div class="card">
                <h3>Account Status</h3>
                <p>Active</p>
            </div>
            <div class="card">
                <h3>Role</h3>
                <p><?php echo ucfirst(htmlspecialchars($role)); ?></p>
            </div>
            <div class="card">
                <h3>Profile</h3>
                <p>Ready</p>
            </div>
        </div>

        <section class="user-summary">
            <div>
                <h3>Account Details</h3>
                <ul class="detail-list">
                    <li><span>Full Name</span><strong><?php echo htmlspecialchars($fullname); ?></strong></li>
                    <li><span>Email</span><strong><?php echo htmlspecialchars($email); ?></strong></li>
                    <li><span>Account Type</span><strong><?php echo ucfirst(htmlspecialchars($role)); ?></strong></li>
                </ul>
            </div>
            <div class="quick-actions">
                <h3>Quick Actions</h3>
                <a href="profile.php" class="add-user-btn">View Profile</a>
                <a href="settings.php" class="add-btn">Open Settings</a>
            </div>
        </section>
    </main>

</body>

</html>