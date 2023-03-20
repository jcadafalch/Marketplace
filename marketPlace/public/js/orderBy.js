const form = document.getElementById('form-order');
const select = document.getElementById('order');

select.addEventListener('change', (event) => {
    form.submit();
});