<?php
session_start();
require 'includes/db.php';

$userId = $_SESSION['user_id'] ?? 1;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Delete user projects first
    $stmt = $pdo->prepare("DELETE FROM projects WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $userId]);

    // Delete user account
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
    $stmt->execute(['id' => $userId]);

    // Log out the user and redirect
    session_destroy();
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Account - RSU Research Factory</title>
</head>
<body>
    <h1>Delete Account</h1>
    <form method="post">
        <p>Are you sure you want to delete your account? This action is irreversible.</p>
        <input type="submit" value="Delete Account">
    </form>
    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
