document.addEventListener("DOMContentLoaded", () => {
  document
    .querySelector(".html_area")
    .addEventListener("click", async function () {
      const response = await fetch(window.location.origin + '/Web_Project/public/index.php/report/piechart_area');
      const data = await response.json();

      let htmlContent =
        "<!DOCTYPE html><html lang='en'><head><title>Statistics</title></head><body>";
      htmlContent += "<h1>Statistics Report</h1>";

      htmlContent += "<table border='1'><tr><th>City</th><th>Count</th></tr>";
      data.forEach((item) => {
        htmlContent += `<tr><td>${item[0]}</td><td>${item[1]}</td></tr>`;
      });
      htmlContent += "</table>";

      htmlContent += "</body></html>";

      const blob = new Blob([htmlContent], {
        type: "text/html;charset=utf-8;",
      });
      const link = document.createElement("a");
      link.href = URL.createObjectURL(blob);
      link.download = "statistics.html";
      link.click();
    });
});
