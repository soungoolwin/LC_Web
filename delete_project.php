<?php
session_start();
require 'includes/db.php';

$userId = $_SESSION['user_id'] ?? 1;
$projectId = $_GET['id'] ?? null;

if ($projectId) {
    $stmt = $pdo->prepare("DELETE FROM projects WHERE id = :id AND user_id = :user_id");
    $stmt->execute(['id' => $projectId, 'user_id' => $userId]);
}

header('Location: dashboard.php');
exit;
?>
