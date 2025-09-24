<?php
require_once "config.php";
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST["title"]);
    $content = trim($_POST["content"]);

    if (empty($title) || empty($content)) {
        $error = "All fields are required.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO posts (user_id, title, content) VALUES (?, ?, ?)");
        if ($stmt->execute([$_SESSION["user_id"], $title, $content])) {
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Failed to create post.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Create Post</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="form-container">
  <h2>Create New Post</h2>
  <?php if ($error): ?><div style="color:red;"><?php echo $error; ?></div><?php endif; ?>

  <form method="post">
    <div class="form-group">
      <label>Title</label>
      <input type="text" name="title" required>
    </div>
    <div class="form-group">
      <label>Content</label>
      <textarea name="content" rows="6" required></textarea>
    </div>
    <button type="submit" class="submit-btn">Create</button>
  </form>
</div>
</body>
</html>
