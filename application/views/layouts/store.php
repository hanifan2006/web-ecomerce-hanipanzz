<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= html_escape($title ?? 'NipzzStore!!') ?></title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/store.css') ?>">
</head>
<body>
<div id="app">
  <div class="topbar">
    <div class="topbar-inner">
      <div class="topbar-links"><a class="topbar-link" href="<?= site_url('tentang-kami') ?>">Tentang Kami</a></div>
      <div class="topbar-links">
        <?php if ($current_user): ?>
          <span class="topbar-link">Halo, <?= html_escape($current_user['full_name']) ?></span>
          <?php if (in_array($current_user['role_slug'], array('super_admin','admin'), TRUE)): ?>
            <a class="topbar-link" href="<?= site_url('admin/dashboard') ?>">Admin Panel</a>
          <?php endif; ?>
          <a class="topbar-link" href="<?= site_url('logout') ?>">Keluar</a>
        <?php else: ?>
          <a class="topbar-link" href="<?= site_url('login') ?>">Masuk</a>
          <a class="topbar-link" href="<?= site_url('register') ?>">Daftar</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <header class="header">
    <div class="header-inner">
      <a href="<?= site_url('shop') ?>" class="logo">Nipzz<span>Store!!</span></a>
      <form class="header-search" action="<?= site_url('shop') ?>" method="get">
        <input type="text" name="q" placeholder="Cari laptop, merek, spesifikasi..." value="<?= html_escape($this->input->get('q')) ?>">
        <button type="submit" class="search-btn" aria-label="Cari">&#128269;</button>
      </form>
      <div class="header-actions">
        <?php if (!$current_user || $current_user['role_slug'] === 'user'): ?>
        <a class="cart-trigger" href="<?= site_url('cart') ?>">
          <div class="cart-trigger-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
            <span class="cart-badge" id="cart-count"><?= (int)$cart_count ?></span>
          </div>
          Keranjang
        </a>
        <?php endif; ?>
        <?php if ($current_user && $current_user['role_slug'] === 'user'): ?>
        <a class="user-menu" href="<?= site_url('akun') ?>">
          <div class="avatar">
            <?php if (!empty($current_user['avatar'])): ?>
              <img src="<?= base_url($current_user['avatar']) ?>" alt="Foto Profil">
            <?php else: ?>
              <?= strtoupper(substr($current_user['full_name'], 0, 1)) ?>
            <?php endif; ?>
          </div>
          <div class="user-menu-text">
            <div class="user-menu-name"><?= html_escape($current_user['full_name']) ?></div>
            <div class="user-menu-role"><?= html_escape($current_user['email']) ?></div>
          </div>
        </a>
        <?php endif; ?>
      </div>
    </div>
  </header>
  <nav class="navbar">
    <div class="navbar-inner">
      <a class="nav-item <?= in_array(uri_string(), array('shop', ''), TRUE) ? 'active' : '' ?>" href="<?= site_url('shop') ?>">Semua Laptop</a>
      <?php if ($current_user && $current_user['role_slug'] === 'user'): ?>
      <a class="nav-item <?= in_array(uri_string(), array('pesanan-saya', 'shop/orders'), TRUE) ? 'active' : '' ?>" href="<?= site_url('pesanan-saya') ?>">Pesanan Saya</a>
      <?php endif; ?>
      <a class="nav-item <?= in_array(uri_string(), array('akun', 'shop/account', 'akun/edit-profil', 'shop/account_edit'), TRUE) ? 'active' : '' ?>" href="<?= $current_user && $current_user['role_slug'] === 'user' ? site_url('akun') : site_url('login?redirect=' . urlencode(site_url('akun'))) ?>">Akun</a>
    </div>
  </nav>
  <?= flash_messages() ?>
  <div id="content-area"><?= $content ?></div>
  <footer class="store-footer">
    <div class="store-footer-inner">
      <div class="sf-brand">Nipzz<span>Strore!!</span></div>
      <p><?= html_escape($settings['site_tagline'] ?? 'Toko laptop terpercaya') ?></p>
      <div class="sf-copy">&copy; <?= date('Y') ?> NipzzStore!!</div>
    </div>
  </footer>
</div>
<div class="toast-wrap" id="toast-wrap"></div>
<script>window.LAPTOPKU = { baseUrl: '<?= base_url() ?>', csrfName: '<?= $this->security->get_csrf_token_name() ?>', csrfHash: '<?= $this->security->get_csrf_hash() ?>' };</script>
<script src="<?= base_url('assets/js/store.js') ?>"></script>
<script src="<?= base_url('assets/js/cart.js') ?>"></script>
</body>
</html>
