document.addEventListener("DOMContentLoaded", () => {
  document
    .querySelector(".pdf_type")
    .addEventListener("click", async function () {
      const response = await fetch(window.location.origin + '/Web_Project/public/index.php/report/piechart_type');
      const data = await response.json();

      const { jsPDF } = window.jspdf;
      const doc = new jsPDF();

      doc.setFontSize(16);
      doc.text("Statistics Report", 10, 10);

      const tableHeaders = ["Type", "Count"];
      const tableData = data.map((item) => [item[0], item[1]]);

      doc.autoTable({
        head: [tableHeaders],
        body: tableData,
        startY: 20,
      });

      doc.save("statisticsTypes.pdf");
    });
});
