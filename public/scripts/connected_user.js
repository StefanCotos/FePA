const profile = document.getElementById('profile');
const profile_for_menu = document.getElementById('profile_for_menu');
const profile_for_menu_to_show = document.getElementById('profile_for_menu_to_show');
const profile_menu_to_show = document.getElementById('profile_menu_to_show');
const adminButton = document.getElementById('admin');
let ok = false;

const openMenu = document.getElementById("closable");
const storedButtonText = sessionStorage.getItem('profileButton');
const isAdmin = sessionStorage.getItem('isAdmin');

if (isAdmin === '1') {
    adminButton.style.display = 'flex';
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
            window.location.href = 'index.html';
        }, 2000);
    });

    logout_menu.addEventListener('click', function () {
        setTimeout(function () {
            sessionStorage.removeItem('profileButton');
            sessionStorage.removeItem('jwt');
            sessionStorage.removeItem('isAdmin');
            window.location.href = 'index.html';
        }, 2000);
    });
}

function myFunction() {
    let widthWindow = window.innerWidth;
    if (openMenu.style.display === "flex" && widthWindow > 1024) {
        openMenu.style.display = "none";
    }
}

window.addEventListener('resize', myFunction);