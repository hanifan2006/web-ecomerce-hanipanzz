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
    <h1>Login ke Akun</h1>
    <p>Pilih tipe akun Anda lalu masukkan data login</p>
    <?= flash_messages() ?>
    <?php if (validation_errors()): ?><div class="alert alert-danger"><?= validation_errors() ?></div><?php endif; ?>
    <?= form_open('auth/login', array('id' => 'login-form')) ?>
      <?php if (!empty($redirect)): ?><input type="hidden" name="redirect" value="<?= html_escape($redirect) ?>"><?php endif; ?>
      <input type="hidden" name="login_as" id="login-as" value="<?= html_escape(set_value('login_as', 'user')) ?>">

      <div class="role-tabs" id="role-tabs">
        <button type="button" class="role-tab <?= set_value('login_as', 'user') === 'user' ? 'active' : '' ?>" data-role="user">
          <div class="rt-name">User</div>
          <div class="rt-sub">Belanja laptop</div>
        </button>
        <button type="button" class="role-tab <?= set_value('login_as') === 'admin' ? 'active' : '' ?>" data-role="admin">
          <div class="rt-name">Admin</div>
          <div class="rt-sub">Kelola toko</div>
        </button>
      </div>

      <div class="form-group">
        <label>Email / Username</label>
        <input type="text" name="identity" id="login-identity" class="input" value="<?= set_value('identity', 'user@laptopku.id') ?>" required>
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" id="login-password" class="input" placeholder="Masukkan password" required>
      </div>
      <div class="form-check">
        <label><input type="checkbox" name="remember" value="1" <?= set_checkbox('remember', '1') ?>> Ingat saya</label>
      </div>
      <button type="submit" class="btn btn-primary btn-block">Login</button>
    <?= form_close() ?>
    <div class="auth-links">
      <a href="<?= site_url('forgot-password') ?>">Lupa password?</a>
      <a href="<?= site_url('register') ?>">Daftar akun baru</a>
    </div>
    <div class="auth-demo" id="login-hint">
      <strong>Demo User:</strong> user@laptopku.id · password: <code>password123</code>
    </div>
  </div>
</div>
<script src="<?= base_url('assets/js/login.js') ?>"></script>
</body>
</html>
