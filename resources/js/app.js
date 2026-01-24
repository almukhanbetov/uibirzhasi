import "./bootstrap";
import Alpine from "alpinejs";

window.Alpine = Alpine;
Alpine.start();

// ✅ открытие модалки оферты
window.openOfferModal = function () {
    const modal = document.getElementById("offerModal");
    if (!modal) return;

    modal.classList.remove("hidden");
    modal.classList.add("flex");
};

// ✅ закрытие модалки оферты
window.closeOfferModal = function () {
    const modal = document.getElementById("offerModal");
    if (!modal) return;

    modal.classList.add("hidden");
    modal.classList.remove("flex");
};

// ✅ нажали "Я принимаю" внутри модалки
window.acceptOffer = function () {
    const checkbox = document.getElementById("offerCheckbox");
    const error = document.getElementById("offerError");
    const block = document.getElementById("offerBlock");

    if (checkbox) checkbox.checked = true;

    // ✅ скрыть ошибку (bootstrap)
    if (error) error.classList.add("d-none");

    // ✅ убрать рамку ошибки (если добавляли)
    if (block) block.classList.remove("border", "border-danger", "p-2");

    window.closeOfferModal();
};

// ✅ Проверка чекбокса при отправке формы
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

            // ✅ рамка вокруг блока
            block.classList.add("border", "border-danger", "p-2", "rounded");

            checkbox.focus();
        }
    });
});
