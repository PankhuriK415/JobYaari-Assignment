<?php
$db_host = getenv('DB_HOST') ?: 'sql200.infinityfree.com';
$db_user = getenv('DB_USER') ?: 'if0_41870268';
$db_pass = getenv('DB_PASS') ?: 'Kushwaha2005';
$db_name = getenv('DB_NAME') ?: 'if0_41870268_jobyaari_blog';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}
$conn->set_charset('utf8mb4');

