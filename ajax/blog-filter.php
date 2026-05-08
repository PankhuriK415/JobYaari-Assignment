<?php
require_once __DIR__ . '/../includes/db.php';

$category = trim($_GET['category'] ?? '');
$date = trim($_GET['date'] ?? '');
$search = trim($_GET['search'] ?? '');

$sql = "SELECT * FROM blogs WHERE 1=1";
$params = [];
$types = '';

if ($category !== '') {
    $sql .= " AND category = ?";
    $types .= 's';
    $params[] = $category;
}

if ($date !== '') {
    $sql .= " AND date = ?";
    $types .= 's';
    $params[] = $date;
}

if ($search !== '') {
    $sql .= " AND (title LIKE ? OR short_description LIKE ? OR content LIKE ?)";
    $types .= 'sss';
    $value = '%' . $search . '%';
    $params[] = $value;
    $params[] = $value;
    $params[] = $value;
}

$sql .= " ORDER BY date DESC";
$stmt = $conn->prepare($sql);
if ($types !== '') {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo '<div class="no-results">No blogs found for the selected filter.</div>';
    exit;
}

while ($row = $result->fetch_assoc()) {
    $title = htmlspecialchars($row['title']);
    $shortDescription = htmlspecialchars($row['short_description']);
    $dateText = htmlspecialchars(date('F j, Y', strtotime($row['date'])));
    $image = htmlspecialchars($row['image'] ?: 'assets/images/placeholder.png');
    $categoryText = htmlspecialchars($row['category']);
    $link = 'blog.php?id=' . urlencode($row['id']);
    echo "<article class=\"blog-card\">";
    echo "<a class=\"card-link\" href=\"{$link}\">";
    echo "<div class=\"card-image\"><img src=\"{$image}\" alt=\"{$title}\"></div>";
    echo "</a>";
    echo "<div class=\"card-content\">";
    echo "<span class=\"blog-category\">{$categoryText}</span>";
    echo "<h3><a href=\"{$link}\">{$title}</a></h3>";
    echo "<p class=\"blog-date\">{$dateText}</p>";
    echo "<p>{$shortDescription}</p>";
    echo "<a class=\"read-more\" href=\"{$link}\">Read more</a>";
    echo "</div>";
    echo "</article>";
}
