<?php $specs = json_decode($product['specs'], TRUE) ?: array(); $disc = ($product['old_price'] && $product['old_price'] > $product['price']) ? round((1-$product['price']/$product['old_price'])*100) : 0; ?>
<div class="main-wrap">
  <div class="pd-layout" style="background:#fff;border-radius:12px;padding:24px;border:1px solid var(--border);">
    <div class="pd-img" style="font-size:80px;text-align:center;"><?php if ($product['image']): ?><img src="<?= html_escape($product['image']) ?>" style="max-width:100%;border-radius:8px;" alt=""><?php else: ?><?= $product['icon'] ?: '💻' ?><?php endif; ?></div>
    <div>
      <span class="badge badge-blue"><?= html_escape($product['badge']) ?></span>
      <h1 style="font-size:22px;margin:10px 0;"><?= html_escape($product['brand'].' '.$product['name']) ?></h1>
      <?php if ($product['old_price']): ?><div class="pd-oldprice"><?= format_rupiah($product['old_price']) ?></div><?php endif; ?>
      <div class="pd-price"><?= format_rupiah($product['price']) ?></div>
      <p>&#9733; <?= $product['rating'] ?> · <?= (int)$product['sold'] ?> terjual · Stok: <?= (int)$product['stock'] ?></p>
      <?php if ($product['stock']>0 && (!$current_user || $current_user['role_slug']==='user')): ?>
      <button type="button" class="btn btn-primary" data-add-cart="<?= (int)$product['id'] ?>">Tambah ke Keranjang</button>
      <?php endif; ?>
      <div class="spec-list" style="margin-top:20px;">
        <?php foreach ($specs as $s): ?><div class="spec-row"><span class="spec-key">Spesifikasi</span><span class="spec-val"><?= html_escape($s) ?></span></div><?php endforeach; ?>
        <div class="spec-row"><span class="spec-key">Garansi</span><span class="spec-val">1 Tahun Resmi</span></div>
      </div>
    </div>
  </div>
</div>
