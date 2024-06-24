let buttonAccept = document.getElementById('buttonAccept');
let buttonDecline = document.getElementById('buttonDecline');
const jwt = sessionStorage.getItem('jwt');
let reportData = JSON.parse(sessionStorage.getItem("reportData"));

buttonAccept.addEventListener('click', (e) => {

    fetch(window.location.origin + '/Web_Project/public/index.php/report/' + reportData.id, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + jwt
        },
    })
        .then(response => {
            if (!response.ok) {
                return response.json().then(errorData => {
                    throw new Error(errorData.error);
                });
            }
        })
        .then(data => {
            console.log('Report updated successfully', data);
            setTimeout(function () {
                window.location.href = '/admin.html';
            }, 2000);
        })
        .catch(error => {
            console.log(error);
        });
})

buttonDecline.addEventListener('click', (e) => {

    fetch(window.location.origin + '/Web_Project/public/index.php/image/' + reportData.id, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + jwt
        },
    })
        .then(response => {
            if (!response.ok) {
                return response.json().then(errorData => {
                    throw new Error(errorData.error);
                });
            }
        })
        .then(data => {
            console.log('Image deleted successfully', data);
                fetch(window.location.origin + '/Web_Project/public/index.php/report/' + reportData.id, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + jwt
                    },
                })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(errorData => {
                                throw new Error(errorData.error);
                            });
                        }
                    })
                    .then(data => {
                        console.log('Report deleted successfully', data);
                    })
                    .catch(error => {
                        console.log(error);
                    });
            setTimeout(function () {
                window.location.href = '/admin.html';
            }, 2000);
        })
        .catch(error => {
            console.log(error);
        });
})