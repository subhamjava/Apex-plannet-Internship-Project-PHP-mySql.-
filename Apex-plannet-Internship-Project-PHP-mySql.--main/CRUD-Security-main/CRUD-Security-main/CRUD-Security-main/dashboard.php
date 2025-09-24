<?php
require 'config.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Pagination setup
$limit = 5; // posts per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Search setup
$search = "";
$params = [];
$query = "SELECT p.*, u.username FROM posts p JOIN users u ON p.user_id = u.id WHERE 1"; // Join to get username

if (!empty($_GET['search'])) {
    $search = trim($_GET['search']);
    $query .= " AND (p.title LIKE ? OR p.content LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

// Count total posts for pagination
$countQuery = preg_replace('/SELECT p\.\*, u\.username/', 'SELECT COUNT(*) as total', $query);
$stmt = $pdo->prepare($countQuery);
$stmt->execute($params);
$totalPosts = $stmt->fetch()["total"];
$totalPages = ceil($totalPosts / $limit);

// Fetch posts with search + pagination
$query .= " ORDER BY p.created_at DESC LIMIT $limit OFFSET $offset";
$stmt = $pdo->prepare($query);
$stmt->execute($params);
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
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

    <form method="get" class="search-form">
        <input type="text" name="search" placeholder="Search posts..." value="<?= htmlspecialchars($search) ?>">
        <button type="submit">Search</button>
    </form>

    <a href="create.php" class="add-btn">+ Add New Post</a>

    <table>
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
        <?php if ($posts): ?>
            <?php foreach ($posts as $post): ?>
                <tr>
                    <td><?= htmlspecialchars($post["title"]) ?></td>
                    <td><?= htmlspecialchars($post["username"]) ?></td>
                    <td><?= date("Y-m-d", strtotime($post["created_at"])) ?></td>
                    <td class="action-btns">
                        <a href="view.php?id=<?= $post['id']; ?>" class="btn-view">View</a>
                        
                        <!-- TASK 4: Conditional Buttons -->
                        <?php
                        $isOwner = ($post["user_id"] == $_SESSION["user_id"]);
                        $isAdmin = (isset($_SESSION["role"]) && $_SESSION["role"] === 'admin');
                        if ($isOwner || $isAdmin):
                        ?>
                            <a href="edit.php?id=<?= $post["id"] ?>" class="edit-btn">Edit</a>
                            <a href="delete.php?id=<?= $post["id"] ?>" class="delete-btn">Delete</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="4">No posts found.</td></tr>
        <?php endif; ?>
    </table>

    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page-1 ?>&search=<?= urlencode($search) ?>" class="page-btn">Prev</a>
        <?php endif; ?>
        <span>Page <?= $page ?> of <?= $totalPages ?></span>
        <?php if ($page < $totalPages): ?>
            <a href="?page=<?= $page+1 ?>&search=<?= urlencode($search) ?>" class="page-btn">Next</a>
        <?php endif; ?>
    </div>
</div>
<!-- Developed by @Ritesh Kumar Jena -->
</body>
</html>