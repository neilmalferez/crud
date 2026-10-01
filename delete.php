<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$id = isset($_GET['id']) ? (int) $_GET['id'] : (isset($_GET['delete']) ? (int) $_GET['delete'] : 0);

if ($id <= 0) {
    header("Location: manage-user.php");
    exit();
}

$stmt = $conn->prepare("SELECT fullname, email, password, role FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if ($user) {
    $archive = $conn->prepare("INSERT INTO archived_users (fullname, email, password, role) VALUES (?, ?, ?, ?)");
    $archive->bind_param("ssss", $user['fullname'], $user['email'], $user['password'], $user['role']);
    $archive->execute();
    $archive->close();

    $delete = $conn->prepare("DELETE FROM users WHERE id = ?");
    $delete->bind_param("i", $id);
    $delete->execute();
    $delete->close();
}

$conn->close();

header("Location: manage-user.php");
exit();
?>
