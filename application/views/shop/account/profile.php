<?php $this->load->view('shop/account/sidebar', get_defined_vars()); ?>
<div class="account-main">
  <div class="account-main-head">
    <div>
      <h1 class="account-main-title">Profil Saya</h1>
      <p class="account-main-sub">Ringkasan akun dan aktivitas belanja Anda</p>
    </div>
    <a href="<?= site_url('akun/edit-profil') ?>" class="btn btn-primary btn-sm">✏️ Edit Profil</a>
  </div>

  <div class="account-stats account-stats-inline">
    <div class="account-stat-card asc-blue">
      <div class="asc-body">
        <div class="asc-val"><?= (int) $order_count ?></div>
        <div class="asc-lbl">Total Pesanan</div>
      </div>
      <div class="asc-icon-wrap">📦</div>
    </div>
    <div class="account-stat-card asc-green">
      <div class="asc-body">
        <div class="asc-val asc-val-sm"><?= format_rupiah($total_spent) ?></div>
        <div class="asc-lbl">Total Belanja</div>
      </div>
      <div class="asc-icon-wrap">💰</div>
    </div>
    <div class="account-stat-card asc-purple">
      <div class="asc-body">
        <div class="asc-val"><?= (int) $completed_count ?></div>
        <div class="asc-lbl">Selesai</div>
      </div>
      <div class="asc-icon-wrap">✅</div>
    </div>
  </div>

  <div class="account-panel">
    <div class="account-panel-head">
      <h2>Informasi Pribadi</h2>
      <span class="badge badge-green"><?= $user['is_active'] ? 'Akun Aktif' : 'Nonaktif' ?></span>
    </div>
    <div class="account-info-grid">
      <div class="aig-item">
        <div class="aig-icon">�️</div>
        <div class="aig-label">Foto Profil</div>
        <div class="aig-value profile-avatar-sm">
          <?php if (!empty($user['avatar'])): ?>
            <img src="<?= base_url($user['avatar']) ?>" alt="Foto Profil">
          <?php else: ?>
            Belum ada foto
          <?php endif; ?>
        </div>
      </div>
      <div class="aig-item">
        <div class="aig-icon">�👤</div>
        <div class="aig-label">Nama Lengkap</div>
        <div class="aig-value"><?= html_escape($user['full_name']) ?></div>
      </div>
      <div class="aig-item">
        <div class="aig-icon">@</div>
        <div class="aig-label">Username</div>
        <div class="aig-value"><?= html_escape($user['username']) ?></div>
      </div>
      <div class="aig-item">
        <div class="aig-icon">✉️</div>
        <div class="aig-label">Email</div>
        <div class="aig-value"><?= html_escape($user['email']) ?></div>
      </div>
      <div class="aig-item">
        <div class="aig-icon">📱</div>
        <div class="aig-label">Telepon</div>
        <div class="aig-value"><?= html_escape($user['phone'] ?: 'Belum diisi') ?></div>
      </div>
      <div class="aig-item">
        <div class="aig-icon">🏷️</div>
        <div class="aig-label">Tipe Akun</div>
        <div class="aig-value"><?= html_escape($user['role_name']) ?></div>
      </div>
      <div class="aig-item">
        <div class="aig-icon">📅</div>
        <div class="aig-label">Bergabung</div>
        <div class="aig-value"><?= date('d F Y', strtotime($user['created_at'])) ?></div>
      </div>
      <div class="aig-item">
        <div class="aig-icon">🕐</div>
        <div class="aig-label">Terakhir Login</div>
        <div class="aig-value"><?= !empty($user['last_login']) ? date('d M Y, H:i', strtotime($user['last_login'])) : 'Belum pernah' ?></div>
      </div>
      <div class="aig-item">
        <div class="aig-icon">🔒</div>
        <div class="aig-label">Keamanan</div>
        <div class="aig-value"><a href="<?= site_url('akun/edit-profil') ?>" class="account-inline-link">Ubah password →</a></div>
      </div>
    </div>
  </div>

  <?php if (!empty($recent_orders)): ?>
  <div class="account-panel">
    <div class="account-panel-head">
      <h2>Pesanan Terbaru</h2>
      <a href="<?= site_url('pesanan-saya') ?>" class="account-inline-link">Lihat semua →</a>
    </div>
    <div class="account-orders-list">
      <?php foreach ($recent_orders as $o): ?>
      <div class="aol-item">
        <div class="aol-left">
          <div class="aol-id"><?= html_escape($o['order_number']) ?></div>
          <div class="aol-meta"><?= date('d M Y', strtotime($o['created_at'])) ?> · <?= count($o['items']) ?> item</div>
        </div>
        <div class="aol-right">
          <?= order_status_badge($o['status']) ?>
          <div class="aol-total"><?= format_rupiah($o['total']) ?></div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
  <?php else: ?>
  <div class="account-panel account-empty-orders">
    <div class="account-empty-icon">🛍️</div>
    <p>Belum ada pesanan. Yuk mulai belanja!</p>
    <a href="<?= site_url('shop') ?>" class="btn btn-primary btn-sm">Jelajahi Laptop</a>
  </div>
  <?php endif; ?>
</div>
