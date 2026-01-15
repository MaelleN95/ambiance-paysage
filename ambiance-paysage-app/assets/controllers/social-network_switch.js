document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('tr').forEach(row => {
        const linkEl = row.querySelector('.link-field');
        const visibleInput = row.querySelector('.social-network-is-visible input[type="checkbox"]');

        if (!visibleInput) return;

        const linkText = linkEl ? linkEl.textContent.trim() : '';

        if (!linkText) {
            visibleInput.disabled = true;
            visibleInput.checked = false;
            visibleInput.style.cursor = 'not-allowed';
        }
    });
});
