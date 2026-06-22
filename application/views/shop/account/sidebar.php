<aside class="account-sidebar">
  <div class="account-sidebar-user">
    <div class="account-sidebar-avatar">
      <?php if (!empty($user['avatar'])): ?>
        <img src="<?= base_url($user['avatar']) ?>" alt="Foto Profil">
      <?php else: ?>
        <?= strtoupper(substr($user['full_name'], 0, 1)) ?>
      <?php endif; ?>
    </div>
    <div class="account-sidebar-name"><?= html_escape($user['full_name']) ?></div>
    <div class="account-sidebar-email"><?= html_escape($user['email']) ?></div>
  </div>
  <nav class="account-nav">
    <a href="<?= site_url('akun') ?>" class="account-nav-item <?= $active_tab === 'profile' ? 'active' : '' ?>">
      <span class="ani-icon">👤</span> Profil Saya
    </a>
    <a href="<?= site_url('akun/edit-profil') ?>" class="account-nav-item <?= $active_tab === 'edit' ? 'active' : '' ?>">
      <span class="ani-icon">✏️</span> Edit Profil
    </a>
    <a href="<?= site_url('pesanan-saya') ?>" class="account-nav-item">
      <span class="ani-icon">📦</span> Pesanan Saya
    </a>
    <a href="<?= site_url('cart') ?>" class="account-nav-item">
      <span class="ani-icon">🛒</span> Keranjang
    </a>
    <div class="account-nav-divider"></div>
    <a href="<?= site_url('logout') ?>" class="account-nav-item account-nav-danger">
      <span class="ani-icon">🚪</span> Keluar
    </a>
  </nav>
</aside>
