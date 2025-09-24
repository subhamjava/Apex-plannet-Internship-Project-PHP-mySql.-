<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logout</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="logout-container">
        <h2>You have been logged out</h2>
        <p>Thank you for visiting.</p>
        <a href="login.php" class="login-again-btn">Login Again</a>
    </div>
</body>
</html>
