let currentUrl = window.location.href;
let reportId = currentUrl.split('/').pop();

$.ajax({
    url: window.location.origin + "/Web_Project/public/index.php/report/" + reportId,
    type: "GET",
    dataType: "json",
    success: function (data) {
        console.log(data);
        let html_append =
            "<h2>Post details</h2>" +
            "<p><strong>ID:</strong>" + data.id + "</p>" +
            "<p><strong>Type:</strong>" + data.animal_type + "</p>" +
            "<p><strong>City:</strong>" + data.city + "</p>" +
            "<p><strong>Street:</strong>" + data.street + "</p>" +
            "<p><strong>Description:</strong>" + data.description + "</p>" +
            "<p><strong>Additional Aspects:</strong>" + data.additional_aspects + "</p>" +
            "<p><strong>Images:</strong>" +
            "<div id='images'></div>"

        $("#postDetails").html(html_append);
        see_images(reportId);

    },
    error: function (xhr, status, error) {
        console.error("Error: " + error);
    },
});