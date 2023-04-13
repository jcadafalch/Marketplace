const button = document.querySelectorAll(".button-addToCart");
const contador = document.querySelector("#numberOfProducts");

const addProductToShoppingCart = async (productId) => {
    try {
        const response = await fetch(`/shoppingCart/addProduct/${productId}`);
        console.log(response);
        if (response.ok) {
            const data = await response.json();
            return data;
        } else {
            return null;
        }
    } catch (error) {
        console.log(error);
        return null;
    }
};
const getShoppingCartProductsIdCookie = () => {
    const cookieName = "shoppingCartProductsId";
    const cookies = document.cookie.split(";");

    for (let i = 0; i < cookies.length; i++) {
        const parts = cookies[i].split("=");
        if (decodeURIComponent(parts[0].trim()) == cookieName) {
            const cookieValue = decodeURIComponent(parts[1].slice(0, -1))
                .toString()
                .split(".");

            return cookieValue.map(Number);
        }
    }

    return null;
};

let cartItems = getShoppingCartProductsIdCookie();
const arrayProducts = cartItems === null ? [] : cartItems;

let counter = arrayProducts.length;
contador.innerHTML = parseInt(counter);
arrayProducts.forEach((product) => {
    let item = document.getElementById(product);
    if (item) {
        let productButton = item.getElementsByClassName("button-addToCart");
        productButton[0].setAttribute("disabled", true);
    }
});

button.forEach((element) => {
    element.addEventListener("click", function (e) {
        if (!arrayProducts.includes(element.id)) {
            counter++;
            contador.innerHTML = parseInt(counter);

            addProductToShoppingCart(parseInt(element.id)).then((res) => {
                if (res !== true) {
                    return;
                }

                element.setAttribute("disabled", true);
                return;
            });
        }
    });
});
