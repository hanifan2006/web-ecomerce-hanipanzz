<div class="content-header"><div class="container-fluid"><h1>Edit Role: <?= html_escape($role['name']) ?></h1></div></div>
<div class="card"><div class="card-body">
  <?= form_open('admin/roles/edit/'.$role['id']) ?>
  <?php foreach ($permissions as $p): ?>
  <div class="form-check"><input type="checkbox" class="form-check-input" name="permissions[]" value="<?= $p['id'] ?>" id="perm<?= $p['id'] ?>" <?= in_array($p['id'], $role_permission_ids) ? 'checked' : '' ?>><label class="form-check-label" for="perm<?= $p['id'] ?>"><?= html_escape($p['name']) ?> <small class="text-muted">(<?= html_escape($p['slug']) ?>)</small></label></div>
  <?php endforeach; ?>
  <button type="submit" class="btn btn-primary mt-3">Simpan</button>
  <a href="<?= site_url('admin/roles') ?>" class="btn btn-secondary mt-3">Batal</a>
  <?= form_close() ?>
</div></div>
