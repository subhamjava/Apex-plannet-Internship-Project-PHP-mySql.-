<?php
require 'config.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Validate post ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid request.");
}

$id = (int)$_GET['id'];

// Fetch post
$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch();

if (!$post) {
    die("Post not found.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>View Post</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="view-container">
    <h2><?php echo htmlspecialchars($post['title']); ?></h2>
    <p><strong>Created at:</strong> <?php echo $post['created_at']; ?></p>
    <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
    <div class="back-container">
    <a class="btn back-btn" href="dashboard.php">⬅ Back to Dashboard</a>
     </div>
</div>
    <!-- Developed by @Ritesh Kumar Jena -->
</body>
</html>

