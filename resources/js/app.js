// 1. Функции управления модальными окнами Оферты
window.openOfferModal = function () {
    const modal = document.getElementById("offerModal");
    if (!modal) return;
    modal.classList.remove("hidden");
    modal.classList.add("flex"); // Для центрирования контента
    document.body.style.overflow = 'hidden'; // Блокировка прокрутки сайта
};

window.closeOfferModal = function () {
    const modal = document.getElementById("offerModal");
    if (!modal) return;
    modal.classList.add("hidden");
    modal.classList.remove("flex");
    document.body.style.overflow = 'auto';
};

// Функция кнопки "Я принимаю" внутри модалки оферты
window.acceptOffer = function () {
    const checkbox = document.getElementById("offerCheckbox");
    const errorBlock = document.getElementById("offerError");
    
    if (checkbox) {
        checkbox.checked = true; // Ставим галочку
    }
    
    if (errorBlock) {
        errorBlock.classList.add("d-none"); // Скрываем ошибку, если она была
    }
    
    window.closeOfferModal();
};

// 2. Функции управления модальными окнами Конфиденциальности
window.openPrivacyModal = function () {
    const modal = document.getElementById("privacyModal");
    if (!modal) return;
    modal.classList.remove("hidden");
    modal.classList.add("flex");
    document.body.style.overflow = 'hidden';
};

window.closePrivacyModal = function () {
    const modal = document.getElementById("privacyModal");
    if (!modal) return;
    modal.classList.add("hidden");
    modal.classList.remove("flex");
    document.body.style.overflow = 'auto';
};

// Функция кнопки "Я принимаю" внутри модалки конфиденциальности
window.acceptPrivacy = function () {
    const checkbox = document.getElementById("privacyCheckbox");
    const errorBlock = document.getElementById("privacyError");
    
    if (checkbox) {
        checkbox.checked = true;
    }
    
    if (errorBlock) {
        errorBlock.classList.add("d-none");
    }
    
    window.closePrivacyModal();
};

// 3. Валидация формы при отправке
document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("registerForm");
    if (!form) return;

    const offerCheckbox = document.getElementById("offerCheckbox");
    const privacyCheckbox = document.getElementById("privacyCheckbox");

    form.addEventListener("submit", (e) => {
        let hasError = false;

        // Проверка оферты
        if (!offerCheckbox || !offerCheckbox.checked) {
            e.preventDefault();
            const err = document.getElementById("offerError");
            if (err) err.classList.remove("d-none");
            hasError = true;
        }

        // Проверка конфиденциальности
        if (!privacyCheckbox || !privacyCheckbox.checked) {
            e.preventDefault();
            const err = document.getElementById("privacyError");
            if (err) err.classList.remove("d-none");
            hasError = true;
        }

        if (hasError) {
            console.log("Форма не отправлена: не приняты условия.");
        }
    });
});