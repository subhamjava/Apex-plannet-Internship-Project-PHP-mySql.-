<?php
require_once "config.php";
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET["id"])) {
    header("Location: dashboard.php");
    exit;
}

$id = intval($_GET["id"]);

// Fetch post
$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch();

// --- TASK 4: Role-Based Access Control ---
$isOwner = ($post && $post["user_id"] == $_SESSION["user_id"]);
$isAdmin = (isset($_SESSION["role"]) && $_SESSION["role"] === 'admin');

if (!$isOwner && !$isAdmin) {
    die("❌ Unauthorized access. You do not have permission to perform this action.");
}
// --- End Access Control ---

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["confirm"])) {
        $stmt = $pdo->prepare("DELETE FROM posts WHERE id = ?");
        $stmt->execute([$id]);
    }
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Delete Post</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="delete-container">
  <h2>Delete Post</h2>
  <p>Are you sure you want to delete: <strong><?php echo htmlspecialchars($post["title"]); ?></strong>?</p>
  <form method="post" class="delete-buttons">
    <button type="submit" name="confirm" class="confirm-delete">Yes, Delete</button>
    <a href="dashboard.php" class="cancel-btn">Cancel</a>
  </form>
</div>
</body>
</html>