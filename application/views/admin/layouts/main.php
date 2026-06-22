<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= html_escape($title ?? 'Admin') ?> | Nipzz!! Store</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('assets/css/admin.css') ?>">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item"><a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a></li>
      <li class="nav-item d-none d-sm-inline-block"><a href="<?= site_url('shop') ?>" class="nav-link">Lihat Toko</a></li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#"><i class="far fa-user"></i> <?= html_escape($current_user['full_name']) ?></a>
        <div class="dropdown-menu dropdown-menu-right">
          <a href="<?= site_url('logout') ?>" class="dropdown-item">Keluar</a>
        </div>
      </li>
    </ul>
  </nav>
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="<?= site_url('admin/dashboard') ?>" class="brand-link"><span class="brand-text font-weight-light ml-3">Nipzz!! Store Admin</span></a>
    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview">
          <?php foreach ($sidebar_menus as $menu): ?>
          <li class="nav-item">
            <a href="<?= site_url($menu['url']) ?>" class="nav-link <?= uri_string() === $menu['url'] ? 'active' : '' ?>">
              <i class="nav-icon <?= html_escape($menu['icon']) ?>"></i>
              <p><?= html_escape($menu['title']) ?></p>
            </a>
          </li>
          <?php endforeach; ?>
        </ul>
      </nav>
    </div>
  </aside>
  <div class="content-wrapper">
    <section class="content pt-3">
      <div class="container-fluid">
        <?= flash_messages() ?>
        <?= $content ?>
      </div>
    </section>
  </div>
  <footer class="main-footer"><strong>Nipzz!! Store</strong> &copy; <?= date('Y') ?></footer>
</div>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script>window.LAPTOPKU = { baseUrl: '<?= base_url() ?>', csrfName: '<?= $this->security->get_csrf_token_name() ?>', csrfHash: '<?= $this->security->get_csrf_hash() ?>' };</script>
<script>
// Flash message handler untuk admin
const flashSuccess = '<?= $this->session->flashdata('success') ?>';
const flashError = '<?= $this->session->flashdata('error') ?>';
const flashInfo = '<?= $this->session->flashdata('info') ?>';
const flashWarning = '<?= $this->session->flashdata('warning') ?>';

if(flashSuccess) { Swal.fire({icon:'success', title:'Berhasil', text:flashSuccess, timer:3000, showConfirmButton:false}); }
if(flashError) { Swal.fire({icon:'error', title:'Error', text:flashError, timer:4000, showConfirmButton:false}); }
if(flashInfo) { Swal.fire({icon:'info', title:'Informasi', text:flashInfo, timer:3000, showConfirmButton:false}); }
if(flashWarning) { Swal.fire({icon:'warning', title:'Perhatian', text:flashWarning, timer:3500, showConfirmButton:false}); }
</script>
<script src="<?= base_url('assets/js/app.js') ?>"></script>
<script src="<?= base_url('assets/js/admin.js') ?>"></script>
</body>
</html>
