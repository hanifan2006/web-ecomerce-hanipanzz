<div class="main-wrap">
  <div style="margin-bottom:18px;"><a href="<?= site_url('cart') ?>" class="btn btn-gray btn-sm">&#8592; Kembali</a> <strong style="font-size:18px;margin-left:10px;">Formulir Pemesanan</strong></div>
  <?php if (validation_errors()): ?><div class="alert-error"><?= validation_errors() ?></div><?php endif; ?>
  <div class="checkout-layout">
    <div>
      <?= form_open('checkout/process') ?>
      <div class="checkout-form-card" style="margin-bottom:16px;background:#fff;padding:20px;border-radius:12px;border:1px solid var(--border);">
        <h3>Data Penerima</h3>
        <div class="form-group"><label class="form-label">Nama Lengkap *</label><input class="input" name="customer_name" value="<?= set_value('customer_name', $user['full_name']) ?>" required></div>
        <div class="form-group"><label class="form-label">Telepon *</label><input class="input" name="phone" value="<?= set_value('phone', $user['phone']) ?>" required></div>
        <div class="form-group"><label class="form-label">Alamat *</label><textarea class="input" name="address" rows="3" required><?= set_value('address') ?></textarea></div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
          <div class="form-group"><label class="form-label">Kota *</label><input class="input" name="city" value="<?= set_value('city') ?>" required></div>
          <div class="form-group"><label class="form-label">Kode Pos</label><input class="input" name="zip_code" value="<?= set_value('zip_code') ?>"></div>
        </div>
        <div class="form-group"><label class="form-label">Catatan</label><input class="input" name="note" value="<?= set_value('note') ?>"></div>
      </div>
      <div class="checkout-form-card" style="background:#fff;padding:20px;border-radius:12px;border:1px solid var(--border);">
        <h3>Metode Pembayaran *</h3>
        <?php foreach (array('transfer'=>'Transfer Bank','cod'=>'COD','qris'=>'QRIS','ewallet'=>'E-Wallet') as $val=>$lbl): ?>
        <label class="pay-opt" style="display:block;margin-bottom:8px;"><input type="radio" name="payment_method" value="<?= $val ?>" <?= set_radio('payment_method', $val) ?> required> <?= $lbl ?></label>
        <?php endforeach; ?>
        <button type="submit" class="btn btn-primary btn-lg btn-block" style="margin-top:16px;">Konfirmasi Pesanan</button>
      <?= form_close() ?>
      </div>
    </div>
    <div class="checkout-summary" style="background:#fff;padding:20px;border-radius:12px;border:1px solid var(--border);height:fit-content;">
      <h3>Ringkasan</h3>
      <?php foreach ($cart as $it): ?>
      <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--border);font-size:13px;">
        <span><?= html_escape($it['brand'].' '.$it['name']) ?> x<?= (int)$it['qty'] ?></span>
        <span><?= format_rupiah($it['subtotal']) ?></span>
      </div>
      <?php endforeach; ?>
      <div style="display:flex;justify-content:space-between;padding:8px 0;"><span>Subtotal</span><span><?= format_rupiah($subtotal) ?></span></div>
      <div style="display:flex;justify-content:space-between;padding:8px 0;"><span>Ongkir</span><span><?= format_rupiah($shipping) ?></span></div>
      <div style="display:flex;justify-content:space-between;padding:8px 0;font-weight:800;font-size:18px;color:var(--primary);"><span>Total</span><span><?= format_rupiah($subtotal + $shipping) ?></span></div>
    </div>
  </div>
</div>
