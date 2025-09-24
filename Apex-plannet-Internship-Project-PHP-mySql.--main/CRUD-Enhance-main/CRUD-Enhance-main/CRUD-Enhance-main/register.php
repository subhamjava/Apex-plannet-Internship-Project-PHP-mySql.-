<?php
require 'config.php';
session_start();

$errors = [];
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // always lowercase + trim
    $username = strtolower(trim($_POST["username"]));
    $email    = strtolower(trim($_POST["email"]));
    $password = $_POST["password"];
    $confirm  = $_POST["confirm"];

    // confirm password check
    if ($password !== $confirm) {
        $errors[] = "Passwords do not match!";
    } else {
        // check duplicates
        $stmt = $pdo->prepare("
            SELECT * FROM users 
            WHERE username = ? OR email = ?
        ");
        $stmt->execute([$username, $email]);
        $existingUser = $stmt->fetch();

        if ($existingUser) {
            $errors[] = "⚠️ Username or Email already exists!";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            if ($stmt->execute([$username, $email, $hashedPassword])) {
                $success = "✅ Registration successful! <a href='login.php'>Login here</a>.";
            } else {
                $errors[] = "❌ Something went wrong. Try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="register-container">
    <h2>Create Account</h2>

    <?php if (!empty($errors)): ?>
        <div class="error"><?php echo implode("<br>", $errors); ?></div>
    <?php endif; ?>
    <?php if (!empty($success)): ?>
        <div class="success"><?php echo $success; ?></div>
    <?php endif; ?>

    <form method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm" placeholder="Confirm Password" required>
        <input type="submit" value="Register">
    </form>

    <p>Already registered? <a href="login.php">Login here</a></p>
</div>
   <!-- Developed by @Ritesh Kumar Jena -->
</body>
</html>
