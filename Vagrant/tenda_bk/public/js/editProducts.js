/**
 * Selectors.
 */
const buttonDissable = document.querySelectorAll(".dissable");
const buttonAble = document.querySelectorAll(".able");
const buttonDelete = document.querySelectorAll(".delete");


/**
 * Funció async que fa la petició a l'url, per actualitzar l'estat del producte.
*/
const ShopEditProduct = async (id, action) => {
    try {
        const response = await fetch(`/tienda/editarProducto/?id=${id}&action=${action}`);
        response;
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

/**
 * EventListener per el butó Habilitar
*/
buttonAble.forEach((elementAction) => {
    elementAction.addEventListener("click", function (e) {
        ShopEditProduct(parseInt(elementAction.id), elementAction.htmlFor).then((res) => {
            if (res !== true) {
                const parent = elementAction.parentElement.parentElement;
                parent.style.backgroundColor='white';
                return;
            }
            return;
        });
    });
});

/**
 * EventListener per el butó eliminar
*/
buttonDelete.forEach((elementAction) => {
   
    elementAction.addEventListener("click", function (e) {
        ShopEditProduct(parseInt(elementAction.id, ), elementAction.htmlFor).then((res) => {
            if (res !== true) {
                const parent = elementAction.parentElement.parentElement;
                parent.style.display='none';
                return;
            }
            return;
        });
    });
});

/**
 * EventListener per el butó Deshabilitar
*/
buttonDissable.forEach((elementAction) => {
    elementAction.addEventListener("click", function (e) {
        ShopEditProduct(parseInt(elementAction.id), elementAction.htmlFor).then((res) => {
            if (res !== true) {
                const parent = elementAction.parentElement.parentElement;
                parent.style.backgroundColor='#f7d7da';
                return;
            }
            return;
        });
    });
});
