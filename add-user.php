<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}


if (isset($_POST['add'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $sql = "INSERT INTO users (fullname, email, password, role) VALUES ('$fullname', '$email', '$password', '$role')";

    if ($conn->query($sql) === TRUE) {
        header("Location: manage-user.php");
    } else {
        $error = "Error: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Add User</title>
</head>

<body>

    <header>
        <div class="email-name">
            <h2>Welcome, <?php echo $_SESSION['fullname']; ?></h2>
        </div>
        <div class="nav">
            <div class="nav-link">
                <a href="manage-user.php">Back to Manage Users</a>
            </div>
            <div class="nav-link">
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
        </div>
    </header>

    <div class="container">
        <h2>Add User</h2>

        <form method="POST" class="form-container">
            <input type="text" name="fullname" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="role">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            <button type="submit" name="add" class="add-btn">Add User</button>
        </form>

        <?php if (isset($error)) {
            echo "<p class='error-message'>$error</p>";
        } ?>
    </div>

</body>

</html>
