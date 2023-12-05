document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    const togglePasswordButton = document.createElement('button');

    togglePasswordButton.textContent = 'Show Password';
    togglePasswordButton.type = 'button';
    togglePasswordButton.classList.add('password-toggle-button');

    passwordInput.parentNode.appendChild(togglePasswordButton);

    togglePasswordButton.addEventListener('click', function() {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            togglePasswordButton.textContent = 'Hide Password';
        } else {
            passwordInput.type = 'password';
            togglePasswordButton.textContent = 'Show Password';
        }
    });

    form.addEventListener('submit', function(event) {
        event.preventDefault();

        if (validateForm()) {
            console.log('Form valid, proses login');
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

        return isValid;
    }
});