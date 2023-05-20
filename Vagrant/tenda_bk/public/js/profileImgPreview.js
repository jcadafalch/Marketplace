function readURL(input) {
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function (e) {
            const imageContainer = input.parentElement.parentElement;
            const uploadedImage = imageContainer.querySelector('.imageUploaded');
            uploadedImage.style.display = "none";

            imageContainer.querySelector(".imagePreview").style.backgroundImage =
                "url(" + e.target.result + ")";
        };
        reader.readAsDataURL(input.files[0]);
    }
}

const imageUploaders = document.getElementsByClassName("imageUpload");
for (const imageUploader of imageUploaders) {
    imageUploader.addEventListener("change", function () {
        readURL(this);
    });
}
