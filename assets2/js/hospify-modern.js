(() => {
  'use strict';
  const nav = document.querySelector('[data-hospify-nav]');
  const toggle = document.querySelector('[data-hospify-menu]');
  const menu = document.querySelector('[data-hospify-menu-items]');
  if (!toggle || !menu) return;
  toggle.addEventListener('click', () => {
    const expanded = toggle.getAttribute('aria-expanded') === 'true';
    toggle.setAttribute('aria-expanded', String(!expanded));
    menu.classList.toggle('d-none', expanded);
  });
  if (nav) window.addEventListener('scroll', () => nav.classList.toggle('shadow-sm', window.scrollY > 8), { passive: true });
})();
