<?php
// index.php
session_start();

// autoload libs
require __DIR__ . '/config/config.php';
require __DIR__ . '/config/database.php'; // class Database
require __DIR__ . '/lib/Form.php';
require __DIR__ . '/lib/helpers.php'; // helper kecil (base_url, asset, flash_set/get)

$db = new Database(); // instance DB
$app = new stdClass();
$app->db = $db;

// routing (sama seperti sebelumnya)
$page = $_GET['page'] ?? 'user/list';
$page = preg_replace('#[^a-zA-Z0-9_\-/]#', '', $page);
$parts = explode('/', $page);
$viewPath = __DIR__ . '/views/' . implode('/', $parts) . '.php';
if (!file_exists($viewPath)) {
    http_response_code(404);
    echo "<h1>404 - Page not found</h1>";
    exit;
}

// buat $app tersedia di semua view
require __DIR__ . '/views/layout/header.php';
require $viewPath; // di view gunakan $app->db untuk akses DB
require __DIR__ . '/views/layout/footer.php';
