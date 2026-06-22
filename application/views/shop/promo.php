<div class="main-wrap">
  <div class="banner" style="background:linear-gradient(120deg,#b91c1c 0%,#dc2626 55%,#f97316 100%);margin-bottom:20px;">
    <div>
      <div class="banner-title" style="font-size:26px;">Promo &amp; Diskon Spesial</div>
      <div class="banner-sub">Penawaran terbatas! Dapatkan laptop impian dengan harga terbaik.</div>
    </div>
    <div class="banner-img">🎁</div>
  </div>
  <?php if (empty($products)): ?>
  <div class="empty"><div class="empty-title">Tidak ada promo saat ini</div></div>
  <?php else: foreach ($products as $p):
    $disc = round((1-$p['price']/$p['old_price'])*100);
  ?>
  <div class="promo-card" style="background:#fff;border-radius:12px;border:1px solid var(--border);padding:20px;margin-bottom:16px;display:flex;gap:20px;align-items:center;">
    <div style="font-size:64px;"><?= $p['icon'] ?: '💻' ?></div>
    <div style="flex:1;">
      <span class="badge badge-red">DISKON <?= $disc ?>%</span>
      <h3><?= html_escape($p['brand'].' '.$p['name']) ?></h3>
      <p><s><?= format_rupiah($p['old_price']) ?></s> <strong style="color:var(--danger);font-size:20px;"><?= format_rupiah($p['price']) ?></strong></p>
      <?php if ($p['stock']>0): ?><button type="button" class="btn btn-primary" data-add-cart="<?= (int)$p['id'] ?>">+ Keranjang</button><?php endif; ?>
    </div>
  </div>
  <?php endforeach; endif; ?>
</div>
