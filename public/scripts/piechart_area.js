google.charts.load("current", { packages: ["corechart"] });
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
  fetch("../php/piechart_area.php")
    .then((response) => response.json())
    .then((data) => {
      data.unshift(["City", "Count"]);
      var dataTable = google.visualization.arrayToDataTable(data);
      var options = {
        backgroundColor: "transparent",
        chartArea: {
          width: "80%",
          height: "80%",
        },
        legend: {
          position: "bottom",
          alignment: "center",
          textStyle: {
            fontSize: 14,
          },
        },
        pieSliceBorderColor: "transparent",
      };

      var chart = new google.visualization.PieChart(
        document.getElementById("piechart_area")
      );
      chart.draw(dataTable, options);
    })
    .catch((error) => {
      console.error("Error fetching data:", error);
    });
}
