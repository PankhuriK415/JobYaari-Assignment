<?php
require_once __DIR__ . '/../includes/auth.php';
requireAdmin();
require_once __DIR__ . '/../includes/db.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $shortDescription = trim($_POST['short_description'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $date = trim($_POST['date'] ?? date('Y-m-d'));
    $imagePath = '';

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

    $stmt = $conn->prepare('INSERT INTO blogs (title, short_description, content, category, image, date) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('ssssss', $title, $shortDescription, $content, $category, $imagePath, $date);
    if ($stmt->execute()) {
        header('Location: blogs.php');
        exit;
    }
    $message = 'Unable to add blog. Please verify all fields.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Blog | Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header class="site-header">
        <div class="container header-inner">
            <div>
                <h1>Add Blog</h1>
                <p>Create a new blog post for the public site.</p>
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
                <input type="text" name="title" required>
                <label>Short Description</label>
                <textarea name="short_description" required rows="3"></textarea>
                <label>Content</label>
                <textarea name="content" required rows="8"></textarea>
                <label>Category</label>
                <input type="text" name="category" required placeholder="Admit Card, Result, Study">
                <label>Blog Date</label>
                <input type="date" name="date" value="<?php echo date('Y-m-d'); ?>" required>
                <label>Image (optional)</label>
                <input type="file" name="image" accept="image/*">
                <button type="submit" class="button">Save Blog</button>
            </form>
        </article>
    </main>
</body>
</html>
