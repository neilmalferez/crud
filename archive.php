<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}


if (isset($_GET['recover'])) {
    $id = $_GET['recover'];


    $user = $conn->query("SELECT * FROM archived_users WHERE id=$id")->fetch_assoc();
    if ($user) {
        $fullname = $user['fullname'];
        $email = $user['email'];
        $password = $user['password'];
        $role = $user['role'];


        $conn->query("INSERT INTO users (fullname, email, password, role) VALUES ('$fullname', '$email', '$password', '$role')");


        $conn->query("DELETE FROM archived_users WHERE id=$id");
    }

    header("Location: archive.php");
    exit();
}


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM archived_users WHERE id=$id");

    header("Location: archive.php");
    exit();
}


$result = $conn->query("SELECT * FROM archived_users");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Archived Users</title>
</head>

<body>

    <header>
        <div class="email-name">
            <h2>Welcome, <?php echo $_SESSION['fullname']; ?></h2>
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
        </div>    </header>

    <div class="container">
        <h2>Archived Users</h2>

        <div class="table-container">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['fullname']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['role']; ?></td>
                        <td>
                            <a href="?recover=<?php echo $row['id']; ?>" class="edit-btn">Recover</a>
                            <a href="?delete=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Permanently delete this user?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>

</body>

</html>
