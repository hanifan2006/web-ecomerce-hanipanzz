<div class="main-wrap" style="max-width:900px;">
  <div class="banner" style="margin-bottom:24px;">
    <div>
      <div class="banner-title"><?= html_escape($settings['site_name'] ?? 'Nipzz!! Store') ?></div>
      <div class="banner-sub"><?= html_escape($settings['site_tagline'] ?? '') ?></div>
    </div>
    <div class="banner-img">🏪</div>
  </div>
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:24px;">
    <div style="background:#fff;border-radius:12px;border:1px solid var(--border);padding:24px;">
      <h3>Visi Kami</h3>
      <p>Menjadi toko laptop online terpercaya dan terlengkap di Indonesia.</p>
    </div>
    <div style="background:#fff;border-radius:12px;border:1px solid var(--border);padding:24px;">
      <h3>Misi Kami</h3>
      <ul><li>Produk original bergaransi resmi</li><li>Harga kompetitif</li><li>Pengiriman cepat</li><li>Pelayanan profesional</li></ul>
    </div>
  </div>
  <div style="background:#fff;border-radius:12px;border:1px solid var(--border);padding:24px;">
    <h3>Hubungi Kami</h3>
    <p>📍 <?= html_escape($settings['site_address'] ?? '') ?></p>
    <p>📞 <?= html_escape($settings['site_phone'] ?? '') ?></p>
    <p>✉️ <?= html_escape($settings['site_email'] ?? '') ?></p>
  </div>
</div>
