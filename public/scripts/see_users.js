fetch(window.location.origin + "/Web_Project/public/index.php/user", {
    method: "GET",
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
        console.log(data);
        let html_append = "";
        data.forEach((item, index) => {
            html_append +=
                "<tr>" +
                "<td>" + item.id + "</td>" +
                "<td>" + item.last_name + "</td>" +
                "<td>" + item.first_name + "</td>" +
                "<td>" + item.email + "</td>" +
                "<td><input class='delete_button' type='button' id='Delete_button" +
                (index + 1) +
                "' value='Delete account' data-id='" +
                item.id + "'></td>" +
                "</tr>";
        });
        document.getElementById("usersTable").innerHTML += html_append;

        document.querySelectorAll(".delete_button").forEach(button => {
            button.addEventListener("click", function () {
                const userId = this.getAttribute('data-id');

                fetch(window.location.origin + '/Web_Project/public/index.php/user/' + userId, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + sessionStorage.getItem('jwt')
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
                        console.log('User removed successfully', data);
                        alert("User removed successfully");
                        setTimeout(function () {
                            window.location.reload();
                        }, 1000);
                    })
                    .catch(error => {
                        console.log(error);
                    });
            });
        });
    })
    .catch(error => {
        console.error("Error:", error);
    });
