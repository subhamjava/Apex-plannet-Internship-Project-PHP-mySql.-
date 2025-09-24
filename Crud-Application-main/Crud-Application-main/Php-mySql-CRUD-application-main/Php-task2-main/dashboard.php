<?php
require_once "config.php";
session_start();

// Redirect if not logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// Fetch posts (with author info)
$stmt = $pdo->query("SELECT posts.*, users.username FROM posts 
                     JOIN users ON posts.user_id = users.id 
                     ORDER BY posts.created_at DESC");
$posts = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="dashboard-container">
  <div class="dashboard-header">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?></h2>
    <a href="logout.php" class="logout-btn">Logout</a>
  </div>

  <a href="create.php" class="add-btn">+ Add New Post</a>

  <table>
    <tr>
      <th>Title</th>
      <th>Author</th>
      <th>Created</th>
      <th>Actions</th>
    </tr>
    <?php foreach ($posts as $post): ?>
      <tr>
        <td><?php echo htmlspecialchars($post["title"]); ?></td>
        <td><?php echo htmlspecialchars($post["username"]); ?></td>
        <td><?php echo $post["created_at"]; ?></td>
        <td class="action-btns">
          <?php if ($post["user_id"] == $_SESSION["user_id"]): ?>
            <a href="edit.php?id=<?php echo $post["id"]; ?>" class="edit-btn">Edit</a>
            <a href="delete.php?id=<?php echo $post["id"]; ?>" class="delete-btn">Delete</a>
          <?php else: ?>
            <span style="color:#888;">No actions</span>
          <?php endif; ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
</div>
    <!--Developed by @Ritesh Kumar Jena -->
</body>
</html>

