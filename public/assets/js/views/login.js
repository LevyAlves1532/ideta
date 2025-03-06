(function(){
    document.getElementById('btn-visibility-password').onclick = function () {
        const password = document.getElementById('password');
        const eye = document.querySelector('.icon-eye');
        const eyeSlash = document.querySelector('.icon-eye-slash');

        if (password.type === 'text') {
            password.type = 'password';
            eye.style.display = 'block';
            eyeSlash.style.display = 'none';
        } else {
            password.type = 'text';
            eyeSlash.style.display = 'block';
            eye.style.display = 'none';
        }
    }
})()