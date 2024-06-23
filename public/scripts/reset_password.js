const loginForm = document.getElementById("log_in_form");
const forgotForm = document.getElementById("forgot_form");
const codeForm = document.getElementById("code_form");
const mask1 = document.getElementById("mask1");
const emailMessage = document.getElementById('emailMessage');
const resetForm = document.getElementById('reset_form');
const code_introduced = document.getElementById('Code');
const mask2 = document.getElementById("mask2");
const codeMessage = document.getElementById('codeMessage');
const mask3 = document.getElementById("mask3");
const errorMessage = document.getElementById('errorMessage');

document.getElementById('forgot_form').addEventListener('submit', function (event) {
    event.preventDefault();
    let email = document.getElementById("E-Mail_Send").value;
    const data = {
        email: email
    };

    fetch(window.location.origin + '/Web_Project/public/index.php/user/forgot', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    })
        .then(response => {
            if (!response.ok) {
                return response.json().then(errorData => {
                    throw new Error(errorData.error);
                });
            }
            return response.json();
        })
        .then(data => {
            console.log('Email send');
            loginForm.style.display = "none";
            forgotForm.style.display = "none";
            setTimeout(function () {
                codeForm.style.display = "flex";
            }, 200);
            codeForm.addEventListener('submit', function (event) {
                event.preventDefault();
                const code_value = parseInt(code_introduced.value, 10);
                const code = parseInt(data.code, 10);
                if (code === code_value) {
                    codeForm.style.display = "none";
                    setTimeout(function () {
                        resetForm.style.display = "flex";
                    }, 200);

                    document.getElementById('reset_form').addEventListener('submit', function (event) {
                        event.preventDefault();
                        let password = document.getElementById("Password_Reset").value;
                        let confirmPassword = document.getElementById("Confirm_Password").value;

                        if (password === confirmPassword) {
                            const data = {
                                password: password
                            };

                            fetch(window.location.origin + '/Web_Project/public/index.php/user', {
                                method: 'PUT',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify(data)
                            })
                                .then(response => {
                                    if (!response.ok) {
                                        return response.json().then(errorData => {
                                            throw new Error(errorData.error);
                                        });
                                    }
                                })
                                .then(data => {
                                    console.log('Password changed', data);
                                    setTimeout(function () {
                                        window.location.reload();
                                    }, 2000);
                                })
                                .catch(error => {
                                    console.log(error.message);
                                });
                        } else {
                            errorMessage.style.display = 'block';
                            mask3.style.display = 'none';
                            setTimeout(function () {
                                errorMessage.style.display = 'none';
                                mask3.style.display = 'block';
                            }, 5000);
                        }

                    });
                } else {
                    codeMessage.style.display = 'block';
                    mask2.style.display = 'none';
                    setTimeout(function () {
                        codeMessage.style.display = 'none';
                        mask2.style.display = 'block';
                    }, 5000);
                }
            });
        })
        .catch(error => {
            if (error.message === "Not Found") {
                emailMessage.style.display = 'block';
                mask1.style.display = 'none';
                setTimeout(function () {
                    emailMessage.style.display = 'none';
                    mask1.style.display = 'block';
                }, 5000);
            }
        });
});
