<?php
require_once __DIR__ . '/../includes/auth.php';
requireAdmin();
require_once __DIR__ . '/../includes/db.php';

$result = $conn->query('SELECT * FROM blogs ORDER BY date DESC');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Blogs | Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>.admin-table{width:100%;border-collapse:collapse;margin-top:20px;}.admin-table th,.admin-table td{padding:12px 14px;border:1px solid #e5e7eb;text-align:left;}.admin-table th{background:#f3f4f6;}.admin-actions a{margin-right:12px;}.admin-note{margin-top: 8px;color:#475569;}</style>
</head>
<body>
    <header class="site-header">
        <div class="container header-inner">
            <div>
                <h1>Blog Manager</h1>
                <p>Manage all blog posts from here.</p>
            </div>
            <nav>
                <a href="dashboard.php">Dashboard</a>
                <a href="add.php">Add Blog</a>
                <a href="logout.php">Logout</a>
            </nav>
        </div>
    </header>

    <main class="container blog-detail">
        <article>
            <h2>All Blogs</h2>
            <p class="admin-note">Click Edit to update a blog or Delete to remove it permanently.</p>
            <?php if ($result->num_rows === 0): ?>
                <div class="no-results">No blogs found. Add your first blog.</div>
            <?php else: ?>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($blog = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($blog['title']); ?></td>
                                <td><?php echo htmlspecialchars($blog['category']); ?></td>
                                <td><?php echo htmlspecialchars(date('F j, Y', strtotime($blog['date']))); ?></td>
                                <td class="admin-actions">
                                    <a class="button" href="edit.php?id=<?php echo urlencode($blog['id']); ?>">Edit</a>
                                    <a class="button" style="background:#dc2626;" href="delete.php?id=<?php echo urlencode($blog['id']); ?>" onclick="return confirm('Delete this blog?');">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </article>
    </main>
</body>
</html>
