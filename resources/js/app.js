import './bootstrap';
import './register';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('registerForm');
    if (!form) return;

    const checkbox = document.getElementById('offerCheckbox');
    const error = document.getElementById('offerError');
    const block = document.getElementById('offerBlock');
    const modal = document.getElementById('offerModal');

    // ===== VALIDATION =====
    form.addEventListener('submit', (e) => {
        if (!checkbox.checked) {
            e.preventDefault();

            error.classList.remove('hidden');
            block.classList.add('border', 'border-red-500', 'rounded-lg', 'p-2');

            checkbox.focus();
        }
    });

    // ===== MODAL FUNCTIONS =====
    window.openOfferModal = () => {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    };

    window.closeOfferModal = () => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    };

    window.acceptOffer = () => {
        checkbox.checked = true;
        error.classList.add('hidden');
        block.classList.remove('border', 'border-red-500', 'p-2');
        closeOfferModal();
    };

});
