<div class="content-header"><div class="container-fluid"><h1>Detail Pesanan <?= html_escape($order['order_number']) ?></h1></div></div>
<div class="card"><div class="card-body">
  <div class="row mb-3">
    <div class="col-md-6"><p><strong>Penerima:</strong> <?= html_escape($order['customer_name']) ?></p><p><strong>Email:</strong> <?= html_escape($order['email']) ?></p><p><strong>Telepon:</strong> <?= html_escape($order['phone']) ?></p></div>
    <div class="col-md-6"><p><strong>Alamat:</strong> <?= html_escape($order['address']) ?>, <?= html_escape($order['city']) ?></p><p><strong>Pembayaran:</strong> <?= payment_label($order['payment_method']) ?></p><p><strong>Status:</strong> <?= order_status_badge($order['status']) ?></p></div>
  </div>
  <table class="table"><thead><tr><th>Produk</th><th>Qty</th><th>Harga</th><th>Subtotal</th></tr></thead><tbody>
    <?php foreach ($order['items'] as $it): ?><tr>
      <td><?= html_escape($it['product_name']) ?></td><td><?= (int)$it['qty'] ?></td><td><?= format_rupiah($it['price']) ?></td><td><?= format_rupiah($it['price']*$it['qty']) ?></td>
    </tr><?php endforeach; ?>
    <tr><td colspan="3" class="text-right"><strong>Subtotal</strong></td><td><?= format_rupiah($order['subtotal']) ?></td></tr>
    <tr><td colspan="3" class="text-right"><strong>Ongkir</strong></td><td><?= format_rupiah($order['shipping_cost']) ?></td></tr>
    <tr><td colspan="3" class="text-right"><strong>Total</strong></td><td><strong><?= format_rupiah($order['total']) ?></strong></td></tr>
  </tbody></table>
  <a href="<?= site_url('admin/orders') ?>" class="btn btn-secondary">Kembali</a>
</div></div>
