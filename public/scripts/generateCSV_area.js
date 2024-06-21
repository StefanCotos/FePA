document.addEventListener("DOMContentLoaded", () => {
  document
    .querySelector(".csv_area")
    .addEventListener("click", async function () {
      const response = await fetch("../../src/php/piechart_area.php");
      const data = await response.json();

      let csvContent = "data:text/csv;charset=utf-8,";
      csvContent += "City,Count\n";
      data.forEach((item) => {
        csvContent += `${item[0]},${item[1]}\n`;
      });

      const link = document.createElement("a");
      link.href = encodeURI(csvContent);
      link.download = "statistics.csv";
      link.click();
    });
});
