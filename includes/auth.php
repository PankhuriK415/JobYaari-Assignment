<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isAdmin()
{
    return !empty($_SESSION['admin_id']);
}

function requireAdmin()
{
    if (!isAdmin()) {
        header('Location: login.php');
        exit;
    }
}

function adminName()
{
    return $_SESSION['admin_username'] ?? 'Admin';
}
