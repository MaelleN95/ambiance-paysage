document.addEventListener('DOMContentLoaded', () => {
    // Choices.js pour le champ service ---
    const serviceSelect = document.querySelector('.choices-service');
    if (serviceSelect) {
        new Choices(serviceSelect, {
            removeItemButton: true,
            placeholderValue: 'Choisir un ou plusieurs services',
            searchEnabled: true,
        });
    }

    // --- Autocomplete adresse avec API Adresse ---
    const addressInput = document.getElementById('contact_address');
    if (!addressInput) return;

    const dropdown = document.createElement('ul');
    addressInput.parentNode.appendChild(dropdown);

    addressInput.addEventListener('input', async () => {
        const query = addressInput.value.trim();
        if (query.length < 3) {
            dropdown.innerHTML = '';
            return;
        }

        try {
            const response = await fetch(
                `https://api-adresse.data.gouv.fr/search/?q=${encodeURIComponent(query)}&limit=5`
            );
            const data = await response.json();

            dropdown.innerHTML = '';
            data.features.forEach(item => {
                const li = document.createElement('li');
                li.textContent = item.properties.label;
                li.addEventListener('click', () => {
                    addressInput.value = li.textContent;
                    dropdown.innerHTML = '';
                });
                dropdown.appendChild(li);
            });
        } catch (err) {
            console.error(err);
            dropdown.innerHTML = '';
        }
    });

    document.addEventListener('click', (e) => {
        if (e.target !== addressInput) dropdown.innerHTML = '';
    });
});