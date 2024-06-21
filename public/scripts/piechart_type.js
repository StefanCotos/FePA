google.charts.load("current", { packages: ["corechart"] });
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
  fetch("../php/piechart_type.php")
    .then((response) => response.json())
    .then((data) => {
      data.unshift(["Animal Type", "Count"]);
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
        document.getElementById("piechart_type")
      );
      chart.draw(dataTable, options);
    })
    .catch((error) => {
      console.error("Error fetching data:", error);
    });
}
