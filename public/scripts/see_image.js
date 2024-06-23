function see_image(image, reportId) {
    $.ajax({
        url: window.location.origin + "/Web_Project/public/index.php/image/"+reportId,
        type: "GET",
        dataType: "json",
        success: function (data) {
            console.log(data);
            let html_append = "";
            $.each(data, function (index, item) {
                html_append +=
                    "<img id='news-image' src='" + item.name + "' alt='animals'>";
                return false;
            });
            $("#"+image).html(html_append);
        },
        error: function (xhr, status, error) {
            console.error("Error: " + error);
        },
    });

}