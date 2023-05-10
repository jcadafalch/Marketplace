// Get the necessary elements from the HTML document
const dropArea = document.querySelector('.drop-area');
const fileInput = document.querySelector('#file-input');
const previewContainer = document.querySelector('.preview-container');
const previewImage = document.querySelector('.preview-image');
const closeButton = document.querySelector('.close-button');
const fileName = document.querySelector('.file-name');

// Add event listener to the drop area to handle when a file is being dragged over it
// dropArea.addEventListener('dragover', (event) => {
//     event.preventDefault(); // Prevent default behavior of browser
//     dropArea.classList.add('active'); // Add "active" class to the drop area
// });

// Add event listener to the drop area to handle when a file is no longer being dragged over it
// dropArea.addEventListener('dragleave', () => {
//     dropArea.classList.remove('active'); // Remove "active" class from the drop area
// });

// // Add event listener to the drop area to handle when a file is dropped onto it
// dropArea.addEventListener('drop', (event) => {
//     event.preventDefault(); // Prevent default behavior of browser
//     const file = event.dataTransfer.files[0]; // Get the file that was dropped
//     showPreview(file); // Show a preview of the file
//     showFileName(file); // Show the name of the file
// });

// Add event listener to the file input element to handle when a file is selected
fileInput.addEventListener('change', () => {
    const file = fileInput.files[0]; // Get the file that was selected
    showPreview(file); // Show a preview of the file
    showFileName(file); // Show the name of the file
});

// Add event listener to the close button to handle when it is clicked
closeButton.addEventListener('click', (event) => {
    event.preventDefault(); // Prevent default behavior of button
    fileInput.value = ''; // Clear the file input value
    previewImage.style.backgroundImage = ''; // Clear the preview image
    // fileName.textContent = ''; // Clear the file name
    previewImage.classList.add('hidden'); // Hide the preview image
    previewContainer.classList.add('hidden'); // Hide the preview container
    previewContainer.classList.remove('flex'); // Remove "flex" class from preview container
    previewImage.classList.remove('flex'); // Remove "flex" class from preview image
});

// Function to show a preview of the file
function showPreview(file) {
    if (file.type.startsWith('image/')) { // Check if the file is an image
        const reader = new FileReader(); // Create a new FileReader object
        reader.readAsDataURL(file); // Read the file as a data URL
        reader.onload = () => { // When the file has been read
            previewImage.style.backgroundImage = `url(${reader.result})`; // Set the background image of the preview container to the data URL
            previewImage.classList.remove('hidden'); // Show the preview image
            dropArea.classList.remove('active'); // Remove "active" class from drop area
            previewContainer.classList.remove('hidden'); // Show the preview container
            // closeButton.classList.remove('hidden');
            previewContainer.classList.add('flex'); // Add "flex" class to preview container
        };
    }
}

// Function to show the name of the file
// function showFileName(file) {
//     fileName.textContent = file.name; // Set the text content of the file name element to the name of the file
//     fileName.style.display = 'block'; // Show the file name element
// }

jQuery(document).ready(function () {
    ImgUpload();
});

function ImgUpload() {
    var imgWrap = "";
    var imgArray = [];

    $('.upload__inputfile').each(function () {
        $(this).on('change', function (e) {
            imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
            var maxLength = $(this).attr('data-max_length');

            var files = e.target.files;
            var filesArr = Array.prototype.slice.call(files);
            var iterator = 0;
            filesArr.forEach(function (f, index) {

                if (!f.type.match('image.*')) {
                    return;
                }

                if (imgArray.length > maxLength) {
                    return false
                } else {
                    var len = 0;
                    for (var i = 0; i < imgArray.length; i++) {
                        if (imgArray[i] !== undefined) {
                            len++;
                        }
                    }
                    if (len > maxLength) {
                        return false;
                    } else {
                        imgArray.push(f);

                        var reader = new FileReader();
                        reader.onload = function (e) {
                            var html =
                                "<div class='upload__img-box'><div style='background-image: url(" +
                                e.target.result + ")' data-number='" + $(
                                    ".upload__img-close").length + "' data-file='" + f
                                    .name +
                                "' class='img-bg'><div class='upload__img-close'></div></div></div>";
                            imgWrap.append(html);
                            iterator++;
                        }
                        reader.readAsDataURL(f);
                    }
                }
            });
        });
    });

    $('body').on('click', ".upload__img-close", function (e) {
        var file = $(this).parent().data("file");
        for (var i = 0; i < imgArray.length; i++) {
            if (imgArray[i].name === file) {
                imgArray.splice(i, 1);
                break;
            }
        }
        $(this).parent().parent().remove();
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

//devuelve el id de los checkbox seleccionados
const checkboxes = document.querySelectorAll("input[type=checkbox][name=category]");
let enabledSettings = []

checkboxes.forEach(function (checkbox) {
    checkbox.addEventListener('change', function () {
        enabledSettings = Array.from(checkboxes).filter(i => i.checked).map(i => i.id);
        console.log(enabledSettings);
    })
});