import "./bootstrap";
import Alpine from "alpinejs";
window.Alpine = Alpine;
Alpine.start();
/**
 * ✅ OFFER MODAL GLOBAL FUNCTIONS
 * Важно: inline onclick="..." ищет функции в window
 */
window.openOfferModal = function () {  
    const modal = document.getElementById("offerModal");
    if (!modal) return;
    modal.classList.remove("hidden");
    modal.classList.add("flex");
};
window.closeOfferModal = function () {
    const modal = document.getElementById("offerModal");
    if (!modal) return;
    modal.classList.add("hidden");
    modal.classList.remove("flex");
};
window.acceptOffer = function () {
    const checkbox = document.getElementById("offerCheckbox");
    const error = document.getElementById("offerError");
    const block = document.getElementById("offerBlock");
    if (checkbox) checkbox.checked = true;
    // ✅ скрыть ошибку (bootstrap)
    if (error) error.classList.add("d-none");
    // ✅ убрать подсветку ошибки если добавляли
    if (block) block.classList.remove("border", "border-danger", "p-2", "rounded");
    window.closeOfferModal();
};
/**
 * ✅ VALIDATION ON SUBMIT
 */
document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("registerForm");
    if (!form) return;
    const checkbox = document.getElementById("offerCheckbox");
    const error = document.getElementById("offerError");
    const block = document.getElementById("offerBlock");
    if (!checkbox || !error || !block) return;
    form.addEventListener("submit", (e) => {
        if (!checkbox.checked) {
            e.preventDefault();
            // ✅ показать ошибку
            error.classList.remove("d-none");
            // ✅ подсветить блок (bootstrap)
            block.classList.add("border", "border-danger", "p-2", "rounded");
            checkbox.focus();
        }
    });
});