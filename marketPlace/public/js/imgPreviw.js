const dropArea = document.querySelector('.drop-area');
const fileInput = document.querySelector('#file-input');
const previewContainer = document.querySelector('.preview-container');
const previewImage = document.querySelector('.preview-image');
const closeButton = document.querySelector('.close-button');
const fileName = document.querySelector('.file-name');

fileInput.addEventListener('change', () => {
    const file = fileInput.files[0];
    showPreview(file);
});

closeButton.addEventListener('click', (event) => {
    event.preventDefault();
    fileInput.value = '';
    previewImage.style.backgroundImage = '';
    // fileName.textContent = ''; 
    previewImage.classList.add('hidden');
    previewContainer.classList.add('hidden');
    previewContainer.classList.remove('flex');
    previewImage.classList.remove('flex');
});

function showPreview(file) {
    if (file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => {
            previewImage.style.backgroundImage = `url(${reader.result})`;
            previewImage.classList.remove('hidden');
            dropArea.classList.remove('active');
            previewContainer.classList.remove('hidden');
            previewContainer.classList.add('flex');
        };
    }
}

document.addEventListener("DOMContentLoaded", function () {
    ImgUpload();
});

function ImgUpload() {
    let imgWrap = "";
    let imgArray = [];

    let uploadInputs = document.querySelectorAll('.upload__inputfile');
    uploadInputs.forEach(function (input) {
        input.addEventListener('change', function (e) {
            imgWrap = input.closest('.upload__box').querySelector('.upload__img-wrap');
            let maxLength = input.getAttribute('data-max_length');

            let files = e.target.files;
            let filesArr = Array.prototype.slice.call(files);
            let iterator = 0;
            filesArr.forEach(function (f, index) {

                if (!f.type.match('image.*')) {
                    return;
                }

                if (imgArray.length > maxLength) {
                    return false;
                } else {
                    let len = 0;
                    for (let i = 0; i < imgArray.length; i++) {
                        if (imgArray[i] !== undefined) {
                            len++;
                        }
                    }
                    if (len > maxLength) {
                        return false;
                    } else {
                        imgArray.push(f);

                        let reader = new FileReader();
                        reader.onload = function (e) {
                            let html =
                                "<div class='upload__img-box'><div style='background-image: url(" +
                                e.target.result + ")' data-number='" + document.querySelectorAll(
                                    ".upload__img-close").length + "' data-file='" + f
                                    .name +
                                "' class='img-bg'><div class='upload__img-close'></div></div></div>";
                            imgWrap.insertAdjacentHTML('beforeend', html);
                            iterator++;
                        }
                        reader.readAsDataURL(f);
                    }
                }
            });
        });
    });

    document.querySelector('body').addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('upload__img-close')) {
            let file = e.target.parentNode.getAttribute('data-file');
            for (let i = 0; i < imgArray.length; i++) {
                if (imgArray[i].name === file) {
                    imgArray.splice(i, 1);
                    break;
                }
            }
            e.target.parentNode.parentNode.remove();
        }
    });
}


//dropdown de checkboxes
let expanded = false;

function showCheckboxes() {
    const checkboxes = document.getElementById("checkboxes");
    if (!expanded) {
        checkboxes.style.display = "block";
        expanded = true;
    } else {
        checkboxes.style.display = "none";
        expanded = false;
    }
}

const checkboxes = document.querySelectorAll("input[type=checkbox][name=category]");
let enabledSettings = []

checkboxes.forEach(function (checkbox) {
    checkbox.addEventListener('change', async function () {
        enabledSettings = Array.from(checkboxes).filter(i => i.checked).map(i => i.id);
        fetch('/tienda/añadirProducto/cat?categories=' + enabledSettings.join(','))
            .then(async data => {
                const subcategories = await data.json();
                console.log(subcategories);
                // const multiselect = document.querySelector('#multiselect2');
                // const checkbox = document.querySelector('#checkboxes2');
                // const label = document.createElement('label');
                // const input = document.createElement('input');
                // multiselect.removeAttribute('hidden');
                // input.type= 'checkbox';
                // input.innerHTML = subcategories;
                // checkbox.insertAdjacentElement("afterend", 'input');
            })
            .catch(error => console.log(error))
    })
});