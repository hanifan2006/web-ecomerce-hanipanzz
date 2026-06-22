<div class="main-wrap">
  <div class="page-head">
    <div>
      <h1 class="page-head-title">Pesanan Saya</h1>
      <p class="page-head-sub">Riwayat dan status pesanan Anda</p>
    </div>
    <a href="<?= site_url('shop') ?>" class="btn btn-outline btn-sm">Lanjut Belanja</a>
  </div>
  <?php if (empty($orders)): ?>
  <div class="empty"><div class="empty-icon">&#128722;</div><div class="empty-title">Belum ada pesanan</div><div class="empty-sub">Mulai belanja laptop impian Anda sekarang</div><a href="<?= site_url('shop') ?>" class="btn btn-primary" style="margin-top:14px;">Belanja Sekarang</a></div>
  <?php else: foreach ($orders as $o): ?>
  <div class="order-card">
    <div class="order-card-head">
      <div>
        <div class="order-id"><?= html_escape($o['order_number']) ?></div>
        <div class="order-date"><?= html_escape(date('d M Y, H:i', strtotime($o['created_at']))) ?></div>
      </div>
      <?= order_status_badge($o['status']) ?>
    </div>
    <div class="order-card-body">
      <?php foreach ($o['items'] as $it): ?>
      <div class="order-item-row">
        <span><?= html_escape($it['product_name']) ?> &times; <?= (int)$it['qty'] ?></span>
        <span class="order-item-price"><?= format_rupiah($it['price']*$it['qty']) ?></span>
      </div>
      <?php endforeach; ?>
      <div class="order-total-row">
        <span>Total Pembayaran</span>
        <strong><?= format_rupiah($o['total']) ?></strong>
      </div>
    </div>
  </div>
  <?php endforeach; endif; ?>
</div>
