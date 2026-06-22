<div class="content-header"><div class="container-fluid"><h1>Pengaturan</h1></div></div>
<div class="card"><div class="card-body">
  <?= form_open('admin/settings') ?>
  <div class="form-group"><label>Nama Situs</label><input type="text" name="site_name" class="form-control" value="<?= html_escape($settings['site_name'] ?? '') ?>"></div>
  <div class="form-group"><label>Tagline</label><textarea name="site_tagline" class="form-control" rows="2"><?= html_escape($settings['site_tagline'] ?? '') ?></textarea></div>
  <div class="form-group"><label>Email</label><input type="email" name="site_email" class="form-control" value="<?= html_escape($settings['site_email'] ?? '') ?>"></div>
  <div class="form-group"><label>Telepon</label><input type="text" name="site_phone" class="form-control" value="<?= html_escape($settings['site_phone'] ?? '') ?>"></div>
  <div class="form-group"><label>Alamat</label><textarea name="site_address" class="form-control" rows="2"><?= html_escape($settings['site_address'] ?? '') ?></textarea></div>
  <div class="form-group"><label>Ongkos Kirim (Rp)</label><input type="number" name="shipping_cost" class="form-control" value="<?= html_escape($settings['shipping_cost'] ?? '50000') ?>"></div>
  <div class="form-group"><label>Rekening Bank</label><input type="text" name="bank_account" class="form-control" value="<?= html_escape($settings['bank_account'] ?? '') ?>"></div>
  <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
  <?= form_close() ?>
</div></div>
