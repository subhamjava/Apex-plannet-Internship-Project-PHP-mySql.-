<?php
require 'config.php';
session_start();

$errors = [];
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = strtolower(trim($_POST["username"]));
    $email    = strtolower(trim($_POST["email"]));
    $password = $_POST["password"];
    $confirm  = $_POST["confirm"];

    // --- TASK 4: Enhanced Server-Side Validation ---
    if (strlen($username) < 4) {
        $errors[] = "Username must be at least 4 characters long.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    }
    if ($password !== $confirm) {
        $errors[] = "Passwords do not match!";
    }
    // --- End Validation ---

    if (empty($errors)) {
        // Check for duplicates
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        if ($stmt->fetch()) {
            $errors[] = "⚠️ Username or Email already exists!";
        } else {
            // All checks passed, insert the user
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
        <div class="error" style="color: red; margin-bottom: 15px;"><?php echo implode("<br>", $errors); ?></div>
    <?php endif; ?>
    <?php if (!empty($success)): ?>
        <div class="success" style="color: green; margin-bottom: 15px;"><?php echo $success; ?></div>
    <?php endif; ?>

    <form method="post">
        <input type="text" name="username" placeholder="Username" required minlength="4">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password (min 8 chars)" required minlength="8">
        <input type="password" name="confirm" placeholder="Confirm Password" required>
        <input type="submit" value="Register">
    </form>

    <p>Already registered? <a href="login.php">Login here</a></p>
</div>
</body>
</html>
