<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];


    $user = $conn->query("SELECT * FROM users WHERE id=$id")->fetch_assoc();
    if ($user) {
        $fullname = $user['fullname'];
        $email = $user['email'];
        $password = $user['password'];
        $role = $user['role'];


        $conn->query("INSERT INTO archived_users (fullname, email, password, role) VALUES ('$fullname', '$email', '$password', '$role')");


        $conn->query("DELETE FROM users WHERE id=$id");
    }

    header("Location: manage-user.php");
    exit();
}


$result = $conn->query("SELECT * FROM users");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Manage Users</title>
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
        <h2>MANAGE CLIENTS</h2>

        <div class="button-container">
            <a href="add-user.php" class="add-user-btn">+ Add Client</a>
            <a href="archive.php" class="archive-btn">Archive</a>
        </div>

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
                            <a href="edit-user.php?id=<?php echo $row['id']; ?>" class="edit-btn">Edit</a>
                            <a href="delete.php?id=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this client?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>

</body>

</html>
