<?php
// views/auth/login.php
// Login view menggunakan $app->db (Database class)
// Simple server-side logic kept (as previous refactor)

$title = "Login";
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($username === '' || $password === '') $errors[] = 'Username & password wajib diisi.';

    if (empty($errors)) {
        $rows = $app->db->prepareAndExecute("SELECT * FROM users WHERE username = ? LIMIT 1", 's', [$username]);
        if ($rows && count($rows) > 0) {
            $user = $rows[0];
            $valid = false;
            if (password_verify($password, $user['password'])) $valid = true;
            if ($password === $user['password']) $valid = true; // fallback legacy
            if ($valid) {
                $_SESSION['user'] = ['id'=>$user['id'],'username'=>$user['username']];
                flash_set('success','Login berhasil.');
                header('Location: ' . base_url('index.php?page=user/list')); exit;
            } else $errors[] = 'Password salah.';
        } else $errors[] = 'User tidak ditemukan.';
    }
}
?>
<div class="d-flex justify-content-center align-items-center" style="min-height:60vh;">
  <div class="col-12 col-md-8 col-lg-5">
    <div class="card-clean">
      <h4 class="mb-2">Masuk ke Lab10Web</h4>
      <p class="small-muted mb-3">Gunakan akun untuk mengelola data barang.</p>

      <?php if($errors): ?>
        <div class="alert alert-danger">
          <ul class="mb-0">
            <?php foreach($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <form method="POST" action="<?= base_url('index.php?page=auth/login') ?>" class="row g-3">
        <div class="col-12">
          <label class="form-label small-muted">Username</label>
          <input name="username" class="form-control" placeholder="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
        </div>
        <div class="col-12">
          <label class="form-label small-muted">Password</label>
          <input name="password" type="password" class="form-control" placeholder="password">
        </div>
        <div class="col-12 d-flex justify-content-between align-items-center">
          <small class="small-muted">Default: admin/admin (jika belum ada user)</small>
          <button class="btn btn-primary">Masuk</button>
        </div>
      </form>
    </div>
  </div>
</div>
