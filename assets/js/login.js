(function () {
  'use strict';

  var DEMO = {
    user: { identity: 'user@laptopku.id', hint: '<strong>Demo User:</strong> user@laptopku.id · password: <code>password123</code>' },
    admin: { identity: 'admin@laptopku.id', hint: '<strong>Demo Admin:</strong> admin@laptopku.id · password: <code>password123</code>' }
  };

  function selectRole(role) {
    var tabs = document.querySelectorAll('.role-tab');
    var hidden = document.getElementById('login-as');
    var identity = document.getElementById('login-identity');
    var hint = document.getElementById('login-hint');
    if (!hidden || !identity) return;

    tabs.forEach(function (tab) {
      tab.classList.toggle('active', tab.getAttribute('data-role') === role);
    });
    hidden.value = role;

    var demo = DEMO[role] || DEMO.user;
    if (!identity.value || identity.value === DEMO.user.identity || identity.value === DEMO.admin.identity) {
      identity.value = demo.identity;
    }
    if (hint) hint.innerHTML = demo.hint;
  }

  document.addEventListener('DOMContentLoaded', function () {
    var hidden = document.getElementById('login-as');
    var initial = hidden ? hidden.value : 'user';
    selectRole(initial);

    document.querySelectorAll('.role-tab').forEach(function (tab) {
      tab.addEventListener('click', function () {
        selectRole(tab.getAttribute('data-role'));
      });
    });
  });
})();
