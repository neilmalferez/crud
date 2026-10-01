<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}


if (!isset($_GET['id'])) {
    header("Location: manage-user.php");
    exit();
}

$id = $_GET['id'];


$user = $conn->query("SELECT * FROM users WHERE id=$id")->fetch_assoc();

if (!$user) {
    header("Location: manage-user.php");
    exit();
}

$error = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $sql = "UPDATE users SET fullname='$fullname', email='$email', role='$role' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: manage-user.php");
        exit();
    } else {
        $error = "Error updating user: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Edit User</title>
</head>

<body>

    <header>
        <div class="email-name">
            <h2>Welcome, <?php echo $_SESSION['fullname']; ?></h2>
        </div>
        <div class="nav">
            <div class="nav-link">
                <a href="manage-user.php">Manage Users</a>
            </div>
            <div class="nav-link">
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
        </div>
    </header>

    <div class="container">
        <h2>Edit User</h2>

        <form method="POST" class="form-container">
            <input type="text" name="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>" required>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            <select name="role">
                <option value="user" <?php if ($user['role'] == 'user') echo 'selected'; ?>>User</option>
                <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
            </select>

            <div class="button-group">
                <a href="manage-user.php" class="cancel-btn">Cancel</a>
                <button type="submit" class="add-btn">Update</button>
            </div>
        </form>

        <?php if (!empty($error)) {
            echo "<p class='error-message'>$error</p>";
        } ?>
    </div>

</body>

</html>
