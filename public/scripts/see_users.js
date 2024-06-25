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
                performActions(userId).then(() => {
                    deleteUser(userId).then(() => {window.location.href='/admin.html'});
                });
            });
        });
    })
    .catch(error => {
        console.error("Error:", error);
    });


function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

async function performActions(userId) {
    try {
        const reportResponse = await fetch(window.location.origin + "/Web_Project/public/index.php/report/user_id/"+ userId, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + sessionStorage.getItem('jwt')
            }
        });

        if (!reportResponse.ok) {
            const errorData = await reportResponse.json();
            throw new Error(errorData.error);
        }

        const reportData = await reportResponse.json();
        console.log(reportData);

        await sleep(2000);

        for (const item of reportData) {
            const imageResponse = await fetch(window.location.origin + '/Web_Project/public/index.php/image/' + item.id, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + sessionStorage.getItem('jwt')
                }
            });

            if (!imageResponse.ok) {
                const errorData = await imageResponse.json();
                throw new Error(errorData.error);
            }

            console.log('Image deleted successfully');

            const reportDeleteResponse = await fetch(window.location.origin + '/Web_Project/public/index.php/report/' + item.id, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + sessionStorage.getItem('jwt')
                }
            });

            if (!reportDeleteResponse.ok) {
                const errorData = await reportDeleteResponse.json();
                throw new Error(errorData.error);
            }

            console.log('Report deleted successfully');
        }
    } catch (error) {
        console.error("Error: " + error);
    }
}

async function deleteUser(userId) {
    try {
        const deleteUserResponse = await fetch(window.location.origin + '/Web_Project/public/index.php/user/' + userId, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + sessionStorage.getItem('jwt')
            }
        });

        if (!deleteUserResponse.ok) {
            const errorData = await deleteUserResponse.json();
            throw new Error(errorData.error);
        }

        console.log('User removed successfully');

        await sleep(3000);

    } catch (error) {
        console.error("Error: " + error);
    }
}
