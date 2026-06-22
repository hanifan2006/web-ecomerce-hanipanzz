<div class="main-wrap">
  <div class="sec-header"><div class="sec-title">Keranjang Belanja</div></div>
  <?php if (empty($cart)): ?>
  <div class="empty"><div class="empty-icon">&#128722;</div><div class="empty-title">Keranjang kosong</div><a href="<?= site_url('shop') ?>" class="btn btn-primary">Mulai Belanja</a></div>
  <?php else: ?>
  <?php foreach ($cart as $item): ?>
  <div class="cart-item" style="background:#fff;padding:16px;border-radius:8px;margin-bottom:10px;border:1px solid var(--border);display:flex;justify-content:space-between;align-items:center;">
    <div><strong><?= html_escape($item['brand'].' '.$item['name']) ?></strong><br><?= format_rupiah($item['price']) ?> x <?= (int)$item['qty'] ?></div>
    <div style="display:flex;align-items:center;gap:10px;">
      <button type="button" class="qty-btn" data-cart-update="<?= (int)$item['id'] ?>" data-qty="<?= (int)$item['qty']-1 ?>">-</button>
      <span><?= (int)$item['qty'] ?></span>
      <button type="button" class="qty-btn" data-cart-update="<?= (int)$item['id'] ?>" data-qty="<?= (int)$item['qty']+1 ?>">+</button>
      <a href="<?= site_url('cart/remove/'.$item['id']) ?>" class="ci-del">Hapus</a>
    </div>
  </div>
  <?php endforeach; ?>
  <div class="cart-total-row" style="margin:20px 0;font-size:18px;font-weight:700;">Total: <?= format_rupiah($total) ?></div>
  <a href="<?= site_url('checkout') ?>" class="btn btn-primary btn-lg btn-block">Lanjut ke Pemesanan</a>
  <?php endif; ?>
</div>
