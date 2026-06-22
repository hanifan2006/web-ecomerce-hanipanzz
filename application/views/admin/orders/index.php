<div class="content-header"><div class="container-fluid d-flex justify-content-between"><div><h1>Manajemen Pesanan</h1></div><a href="<?= site_url('admin/orders/export') ?>" class="btn btn-success btn-sm">Export Excel</a></div></div>
<div class="card"><div class="card-body">
  <table id="datatable" class="table table-bordered table-striped">
    <thead><tr><th>No</th><th>Customer</th><th>Total</th><th>Tanggal</th><th>Status</th><th>Ubah Status</th><th>Aksi</th></tr></thead>
    <tbody>
      <?php foreach ($orders as $o): ?>
      <tr>
        <td><?= html_escape($o['order_number']) ?></td>
        <td><?= html_escape($o['customer_name']) ?><br><small><?= html_escape($o['email']) ?></small></td>
        <td><?= format_rupiah($o['total']) ?></td>
        <td><?= html_escape(date('d/m/Y', strtotime($o['created_at']))) ?></td>
        <td><?= order_status_badge($o['status']) ?></td>
        <td><?= form_open('admin/orders/update_status/'.$o['id'], array('class'=>'form-inline')) ?>
          <select name="status" class="form-control form-control-sm">
            <?php foreach (array('diproses','dikirim','selesai','dibatalkan') as $s): ?>
            <option value="<?= $s ?>" <?= $o['status']===$s?'selected':'' ?>><?= ucfirst($s) ?></option>
            <?php endforeach; ?>
          </select>
          <button class="btn btn-sm btn-primary ml-1">Simpan</button>
        <?= form_close() ?></td>
        <td><a href="<?= site_url('admin/orders/view/'.$o['id']) ?>" class="btn btn-xs btn-info">Detail</a></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div></div>
