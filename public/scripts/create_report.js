const mask = document.getElementById('mask');
const notLogged = document.getElementById('notLogged');
const jwt = sessionStorage.getItem('jwt');
document.getElementById("submit_form").addEventListener("submit", function (event) {
    event.preventDefault();
    if (jwt) {
        let animal_type = document.getElementById("animal_type").value;
        let city = document.getElementById("city").value;
        let street = document.getElementById("street").value;
        let description = document.getElementById("description").value;
        let additional_aspects = document.getElementById("additional_aspects").value;

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
            })
            .then((data) => {
                console.log("Report created successfully", data);
                setTimeout(function () {
                    window.location.reload();
                }, 2000);
            })
            .catch((error) => {
                console.error("Error:", error);
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
