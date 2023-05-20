let deleteButtons = document.querySelectorAll(
    ".shoppingcart-main-article-productDelete-span"
);

const updateNumberOfProducts = (element) => {
    element.innerText = `${deleteButtons.length} ${
        deleteButtons.length > 1 || deleteButtons.length === 0
            ? "artículos"
            : "artículo"
    }`;
};

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
        const section = document.querySelector(".shoppingcart-section");

        updateNumberOfProducts(section.children[1]);
    });
}
