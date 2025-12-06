document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.featured-on-homepage-switch input[type="checkbox"]');

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                checkboxes.forEach(cb => {
                    if (cb !== this) {
                        cb.checked = false;
                    }
                });

                const url = this.dataset.url;
                if (url) {
                    fetch(url, { method: 'POST' });
                }
            }
        });
    });
});
