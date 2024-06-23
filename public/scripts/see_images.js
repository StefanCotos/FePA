function see_images(reportId) {
    $.ajax({
        url: window.location.origin + "/Web_Project/public/index.php/image/"+reportId,
        type: "GET",
        dataType: "json",
        success: function (data) {
            console.log(data);
            let html_append = "";
            $.each(data, function (index, item) {
                html_append +=
                    "<img class='mySlides' id='news-image' src='" + item.name + "' alt='animals'>";
            });
            $("#images").html(html_append);
            carousel();
        },
        error: function (xhr, status, error) {
            console.error("Error: " + error);
        },
    });

}