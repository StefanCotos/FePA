const profile = document.getElementById('profile');
let ok = false;

const storedButtonText = localStorage.getItem('profileButton');
if (storedButtonText) {
    ok = true;
    profile.textContent = storedButtonText;
    profile.classList.add('no-link-style');
}

if (ok) {
    const openMenu = document.getElementById("closable");


    profile.addEventListener('click', function () {
        if (openMenu.style.display === "flex") {
            openMenu.style.display = "none";
        } else {
            openMenu.style.display = "flex";
        }
    });

    const logout = document.getElementById("logout");
    logout.addEventListener('click', function () {
        setTimeout(function () {
            localStorage.removeItem('profileButton');
            window.location.href = 'index.html';
        }, 2000);
    });
}