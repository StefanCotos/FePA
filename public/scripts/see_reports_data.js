fetch(window.location.origin + "/Web_Project/public/index.php/report", {
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
        let image = "image";
        let i = 0;
        let result = "";

        data.forEach((item) => {
            result = image + i;
            html_append +=
                "<div class='preview' id='news-item' data-id='" +
                item.id +
                "' data-animal_type='" +
                item.animal_type +
                "' data-city='" +
                item.city +
                "' data-street='" +
                item.street +
                "' data-description='" +
                item.description +
                "' data-additional_aspects='" +
                item.additional_aspects +
                "' data-user_id='" +
                item.user_id +
                "' data-pub_date='" +
                item.pub_date +
                "'>" +
                "<strong>Type: " +
                item.animal_type +
                "</strong><br>" +
                "<img src='images/Logo.png' id='news-logo' alt='logo'>" +
                "<div id='" +
                result +
                "' ></div>" +
                "<div id='news-description'>" +
                "<strong>Details:</strong><br>" +
                item.description +
                "<br>" +
                item.additional_aspects +
                "<br>" +
                item.city +
                ". " +
                item.street +
                ".<br>..." +
                "</div>" +
                "</div>";
            i++;
        });

        document.getElementById("news").innerHTML = html_append;

        data.forEach((item, index) => {
            let result = image + index;
            see_image(result, item.id);
        });

        document.querySelectorAll('.preview').forEach(preview => {
            preview.addEventListener('click', function () {
                const userId = this.getAttribute('data-user_id');

                fetch(window.location.origin + '/Web_Project/public/index.php/user/' + userId, {
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
                        const reportData = {
                            id: this.getAttribute('data-id'),
                            animal_type: this.getAttribute('data-animal_type'),
                            city: this.getAttribute('data-city'),
                            street: this.getAttribute('data-street'),
                            description: this.getAttribute('data-description'),
                            additional_aspects: this.getAttribute('data-additional_aspects'),
                            username: username,
                            pub_date: this.getAttribute('data-pub_date')
                        };

                        sessionStorage.setItem("reportData", JSON.stringify(reportData));
                        window.location.href = "post.html";
                    })
                    .catch(error => {
                        console.error(error);
                    });
            });
        });
    })
    .catch(error => {
        console.error("Error: " + error);
    });
