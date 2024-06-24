function see_image(image, reportId) {
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
            let html_append;
            if (Object.keys(data).length === 0) {
                html_append = "<img id='news-image' src='https://res.cloudinary.com/hf0egkogn/image/upload/v1719143533/33.jpg' alt='animals'>";
            } else {
                html_append = "<img id='news-image' src='" + data[0].name + "' alt='animals'>";
            }
            document.getElementById(image).innerHTML = html_append;
        })
        .catch(error => {
            console.error("Error: " + error);
        });
}
