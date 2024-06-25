const buttonChangeFirstName = document.getElementById("buttonChangeFirstName");
const buttonChangeLastName = document.getElementById("buttonChangeLastName");
const buttonChangeEmail = document.getElementById("buttonChangeEmail");
const buttonChangeUsername = document.getElementById("buttonChangeUsername");
const buttonChangePassword = document.getElementById("buttonChangePassword");
const buttonDeleteAccount = document.getElementById("buttonDeleteAccount");

buttonChangeFirstName.addEventListener("click", () => {
    let firstName = prompt("Please write your new first name:");
    if (firstName !== null) {
        const data = {
            first_name: firstName
        };
        fetch(window.location.origin + '/Web_Project/public/index.php/user/change_first_name', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + sessionStorage.getItem('jwt')
            },
            body: JSON.stringify(data)
        })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errorData => {
                        throw new Error(errorData.error);
                    });
                }
            })
            .then(data => {
                console.log("First name updated", data);
                setTimeout(function () {
                    window.location.href = '/account.html';
                }, 2000);
            })
            .catch(error => {
                console.log(error);
            });
    } else {
        alert("You have not entering nothing!");
    }
})

buttonChangeLastName.addEventListener("click", () => {
    let lastName = prompt("Please write your new last name:");
    if (lastName !== null) {
        const data = {
            last_name: lastName
        };
        fetch(window.location.origin + '/Web_Project/public/index.php/user/change_last_name', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + sessionStorage.getItem('jwt')
            },
            body: JSON.stringify(data)
        })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errorData => {
                        throw new Error(errorData.error);
                    });
                }
            })
            .then(data => {
                console.log("Last name updated", data);
                setTimeout(function () {
                    window.location.href = '/account.html';
                }, 2000);
            })
            .catch(error => {
                console.log(error);
            });
    } else {
        alert("You have not entering nothing!");
    }
})

buttonChangeEmail.addEventListener("click", () => {
    let email = prompt("Please write your new email:");
    if (email !== null) {
        const data = {
            email: email
        };
        fetch(window.location.origin + '/Web_Project/public/index.php/user/change_email', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + sessionStorage.getItem('jwt')
            },
            body: JSON.stringify(data)
        })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errorData => {
                        throw new Error(errorData.error);
                    });
                }
            })
            .then(data => {
                console.log("Email updated", data);
                setTimeout(function () {
                    window.location.href = '/account.html';
                }, 2000);
            })
            .catch(error => {
                if (error.message === "Account already exists with this email") {
                    alert("Account already exists with this email! Choose another one!");
                }
            });
    } else {
        alert("You have not entering nothing!");
    }
})

buttonChangeUsername.addEventListener("click", () => {
    let username = prompt("Please write your new username:");
    if (username !== null) {
        const data = {
            username: username
        };
        fetch(window.location.origin + '/Web_Project/public/index.php/user/change_username', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + sessionStorage.getItem('jwt')
            },
            body: JSON.stringify(data)
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
                console.log("Username updated");
                sessionStorage.setItem('profileButton', username);
                sessionStorage.setItem('jwt', data.newJWT);
                setTimeout(function () {
                    window.location.href = '/account.html';
                }, 2000);
            })
            .catch(error => {
                if (error.message === "Account already exists with this username") {
                    alert("Account already exists with this username! Choose another one!");
                }
            });
    } else {
        alert("You have not entering nothing!");
    }
})

buttonChangePassword.addEventListener("click", () => {
    alert("Please use the reset password option from login! Thank you!")
})

buttonDeleteAccount.addEventListener("click", () => {
    performActions().then(() => {
        deleteUser().then(() => {window.location.href = '/';});
    });

})

function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

async function performActions() {
    try {
        const reportResponse = await fetch(window.location.origin + "/Web_Project/public/index.php/report/user_id/-", {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + sessionStorage.getItem('jwt')
            }
        });

        if (!reportResponse.ok) {
            const errorData = await reportResponse.json();
            throw new Error(errorData.error);
        }

        const reportData = await reportResponse.json();
        console.log(reportData);

        await sleep(2000);

        for (const item of reportData) {
            const imageResponse = await fetch(window.location.origin + '/Web_Project/public/index.php/image/' + item.id, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + sessionStorage.getItem('jwt')
                }
            });

            if (!imageResponse.ok) {
                const errorData = await imageResponse.json();
                throw new Error(errorData.error);
            }

            console.log('Image deleted successfully');

            const reportDeleteResponse = await fetch(window.location.origin + '/Web_Project/public/index.php/report/' + item.id, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + sessionStorage.getItem('jwt')
                }
            });

            if (!reportDeleteResponse.ok) {
                const errorData = await reportDeleteResponse.json();
                throw new Error(errorData.error);
            }

            console.log('Report deleted successfully');
        }
    } catch (error) {
        console.error("Error: " + error);
    }
}

async function deleteUser() {
    try {
        const userInfoResponse = await fetch(window.location.origin + "/Web_Project/public/index.php/user/info", {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + sessionStorage.getItem('jwt')
            }
        });

        if (!userInfoResponse.ok) {
            const errorData = await userInfoResponse.json();
            throw new Error(errorData.error);
        }

        const userInfo = await userInfoResponse.json();

        await sleep(2000);

        const deleteUserResponse = await fetch(window.location.origin + '/Web_Project/public/index.php/user/' + userInfo.id, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + sessionStorage.getItem('jwt')
            }
        });

        if (!deleteUserResponse.ok) {
            const errorData = await deleteUserResponse.json();
            throw new Error(errorData.error);
        }

        console.log('User removed successfully');

        sessionStorage.removeItem('profileButton');
        sessionStorage.removeItem('jwt');
        sessionStorage.removeItem('isAdmin');

        await sleep(3000);

    } catch (error) {
        console.error("Error: " + error);
    }
}
