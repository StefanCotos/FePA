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
                item.descriptions +
                "' data-additional_aspects='" +
                item.additional_aspects +
                "'></td>" +
                "</tr>";
        });
        $("#reportsNotApproved").append(html_append);

        $(".view_post").click(function () {
            let reportData = {
                id: $(this).data("id"),
                animal_type: $(this).data("animal_type"),
                city: $(this).data("city"),
                street: $(this).data("street"),
                descriptions: $(this).data("description"),
                additional_aspects: $(this).data("additional_aspects"),
            };

            localStorage.setItem("reportData", JSON.stringify(reportData));
            window.location.href = "postuntilapprove.html";
        });
    },
    error: function (xhr, status, error) {
        console.error("Error: " + error);
    },
});
