<?php
// functions.php
function getUserInfo($pdo, $userId) {
    $stmt = $pdo->prepare("SELECT username, email FROM users WHERE id = :id");
    $stmt->execute(['id' => $userId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getUserProjects($pdo, $userId) {
    $stmt = $pdo->prepare("SELECT * FROM projects WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getStatistics($pdo) {
    $totalProjects = $pdo->query("SELECT COUNT(*) FROM projects")->fetchColumn();
    $totalUsers = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    return ['totalProjects' => $totalProjects, 'totalUsers' => $totalUsers];
}
?>
