document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    const agreeTermCheckbox = document.getElementById('agree-term');
    const showPasswordCheckbox = document.getElementById('show-password');

    form.addEventListener('submit', function(event) {
        event.preventDefault();

        if (validateForm()) {
            console.log('Form valid, proses pendaftaran');
        } else {
            console.log('Form tidak valid');
        }
    });

    function validateForm() {
        let isValid = true;

        if (usernameInput.value.trim() === '') {
            isValid = false;
            alert('Username harus diisi');
        }

        if (passwordInput.value.trim() === '') {
            isValid = false;
            alert('Password harus diisi');
        }

        if (!agreeTermCheckbox.checked) {
            isValid = false;
            alert('Anda harus menerima syarat dan ketentuan');
        }

        return isValid;
    }

    showPasswordCheckbox.addEventListener('change', function() {
        passwordInput.type = this.checked ? 'text' : 'password';
    });

    passwordInput.addEventListener('input', function() {
        var passwordStrength = zxcvbn(this.value);
    });
});