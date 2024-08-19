<?php
session_start();
require 'includes/db.php';

$userId = $_SESSION['user_id'] ?? 1;
$projectId = $_GET['id'] ?? null;

if (!$projectId) {
    header('Location: dashboard.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM projects WHERE id = :id AND user_id = :user_id");
$stmt->execute(['id' => $projectId, 'user_id' => $userId]);
$project = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    
    $stmt = $pdo->prepare("UPDATE projects SET title = :title, description = :description WHERE id = :id AND user_id = :user_id");
    $stmt->execute(['title' => $title, 'description' => $description, 'id' => $projectId, 'user_id' => $userId]);

    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Project - RSU Research Factory</title>
</head>
<body>
    <h1>Edit Project</h1>
    <form method="post">
        <label for="title">Project Title:</label><br>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($project['title']) ?>"><br><br>
        
        <label for="description">Project Description:</label><br>
        <textarea id="description" name="description"><?= htmlspecialchars($project['description']) ?></textarea><br><br>
        
        <input type="submit" value="Save Changes">
    </form>
    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
