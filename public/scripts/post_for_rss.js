let currentUrl = window.location.href;
let reportId = currentUrl.split('/').pop();

fetch(window.location.origin + "/Web_Project/public/index.php/report/" + reportId, {
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
        const userUrl = window.location.origin + '/Web_Project/public/index.php/user/' + data.user_id;

        return fetch(userUrl, {
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
            .then(userData => {
                const username = userData.username;
                document.getElementById("postDetails").innerHTML = "<h2>Post details</h2>" +
                    "<p><strong>ID:</strong> " + data.id + "</p>" +
                    "<p><strong>Type:</strong> " + data.animal_type + "</p>" +
                    "<p><strong>City:</strong> " + data.city + "</p>" +
                    "<p><strong>Street:</strong> " + data.street + "</p>" +
                    "<p><strong>Description:</strong> " + data.description + "</p>" +
                    "<p><strong>Additional Aspects:</strong> " + data.additional_aspects + "</p>" +
                    "<p><strong>Publication date:</strong> " + data.pub_date + "</p>" +
                    "<p><strong>Posted by:</strong> " + username + "</p>" +
                    "<p><strong>Images:</strong>" +
                    "<div id='images'></div>";
                see_images(reportId);
            });
    })
    .catch(error => {
        console.error("Error: " + error);
    });
