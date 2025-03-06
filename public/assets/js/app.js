(function(){
    const btnVisibilityPassword = document.querySelectorAll('.btn-visibility-password');

    btnVisibilityPassword.forEach(btn => {
        btn.onclick = toggleVisibilityPassword;
    });

    function toggleVisibilityPassword() {
        const inputPassword = document.getElementById(this.dataset.toggleVisisbility);
        const eye = this.querySelector('.icon-eye');
        const eyeSlash = this.querySelector('.icon-eye-slash');

        if (inputPassword.type === 'text') {
            inputPassword.type = 'password';
            eye.style.display = 'block';
            eyeSlash.style.display = 'none';
        } else {
            inputPassword.type = 'text';
            eyeSlash.style.display = 'block';
            eye.style.display = 'none';
        }
    }
})()