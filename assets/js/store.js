(function () {
  'use strict';
  function showToast(msg, type) {
    var wrap = document.getElementById('toast-wrap');
    if (!wrap) return;
    var t = document.createElement('div');
    t.className = 'toast toast-' + (type || 'info');
    t.innerHTML = '<div class="toast-dot"></div><span class="toast-msg">' + msg + '</span>';
    wrap.appendChild(t);
    setTimeout(function () { t.remove(); }, 3000);
  }
  window.showToast = showToast;
})();
