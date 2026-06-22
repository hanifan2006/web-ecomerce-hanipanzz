<div class="content-header"><div class="container-fluid d-flex justify-content-between align-items-center flex-wrap">
  <div><h1 class="m-0">Manajemen Produk</h1><p class="text-muted mb-0"><?= count($products) ?> produk</p></div>
  <div class="mt-2">
    <a href="<?= site_url('admin/products/create') ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah</a>
    <a href="<?= site_url('admin/products/export') ?>" class="btn btn-success btn-sm"><i class="fas fa-file-excel"></i> Export</a>
  </div>
</div></div>
<div class="card"><div class="card-body">
  <table id="datatable" class="table table-bordered table-striped">
    <thead><tr><th>ID</th><th>Produk</th><th>Kategori</th><th>Harga</th><th>Stok</th><th>Terjual</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody>
      <?php foreach ($products as $p): ?>
      <tr>
        <td><?= (int)$p['id'] ?></td>
        <td><strong><?= html_escape($p['brand'].' '.$p['name']) ?></strong></td>
        <td><?= html_escape($p['category_name']) ?></td>
        <td><?= format_rupiah($p['price']) ?></td>
        <td><?= (int)$p['stock'] ?></td>
        <td><?= (int)$p['sold'] ?></td>
        <td><span class="badge badge-<?= $p['stock']>0?'success':'danger' ?>"><?= $p['stock']>0?'Aktif':'Habis' ?></span></td>
        <td>
          <a href="<?= site_url('admin/products/edit/'.$p['id']) ?>" class="btn btn-xs btn-info">Edit</a>
          <a href="<?= site_url('admin/products/delete/'.$p['id']) ?>" class="btn btn-xs btn-danger" data-confirm="Hapus produk ini?">Hapus</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div></div>
