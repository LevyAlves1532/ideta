(function(){
    /**
     * Input Password
     */
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

    /**
     * Change quantity from rows in the table
     */
    const selectQtdRows = document.getElementById('qtd-rows');

    if (selectQtdRows) {
        selectQtdRows.onchange = filterQtdRows;

        function filterQtdRows() {
            const url = window.location.href;
            window.location.href = url + (url.includes('?') ? '&qtd_rows=' + this.value : '?qtd_rows=' + this.value);
        }
    }

    const modalDelete = document.getElementById('modal-delete');

    if (modalDelete) {
        const btnsDeleteModalConfirm = document.querySelectorAll('[data-target="#modal-delete"]');
    
        if (btnsDeleteModalConfirm.length > 0) {
            btnsDeleteModalConfirm.forEach(btn => {
                btn.onclick = addActionFormDeleteModal;
            });
        }
    
        function addActionFormDeleteModal() {
            const form = modalDelete.querySelector('form');

            if (form) {
                form.action = this.dataset.action;
                console.log(form);
            }
        }
    }
})()