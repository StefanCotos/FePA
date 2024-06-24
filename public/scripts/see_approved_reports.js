$.ajax({
    url: window.location.origin + "/Web_Project/public/index.php/report",
    type: "GET",
    dataType: "json",
    headers: {
        'Authorization': 'Bearer ' + sessionStorage.getItem('jwt')
    },
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
                item.animal_type +
                "</td>" +
                "<td>" +
                item.city +
                "</td>" +
                "<td>" +
                item.street +
                "</td>" +
                "<td><input class='delete_post' type='button' id='Delete_Post" +
                (index + 1) +
                "' value='Delete post' data-id='" +
                item.id +
                "'></td>" +
                "</tr>";
        });
        $("#reportsApproved").append(html_append);

        $(".delete_post").click(function () {
            const jwt = sessionStorage.getItem('jwt');

            fetch(window.location.origin + '/Web_Project/public/index.php/image/' + $(this).data("id"), {
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
                    fetch(window.location.origin + '/Web_Project/public/index.php/report/' + $(this).data("id"), {
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
        });

    },
    error: function (xhr, status, error) {
        console.error("Error: " + error);
    },
});
