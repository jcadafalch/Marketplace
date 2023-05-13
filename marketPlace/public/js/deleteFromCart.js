let deleteButtons = document.querySelectorAll(
    ".shoppingcart-main-article-productDelete-span"
);

const delTotal = (button) => {
    let itemPrice = button.parentElement.parentElement.querySelector(".shoppingcart-main-article-productPrice");
    let total = document.querySelector(".shoppingcart-aside-preufinal");
    const section = document.querySelector("section");


    if (parseFloat(itemPrice.innerHTML).toFixed(2) <= 0) {
        total.innerHTML = "0€";

        let h2 = document.createElement("h2");
        h2.innerHTML = "No hay productos en el carrito";
        console.log(section);
        section.append(h2);
        section.querySelector("h5").innerHTML = (parseInt(section.querySelector("h5").innerHTML.charAt(0)) - 1) + " artículos"; 
    } else {
        total.innerHTML = parseFloat(total.innerHTML).toFixed(2) - parseFloat(itemPrice.innerHTML).toFixed(2) + "€";
        section.querySelector("h5").innerHTML = (parseInt(section.querySelector("h5").innerHTML.charAt(0)) - 1) + " artículos"; 
    }
}

const delProductFromShoppingCart = async (productId) => {
    try {
        const response = await fetch(`/shoppingCart/delProduct/${productId}`);
        let cartItems = getShoppingCartProductsIdCookie();
        const arrayProducts = cartItems === null ? [] : cartItems;

        let counter = arrayProducts.length;
        contador.innerHTML = parseInt(counter);
        if (response.ok) {
            const data = await response.json();
            return data;
        } else {
            return null;
        }
    } catch (error) {
        return null;
    }
};

if (deleteButtons != null) {

    for (const delButton of deleteButtons) {
        delButton.addEventListener("mouseover", (event) => {
            event.target.style.color = "black";
            event.target.parentElement.parentElement.classList.remove(
                "shoppingcart-main-article-boxshadowNormal"
            );
            event.target.parentElement.parentElement.classList.add(
                "shoppingcart-main-article-boxshadowDelete"
            );
        });

        delButton.addEventListener("mouseout", (event) => {
            event.target.style.color = "red";
            event.target.parentElement.parentElement.classList.remove(
                "shoppingcart-main-article-boxshadowDelete"
            );
            event.target.parentElement.parentElement.classList.add(
                "shoppingcart-main-article-boxshadowNormal"
            );
        });

        delButton.addEventListener("click", (event) => {
            event.target.parentElement.parentElement.remove();

            deleteButtons = document.querySelectorAll(
                ".shoppingcart-main-article-productDelete-span"
            );

            delProductFromShoppingCart(parseInt(event.target.parentElement.parentElement.id));

            delTotal(delButton);
        });
    }
}