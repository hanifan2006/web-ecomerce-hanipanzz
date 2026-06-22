<?php $is_edit = !empty($product); $action = $is_edit ? 'admin/products/edit/'.$product['id'] : 'admin/products/create'; ?>
<div class="content-header"><div class="container-fluid"><h1><?= $is_edit ? 'Edit Produk' : 'Tambah Produk' ?></h1></div></div>
<div class="card"><div class="card-body">
  <?php if (validation_errors()): ?><div class="alert alert-danger"><?= validation_errors() ?></div><?php endif; ?>
  <?= form_open_multipart($action) ?>
  <div class="row">
    <div class="col-md-6 form-group"><label>Merek *</label><input type="text" name="brand" class="form-control" value="<?= set_value('brand', $product['brand'] ?? '') ?>" required></div>
    <div class="col-md-6 form-group"><label>Nama Produk *</label><input type="text" name="name" class="form-control" value="<?= set_value('name', $product['name'] ?? '') ?>" required></div>
    <div class="col-md-6 form-group"><label>Kategori *</label>
      <select name="category_id" class="form-control" required>
        <?php foreach ($categories as $c): ?><option value="<?= $c['id'] ?>" <?= set_select('category_id', $c['id'], ($product['category_id'] ?? '')==$c['id']) ?>><?= html_escape($c['name']) ?></option><?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-6 form-group"><label>Badge</label><input type="text" name="badge" class="form-control" value="<?= set_value('badge', $product['badge'] ?? 'Baru') ?>"></div>
    <div class="col-md-4 form-group"><label>Harga *</label><input type="number" name="price" class="form-control" value="<?= set_value('price', $product['price'] ?? '') ?>" required></div>
    <div class="col-md-4 form-group"><label>Harga Coret</label><input type="number" name="old_price" class="form-control" value="<?= set_value('old_price', $product['old_price'] ?? '') ?>"></div>
    <div class="col-md-4 form-group"><label>Stok *</label><input type="number" name="stock" class="form-control" value="<?= set_value('stock', $product['stock'] ?? 0) ?>" required></div>
    <div class="col-md-4 form-group"><label>Rating</label><input type="number" step="0.1" name="rating" class="form-control" value="<?= set_value('rating', $product['rating'] ?? 4.0) ?>"></div>
    <div class="col-md-4 form-group"><label>Icon (emoji)</label><input type="text" name="icon" class="form-control" value="<?= set_value('icon', $product['icon'] ?? '💻') ?>"></div>
    <div class="col-md-4 form-group"><label class="d-block">Aktif</label><input type="checkbox" name="is_active" value="1" <?= set_checkbox('is_active', '1', ($product['is_active'] ?? 1)==1) ?>></div>
    <div class="col-md-6 form-group"><label>URL Gambar</label><input type="url" name="image" id="image-url" class="form-control" value="<?= set_value('image', $product['image'] ?? '') ?>"></div>
    <div class="col-md-6 form-group"><label>Upload Gambar</label><input type="file" name="image_file" class="form-control-file" accept="image/*"></div>
    <div class="col-12 form-group"><label>Spesifikasi (pisah koma)</label><input type="text" name="specs" class="form-control" value="<?= set_value('specs', isset($product['specs_array']) ? implode(', ', $product['specs_array']) : '') ?>"></div>
  </div>
  <button type="submit" class="btn btn-primary">Simpan</button>
  <a href="<?= site_url('admin/products') ?>" class="btn btn-secondary">Batal</a>
  <?= form_close() ?>
</div></div>
