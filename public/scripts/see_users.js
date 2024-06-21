$.ajax({
    url: window.location.origin + "/Web_Project/src/php/see_users.php",
    type: "GET",
    dataType: "json",
    success: function (data) {
        console.log(data);
        let html_append = "";
        $.each(data, function (index, item) {
            html_append +=
                "<tr>" +
                "<td>" +
                item.id +
                "</td>" +
                "<td>" +
                item.last_name +
                "</td>" +
                "<td>" +
                item.first_name +
                "</td>" +
                "<td>" +
                item.email +
                "</td>" +
                "<td><input class='delete_button' type='button' id='Delete_button" +
                (index+1) +
                "' value='Delete account' data-id='"+
                item.id +"'></td>" +
                "</tr>";
        });
        $("#usersTable").append(html_append);

        $(".delete_button").click(function () {
            const jwt = sessionStorage.getItem('jwt');

            fetch(window.location.origin + '/Web_Project/public/index.php/user/' + $(this).data("id"), {
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
    },
    error: function (xhr, status, error) {
        console.error("Error: " + error);
    },
});
