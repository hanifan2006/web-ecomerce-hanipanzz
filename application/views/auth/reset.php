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
    <h1>Reset Password</h1>
    <?= flash_messages() ?>
    <?php if (validation_errors()): ?><div class="alert alert-danger"><?= validation_errors() ?></div><?php endif; ?>
    <?= form_open('auth/reset/' . html_escape($token)) ?>
      <div class="form-group"><label>Password Baru</label><input type="password" name="password" class="input" required></div>
      <div class="form-group"><label>Konfirmasi Password</label><input type="password" name="password_confirm" class="input" required></div>
      <button type="submit" class="btn btn-primary btn-block">Simpan Password</button>
    <?= form_close() ?>
  </div>
</div>
</body>
</html>
