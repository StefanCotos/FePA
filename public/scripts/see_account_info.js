fetch(window.location.origin + "/Web_Project/public/index.php/user/info", {
    method: 'GET',
    headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer ' + sessionStorage.getItem('jwt')
    }
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
        sessionStorage.setItem("userId", data.id);
        let html_append =
            "<tr>" +
            "<td>" +
            data.id +
            "</td>" +
            "<td>" +
            data.first_name +
            "</td>" +
            "<td>" +
            data.last_name +
            "</td>" +
            "<td>" +
            data.email +
            "</td>" +
            "<td>" +
            data.username +
            "</td>" +
            "</tr>";

        document.getElementById('accountInfo').innerHTML += html_append;
    })
    .catch(error => {
        console.error("Error: " + error);
    });