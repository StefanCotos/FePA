const loginForm = document.getElementById("log_in_form");

loginForm.addEventListener('submit', function (event) {
    event.preventDefault();
    const emailValue = document.getElementById('E-Mail').value;
    const username = emailValue.substring(0, emailValue.indexOf('@'));

    setTimeout(function () {
        localStorage.setItem('profileButton', username);
        window.location.href = 'index.html';
    }, 2000);

});

const forgot = document.getElementById("forgot_password");
const forgotForm = document.getElementById("forgot_form");

forgot.addEventListener('click', function () {
    loginForm.style.display="none";
    setTimeout(function () {
        forgotForm.style.display = "flex";
    }, 200);
});

const codeForm = document.getElementById("code_form")

forgotForm.addEventListener('submit', function (event) {
    event.preventDefault();
    forgotForm.style.display="none";

    setTimeout(function () {
        codeForm.style.display="flex";
    }, 200);

});

const resetForm = document.getElementById("reset_form")

codeForm.addEventListener('submit', function (event) {
    event.preventDefault();
    codeForm.style.display="none";

    setTimeout(function () {
        resetForm.style.display="flex";
    }, 200);
});

const password = document.getElementById('Password_Reset');
const conf_password = document.getElementById('Confirm_Password');
const errorMessage = document.getElementById('errorMessage');
const mask = document.getElementById('mask')

resetForm.addEventListener('submit', function (event) {
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
        resetForm.style.display="none";

        setTimeout(function () {
            window.location.href = 'log_in.html';
        }, 200);
    }
});