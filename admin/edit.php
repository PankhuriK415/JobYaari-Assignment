<?php
require_once __DIR__ . '/../includes/auth.php';
requireAdmin();
require_once __DIR__ . '/../includes/db.php';

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    header('Location: blogs.php');
    exit;
}

$stmt = $conn->prepare('SELECT * FROM blogs WHERE id = ? LIMIT 1');
$stmt->bind_param('i', $id);
$stmt->execute();
$blog = $stmt->get_result()->fetch_assoc();
if (!$blog) {
    header('Location: blogs.php');
    exit;
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $shortDescription = trim($_POST['short_description'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $date = trim($_POST['date'] ?? date('Y-m-d'));
    $imagePath = $blog['image'];

    if (!empty($_FILES['image']['name'])) {
        $uploadDir = __DIR__ . '/../uploads/';
        $source = $_FILES['image']['tmp_name'];
        $filename = basename($_FILES['image']['name']);
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($ext, $allowed)) {
            $safeName = 'blog_' . time() . '_' . preg_replace('/[^a-zA-Z0-9\-_.]/', '_', $filename);
            $destination = $uploadDir . $safeName;
            if (move_uploaded_file($source, $destination)) {
                $imagePath = 'uploads/' . $safeName;
            }
        }
    }

    $update = $conn->prepare('UPDATE blogs SET title = ?, short_description = ?, content = ?, category = ?, image = ?, date = ? WHERE id = ?');
    $update->bind_param('ssssssi', $title, $shortDescription, $content, $category, $imagePath, $date, $id);
    if ($update->execute()) {
        header('Location: blogs.php');
        exit;
    }
    $message = 'Unable to update blog. Please verify all fields.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog | Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header class="site-header">
        <div class="container header-inner">
            <div>
                <h1>Edit Blog</h1>
                <p>Update the blog content, category or image.</p>
            </div>
            <nav>
                <a href="dashboard.php">Dashboard</a>
                <a href="blogs.php">All Blogs</a>
                <a href="logout.php">Logout</a>
            </nav>
        </div>
    </header>

    <main class="container blog-detail">
        <article>
            <?php if ($message): ?>
                <div class="no-results" style="background:#fee2e2;color:#b91c1c;"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            <form action="" method="post" enctype="multipart/form-data" class="admin-form">
                <label>Title</label>
                <input type="text" name="title" required value="<?php echo htmlspecialchars($blog['title']); ?>">
                <label>Short Description</label>
                <textarea name="short_description" required rows="3"><?php echo htmlspecialchars($blog['short_description']); ?></textarea>
                <label>Content</label>
                <textarea name="content" required rows="8"><?php echo htmlspecialchars($blog['content']); ?></textarea>
                <label>Category</label>
                <input type="text" name="category" required value="<?php echo htmlspecialchars($blog['category']); ?>">
                <label>Blog Date</label>
                <input type="date" name="date" value="<?php echo htmlspecialchars($blog['date']); ?>" required>
                <label>Current Image</label>
                <?php if ($blog['image']): ?>
                    <img style="max-width:320px;border-radius:16px;margin-bottom:16px;" src="../<?php echo htmlspecialchars($blog['image']); ?>" alt="Current image">
                <?php else: ?>
                    <div class="no-results" style="background:#eff6ff;color:#0369a1;">No image uploaded yet.</div>
                <?php endif; ?>
                <label>Replace Image (optional)</label>
                <input type="file" name="image" accept="image/*">
                <button type="submit" class="button">Update Blog</button>
            </form>
        </article>
    </main>
</body>
</html>
