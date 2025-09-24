<?php
require 'config.php';
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usernameOrEmail = strtolower(trim($_POST["username"]));
    $password = $_POST["password"];

    // The SELECT * query will automatically fetch the new 'role' column
    $stmt = $pdo->prepare("
        SELECT * FROM users 
        WHERE username = ? OR email = ?
    ");
    $stmt->execute([$usernameOrEmail, $usernameOrEmail]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user["password"])) {
        // Set session variables upon successful login
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["role"] = $user["role"]; // <-- TASK 4 CHANGE: Store user's role
        
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "❌ Invalid username/email or password!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="register-container">
    <h2>Login</h2>

    <?php if (!empty($error)): ?>
        <div class="error" style="color: red; margin-bottom: 15px;"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="post">
        <input type="text" name="username" placeholder="Username or Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Login">
    </form>

    <p>Don’t have an account? <a href="register.php">Register here</a></p>
</div>
</body>
</html>
