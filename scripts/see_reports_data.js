$.ajax({
  url: "http://localhost/Web-Project/php/see_reports_data.php",
  type: "GET",
  dataType: "json",
  success: function (data) {
    console.log(data);
    var html_append = "";
    $.each(data, function (index, item) {
      html_append +=
        "<a class='no-link-style' id='news-item'><strong>" +
        "Type: " +
        item.animal_type +
        "</strong><br>" +
        "<img src='assets/Logo.png' id='news-logo' alt='logo'>" +
        "<img src='" +
        item.image +
        "' id='news-image' alt='animals'><strong>" +
        "<div id='news-description'>" +
        "Details: " +
        "</strong><br>" +
        item.descriptions +
        "<br>" +
        item.additional_aspects +
        "<br>" +
        item.city +
        ". " +
        item.street +
        "." +
        "<br>..." +
        "</div></a>";
    });
    $("#news").html(html_append);
  },
});
