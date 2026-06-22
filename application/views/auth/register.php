<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= html_escape($title) ?></title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/auth.css') ?>">
</head>
<body>
<div class="auth-wrap">
  <div class="auth-card">
    <div class="auth-brand">Laptop<span>Ku</span></div>
    <h1>Daftar Akun</h1>
    <?= flash_messages() ?>
    <?php if (validation_errors()): ?><div class="alert alert-danger"><?= validation_errors() ?></div><?php endif; ?>
    <?= form_open('auth/register') ?>
      <div class="form-group"><label>Nama Lengkap</label><input type="text" name="full_name" class="input" value="<?= set_value('full_name') ?>" required></div>
      <div class="form-group"><label>Username</label><input type="text" name="username" class="input" value="<?= set_value('username') ?>" required></div>
      <div class="form-group"><label>Email</label><input type="email" name="email" class="input" value="<?= set_value('email') ?>" required></div>
      <div class="form-group"><label>Telepon</label><input type="text" name="phone" class="input" value="<?= set_value('phone') ?>"></div>
      <div class="form-group"><label>Password</label><input type="password" name="password" class="input" required></div>
      <div class="form-group"><label>Konfirmasi Password</label><input type="password" name="password_confirm" class="input" required></div>
      <button type="submit" class="btn btn-primary btn-block">Daftar</button>
    <?= form_close() ?>
    <div class="auth-links"><a href="<?= site_url('login') ?>">Sudah punya akun? Masuk</a></div>
  </div>
</div>
</body>
</html>
