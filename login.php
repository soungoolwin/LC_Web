<?php

session_start();

$pdo = new PDO("mysql:host=localhost;dbname=database", "username", "password");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Example credentials (replace with your database verification)
    $correct_username = "admin";
    $correct_password = "password";

    if ($username == $correct_username && $password == $correct_password) {
        $_SESSION['username'] = $username;
        header("Location: dashboard1.php");
    } else {
        echo "<script>alert('Incorrect username or password');</script>";
    }
}
?>
