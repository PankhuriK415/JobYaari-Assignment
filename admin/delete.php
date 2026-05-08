<?php
require_once __DIR__ . '/../includes/auth.php';
requireAdmin();
require_once __DIR__ . '/../includes/db.php';

$id = intval($_GET['id'] ?? 0);
if ($id > 0) {
    $stmt = $conn->prepare('SELECT image FROM blogs WHERE id = ? LIMIT 1');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $blog = $stmt->get_result()->fetch_assoc();
    if ($blog) {
        if (!empty($blog['image']) && file_exists(__DIR__ . '/../' . $blog['image'])) {
            @unlink(__DIR__ . '/../' . $blog['image']);
        }
        $delete = $conn->prepare('DELETE FROM blogs WHERE id = ?');
        $delete->bind_param('i', $id);
        $delete->execute();
    }
}
header('Location: blogs.php');
exit;
