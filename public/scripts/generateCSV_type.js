document.addEventListener("DOMContentLoaded", () => {
    document
      .querySelector(".csv_type")
      .addEventListener("click", async function () {
        const response = await fetch(window.location.origin + '/Web_Project/public/index.php/report/piechart_type');
        const data = await response.json();
  
        let csvContent = "data:text/csv;charset=utf-8,";
        csvContent += "Type,Count\n";
        data.forEach((item) => {
          csvContent += `${item[0]},${item[1]}\n`;
        });
  
        const link = document.createElement("a");
        link.href = encodeURI(csvContent);
        link.download = "statisticsTypes.csv";
        link.click();
      });
  });
  