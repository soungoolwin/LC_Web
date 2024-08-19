<?php
session_start();
require 'includes/db.php';

$userId = $_SESSION['user_id'] ?? 1;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    
    $stmt = $pdo->prepare("INSERT INTO projects (user_id, title, description) VALUES (:user_id, :title, :description)");
    $stmt->execute(['user_id' => $userId, 'title' => $title, 'description' => $description]);

    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Project - RSU Research Factory</title>
</head>
<body>
    <h1>Add New Project</h1>
    <form method="post">
        <label for="title">Project Title:</label><br>
        <input type="text" id="title" name="title"><br><br>
        
        <label for="description">Project Description:</label><br>
        <textarea id="description" name="description"></textarea><br><br>
        
        <input type="submit" value="Add Project">
    </form>
    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
