<?php
require_once __DIR__ . '/../includes/auth.php';
requireAdmin();
require_once __DIR__ . '/../includes/db.php';

$blogCountResult = $conn->query('SELECT COUNT(*) AS total FROM blogs');
$blogCount = $blogCountResult->fetch_assoc()['total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | JobYaari Blog</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header class="site-header">
        <div class="container header-inner">
            <div>
                <h1>Admin Dashboard</h1>
                <p>Welcome back, <?php echo htmlspecialchars(adminName()); ?>.</p>
            </div>
            <nav>
                <a href="blogs.php">Blog Management</a>
                <a href="add.php">Add Blog</a>
                <a href="logout.php">Logout</a>
            </nav>
        </div>
    </header>

    <main class="container blog-detail">
        <article>
            <h2>Blog management summary</h2>
            <p>Total blogs published: <strong><?php echo intval($blogCount); ?></strong></p>
            <p>Use the links above to manage blog posts quickly and securely.</p>
            <div style="margin-top: 28px; display:flex; gap:16px; flex-wrap:wrap;">
                <a class="button" href="blogs.php">View All Blogs</a>
                <a class="button" href="add.php">Add New Blog</a>
            </div>
        </article>
    </main>
</body>
</html>
