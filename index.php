<?php
session_start();

require_once 'user.php';


// Redirect to login.php if the user is not authenticated
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header('Location: login.php');
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    
</head>
<body>
    <div class="welcome-container">
        <h2>Welcome, <?= $_SESSION['username'] ?>!</h2>
        <p>Hope you're doing well</p>
        <p><a href="logout.php">Logout</a></p>
    </div>
</body>
</html>