document.addEventListener("DOMContentLoaded", () => {

    // Toggle category navigation dropdowns
    const categoryToggles = document.querySelectorAll('.category-toggle');
    for (const categoryToggle of categoryToggles) {
        categoryToggle.addEventListener('click', function(event) {
            event.currentTarget.closest('.category').classList.toggle('is-active');
        });
    }

    // Disable order submit button after one click
    const orderSubmit = document.getElementById('order-submit');
    orderSubmit.addEventListener('click', function(event) {
        event.currentTarget.classList.add('disabled');
        event.currentTarget.setAttribute('onclick', 'return false;');
    });
})