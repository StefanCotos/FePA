$.ajax({
    url: window.location.origin + "/Web_Project/public/index.php/report",
    type: "GET",
    dataType: "json",
    success: function (data) {
        console.log(data);
        let html_append = "";
        let image = "image";
        let i = 0;
        let result = "";
        $.each(data, function (index, item) {
            result = image + i;
            html_append +=
                "<div class='preview' id='news-item' data-id='" +
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
                "'>" +
                "<strong>Type: " +
                item.animal_type +
                "</strong><br>" +
                "<img src='images/Logo.png' id='news-logo' alt='logo'>" +
                "<div id='" +
                result +
                "' ></div>" +
                "<div id='news-description'>" +
                "<strong>Details:</strong><br>" +
                item.description +
                "<br>" +
                item.additional_aspects +
                "<br>" +
                item.city +
                ". " +
                item.street +
                ".<br>..." +
                "</div>" +
                "</div>";
            $("#news").html(html_append);
            see_image(result, item.id);
            i++;
        });

        $(".preview").click(function () {
            let reportData = {
                id: $(this).data("id"),
                animal_type: $(this).data("animal_type"),
                city: $(this).data("city"),
                street: $(this).data("street"),
                description: $(this).data("description"),
                additional_aspects: $(this).data("additional_aspects"),
            };

            sessionStorage.setItem("reportData", JSON.stringify(reportData));
            window.location.href = "post.html";
        });
    },
    error: function (xhr, status, error) {
        console.error("Error: " + error);
    },
});
