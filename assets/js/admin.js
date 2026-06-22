(function () {
  'use strict';
  if (typeof $ === 'undefined') return;
  $(function () {
    if ($('#datatable').length) {
      $('#datatable').DataTable({
        responsive: true,
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        language: { url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json' }
      });
    }
    $(document).on('click', '[data-confirm]', function (e) {
      if (!confirm($(this).data('confirm'))) e.preventDefault();
    });
  });
})();
