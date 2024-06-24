$.ajax({
    url: window.location.origin + "/Web_Project/public/index.php/report/not_approved",
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
                "<td><input class='view_post' type='button' id='View_post" +
                item.id +
                "' value='View post' data-id='" +
                item.id +
                "' data-animal_type='" +
                item.animal_type +
                "' data-city='" +
                item.city +
                "' data-street='" +
                item.street +
                "' data-description='" +
                item.description +
                "' data-additional_aspects='" +
                item.additional_aspects +
                "' data-user_id='" +
                item.user_id +
                "' data-pub_date='" +
                item.pub_date +
                "'></td>" +
                "</tr>";
        });
        $("#reportsNotApproved").append(html_append);

        $(".view_post").click(function () {
            let username;
            fetch(window.location.origin + '/Web_Project/public/index.php/user/' + $(this).data("user_id"), {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
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
                    username = data.username;
                    let reportData = {
                        id: $(this).data("id"),
                        animal_type: $(this).data("animal_type"),
                        city: $(this).data("city"),
                        street: $(this).data("street"),
                        description: $(this).data("description"),
                        additional_aspects: $(this).data("additional_aspects"),
                        username: username,
                        pub_date: $(this).data("pub_date"),
                    };

                    sessionStorage.setItem("reportData", JSON.stringify(reportData));
                    window.location.href = "postuntilapprove.html";
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
