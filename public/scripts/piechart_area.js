google.charts.load("current", { packages: ["corechart"] });
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
  fetch(window.location.origin + '/Web_Project/public/index.php/report/piechart_area')
    .then((response) => response.json())
    .then((data) => {
      data.unshift(["City", "Count"]);
      let dataTable = google.visualization.arrayToDataTable(data);
      let options = {
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

      let chart = new google.visualization.PieChart(
        document.getElementById("piechart_area")
      );
      chart.draw(dataTable, options);
    })
    .catch((error) => {
      console.error("Error fetching data:", error);
    });
}
