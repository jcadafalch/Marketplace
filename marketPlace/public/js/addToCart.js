const button = document.querySelectorAll('.button-addToCart');
const contador = document.querySelector('#numberOfProducts');

let counter = 1;

button.forEach(element => {
    element.addEventListener('click', function (e) {
        parseInt(contador.innerHTML = counter);
        counter++;
    });
});





