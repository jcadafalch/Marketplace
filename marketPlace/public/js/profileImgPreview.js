function readURL(input) {
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function(e) {
            const shopLogo = document.querySelector('#shopLogo');
            if (shopLogo) {
                shopLogo.style.display='none'
            }
            
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
