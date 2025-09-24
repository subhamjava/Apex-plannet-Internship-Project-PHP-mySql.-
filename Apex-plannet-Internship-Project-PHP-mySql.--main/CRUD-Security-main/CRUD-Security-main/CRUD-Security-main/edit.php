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

$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST["title"]);
    $content = trim($_POST["content"]);

    if (empty($title) || empty($content)) {
        $error = "All fields are required.";
    } else {
        $stmt = $pdo->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
        if ($stmt->execute([$title, $content, $id])) {
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Failed to update post.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Edit Post</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="edit-form-container">
  <h2>Edit Post</h2>
  <?php if ($error): ?><div style="color:red; margin-bottom: 15px;"><?php echo $error; ?></div><?php endif; ?>

  <form method="post">
    <div class="form-group">
      <label>Title</label>
      <input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
    </div>
    <div class="form-group">
      <label>Content</label>
      <textarea name="content" rows="6" required><?php echo htmlspecialchars($post['content']); ?></textarea>
    </div>
    <button type="submit" class="update-btn">Update</button>
  </form>
</div>
    <!-- Developed by @Ritesh Kumar Jena -->
</body>
</html>

