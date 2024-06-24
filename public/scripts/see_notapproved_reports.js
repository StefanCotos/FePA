fetch(window.location.origin + "/Web_Project/public/index.php/report/not_approved", {
    method: 'GET',
    headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer ' + sessionStorage.getItem('jwt')
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

        data.forEach((item) => {
            html_append +=
                "<tr>" +
                "<td>" +
                item.id +
                "</td>" +
                "<td>" +
                item.animal_type +
                "</td>" +
                "<td>" +
                item.city +
                "</td>" +
                "<td>" +
                item.street +
                "</td>" +
                "<td><input class='view_post' type='button' id='View_post" +
                item.id +
                "' value='View post' data-id='" +
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
                "'></td>" +
                "</tr>";
        });

        document.getElementById('reportsNotApproved').innerHTML += html_append;
        document.querySelectorAll('.view_post').forEach(button => {
            button.addEventListener('click', function () {
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
                        window.location.href = "postuntilapprove.html";
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