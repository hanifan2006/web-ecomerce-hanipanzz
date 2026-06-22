<div class="content-header">
  <div class="container-fluid"><h1 class="m-0">Dashboard</h1><p class="text-muted">Ringkasan performa toko Nipzz!! Store</p></div>
</div>
<div class="row">
  <div class="col-lg-3 col-6"><div class="small-box bg-info"><div class="inner"><h3><?= format_rupiah($revenue) ?></h3><p>Pendapatan</p></div><div class="icon"><i class="fas fa-money-bill-wave"></i></div></div></div>
  <div class="col-lg-3 col-6"><div class="small-box bg-success"><div class="inner"><h3><?= (int)$order_count ?></h3><p>Total Pesanan</p></div><div class="icon"><i class="fas fa-shopping-cart"></i></div></div></div>
  <div class="col-lg-3 col-6"><div class="small-box bg-warning"><div class="inner"><h3><?= (int)$customer_count ?></h3><p>Pelanggan</p></div><div class="icon"><i class="fas fa-users"></i></div></div></div>
  <div class="col-lg-3 col-6"><div class="small-box bg-danger"><div class="inner"><h3><?= (int)$total_sold ?></h3><p>Unit Terjual</p></div><div class="icon"><i class="fas fa-laptop"></i></div></div></div>
</div>
<div class="row">
  <div class="col-md-6">
    <div class="card"><div class="card-header"><h3 class="card-title">Pesanan Terbaru</h3><div class="card-tools"><a href="<?= site_url('admin/orders') ?>" class="btn btn-sm btn-default">Lihat Semua</a></div></div>
      <div class="card-body p-0"><table class="table table-sm"><thead><tr><th>ID</th><th>Customer</th><th>Total</th><th>Status</th></tr></thead><tbody>
        <?php foreach ($recent_orders as $o): ?><tr>
          <td><a href="<?= site_url('admin/orders/view/'.$o['id']) ?>"><?= html_escape($o['order_number']) ?></a></td>
          <td><?= html_escape($o['customer_name']) ?></td>
          <td><?= format_rupiah($o['total']) ?></td>
          <td><?= order_status_badge($o['status']) ?></td>
        </tr><?php endforeach; ?>
      </tbody></table></div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card"><div class="card-header"><h3 class="card-title">Stok Menipis</h3></div>
      <div class="card-body p-0"><table class="table table-sm"><thead><tr><th>Produk</th><th>Stok</th></tr></thead><tbody>
        <?php foreach ($low_stock as $p): ?><tr>
          <td><?= html_escape($p['brand'].' '.$p['name']) ?></td>
          <td><span class="badge badge-<?= $p['stock']<=3?'danger':'warning' ?>"><?= (int)$p['stock'] ?></span></td>
        </tr><?php endforeach; ?>
      </tbody></table></div>
    </div>
  </div>
</div>
