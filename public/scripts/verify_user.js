const mask = document.getElementById('mask');
const nonexistentMessage = document.getElementById('nonexistentMessage');
const passwordMessage = document.getElementById('passwordMessage');

document.getElementById('log_in_form').addEventListener('submit', function (event) {
    event.preventDefault();
    let user = document.getElementById("E-Mail").value;
    let password = document.getElementById("Password").value;

    const data = {
        user: user,
        password: password
    };

    fetch(window.location.origin + '/Web_Project/public/index.php/user/exist', {
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
            console.log('User authenticated successfully');
            let username = data.username;
            sessionStorage.setItem('profileButton', username);
            sessionStorage.setItem('jwt', data.jwt);
            sessionStorage.setItem('isAdmin', data.isAdmin);
            setTimeout(function () {
                window.location.href = '/';
            }, 2000);
        })
        .catch(error => {
            if (error.message === "Not Found") {
                nonexistentMessage.style.display = 'block';
                mask.style.display = 'none';
                setTimeout(function () {
                    nonexistentMessage.style.display = 'none';
                    mask.style.display = 'block';
                }, 5000);
            } else if (error.message === "Incorrect password") {
                passwordMessage.style.display = 'block';
                mask.style.display = 'none';
                setTimeout(function () {
                    passwordMessage.style.display = 'none';
                    mask.style.display = 'block';
                }, 5000);
            }
        });
});