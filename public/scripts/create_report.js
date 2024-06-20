document
  .getElementById("submit_form")
  .addEventListener("submit", function (event) {
    event.preventDefault();
    console.log("Form submitted"); // Adăugăm această linie
    let animal_type = document.getElementById("animal_type").value;
    let city = document.getElementById("city").value;
    let street = document.getElementById("street").value;
    let description = document.getElementById("description").value;
    let additional_aspects =
      document.getElementById("additional_aspects").value;

    const data = {
      animal_type: animal_type,
      city: city,
      street: street,
      description: description,
      additional_aspects: additional_aspects,
    };

    console.log(data); // Adăugăm această linie

    fetch(
      window.location.origin +
        "/Web_Project/dispatchers/report_dispatcher.php/report",
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
      }
    )
      .then((response) => {
        if (!response.ok) {
          return response.json().then((errorData) => {
            throw new Error(errorData.error);
          });
        }
        return response.json();
      })
      .then((data) => {
        console.log("Report created successfully", data);
        setTimeout(function () {
          //window.location.href = "report.php";
        }, 2000);
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  });
