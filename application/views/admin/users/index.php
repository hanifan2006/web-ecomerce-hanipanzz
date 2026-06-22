<div class="content-header"><div class="container-fluid d-flex justify-content-between"><div><h1>Pengguna</h1></div><a href="<?= site_url('admin/users/create') ?>" class="btn btn-primary btn-sm">Tambah</a></div></div>
<div class="card"><div class="card-body">
  <table id="datatable" class="table table-bordered table-striped">
    <thead><tr><th>Nama</th><th>Username</th><th>Email</th><th>Role</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody>
      <?php foreach ($users as $u): ?>
      <tr>
        <td><?= html_escape($u['full_name']) ?></td>
        <td><?= html_escape($u['username']) ?></td>
        <td><?= html_escape($u['email']) ?></td>
        <td><?= html_escape($u['role_name']) ?></td>
        <td><span class="badge badge-<?= $u['is_active']?'success':'danger' ?>"><?= $u['is_active']?'Aktif':'Nonaktif' ?></span></td>
        <td>
          <a href="<?= site_url('admin/users/edit/'.$u['id']) ?>" class="btn btn-xs btn-info">Edit</a>
          <a href="<?= site_url('admin/users/delete/'.$u['id']) ?>" class="btn btn-xs btn-danger" data-confirm="Hapus user?">Hapus</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div></div>
