const profile = document.getElementById('profile');
const profile_for_menu = document.getElementById('profile_for_menu');
const profile_for_menu_to_show = document.getElementById('profile_for_menu_to_show');
const profile_menu_to_show = document.getElementById('profile_menu_to_show');
const adminButton = document.getElementById('admin');
const adminButton1 = document.getElementById('admin1');
let ok = false;

const openMenu = document.getElementById("closable");
const storedButtonText = sessionStorage.getItem('profileButton');
const isAdmin = sessionStorage.getItem('isAdmin');

if (isAdmin === '1') {
    adminButton.style.display = 'block';
    adminButton1.style.display = 'block';
}

if (storedButtonText) {
    ok = true;
    profile.textContent = storedButtonText;
    profile.classList.add('no-link-style');
    profile_for_menu.textContent = storedButtonText;
    profile_for_menu.classList.add('no-link-style');
    profile_for_menu_to_show.textContent = storedButtonText;
    profile_for_menu_to_show.classList.add('no-link-style');
}

if (ok) {

    profile.addEventListener('click', function () {
        if (openMenu.style.display === "flex") {
            openMenu.style.display = "none";
        } else {
            openMenu.style.display = "flex";
        }
    });

    profile_for_menu.addEventListener('click', function () {
        menu_to_show.style.display = "none";
        to_show.style.borderBottomLeftRadius = "30px";
        to_show.style.borderBottomRightRadius = "30px";
        profile_menu_to_show.style.display = "flex";
        to_show.style.borderBottomLeftRadius = "0";
        to_show.style.borderBottomRightRadius = "0";
    });

    profile_for_menu_to_show.addEventListener('click', function () {
        profile_menu_to_show.style.display = "none";
        hideFunction();
        menu_to_show.style.display = "flex";
        showFunction();
    });

    const logout = document.getElementById("logout");
    const logout_menu = document.getElementById('logout_menu');
    logout.addEventListener('click', function () {
        setTimeout(function () {
            sessionStorage.removeItem('profileButton');
            sessionStorage.removeItem('jwt');
            sessionStorage.removeItem('isAdmin');
            window.location.href = '/';
        }, 2000);
    });

    logout_menu.addEventListener('click', function () {
        setTimeout(function () {
            sessionStorage.removeItem('profileButton');
            sessionStorage.removeItem('jwt');
            sessionStorage.removeItem('isAdmin');
            window.location.href = '/';
        }, 2000);
    });

    const account = document.getElementById("account");
    const account_menu = document.getElementById('account_menu');

    fetch(window.location.origin + '/Web_Project/public/index.php/user/isAdmin', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + sessionStorage.getItem('jwt')
        },
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
            let ok = data.isAdmin;

            if (ok === 0) {
                account.addEventListener('click', function () {
                    setTimeout(function () {
                        window.location.href = '/account.html';
                    }, 2000);
                });

                account_menu.addEventListener('click', function () {
                    setTimeout(function () {
                        window.location.href = '/account.html';
                    }, 2000);
                });
            } else {
                account.addEventListener('click', function () {
                    alert("You cannot see your account information");
                });

                account_menu.addEventListener('click', function () {
                    alert("You cannot see your account information");
                });
            }

        })
        .catch(error => {
            console.log(error);
        });


}

function myFunction() {
    let widthWindow = window.innerWidth;
    if (openMenu.style.display === "flex" && widthWindow > 1024) {
        openMenu.style.display = "none";
    }
}

window.addEventListener('resize', myFunction);