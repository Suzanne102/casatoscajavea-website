document.addEventListener('DOMContentLoaded', function () {

  const isEnglish = window.location.pathname.startsWith('/en/');
  const base = isEnglish ? '/en/templates/' : '/templates/';

  // NAV
  fetch(base + 'nav.html')
    .then(res => res.text())
    .then(data => {
      document.getElementById('nav-placeholder').innerHTML = data;
      initNav();
    });

  // FOOTER
  fetch(base + 'footer.html')
    .then(res => res.text())
    .then(data => {
      document.getElementById('footer-placeholder').innerHTML = data;
    });

  // APT NAV (if exists)
  const aptNav = document.getElementById('apt-nav-placeholder');
  if (aptNav) {
    fetch(base + 'apt-nav.html')
      .then(res => res.text())
      .then(data => {
        aptNav.innerHTML = data;
      });
  }

});