let deleteButtons = document.querySelectorAll(
    ".shoppingcart-main-article-productDelete-span"
);

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
        });
    }
}