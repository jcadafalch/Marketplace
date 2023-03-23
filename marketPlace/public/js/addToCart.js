const button = document.querySelectorAll(".button-addToCart");
const contador = document.querySelector("#numberOfProducts");

const addProductToShoppingCart = async (productId) => {
    try {
        const response = await fetch(`/shoppingCart/addProdct/${productId}`);
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

let cartItems = localStorage.getItem("productes");
const arrayProducts = cartItems === null ? [] : JSON.parse(cartItems);

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
                if (res === null) {
                    return;
                }

                const arrayProductsJSON = JSON.stringify(res);
                localStorage.setItem("productes", arrayProductsJSON);
            });
            //arrayProducts.push(parseInt(element.id));

            element.setAttribute("disabled", true);
            return;
        }

        const arrayProductsJSON = JSON.stringify(arrayProducts);
        localStorage.setItem("productes", arrayProductsJSON);
    });
});
