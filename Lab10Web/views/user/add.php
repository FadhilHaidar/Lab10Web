<?php
// views/user/add.php
require_once __DIR__ . '/../../lib/Form.php';
if (!isset($_SESSION['user'])) { header("Location: " . base_url("index.php?page=auth/login")); exit; }
$title = "Tambah Barang";

$form = new Form(base_url('index.php?page=user/add'), 'POST');
$form->addField('kategori','Kategori','text');
$form->addField('nama','Nama Barang','text');
$form->addField('deskripsi','Deskripsi','textarea');
$form->addField('tanggal_masuk','Tanggal Masuk','date', date('Y-m-d'));
$form->addField('harga_beli','Harga Beli','number',0);
$form->addField('harga_jual','Harga Jual','number',0);
$form->addField('stok','Stok','number',0);
$form->addField('gambar','Gambar','file');

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // minimal validation
    if (empty($_POST['nama']) || empty($_POST['kategori'])) $errors[] = 'Nama & kategori wajib diisi.';
    if (empty($errors)) {
        $data = [
            'kategori' => $_POST['kategori'],
            'nama' => $_POST['nama'],
            'deskripsi' => $_POST['deskripsi'] ?? '',
            'tanggal_masuk' => $_POST['tanggal_masuk'] ?? date('Y-m-d'),
            'harga_beli' => (int)($_POST['harga_beli'] ?? 0),
            'harga_jual' => (int)($_POST['harga_jual'] ?? 0),
            'stok' => (int)($_POST['stok'] ?? 0),
            'gambar' => ''
        ];
        if (!empty($_FILES['gambar']['name'])) {
            $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
            $filename = time() . "_" . rand(1000,9999) . "." . $ext;
            $dest = __DIR__ . '/../../gambar/' . $filename;
            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $dest)) $data['gambar'] = $filename;
        }
        $ins = $app->db->insert('data_barang', $data);
        if ($ins) { flash_set('success','Data berhasil ditambahkan.'); header('Location: ' . base_url('index.php?page=user/list')); exit; }
        else $errors[] = 'Gagal menyimpan.';
    }
}
?>

<div class="page-hero">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <div>
      <h3 class="mb-0">Tambah Barang</h3>
      <div class="small-muted">Masukkan data barang baru.</div>
    </div>
  </div>

  <div class="card-clean">
    <?php if($errors): ?>
      <div class="alert alert-danger"><?= implode('<br>', array_map('htmlspecialchars',$errors)) ?></div>
    <?php endif; ?>

    <!-- Render form - Form class returns markup with .form-control -->
    <?= $form->open('enctype="multipart/form-data"') ?>
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label small-muted">Kategori</label>
          <input class="form-control" name="kategori" value="<?= htmlspecialchars($_POST['kategori'] ?? '') ?>">
        </div>
        <div class="col-md-6">
          <label class="form-label small-muted">Nama Barang</label>
          <input class="form-control" name="nama" value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>">
        </div>

        <div class="col-12">
          <label class="form-label small-muted">Deskripsi</label>
          <textarea class="form-control" name="deskripsi" rows="4"><?= htmlspecialchars($_POST['deskripsi'] ?? '') ?></textarea>
        </div>

        <div class="col-md-4">
          <label class="form-label small-muted">Tanggal Masuk</label>
          <input type="date" name="tanggal_masuk" class="form-control" value="<?= date('Y-m-d') ?>">
        </div>
        <div class="col-md-4">
          <label class="form-label small-muted">Harga Beli</label>
          <input type="number" name="harga_beli" class="form-control" value="0">
        </div>
        <div class="col-md-4">
          <label class="form-label small-muted">Harga Jual</label>
          <input type="number" name="harga_jual" class="form-control" value="0">
        </div>

        <div class="col-md-4">
          <label class="form-label small-muted">Stok</label>
          <input type="number" name="stok" class="form-control" value="0">
        </div>

        <div class="col-md-8">
          <label class="form-label small-muted">Gambar</label>
          <input type="file" name="gambar" class="form-control">
        </div>

        <div class="col-12 d-flex justify-content-end">
          <a href="<?= base_url('index.php?page=user/list') ?>" class="btn btn-outline me-2">Batal</a>
          <button class="btn btn-primary">Simpan</button>
        </div>
      </div>
    <?= $form->close() ?>
  </div>
</div>
