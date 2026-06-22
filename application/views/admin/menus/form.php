<?php $is_edit = !empty($menu); $action = $is_edit ? 'admin/menus/edit/'.$menu['id'] : 'admin/menus/create'; ?>
<div class="content-header"><div class="container-fluid"><h1><?= $is_edit ? 'Edit Menu' : 'Tambah Menu' ?></h1></div></div>
<div class="card"><div class="card-body">
  <?= form_open($action) ?>
  <div class="form-group"><label>Judul</label><input type="text" name="title" class="form-control" value="<?= set_value('title', $menu['title'] ?? '') ?>" required></div>
  <div class="form-group"><label>URL</label><input type="text" name="url" class="form-control" value="<?= set_value('url', $menu['url'] ?? '') ?>" required></div>
  <div class="form-group"><label>Icon (FontAwesome class)</label><input type="text" name="icon" class="form-control" value="<?= set_value('icon', $menu['icon'] ?? 'fas fa-circle') ?>"></div>
  <div class="form-group"><label>Permission Slug</label><input type="text" name="permission_slug" class="form-control" value="<?= set_value('permission_slug', $menu['permission_slug'] ?? '') ?>"></div>
  <div class="form-group"><label>Urutan</label><input type="number" name="sort_order" class="form-control" value="<?= set_value('sort_order', $menu['sort_order'] ?? 0) ?>"></div>
  <div class="form-group"><label><input type="checkbox" name="is_active" value="1" <?= set_checkbox('is_active', '1', ($menu['is_active'] ?? 1)==1) ?>> Aktif</label></div>
  <button type="submit" class="btn btn-primary">Simpan</button>
  <a href="<?= site_url('admin/menus') ?>" class="btn btn-secondary">Batal</a>
  <?= form_close() ?>
</div></div>
