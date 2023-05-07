function readURL(input) {
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function(e) {
            const shopLogo = document.querySelector('#shopLogo');
            const profileImg = document.querySelector('#profileImg');
            const shopImg = document.querySelector('#shopImg');
            if (shopLogo) {
                shopLogo.style.display='none'
            }
            if (profileImg) {
                profileImg.style.display='none'
            }
            if (shopImg) {
                shopImg.style.display='none'
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
