/**
 * Selectors.
 */
const buttonDissable = document.querySelectorAll(".dissable");
const buttonAble = document.querySelectorAll(".able");
const buttonDelete = document.querySelectorAll(".delete");
const buttonUp = document.querySelectorAll(".up");
const buttonDown = document.querySelectorAll(".down");


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
 * Funció async que fa la petició a l'url, per actualitzar L'ordre del producte.
*/
const ShopOrderProduct = async (id, action) => {
    try {
        const response = await fetch(`/tienda/ordenarProducto/?id=${id}&action=${action}`);
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

/**
 * EventListener per el butó pujar un producte.
*/
buttonUp.forEach((elementAction) => {
    elementAction.addEventListener("click", function (e) {
        ShopOrderProduct(parseInt(elementAction.id), elementAction.htmlFor).then((res) => {
            if (res !== true) {
                const parent = elementAction.parentElement.parentElement;
                location.reload();
                return;
            }
            return;
        });
    });
});

/**
 * EventListener per el butó baixar un producte
*/
buttonDown.forEach((elementAction) => {
    elementAction.addEventListener("click", function (e) {
        ShopOrderProduct(parseInt(elementAction.id), elementAction.htmlFor).then((res) => {
            if (res !== true) {
                const parent = elementAction.parentElement.parentElement;
                location.reload();
                return;
            }
            return;
        });
    });
});