document.addEventListener("DOMContentLoaded", () => {
  document
    .querySelector(".pdf_area")
    .addEventListener("click", async function () {
      const response = await fetch(window.location.origin + '/Web_Project/public/index.php/report/piechart_area');
      const data = await response.json();

      const { jsPDF } = window.jspdf;
      const doc = new jsPDF();

      doc.setFontSize(16);
      doc.text("Statistics Report", 10, 10);

      const tableHeaders = ["City", "Count"];
      const tableData = data.map((item) => [item[0], item[1]]);

      doc.autoTable({
        head: [tableHeaders],
        body: tableData,
        startY: 20,
      });

      doc.save("statistics.pdf");
    });
});
