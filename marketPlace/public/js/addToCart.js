const button = document.getElementsByClassName('button-addToCart');

button.addEventListener('click', function (e) {
    e.preventdefault();
    console.log('hola');
});