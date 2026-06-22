<?php $is_edit = !empty($user); $action = $is_edit ? 'admin/users/edit/'.$user['id'] : 'admin/users/create'; ?>
<div class="content-header"><div class="container-fluid"><h1><?= $is_edit ? 'Edit Pengguna' : 'Tambah Pengguna' ?></h1></div></div>
<div class="card"><div class="card-body">
  <?php if (validation_errors()): ?><div class="alert alert-danger"><?= validation_errors() ?></div><?php endif; ?>
  <?= form_open($action) ?>
  <div class="row">
    <div class="col-md-6 form-group"><label>Nama</label><input type="text" name="full_name" class="form-control" value="<?= set_value('full_name', $user['full_name'] ?? '') ?>" required></div>
    <div class="col-md-6 form-group"><label>Role</label><select name="role_id" class="form-control"><?php foreach ($roles as $r): ?><option value="<?= $r['id'] ?>" <?= set_select('role_id', $r['id'], ($user['role_id']??'')==$r['id']) ?>><?= html_escape($r['name']) ?></option><?php endforeach; ?></select></div>
    <div class="col-md-6 form-group"><label>Username</label><input type="text" name="username" class="form-control" value="<?= set_value('username', $user['username'] ?? '') ?>" required></div>
    <div class="col-md-6 form-group"><label>Email</label><input type="email" name="email" class="form-control" value="<?= set_value('email', $user['email'] ?? '') ?>" required></div>
    <div class="col-md-6 form-group"><label>Telepon</label><input type="text" name="phone" class="form-control" value="<?= set_value('phone', $user['phone'] ?? '') ?>"></div>
    <div class="col-md-6 form-group"><label>Password <?= $is_edit ? '(kosongkan jika tidak diubah)' : '*' ?></label><input type="password" name="password" class="form-control" <?= $is_edit ? '' : 'required' ?>></div>
    <div class="col-md-6 form-group"><label class="d-block">Aktif</label><input type="checkbox" name="is_active" value="1" <?= set_checkbox('is_active', '1', ($user['is_active'] ?? 1)==1) ?>></div>
  </div>
  <button type="submit" class="btn btn-primary">Simpan</button>
  <a href="<?= site_url('admin/users') ?>" class="btn btn-secondary">Batal</a>
  <?= form_close() ?>
</div></div>
