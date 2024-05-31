<?php
session_start();
require_once 'user.php';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logged In</title>
    
</head>
<body>
    <div class="welcome-container">
        <h2>Welcome, <?php echo $_POST['username'] ?>!</h2>
        <p><a href="logout.php">Logout</a></p>
    </div>
</body>
</html>