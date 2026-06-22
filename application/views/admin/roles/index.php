<div class="content-header"><div class="container-fluid"><h1>Role & Permission</h1></div></div>
<div class="row">
  <?php foreach ($roles as $role): ?>
  <div class="col-md-4"><div class="card"><div class="card-header"><h3 class="card-title"><?= html_escape($role['name']) ?></h3></div><div class="card-body">
    <p class="text-muted"><?= html_escape($role['description']) ?></p>
    <ul class="list-unstyled mb-3"><?php foreach ($role['permissions'] as $p): ?><li><i class="fas fa-check text-success"></i> <?= html_escape($p['name']) ?></li><?php endforeach; ?></ul>
    <?php if ($role['slug'] !== 'super_admin'): ?><a href="<?= site_url('admin/roles/edit/'.$role['id']) ?>" class="btn btn-sm btn-primary">Kelola Permission</a><?php else: ?><span class="badge badge-info">Akses Penuh</span><?php endif; ?>
  </div></div></div>
  <?php endforeach; ?>
</div>
