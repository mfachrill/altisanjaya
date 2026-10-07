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
document.addEventListener('keydown', event => { if (event.key === 'Escape' && !document.querySelector('dialog[open]')) { closeMenu(); toggle?.focus(); } });
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

const authSuccessPopup = document.querySelector('[data-auth-success]');
if (authSuccessPopup) {
    authSuccessPopup.showModal();
    authSuccessPopup.addEventListener('close', () => authSuccessPopup.remove());
    window.addEventListener('pagehide', () => authSuccessPopup.remove());
}

const actionConfirmPopup = document.querySelector('[data-action-confirm]');
if (actionConfirmPopup) {
    let pendingSubmission = null;
    let approvedForm = null;
    const acceptButton = actionConfirmPopup.querySelector('[data-confirm-accept]');
    document.querySelectorAll('form[data-confirm-action]').forEach(form => {
        form.addEventListener('submit', event => {
            if (approvedForm === form) return;
            event.preventDefault();
            if (actionConfirmPopup.open) return;
            const action = form.dataset.confirmAction;
            pendingSubmission = { form, submitter: event.submitter };
            actionConfirmPopup.querySelector('#action-confirm-title').textContent = actionConfirmPopup.dataset[`${action}Title`];
            actionConfirmPopup.querySelector('#action-confirm-message').textContent = actionConfirmPopup.dataset[`${action}Message`].replace(':name', () => form.dataset.productName || '');
            acceptButton.textContent = actionConfirmPopup.dataset[`${action}Label`];
            acceptButton.classList.toggle('confirm-delete', action === 'delete');
            actionConfirmPopup.returnValue = '';
            actionConfirmPopup.showModal();
        });
    });
    actionConfirmPopup.addEventListener('cancel', () => { actionConfirmPopup.returnValue = 'cancel'; });
    actionConfirmPopup.addEventListener('close', () => {
        const submission = pendingSubmission;
        pendingSubmission = null;
        if (actionConfirmPopup.returnValue !== 'confirm' || !submission) return;
        approvedForm = submission.form;
        try {
            if (submission.submitter) submission.form.requestSubmit(submission.submitter);
            else submission.form.requestSubmit();
        } finally {
            approvedForm = null;
        }
    });
    window.addEventListener('pagehide', () => {
        pendingSubmission = null;
        actionConfirmPopup.close('cancel');
    });
}
