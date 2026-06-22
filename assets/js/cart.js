(function () {
  'use strict';
  var cfg = window.LAPTOPKU || {};

  function post(url, data, cb) {
    data = data || {};
    if (cfg.csrfName) data[cfg.csrfName] = cfg.csrfHash;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', cfg.baseUrl + url);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.onload = function () {
      try { cb(JSON.parse(xhr.responseText)); } catch (e) { cb({ success: false, message: 'Error' }); }
    };
    xhr.send(Object.keys(data).map(function (k) {
      return encodeURIComponent(k) + '=' + encodeURIComponent(data[k]);
    }).join('&'));
  }

  function updateBadge(count) {
    var el = document.getElementById('cart-count');
    if (el) el.textContent = count;
  }

  document.addEventListener('click', function (e) {
    var addBtn = e.target.closest('[data-add-cart]');
    if (addBtn) {
      e.preventDefault();
      post('cart/add', { product_id: addBtn.getAttribute('data-add-cart'), qty: 1 }, function (res) {
        if (window.showToast) window.showToast(res.message, res.success ? 'info' : 'error');
        if (res.success && res.count !== undefined) updateBadge(res.count);
      });
      return;
    }
    var updBtn = e.target.closest('[data-cart-update]');
    if (updBtn) {
      e.preventDefault();
      post('cart/update', {
        product_id: updBtn.getAttribute('data-cart-update'),
        qty: updBtn.getAttribute('data-qty')
      }, function (res) {
        if (res.success) location.reload();
        else if (window.showToast) window.showToast(res.message, 'error');
      });
    }
  });
})();
