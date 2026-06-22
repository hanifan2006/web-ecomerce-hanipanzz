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
    <h1>Lupa Password</h1>
    <?= flash_messages() ?>
    <?php if (validation_errors()): ?><div class="alert alert-danger"><?= validation_errors() ?></div><?php endif; ?>
    <?= form_open('auth/forgot') ?>
      <div class="form-group"><label>Email terdaftar</label><input type="email" name="email" class="input" value="<?= set_value('email') ?>" required></div>
      <button type="submit" class="btn btn-primary btn-block">Kirim Link Reset</button>
    <?= form_close() ?>
    <div class="auth-links"><a href="<?= site_url('login') ?>">Kembali ke login</a></div>
  </div>
</div>
</body>
</html>
