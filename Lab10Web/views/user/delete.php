<?php
// views/user/delete.php

// Cek login
if (!isset($_SESSION['user'])) {
    header("Location: " . base_url("index.php?page=auth/login"));
    exit;
}

$id = $_GET['id'] ?? 0;
$item = $app->db->fetch("SELECT * FROM data_barang WHERE id_barang = " . intval($id));

if (!$item) {
    flash_set('error', 'Data tidak ditemukan.');
    header("Location: " . base_url("index.php?page=user/list"));
    exit;
}

// Hapus gambar jika ada
if (!empty($item['gambar'])) {
    $path = __DIR__ . '/../../gambar/' . $item['gambar'];
    if (file_exists($path)) unlink($path);
}

// Hapus data dari database
$app->db->delete('data_barang', "id_barang = " . intval($id));

flash_set('success', 'Data berhasil dihapus.');
header("Location: " . base_url("index.php?page=user/list"));
exit;
