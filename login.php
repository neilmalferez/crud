<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['fullname'] = $row['fullname'];

            if ($row['role'] == "admin") {
                header("Location: admin-dashboard.php");
            } else {
                header("Location: user-dashboard.php");
            }
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No user found.";
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
    <title>Login</title>
</head>

<body>

    <div class="login-container">
        <h2>Login</h2>

        <form method="POST" class="form-container">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" class="add-btn">Login</button>
        </form>

        <?php if (isset($error)) {
            echo "<p class='error-message'>$error</p>";
        } ?>

        <!-- Register Button -->
        <div class="login-register">
            <p>Don't have an account?</p>
            <a href="register.php" class="register-btn">Register</a>
        </div>
    </div>

</body>

</html>
