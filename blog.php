<?php
require_once __DIR__ . '/includes/db.php';

$id = intval($_GET['id'] ?? 0);
$blog = null;
if ($id > 0) {
    $stmt = $conn->prepare("SELECT * FROM blogs WHERE id = ? LIMIT 1");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $blog = $stmt->get_result()->fetch_assoc();
}
if (!$blog) {
    header('HTTP/1.1 404 Not Found');
    $title = 'Blog not found';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $blog ? htmlspecialchars($blog['title']) : 'Blog not found'; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header class="site-header">
        <div class="container header-inner">
            <div>
                <h1>JobYaari Blog</h1>
            </div>
            <nav>
                <a href="index.php">Home</a>
                <a href="admin/login.php">Admin</a>
            </nav>
        </div>
    </header>

    <main class="container blog-detail">
        <?php if (!$blog): ?>
            <section class="detail-notice">
                <h2>Blog not found</h2>
                <p>The blog you are looking for does not exist or has been removed.</p>
                <a class="button" href="index.php">Back to listings</a>
            </section>
        <?php else: ?>
            <article>
                <span class="blog-category"><?php echo htmlspecialchars($blog['category']); ?></span>
                <h2><?php echo htmlspecialchars($blog['title']); ?></h2>
                <p class="blog-date"><?php echo htmlspecialchars(date('F j, Y', strtotime($blog['date']))); ?></p>
                <div class="detail-image">
                    <img src="<?php echo htmlspecialchars($blog['image'] ?: 'https://via.placeholder.com/1200x600?text=Blog+Image'); ?>" alt="<?php echo htmlspecialchars($blog['title']); ?>">
                </div>
                <div class="detail-content">
                    <?php echo nl2br(htmlspecialchars($blog['content'])); ?>
                </div>
                <a class="button" href="index.php">Back to Blog List</a>
            </article>
        <?php endif; ?>
    </main>

    <footer class="site-footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> JobYaari Blog.</p>
        </div>
    </footer>
</body>
</html>
