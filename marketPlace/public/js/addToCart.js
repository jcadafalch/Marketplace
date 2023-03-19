const button = document.querySelectorAll('.button-addToCart');
const contador = document.querySelector('#numberOfProducts');

let cartItems = localStorage.getItem("productes");
const arrayProducts = cartItems === null ? [] : JSON.parse(cartItems);

let counter = arrayProducts.length ;
contador.innerHTML = parseInt(counter);
arrayProducts.forEach((product) => {
    let item = document.getElementById(product);
    if (item) {
        let productButton = item.getElementsByClassName('button-addToCart');
        productButton[0].setAttribute('disabled', true);
    }
})



button.forEach(element => {
    element.addEventListener('click', function (e) {

        if (!arrayProducts.includes(element.id)) {
            counter++;
            contador.innerHTML = parseInt(counter);
            arrayProducts.push(element.id);

            element.setAttribute('disabled', true);
        }

        const arrayProductsJSON = JSON.stringify(arrayProducts);
        localStorage.setItem("productes", arrayProductsJSON); 
    });
});