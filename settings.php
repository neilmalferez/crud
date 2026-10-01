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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Settings</title>
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

    <main class="page-panel user-panel">
        <div class="panel-heading">
            <p>Account Controls</p>
            <h1>Settings</h1>
        </div>
        <p>Your account settings route is connected. Use this page to review account preferences and session actions.</p>

        <section class="settings-grid">
            <article class="settings-card">
                <h3>Profile Information</h3>
                <p>View the name and email address attached to your account.</p>
                <a href="profile.php" class="add-user-btn">View Profile</a>
            </article>
            <article class="settings-card">
                <h3>Signed-in Email</h3>
                <p><?php echo htmlspecialchars($email); ?></p>
                <span class="status-pill">Active</span>
            </article>
            <article class="settings-card">
                <h3>Session</h3>
                <p>End your current session when you are finished using the system.</p>
                <a href="logout.php" class="delete-btn">Logout</a>
            </article>
        </section>
    </main>

</body>

</html>