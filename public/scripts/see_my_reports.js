fetch(window.location.origin + "/Web_Project/public/index.php/report/user_id/-", {
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

        data.forEach((item, index) => {
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
                "<td><input class='delete_post' type='button' id='Delete_Post" +
                (index + 1) +
                "' value='Delete post' data-id='" +
                item.id +
                "'></td>" +
                "</tr>";
        });

        document.getElementById('reportsApproved').innerHTML += html_append;

        document.querySelectorAll('.delete_post').forEach(button => {
            button.addEventListener('click', function () {
                const postId = this.getAttribute('data-id');

                fetch(window.location.origin + '/Web_Project/public/index.php/image/' + postId, {
                    method: 'DELETE',
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
                    })
                    .then(data => {
                        console.log('Image deleted successfully', data);
                        fetch(window.location.origin + '/Web_Project/public/index.php/report/' + postId, {
                            method: 'DELETE',
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
                            })
                            .then(data => {
                                console.log('Report deleted successfully', data);
                                setTimeout(() => {
                                    window.location.href = '/account.html';
                                }, 2000);
                            })
                            .catch(error => {
                                console.error(error);
                            });
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