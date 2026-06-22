<div class="content-header"><div class="container-fluid d-flex justify-content-between"><div><h1>Data Pelanggan</h1></div><a href="<?= site_url('admin/customers/export') ?>" class="btn btn-success btn-sm">Export</a></div></div>
<div class="card"><div class="card-body">
  <table id="datatable" class="table table-bordered table-striped">
    <thead><tr><th>Pelanggan</th><th>Telepon</th><th>Pesanan</th><th>Total Belanja</th><th>Bergabung</th><th>Tier</th></tr></thead>
    <tbody>
      <?php foreach ($customers as $c):
        $spent = (float)$c['total_spent'];
        $tier = $spent > 50000000 ? 'VIP' : ($spent > 20000000 ? 'Premium' : 'Regular');
        $tierClass = $spent > 50000000 ? 'warning' : ($spent > 20000000 ? 'purple' : 'secondary');
      ?>
      <tr>
        <td><strong><?= html_escape($c['full_name']) ?></strong><br><small><?= html_escape($c['email']) ?></small></td>
        <td><?= html_escape($c['phone']) ?></td>
        <td><?= (int)$c['order_count'] ?></td>
        <td><?= format_rupiah($spent) ?></td>
        <td><?= html_escape(date('M Y', strtotime($c['created_at']))) ?></td>
        <td><span class="badge badge-<?= $tierClass === 'purple' ? 'primary' : $tierClass ?>"><?= $tier ?></span></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div></div>
