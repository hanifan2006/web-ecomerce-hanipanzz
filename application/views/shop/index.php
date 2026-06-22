<div class="main-wrap">
  <div class="banner">
    <div>
      <div class="banner-title">Laptop Premium<br>Harga Terbaik</div>
      <div class="banner-sub">Koleksi terlengkap dari brand ternama. Garansi resmi &amp; pengiriman cepat.</div>
      <div class="banner-stats">
        <div class="bstat"><div class="bstat-num"><?= (int)$product_count ?>+</div><div class="bstat-lbl">Model</div></div>
        <div class="bstat"><div class="bstat-num"><?= (int)$customer_count ?>+</div><div class="bstat-lbl">Pelanggan</div></div>
        <div class="bstat"><div class="bstat-num">100%</div><div class="bstat-lbl">Garansi Resmi</div></div>
      </div>
    </div>
    <div class="banner-img">💻</div>
  </div>
  <div class="cat-row">
    <?php $cat = $filters['category'] ?: 'all'; ?>
    <?php foreach (array('all'=>'Semua') + array_column($categories, 'name', 'slug') as $slug => $label): ?>
    <a class="cat-pill <?= ($cat===$slug || ($slug==='all' && !$filters['category']))?'active':'' ?>" href="<?= site_url('shop?cat='.($slug==='all'?'all':$slug).($filters['search']?'&q='.urlencode($filters['search']):'')) ?>"><?= html_escape($label) ?></a>
    <?php endforeach; ?>
  </div>
  <div class="sec-header">
    <div class="sec-title"><?= count($products) ?> produk ditemukan</div>
  </div>
  <div class="sort-bar">
    <span>Urutkan:</span>
    <?php foreach (array('default'=>'Relevan','price-asc'=>'Termurah','price-desc'=>'Termahal','sold'=>'Terlaris','rating'=>'Rating') as $val=>$lbl): ?>
    <a class="sort-btn <?= $filters['sort']===$val?'active':'' ?>" href="<?= site_url('shop?sort='.$val.($filters['category']?'&cat='.$filters['category']:'').($filters['search']?'&q='.urlencode($filters['search']):'')) ?>"><?= $lbl ?></a>
    <?php endforeach; ?>
  </div>
  <?php if (empty($products)): ?>
  <div class="empty"><div class="empty-icon">&#128269;</div><div class="empty-title">Produk tidak ditemukan</div><a href="<?= site_url('shop') ?>" class="btn btn-outline" style="margin-top:14px;">Reset Filter</a></div>
  <?php else: ?>
  <div class="product-grid">
    <?php foreach ($products as $p):
      $disc = ($p['old_price'] && $p['old_price'] > $p['price']) ? round((1-$p['price']/$p['old_price'])*100) : 0;
    ?>
    <div class="pcard">
      <a href="<?= site_url('produk/'.$p['id']) ?>" class="pcard-link">
        <div class="pcard-img">
          <?php if ($p['image']): ?><img src="<?= html_escape($p['image']) ?>" alt=""><?php else: ?><span class="pcard-emoji"><?= $p['icon'] ?: '💻' ?></span><?php endif; ?>
          <?php if ($disc): ?><div class="pcard-discount">-<?= $disc ?>%</div><?php endif; ?>
          <div class="pcard-badge"><span class="badge badge-blue" style="font-size:9px;"><?= html_escape($p['badge']) ?></span></div>
        </div>
        <div class="pcard-body">
          <div class="pcard-brand"><?= html_escape($p['brand']) ?></div>
          <div class="pcard-name"><?= html_escape($p['name']) ?></div>
          <div><?php if ($p['old_price']): ?><span class="pcard-old"><?= format_rupiah($p['old_price']) ?></span><?php endif; ?>
          <span class="pcard-price"><?= format_rupiah($p['price']) ?></span></div>
          <div class="pcard-rating">&#9733; <?= $p['rating'] ?> · <?= (int)$p['sold'] ?> terjual</div>
        </div>
      </a>
      <?php if ($p['stock'] > 0 && (!$current_user || $current_user['role_slug']==='user')): ?>
      <button type="button" class="pcard-add-btn" data-add-cart="<?= (int)$p['id'] ?>">+</button>
      <?php endif; ?>
    </div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
</div>
