<?php
session_start();
require_once __DIR__ . '/../includes/db.php';

if (!empty($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit;
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare('SELECT id, username, password FROM admins WHERE username = ? LIMIT 1');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        header('Location: dashboard.php');
        exit;
    }

    $message = 'Invalid username or password.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | JobYaari Blog</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <main class="container blog-detail">
        <article>
            <h2>Admin Login</h2>
            <p>Enter your admin credentials to manage blogs.</p>
            <?php if ($message): ?>
                <div class="no-results" style="background:#fee2e2;color:#b91c1c;"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            <form action="" method="post" class="admin-form">
                <label>Username</label>
                <input type="text" name="username" required placeholder="admin">
                <label>Password</label>
                <input type="password" name="password" required placeholder="Password123">
                <button type="submit" class="button">Login</button>
            </form>
            <p style="margin-top: 16px; color: #475569;">Use username <strong>admin</strong> and password <strong>Password123</strong>.</p>
        </article>
    </main>
</body>
</html>
