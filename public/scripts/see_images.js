function see_images(reportId) {
    const url = window.location.origin + "/Web_Project/public/index.php/image/" + reportId;

    fetch(url, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(response => {
            if (!response.ok) {
                return response.json().then(errorData => {
                    throw new Error(errorData.error);
                });
            }
            return response.json();
        })
        .then(data => {
            console.log(data);
            let html_append = "";
            if (Object.keys(data).length === 0) {
                html_append = "<img id='news-image' src='https://res.cloudinary.com/hf0egkogn/image/upload/v1719143533/33.jpg' alt='animals'>";
            } else {
                data.forEach((item, index) => {
                    html_append += "<img class='mySlides' id='news-image' src='" + item.name + "' alt='animals'>";
                });
            }
            document.getElementById("images").innerHTML = html_append;
            carousel();
        })
        .catch(error => {
            console.error("Error: " + error);
        });
}
