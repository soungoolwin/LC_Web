<?php
session_start();
require 'includes/db.php';

$userId = $_SESSION['user_id'] ?? 1;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    
    $stmt = $pdo->prepare("UPDATE users SET username = :username, email = :email WHERE id = :id");
    $stmt->execute(['username' => $username, 'email' => $email, 'id' => $userId]);

    header('Location: dashboard.php');
    exit;
}

$stmt = $pdo->prepare("SELECT username, email FROM users WHERE id = :id");
$stmt->execute(['id' => $userId]);
$userInfo = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - RSU Research Factory</title>
</head>
<body>
    <h1>Edit Profile</h1>
    <form method="post">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" value="<?= htmlspecialchars($userInfo['username']) ?>"><br><br>
        
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($userInfo['email']) ?>"><br><br>
        
        <input type="submit" value="Save Changes">
    </form>
    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
