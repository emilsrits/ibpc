document.addEventListener("DOMContentLoaded", () => {

    const categoryToggles = document.querySelectorAll('.category-toggle');

    for (const categoryToggle of categoryToggles) {
        categoryToggle.addEventListener('click', function(event) {
            event.currentTarget.closest('.category').classList.toggle('is-active');
        });
    }

})