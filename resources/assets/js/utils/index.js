document.addEventListener("DOMContentLoaded", () => {

    // Toggle category navigation dropdowns
    const categoryToggles = document.querySelectorAll('.category-toggle');
    
    for (let categoryToggle of categoryToggles) {
        categoryToggle.addEventListener('click', function(event) {
            event.currentTarget.closest('.category').classList.toggle('is-active');
        });
    }

    // Toggle section content
    const formSectionToggles = document.querySelectorAll('.section-toggle');

    for (let formSectionToggle of formSectionToggles) {
        formSectionToggle.addEventListener('click', function(event) {
            event.currentTarget.parentElement.classList.toggle('is-active');
        });
    }

    // Disable order submit button after one click
    const orderSubmit = document.getElementById('order-submit');

    if (orderSubmit) {
        orderSubmit.addEventListener('click', function(event) {
            event.currentTarget.classList.add('disabled');
            event.currentTarget.setAttribute('onclick', 'return false;');
        });
    }
    
})