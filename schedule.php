<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
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
    <title>Schedule</title>
</head>

<body>
    <header>
        <div class="email-name">
            <h2>Welcome, <?php echo htmlspecialchars($_SESSION['fullname']); ?></h2>
        </div>
        <div class="nav">
            <div class="nav-link"><a href="admin-dashboard.php">Dashboard</a></div>
            <div class="nav-link"><a href="manage-user.php">Manage Users</a></div>
            <div class="nav-link"><a href="logout.php" class="logout-btn">Logout</a></div>
        </div>
    </header>

    <main class="page-panel">
        <h1>Schedule</h1>
        <p>This route is now connected. Add schedule details here when the scheduling module is ready.</p>
    </main>
</body>

</html>
