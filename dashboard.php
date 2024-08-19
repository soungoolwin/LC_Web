<?php
session_start();

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

// Database connection (replace with your actual DB credentials)
$conn = new mysqli("localhost", "username", "password", "database");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user data
$username = $_SESSION['username'];
$sql = "SELECT * FROM users WHERE username='$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found";
    exit();
}

// Fetch data for display (example: research projects)
$projects = [];
$sql = "SELECT * FROM projects WHERE user_id='" . $user['id'] . "'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $projects[] = $row;
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSU Research Factory Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Welcome to Your Dashboard, <?php echo $user['username']; ?>!</h1>
        <p>This is your central hub for managing your research and profile.</p>

        <div class="dashboard-section">
            <h2>Your Profile</h2>
            <p><strong>Username:</strong> <?php echo $user['username']; ?></p>
            <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
            <a href="edit_profile.php" class="btn">Edit Profile</a>
            <a href="logout.php" class="btn">Logout</a>
        </div>

        <div class="dashboard-section">
            <h2>Your Research Projects</h2>
            <?php if (count($projects) > 0): ?>
                <ul>
                    <?php foreach ($projects as $project): ?>
                        <li>
                            <strong><?php echo $project['title']; ?></strong> 
                            <p><?php echo $project['description']; ?></p>
                            <a href="edit_project.php?id=<?php echo $project['id']; ?>" class="btn">Edit</a>
                            <a href="delete_project.php?id=<?php echo $project['id']; ?>" class="btn">Delete</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>You have no research projects yet.</p>
            <?php endif; ?>
            <a href="add_project.php" class="btn">Add New Project</a>
        </div>

        <div class="dashboard-section">
            <h2>Global Research Statistics</h2>
            <p>Here you can view aggregated research data from all users.</p>
            <!-- Example of statistical data -->
            <p>Total Projects: 125</p>
            <p>Total Users: 50</p>
            <!-- You can add more detailed statistics and graphs here -->
        </div>

        <div class="dashboard-section">
            <h2>Account Settings</h2>
            <a href="change_password.php" class="btn">Change Password</a>
            <a href="delete_account.php" class="btn">Delete Account</a>
        </div>
    </div>
</body>
</html>
