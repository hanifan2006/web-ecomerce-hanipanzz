<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Install Nipzz!! Store</title>
<style>
body{font-family:system-ui,sans-serif;background:#f1f5f9;padding:40px}
.card{max-width:560px;margin:0 auto;background:#fff;padding:32px;border-radius:12px;box-shadow:0 4px 20px rgba(0,0,0,.08)}
.btn{display:inline-block;background:#1a56db;color:#fff;padding:10px 20px;border-radius:8px;text-decoration:none;font-weight:600}
.ok{color:#059669}.err{color:#dc2626}
code{background:#f1f5f9;padding:2px 6px;border-radius:4px}
</style>
</head>
<body>
<div class="card">
  <h1>Install Nipzz!! Store CI3</h1>
  <p>Database: <strong>laptopku_db</strong> (MySQL/XAMPP)</p>
  <p>Status koneksi: <?= $db_ok ? '<span class="ok">Terhubung</span>' : '<span class="err">Gagal — buat database laptopku_db di phpMyAdmin</span>' ?></p>
  <?php if ($message): ?><p><?= html_escape($message) ?></p><?php endif; ?>
  <?php if ($db_ok): ?>
    <p><a class="btn" href="<?= site_url('install?run=1') ?>">Jalankan Migration & Seeder</a></p>
    <p>Setelah install, <a href="<?= site_url('login') ?>">login di sini</a>.</p>
  <?php endif; ?>
  <hr>
  <p><small>Default: superadmin@laptopku.id / password123</small></p>
</div>
</body>
</html>
