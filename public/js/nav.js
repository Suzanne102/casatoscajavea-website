// /public/js/nav.js

// =========================
// Language Mapping
// =========================

// ES -> EN
const langMap = {
  '/index.html': '/en/index.html',
  '/': '/en/index.html',
  '/pages/galeria-fotos.html': '/en/pages/photo-gallery.html',
  '/pages/disponibilidad.html': '/en/pages/availability.html',
  '/pages/resenas.html': '/en/pages/reviews.html',
  '/pages/nosotros.html': '/en/pages/about.html',
  '/pages/mapa.html': '/en/pages/maps.html',
  '/pages/actividades.html': '/en/pages/activities.html',
  '/pages/forms/consulta-ahora.html': '/en/pages/forms/enquire.html',
  '/pages/apt/no1.html': '/en/pages/apt/no1.html',
  '/pages/apt/no2.html': '/en/pages/apt/no2.html',
  '/pages/apt/no3.html': '/en/pages/apt/no3.html',
  '/pages/apt/no4.html': '/en/pages/apt/no4.html',
  '/pages/apt/no5.html': '/en/pages/apt/no5.html',
  '/pages/apt/ca.html': '/en/pages/apt/ca.html',
  '/pages/forms/hoja-registro.html': '/en/pages/forms/register-now.html',
  '/pages/forms/gracias-registro.html': '/en/pages/forms/registration-confirmation.html'
};

// EN -> ES computed from langMap
const reverseMap = Object.fromEntries(
  Object.entries(langMap).map(([es, en]) => [en, es])
);

function normalizePath(path) {
  return path.replace(/\/{2,}/g, '/');
}

// =========================
// Language Switching
// =========================
function switchLang(event) {
  if (event) event.preventDefault();

  const raw = normalizePath(window.location.pathname);
  const isEnglish = raw.startsWith('/en/');
  const target = isEnglish ? reverseMap[raw] : langMap[raw];

  if (!target) {
    const alt = raw.endsWith('/index.html')
      ? raw.replace('/index.html', '/')
      : raw + 'index.html';
    const altTarget = isEnglish ? reverseMap[alt] : langMap[alt];
    if (altTarget) {
      window.location.href = altTarget;
      return;
    }
  }

  window.location.href = target || (isEnglish ? '/' : '/en/');
}

// Dynamically set flag icon
function initLangFlag() {
  const raw = normalizePath(window.location.pathname);
  const isEnglish = raw.startsWith('/en/');
  const flag = document.getElementById('lang-flag');

  if (flag) {
    flag.src = isEnglish ? '/assets/spanish-flag.png' : '/assets/english-flag.png';
    flag.alt = isEnglish ? 'Español' : 'English';
  }

  const switcher = document.getElementById('lang-switch');
  if (switcher) {
    switcher.onclick = switchLang;
  }
}

// =========================
// Hamburger Menu
// =========================
function initHamburger() {
  const btn = document.getElementById('menu-toggle');
  const menu = document.getElementById('nav-menu');

  if (!btn || !menu) return;

  btn.addEventListener('click', () => menu.classList.toggle('show'));
}

// =========================
// Initialize Nav After Fetch
// =========================
function initNav() {
  initLangFlag();
  initHamburger();
}