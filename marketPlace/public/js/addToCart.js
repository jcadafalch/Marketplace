const button = document.querySelectorAll('.button-addToCart');
const contador = document.querySelector('#numberOfProducts');

let counter = 1;
const arrayProducts = [];

button.forEach(element => {
    element.addEventListener('click', function (e) {

        if (!arrayProducts.includes(element.id)) {
            parseInt(contador.innerHTML = counter);
            counter++;
            arrayProducts.push(element.id);

            element.setAttribute('disabled', true);
        }

        document.cookie = "item =" + arrayProducts ;
    });
});







