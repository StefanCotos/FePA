const loginForm = document.getElementById('sign_up_form');
const password = document.getElementById('Password');
const conf_password = document.getElementById('Confirm_Password');
const errorMessage = document.getElementById('errorMessage');

loginForm.addEventListener('submit', function (event) {
    event.preventDefault();

    const password1 = password.value;
    const password2 = conf_password.value;

    if (password1 !== password2) {
        errorMessage.style.display = 'block';
        mask.style.display = 'none';
        setTimeout(function () {
            errorMessage.style.display = 'none';
            mask.style.display = 'block';
        }, 2000);
    } else {
        const username = document.getElementById('Username').value;
        if (username.length === 0) {
            const emailValue = document.getElementById('E-Mail').value;
            const username = emailValue.substring(0, emailValue.indexOf('@'));
            localStorage.setItem('profileButton', username);
        }
        else
            localStorage.setItem('profileButton', username);
        setTimeout(function () {
            window.location.href = 'index.html';
        }, 2000);

    }
});