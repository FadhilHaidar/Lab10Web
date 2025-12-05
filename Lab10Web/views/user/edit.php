<?php
// views/user/edit.php
require_once __DIR__ . '/../../lib/Form.php';
if (!isset($_SESSION['user'])) { header("Location: " . base_url("index.php?page=auth/login")); exit; }

$id = intval($_GET['id'] ?? 0);
$item = $app->db->fetch("SELECT * FROM data_barang WHERE id_barang = {$id}");
if (!$item) { flash_set('error','Data tidak ditemukan.'); header('Location: ' . base_url('index.php?page=user/list')); exit; }
$title = "Edit Barang";

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['nama']) || empty($_POST['kategori'])) $errors[] = 'Nama & kategori wajib diisi.';
    if (empty($errors)) {
        $data = [
            'kategori' => $_POST['kategori'],
            'nama' => $_POST['nama'],
            'deskripsi' => $_POST['deskripsi'] ?? '',
            'tanggal_masuk' => $_POST['tanggal_masuk'] ?? $item['tanggal_masuk'],
            'harga_beli' => (int)($_POST['harga_beli'] ?? 0),
            'harga_jual' => (int)($_POST['harga_jual'] ?? 0),
            'stok' => (int)($_POST['stok'] ?? 0),
            'gambar' => $item['gambar']
        ];
        if (!empty($_FILES['gambar']['name'])) {
            $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
            $fn = time() . "_" . rand(1000,9999) . "." . $ext;
            $dest = __DIR__ . '/../../gambar/' . $fn;
            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $dest)) $data['gambar'] = $fn;
        }
        $app->db->update('data_barang', $data, "id_barang = {$id}");
        flash_set('success','Data diperbarui.'); header('Location: ' . base_url('index.php?page=user/list')); exit;
    }
}
?>

<div class="page-hero">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <div>
      <h3 class="mb-0">Edit Barang</h3>
      <div class="small-muted">Perbarui data barang.</div>
    </div>
  </div>

  <div class="card-clean">
    <?php if($errors): ?>
      <div class="alert alert-danger"><?= implode('<br>', array_map('htmlspecialchars',$errors)) ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="row g-3">
      <div class="col-md-6">
        <label class="form-label small-muted">Kategori</label>
        <input name="kategori" class="form-control" value="<?= htmlspecialchars($item['kategori']) ?>">
      </div>
      <div class="col-md-6">
        <label class="form-label small-muted">Nama Barang</label>
        <input name="nama" class="form-control" value="<?= htmlspecialchars($item['nama']) ?>">
      </div>

      <div class="col-12">
        <label class="form-label small-muted">Deskripsi</label>
        <textarea name="deskripsi" class="form-control" rows="4"><?= htmlspecialchars($item['deskripsi']) ?></textarea>
      </div>

      <div class="col-md-4">
        <label class="form-label small-muted">Tanggal Masuk</label>
        <input type="date" name="tanggal_masuk" class="form-control" value="<?= htmlspecialchars($item['tanggal_masuk']) ?>">
      </div>
      <div class="col-md-4">
        <label class="form-label small-muted">Harga Beli</label>
        <input type="number" name="harga_beli" class="form-control" value="<?= htmlspecialchars($item['harga_beli']) ?>">
      </div>
      <div class="col-md-4">
        <label class="form-label small-muted">Harga Jual</label>
        <input type="number" name="harga_jual" class="form-control" value="<?= htmlspecialchars($item['harga_jual']) ?>">
      </div>

      <div class="col-md-4">
        <label class="form-label small-muted">Stok</label>
        <input type="number" name="stok" class="form-control" value="<?= htmlspecialchars($item['stok']) ?>">
      </div>

      <div class="col-md-8">
        <label class="form-label small-muted">Gambar (opsional)</label>
        <input type="file" name="gambar" class="form-control">
        <?php if($item['gambar']): ?>
          <div class="mt-2"><img src="<?= base_url('gambar/' . $item['gambar']) ?>" style="width:120px;border-radius:8px"></div>
        <?php endif; ?>
      </div>

      <div class="col-12 d-flex justify-content-end">
        <a href="<?= base_url('index.php?page=user/list') ?>" class="btn btn-outline me-2">Batal</a>
        <button class="btn btn-primary">Perbarui</button>
      </div>
    </form>
  </div>
</div>
