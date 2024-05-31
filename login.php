<?php
session_start();

require_once 'config.php';

try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE . ";port=" . DB_PORT;
    $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    );

    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$login_error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the user exists and get the hashed password
    $sql = "SELECT id, password FROM users WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch();
        if (password_verify($password, $user['password'])) {
            $_SESSION['authenticated'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $username;
            header('Location: index.php');
            exit();
        } else {
            $login_error = "Invalid username or password.";
            if (!isset($_SESSION['failed_attempts'])) {
                $_SESSION['failed_attempts'] = 1;
            } else {
                $_SESSION['failed_attempts'] = $_SESSION['failed_attempts'] + 1;
            }
        }
    } else {
        $login_error = "Invalid username or password.";
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
        
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (!empty($login_error)): ?>
            <p class="error"><?php echo htmlspecialchars($login_error); ?></p>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p><a href="new.php">Don't have an account? Register here</a></p>
    </div>
</body>
</html>