<div class="content-header"><div class="container-fluid"><h1>Riwayat Transaksi</h1></div></div>
<?php foreach ($orders as $o): ?>
<div class="card mb-2"><div class="card-header d-flex justify-content-between">
  <div><strong><?= html_escape($o['order_number']) ?></strong> — <?= html_escape($o['customer_name']) ?> · <?= html_escape($o['email']) ?></div>
  <div><?= order_status_badge($o['status']) ?> <strong><?= format_rupiah($o['total']) ?></strong></div>
</div><div class="card-body">
  <?php foreach ($o['items'] as $it): ?><span class="badge badge-secondary mr-1"><?= html_escape($it['product_name']) ?> x<?= (int)$it['qty'] ?></span><?php endforeach; ?>
</div></div>
<?php endforeach; ?>
