<?php
require_once __DIR__ . '/includes/db.php';

$categoryResult = $conn->query("SELECT DISTINCT category FROM blogs ORDER BY category ASC");
$dateResult = $conn->query("SELECT DISTINCT date FROM blogs ORDER BY date DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Listing | JobYaari Blog</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header class="site-header">
        <div class="container header-inner">
            <div>
                <h1>JobYaari Blog</h1>
                <p>Latest blogs, news, and exam updates.</p>
            </div>
            <nav>
                <a href="admin/login.php">Admin Panel</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="hero">
            <div>
                <h2>Explore the latest blogs</h2>
                <p>Use search and filters without reloading the page.</p>
            </div>
            <div class="hero-action">
                <a class="button" href="admin/login.php">Open Admin Panel</a>
            </div>
        </section>

        <section class="filter-panel">
            <form id="filterForm">
                <div class="form-row">
                    <label for="search">Search</label>
                    <input id="search" type="text" name="search" placeholder="Search blogs...">
                </div>
                <div class="form-row">
                    <label for="category">Category</label>
                    <select id="category" name="category">
                        <option value="">All Categories</option>
                        <?php while ($row = $categoryResult->fetch_assoc()): ?>
                            <option value="<?php echo htmlspecialchars($row['category']); ?>"><?php echo htmlspecialchars($row['category']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-row">
                    <label for="date">Date</label>
                    <select id="date" name="date">
                        <option value="">All Dates</option>
                        <?php while ($row = $dateResult->fetch_assoc()): ?>
                            <option value="<?php echo htmlspecialchars($row['date']); ?>"><?php echo htmlspecialchars(date('F j, Y', strtotime($row['date']))); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-row form-action">
                    <button type="submit" class="button">Apply Filters</button>
                </div>
            </form>
        </section>

        <section class="blog-grid" id="blogGrid">
            <?php
            $initialQuery = $conn->query("SELECT * FROM blogs ORDER BY date DESC");
            if ($initialQuery->num_rows === 0):
                echo '<div class="no-results">No blogs available yet.</div>';
            else:
                while ($blog = $initialQuery->fetch_assoc()):
                    $image = $blog['image'] ?: 'https://via.placeholder.com/600x400?text=Blog+Image';
                    $short = htmlspecialchars($blog['short_description']);
                    $title = htmlspecialchars($blog['title']);
                    $category = htmlspecialchars($blog['category']);
                    $dateText = htmlspecialchars(date('F j, Y', strtotime($blog['date'])));
                    $link = 'blog.php?id=' . urlencode($blog['id']);
                    echo "<article class=\"blog-card\">";
                    echo "<a class=\"card-link\" href=\"{$link}\">";
                    echo "<div class=\"card-image\"><img src=\"{$image}\" alt=\"{$title}\"></div>";
                    echo "</a>";
                    echo "<div class=\"card-content\">";
                    echo "<span class=\"blog-category\">{$category}</span>";
                    echo "<h3><a href=\"{$link}\">{$title}</a></h3>";
                    echo "<p class=\"blog-date\">{$dateText}</p>";
                    echo "<p>{$short}</p>";
                    echo "<a class=\"read-more\" href=\"{$link}\">Read more</a>";
                    echo "</div>";
                    echo "</article>";
                endwhile;
            endif;
            ?>
        </section>
    </main>

    <footer class="site-footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> JobYaari Blog. Built with PHP, MySQL, and AJAX.</p>
        </div>
    </footer>

    <script src="assets/js/app.js"></script>
</body>
</html>
