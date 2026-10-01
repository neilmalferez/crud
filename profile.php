<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}

$userId = (int) $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT id, fullname, email, role FROM users WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $userId);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Profile</title>
</head>

<body class="user-page">

    <header>
        <div class="email-name">
            <h2>Welcome, <?php echo htmlspecialchars($user['fullname']); ?></h2>
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

    <main class="page-panel user-panel">
        <div class="panel-heading">
            <p>Account Profile</p>
            <h1>Profile</h1>
        </div>

        <section class="profile-card">
            <div class="profile-avatar">
                <?php echo strtoupper(substr($user['fullname'], 0, 1)); ?>
            </div>
            <div class="profile-info">
                <h2><?php echo htmlspecialchars($user['fullname']); ?></h2>
                <p><?php echo ucfirst(htmlspecialchars($user['role'])); ?> Account</p>
            </div>
        </section>

        <ul class="detail-list profile-details">
            <li><span>User ID</span><strong>#<?php echo (int) $user['id']; ?></strong></li>
            <li><span>Full Name</span><strong><?php echo htmlspecialchars($user['fullname']); ?></strong></li>
            <li><span>Email</span><strong><?php echo htmlspecialchars($user['email']); ?></strong></li>
            <li><span>Role</span><strong><?php echo ucfirst(htmlspecialchars($user['role'])); ?></strong></li>
        </ul>

        <div class="button-group">
            <a href="user-dashboard.php" class="cancel-btn">Back to Dashboard</a>
            <a href="settings.php" class="add-user-btn">Go to Settings</a>
        </div>
    </main>

</body>

</html>