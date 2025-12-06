document.addEventListener('DOMContentLoaded', function () {
console.log('Opening hours controller loaded');
    const mode = document.querySelector('select[name$="[mode]"]');
    const morningStart = document.querySelector('input[name$="[morningStart]"]')?.closest('.form-group');
    const morningEnd = document.querySelector('input[name$="[morningEnd]"]')?.closest('.form-group');
    const afternoonStart = document.querySelector('input[name$="[afternoonStart]"]')?.closest('.form-group');
    const afternoonEnd = document.querySelector('input[name$="[afternoonEnd]"]')?.closest('.form-group');

    function updateFields() {
        const value = mode.value;

        // Reset : tout visible et enabled
        [morningStart, morningEnd, afternoonStart, afternoonEnd].forEach(f => {
            f.style.display = '';
            f.querySelector('input').disabled = false;
        });

        if (value === 'closed') {
            // closed → tout disabled
            [morningStart, morningEnd, afternoonStart, afternoonEnd].forEach(f => {
                f.style.display = 'none';
                f.querySelector('input').disabled = true;
            });
        }

        if (value === 'open') {
            // open → seul morningStart et afternoonEnd visibles
            morningEnd.style.display = 'none';
            afternoonStart.style.display = 'none';
            morningEnd.querySelector('input').disabled = true;
            afternoonStart.querySelector('input').disabled = true;
        }
        
        if (value === 'break') {
            // break → tout enabled (déjà le cas)
        }
    }

    updateFields();
    mode.addEventListener('change', updateFields);
});
