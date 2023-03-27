/**
 * Selectors 
 */
const form = document.getElementById("form-order");
const select = document.getElementById("order");
const search = document.getElementById("search");
const category = document.getElementById("category");

/**
 * Funció per inserir els querry params als hidden inputs.
 */
function insertQuerryStringParams(urlParams) {
    search.value = urlParams.get("search");
    category.value = urlParams.get("category");
}

/**
 * Funció per obtenir els querry params.
 */
function getQuerryStringParamsAndInsert() {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    insertQuerryStringParams(urlParams);
}

/**
 * EventListener del selector d'ordenació
 */
select.addEventListener("change", (event) => {
    getQuerryStringParamsAndInsert();
    
    form.submit();
});
