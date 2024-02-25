document.addEventListener('DOMContentLoaded', function() {
    var iconsElement = document.getElementById('icons-1');

    if (iconsElement) {
        iconsElement.addEventListener('click', function() {
            var userBox = document.getElementById('user-box-1');
            if (userBox) {
                userBox.classList.toggle('show');
            } else {
                console.error("Element with id 'user-box' not found.");
            }
        });
    } else {
        console.error("Element with id 'icons-1' not found.");
    }
});

document.addEventListener('DOMContentLoaded', function() {
    let closeBtn = document.querySelector('#close-form');

    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            let updateProduct = document.querySelector('.update-product');
            if (updateProduct) {
                updateProduct.style.display = 'none';
            }
        });
    }
});