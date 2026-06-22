<div class="content-header"><div class="container-fluid"><h1>Log Aktivitas</h1></div></div>
<div class="card"><div class="card-body">
  <table id="datatable" class="table table-bordered table-striped">
    <thead><tr><th>Waktu</th><th>User</th><th>Aksi</th><th>Deskripsi</th><th>IP</th></tr></thead>
    <tbody>
      <?php foreach ($logs as $log): ?>
      <tr>
        <td><?= html_escape($log['created_at']) ?></td>
        <td><?= html_escape($log['full_name'] ?: 'System') ?></td>
        <td><?= html_escape($log['action']) ?></td>
        <td><?= html_escape($log['description']) ?></td>
        <td><?= html_escape($log['ip_address']) ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div></div>
