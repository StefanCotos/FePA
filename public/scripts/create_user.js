const mask = document.getElementById('mask');
const errorMessage = document.getElementById('errorMessage');
const existMessage = document.getElementById('existMessage');
const usernameMessage = document.getElementById('usernameMessage');
document.getElementById('sign_up_form').addEventListener('submit', function (event) {
    event.preventDefault();
    let first_name = document.getElementById("First_Name").value;
    let last_name = document.getElementById("Last_Name").value;
    let email = document.getElementById("E-Mail").value;
    let password = document.getElementById("Password").value;
    let confirmPassword = document.getElementById("Confirm_Password").value;
    let username = document.getElementById("Username").value;

    if (password === confirmPassword) {

        if (username.trim() === '') {
            username = email.split('@')[0];
        }

        const data = {
            first_name: first_name,
            last_name: last_name,
            email: email,
            password: password,
            username: username
        };

        fetch(window.location.origin + '/Web_Project/public/index.php/user', {
            method: 'POST',
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
                return response.json();
            })
            .then(data => {
                console.log('User created successfully', data);
                sessionStorage.setItem('profileButton', username);
                sessionStorage.setItem('jwt', data.jwt);
                setTimeout(function () {
                    window.location.href = '/';
                }, 2000);
            })
            .catch(error => {
                if (error.message === "Email already exists") {
                    existMessage.style.display = 'block';
                    mask.style.display = 'none';
                    setTimeout(function () {
                        existMessage.style.display = 'none';
                        mask.style.display = 'block';
                    }, 5000);
                } else if (error.message === "Username already exists") {
                    usernameMessage.style.display = 'block';
                    mask.style.display = 'none';
                    setTimeout(function () {
                        usernameMessage.style.display = 'none';
                        mask.style.display = 'block';
                    }, 5000);
                }
            });
    } else {
        errorMessage.style.display = 'block';
        mask.style.display = 'none';
        setTimeout(function () {
            errorMessage.style.display = 'none';
            mask.style.display = 'block';
        }, 5000);
    }
});
