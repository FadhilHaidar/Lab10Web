<?php
// lib/helpers.php
// Helper sederhana untuk aplikasi

function base_url($path = '') {
    // otomatis ambil host + folder
    $root = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
    return $root . '/' . ltrim($path, '/');
}

function asset($path) {
    return base_url('assets/' . ltrim($path, '/'));
}

// Flash message (sukses/error)
function flash_set($key, $value) {
    $_SESSION['flash'][$key] = $value;
}

function flash_get($key) {
    if (!isset($_SESSION['flash'][$key])) return '';
    $msg = $_SESSION['flash'][$key];
    unset($_SESSION['flash'][$key]);
    return $msg;
}
