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
                "<td><input class='delete_button' type='submit' id='Delete_button" +
                (index + 1) +
                "' value='Delete account'></td>" +
                "</tr>";
        });
        $("#usersTable").append(html_append);
    },
    error: function (xhr, status, error) {
        console.error("Error: " + error);
    },
});
