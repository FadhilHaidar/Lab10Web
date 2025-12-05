<?php
// views/user/list.php
if (!isset($_SESSION['user'])) { header("Location: " . base_url("index.php?page=auth/login")); exit; }

$title = "Data Barang";
$rows = $app->db->fetchAll("SELECT * FROM data_barang ORDER BY id_barang DESC");
?>

<div class="page-hero">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <div>
      <h3 class="mb-0">Data Barang</h3>
      <div class="small-muted">Kelola barang — tambah, edit, hapus</div>
    </div>
    <div class="d-flex gap-2">
      <a href="<?= base_url('index.php?page=user/add') ?>" class="btn btn-primary">+ Tambah Barang</a>
    </div>
  </div>

  <div class="card-clean table-modern">
    <table class="table align-middle mb-0">
      <thead>
        <tr>
          <th style="width:48px">No</th>
          <th>Gambar</th>
          <th>Nama</th>
          <th>Kategori</th>
          <th>Harga</th>
          <th>Stok</th>
          <th>Tgl Masuk</th>
          <th style="width:140px">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if(!$rows): ?>
          <tr><td colspan="8" class="text-center small-muted py-4">Belum ada data barang.</td></tr>
        <?php else: foreach($rows as $i => $r): ?>
          <tr>
            <td><?= $i+1 ?></td>
            <td>
              <?php if($r['gambar']): ?>
                <img src="<?= base_url('gambar/' . $r['gambar']) ?>" alt="img" class="me-2">
              <?php else: ?>
                <div class="small-muted">-</div>
              <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($r['nama']) ?></td>
            <td><?= htmlspecialchars($r['kategori']) ?></td>
            <td>Rp <?= number_format($r['harga_jual'],0,',','.') ?></td>
            <td><?= intval($r['stok']) ?></td>
            <td><?= htmlspecialchars($r['tanggal_masuk']) ?></td>
            <td>
              <div class="card-actions">
                <a href="<?= base_url('index.php?page=user/edit&id=' . $r['id_barang']) ?>" class="btn btn-outline btn-sm">Edit</a>
                <a href="<?= base_url('index.php?page=user/delete&id=' . $r['id_barang']) ?>"
                   onclick="return confirm('Yakin ingin menghapus?')"
                   class="btn btn-outline btn-sm btn-danger">Hapus</a>
              </div>
            </td>
          </tr>
        <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>
</div>
