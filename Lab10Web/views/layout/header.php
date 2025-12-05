<?php
// views/layout/header.php
// Clean "Apple-like" header untuk Lab10Web (mint-fresh)
// Pastikan helpers.php tersedia (base_url, asset, flash_get)

?><!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Lab10Web - <?= isset($title) ? htmlspecialchars($title) : 'Dashboard' ?></title>

  <!-- Google Font (Poppins) -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- App CSS (custom minimalist) -->
  <link rel="stylesheet" href="<?= asset('css/style_app.css') ?>">

  <meta name="theme-color" content="#E8FBFF">
  <style>body{font-family:'Poppins',system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial;} </style>
</head>
<body class="bg-soft-light">
<!-- Fixed minimal navbar -->
<nav id="mainNav" class="navbar navbar-expand-lg fixed-top navbar-light py-2">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center gap-2" href="<?= base_url('index.php?page=user/list') ?>">
      <span class="brand-icon" aria-hidden="true"></span>
      <span class="brand-name">Lab10Web</span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu"
            aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto align-items-lg-center">
        <li class="nav-item"><a class="nav-link" href="<?= base_url('index.php?page=user/list') ?>">Data Barang</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= base_url('index.php?page=user/add') ?>">Tambah</a></li>
        <?php if(isset($_SESSION['user'])): ?>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('index.php?page=auth/logout') ?>">Logout</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('index.php?page=auth/login') ?>">Login</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<!-- top spacing to avoid navbar overlap -->
<div class="pt-5"></div>

<div class="container">
  <?php if($m = flash_get('success')): ?>
    <div class="alert alert-success rounded-pill shadow-sm"><?= htmlspecialchars($m) ?></div>
  <?php endif; ?>
  <?php if($m = flash_get('error')): ?>
    <div class="alert alert-danger rounded-pill shadow-sm"><?= htmlspecialchars($m) ?></div>
  <?php endif; ?>
