function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.querySelector('#imagePreview').style.backgroundImage='url('+e.target.result +')';
            document.querySelector('#imagePreview').hide();
            document.querySelector('#imagePreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

document.querySelector('#imageUpload').addEventListener('change',function(){
    readURL(this);
});
