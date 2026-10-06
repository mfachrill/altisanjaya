const toggle = document.querySelector('[data-menu-toggle]');
const menu = document.getElementById('mobile-menu');
function closeMenu() {
    menu?.classList.add('hidden');
    toggle?.setAttribute('aria-expanded', 'false');
}
toggle?.addEventListener('click', () => {
    const open = toggle.getAttribute('aria-expanded') !== 'true';
    toggle.setAttribute('aria-expanded', String(open));
    menu.classList.toggle('hidden', !open);
});
menu?.querySelectorAll('a').forEach(link => link.addEventListener('click', closeMenu));
document.addEventListener('keydown', event => { if (event.key === 'Escape') { closeMenu(); toggle?.focus(); } });
document.querySelectorAll('[data-submit-once]').forEach(form => {
    form.addEventListener('submit', () => {
        const button = form.querySelector('button[type="submit"]');
        button.disabled = true;
        button.textContent = 'Submitting request…';
    });
});
window.addEventListener('pageshow', () => document.querySelectorAll('[data-submit-once] button').forEach(button => {
    button.disabled = false; button.textContent = 'Submit Request Order →';
}));
