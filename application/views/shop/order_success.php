<div class="main-wrap" style="max-width:560px;margin:40px auto;">
  <div style="background:#fff;border-radius:12px;border:1px solid var(--border);padding:40px;text-align:center;">
    <div style="width:64px;height:64px;background:#d1fae5;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:28px;">&#10003;</div>
    <h2>Pesanan Berhasil Dibuat!</h2>
    <p>No. Pesanan: <strong style="color:var(--primary);"><?= html_escape($order['order_number']) ?></strong></p>
    <div style="background:var(--bg);border-radius:8px;padding:14px;text-align:left;margin:20px 0;font-size:13px;">
      <p><strong>Penerima:</strong> <?= html_escape($order['customer_name']) ?></p>
      <p><strong>Total:</strong> <?= format_rupiah($order['total']) ?></p>
      <p><strong>Pembayaran:</strong> <?= payment_label($order['payment_method']) ?></p>
    </div>
    <a href="<?= site_url('pesanan-saya') ?>" class="btn btn-primary">Lihat Pesanan Saya</a>
    <a href="<?= site_url('shop') ?>" class="btn btn-outline">Lanjut Belanja</a>
  </div>
</div>
