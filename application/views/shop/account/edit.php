<?php $this->load->view('shop/account/sidebar', get_defined_vars()); ?>
<div class="account-main">
  <div class="account-main-head">
    <div>
      <h1 class="account-main-title">Edit Profil</h1>
      <p class="account-main-sub">Perbarui informasi pribadi dan keamanan akun</p>
    </div>
    <a href="<?= site_url('akun') ?>" class="btn btn-outline btn-sm">← Kembali ke Profil</a>
  </div>

  <div class="account-panel account-edit-panel">
    <?php if (validation_errors()): ?>
    <div class="alert-error-inline"><?= validation_errors() ?></div>
    <?php endif; ?>
    <?php if (!empty($upload_error)): ?>
    <div class="alert-error-inline"><?= $upload_error ?></div>
    <?php endif; ?>

    <div class="edit-profile-header">
      <div class="account-sidebar-avatar edit-avatar-lg">
        <?php if (!empty($user['avatar'])): ?>
          <img src="<?= base_url($user['avatar']) ?>" alt="Foto Profil">
        <?php else: ?>
          <?= strtoupper(substr($user['full_name'], 0, 1)) ?>
        <?php endif; ?>
      </div>
      <div>
        <div class="edit-profile-name"><?= html_escape($user['full_name']) ?></div>
        <div class="edit-profile-email"><?= html_escape($user['email']) ?></div>
      </div>
    </div>

    <?= form_open_multipart('akun/update', array('class' => 'edit-profile-form')) ?>
      <div class="edit-section">
        <div class="edit-section-title">Data Diri</div>
        <div class="edit-form-grid">
          <div class="form-group">
            <label class="form-label">Nama Lengkap <span class="req">*</span></label>
            <input type="text" name="full_name" class="input" value="<?= set_value('full_name', $user['full_name']) ?>" required>
          </div>
          <div class="form-group">
            <label class="form-label">Username</label>
            <input type="text" class="input input-disabled" value="<?= html_escape($user['username']) ?>" disabled>
            <small class="form-hint">Username tidak dapat diubah</small>
          </div>
          <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" class="input input-disabled" value="<?= html_escape($user['email']) ?>" disabled>
            <small class="form-hint">Email terdaftar pada akun</small>
          </div>
          <div class="form-group">
            <label class="form-label">Nomor Telepon</label>
            <input type="text" name="phone" class="input" value="<?= set_value('phone', $user['phone']) ?>" placeholder="Contoh: 0812-3456-7890">
          </div>
          <div class="form-group">
            <label class="form-label">Foto Profil</label>
            <input type="file" name="avatar" class="input" accept="image/png,image/jpeg,image/jpg,image/gif">
            <small class="form-hint">Unggah foto baru jika ingin mengganti foto profil.</small>
          </div>
        </div>
      </div>

      <div class="edit-section">
        <div class="edit-section-title">Keamanan Akun</div>
        <p class="edit-section-desc">Kosongkan jika tidak ingin mengubah password</p>
        <div class="edit-form-grid">
          <div class="form-group">
            <label class="form-label">Password Baru</label>
            <input type="password" name="password" class="input" placeholder="Minimal 6 karakter" autocomplete="new-password">
          </div>
          <div class="form-group">
            <label class="form-label">Konfirmasi Password</label>
            <input type="password" name="password_confirm" class="input" placeholder="Ulangi password baru" autocomplete="new-password">
          </div>
        </div>
      </div>

      <div class="edit-form-actions">
        <button type="submit" class="btn btn-primary btn-lg">Simpan Perubahan</button>
        <a href="<?= site_url('akun') ?>" class="btn btn-gray">Batal</a>
      </div>
    <?= form_close() ?>
  </div>
</div>
