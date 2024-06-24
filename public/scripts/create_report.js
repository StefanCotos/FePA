const mask = document.getElementById('mask');
const notLogged = document.getElementById('notLogged');
const isAdminAndNot = document.getElementById('isAdmin');
const jwt = sessionStorage.getItem('jwt');
document.getElementById("submit_form").addEventListener("submit", function (event) {
    event.preventDefault();
    if (jwt) {
        fetch(window.location.origin + '/Web_Project/public/index.php/user/isAdmin', {
            method: 'GET',
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
                return response.json();
            })
            .then(data => {
                let ok = data.isAdmin;

                if (ok === 0) {
                    let animal_type = document.getElementById("animal_type").value;
                    let city = document.getElementById("city").value;
                    let street = document.getElementById("street").value;
                    let description = document.getElementById("description").value;
                    let additional_aspects = document.getElementById("additional_aspects").value;
                    let images = document.getElementById("Photos");
                    const files = images.files;

                    const data = {
                        animal_type: animal_type,
                        city: city,
                        street: street,
                        description: description,
                        additional_aspects: additional_aspects,
                    };

                    fetch(
                        window.location.origin + "/Web_Project/public/index.php/report",
                        {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                'Authorization': 'Bearer ' + jwt
                            },
                            body: JSON.stringify(data),
                        }
                    )
                        .then((response) => {
                            if (!response.ok) {
                                return response.json().then((errorData) => {
                                    throw new Error(errorData.error);
                                });
                            }
                            return response.json();
                        })
                        .then((data) => {
                            console.log("Report created successfully", data);

                            for (let i = 0; i < files.length; i++) {
                                const file = files[i];
                                const reader = new FileReader();

                                reader.onload = function (e) {
                                    const base64String = e.target.result.split(',')[1];
                                    const data1 = {
                                        type: file.type,
                                        base64: base64String,
                                        reportId: data.reportId
                                    };

                                    fetch(
                                        window.location.origin + "/Web_Project/public/index.php/image",
                                        {
                                            method: "POST",
                                            headers: {
                                                "Content-Type": "application/json",
                                                'Authorization': 'Bearer ' + jwt
                                            },
                                            body: JSON.stringify(data1),
                                        }
                                    )
                                        .then((response) => {
                                            if (!response.ok) {
                                                return response.json().then((errorData) => {
                                                    throw new Error(errorData.error);
                                                });
                                            }
                                        })
                                        .then((data) => {
                                            console.log("Image created successfully", data);
                                        })
                                        .catch((error) => {
                                            console.error("Error:", error);
                                        });

                                };
                                reader.readAsDataURL(file);
                            }

                            setTimeout(function () {
                                window.location.reload();
                            }, 2000);
                        })
                        .catch((error) => {
                            console.error("Error:", error);
                        });
                } else {
                    isAdminAndNot.style.display = 'block';
                    mask.style.display = 'none';
                    setTimeout(function () {
                        isAdminAndNot.style.display = 'none';
                        mask.style.display = 'block';
                    }, 5000);
                }

            })
            .catch(error => {
                console.log(error);
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
