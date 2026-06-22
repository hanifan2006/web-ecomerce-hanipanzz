<div class="content-header"><div class="container-fluid d-flex justify-content-between"><div><h1>Manajemen Menu</h1></div><a href="<?= site_url('admin/menus/create') ?>" class="btn btn-primary btn-sm">Tambah Menu</a></div></div>
<div class="card mb-3"><div class="card-header">Assign Menu ke Role</div><div class="card-body">
  <?php foreach ($roles as $role): if ($role['slug']==='super_admin') continue;
    $menu_ids = $role_menus[$role['id']] ?? array();
  ?>
  <?= form_open('admin/menus/assign_role/'.$role['id']) ?>
  <h6><?= html_escape($role['name']) ?></h6>
  <div class="row mb-3"><?php foreach ($menus as $m): ?><div class="col-md-3"><label><input type="checkbox" name="menus[]" value="<?= $m['id'] ?>" <?= in_array($m['id'], $menu_ids)?'checked':'' ?>> <?= html_escape($m['title']) ?></label></div><?php endforeach; ?></div>
  <button type="submit" class="btn btn-sm btn-success mb-3">Simpan <?= html_escape($role['name']) ?></button>
  <?= form_close() ?>
  <?php endforeach; ?>
</div></div>
<div class="card"><div class="card-body">
  <table id="datatable" class="table table-bordered"><thead><tr><th>Judul</th><th>URL</th><th>Icon</th><th>Permission</th><th>Urutan</th><th>Aksi</th></tr></thead><tbody>
    <?php foreach ($menus as $m): ?><tr>
      <td><?= html_escape($m['title']) ?></td><td><?= html_escape($m['url']) ?></td><td><i class="<?= html_escape($m['icon']) ?>"></i></td>
      <td><?= html_escape($m['permission_slug']) ?></td><td><?= (int)$m['sort_order'] ?></td>
      <td><a href="<?= site_url('admin/menus/edit/'.$m['id']) ?>" class="btn btn-xs btn-info">Edit</a>
      <a href="<?= site_url('admin/menus/delete/'.$m['id']) ?>" class="btn btn-xs btn-danger" data-confirm="Hapus menu?">Hapus</a></td>
    </tr><?php endforeach; ?>
  </tbody></table>
</div></div>
