const mask = document.getElementById('mask');
const notLogged = document.getElementById('notLogged');
const internalError = document.getElementById('internalError');
const incorrectMail = document.getElementById('incorrectMail');
const jwt = sessionStorage.getItem('jwt');

document.getElementById('submit_form').addEventListener('submit', function (event) {
    event.preventDefault();
    if (jwt) {
        let name = document.getElementById("Name").value;
        let subject = document.getElementById("Subject").value;
        let email = document.getElementById("E-Mail").value;
        let message = document.getElementById("Message").value;

        const data = {
            name: name,
            subject: subject,
            email: email,
            message: message
        };

        fetch(window.location.origin + '/Web_Project/public/index.php/user/contact', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + jwt
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
            .then(() => {
                console.log('Email sent');
                alert('Email sent successfully.');
                setTimeout(function () {
                    window.location.reload();
                }, 2000);
            })
            .catch(error => {
                if (error.message === "Internal Server Error") {
                    internalError.style.display = 'block';
                    mask.style.display = 'none';
                    setTimeout(function () {
                        internalError.style.display = 'none';
                        mask.style.display = 'block';
                    }, 5000);
                } else if (error.message === "Invalid email address") {
                    incorrectMail.style.display = 'block';
                    mask.style.display = 'none';
                    setTimeout(function () {
                        incorrectMail.style.display = 'none';
                        mask.style.display = 'block';
                    }, 5000);
                }
            });
    } else {
        notLogged.style.display = 'block';
        mask.style.display = 'none';
        setTimeout(function () {
            notLogged.style.display = 'none';
            mask.style.display = 'block';
        }, 5000);
    }
});