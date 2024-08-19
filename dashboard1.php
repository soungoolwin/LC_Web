<?php
session_start();
require 'includes/db.php';
require 'includes/functions.php';

// Example user ID for demonstration; you should retrieve this from the session
$userId = $_SESSION['user_id'] ?? 1; // This assumes the user is logged in and has an ID of 1.

$userInfo = getUserInfo($pdo, $userId);
$userProjects = getUserProjects($pdo, $userId);
$statistics = getStatistics($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - RSU Research Factory</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 80%; margin: 0 auto; }
        h1 { text-align: center; margin-bottom: 20px; }
        .profile, .projects, .statistics, .settings { margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        a { color: blue; text-decoration: none; }
        a:hover { text-decoration: underline; }
        .actions { display: flex; gap: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Dashboard - RSU Research Factory</h1>

        <!-- User Profile Section -->
        <div class="profile">
            <h2>User Profile</h2>
            <p><strong>Username:</strong> <?= htmlspecialchars($userInfo['username']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($userInfo['email']) ?></p>
            <div class="actions">
                <a href="edit_profile.php">Edit Profile</a> | 
                <a href="logout.php">Logout</a>
            </div>
        </div>

        <!-- Research Projects Section -->
        <div class="projects">
            <h2>Your Research Projects</h2>
            <?php if (count($userProjects) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Project Title</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($userProjects as $project): ?>
                            <tr>
                                <td><?= htmlspecialchars($project['title']) ?></td>
                                <td><?= htmlspecialchars($project['description']) ?></td>
                                <td>
                                    <a href="edit_project.php?id=<?= $project['id'] ?>">Edit</a> | 
                                    <a href="delete_project.php?id=<?= $project['id'] ?>" onclick="return confirm('Are you sure you want to delete this project?');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>You have no projects yet.</p>
            <?php endif; ?>
            <div class="actions">
                <a href="add_project.php">Add New Project</a>
            </div>
        </div>

        <!-- Global Research Statistics -->
        <div class="statistics">
            <h2>Global Research Statistics</h2>
            <p><strong>Total Projects:</strong> <?= $statistics['totalProjects'] ?></p>
            <p><strong>Total Users:</strong> <?= $statistics['totalUsers'] ?></p>
            <!-- Expand this section with charts or graphs if needed -->
        </div>

        <!-- Account Settings Section -->
        <div class="settings">
            <h2>Account Settings</h2>
            <div class="actions">
                <a href="change_password.php">Change Password</a> | 
                <a href="delete_account.php" onclick="return confirm('Are you sure you want to delete your account?');">Delete Account</a>
            </div>
        </div>
    </div>
</body>
</html>
