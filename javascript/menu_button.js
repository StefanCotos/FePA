const menu = document.getElementById('menu_visible');
const menu_to_show = document.getElementById('menu__to_show');
const to_show = document.getElementById('to_show');
const menu_toggle__line1 = document.getElementById('menu_toggle__line1');
const menu_toggle__line2 = document.getElementById('menu_toggle__line2');
const menu_toggle__line3 = document.getElementById('menu_toggle__line3');

function hideFunction(){
    menu_to_show.style.display = "none";
    to_show.style.borderBottomLeftRadius = "30px";
    to_show.style.borderBottomRightRadius = "30px";
    menu_toggle__line1.style.left = "0";
    menu_toggle__line1.style.top = "0";
    menu_toggle__line1.style.width = "30px";
    menu_toggle__line1.style.height = "3px";
    menu_toggle__line2.style.left = "0";
    menu_toggle__line2.style.top = "11px";
    menu_toggle__line2.style.width = "30px";
    menu_toggle__line2.style.height = "3px";
    menu_toggle__line3.style.right = "0";
    menu_toggle__line3.style.bottom = "0";
    menu_toggle__line3.style.width = "30px";
    menu_toggle__line3.style.height = "3px";
}

function showFunction(){
    menu_to_show.style.display = "flex";
    to_show.style.borderBottomLeftRadius = "0";
    to_show.style.borderBottomRightRadius = "0";
    menu_toggle__line1.style.left = "1px";
    menu_toggle__line1.style.width = "3px";
    menu_toggle__line1.style.height = "25px";
    menu_toggle__line2.style.top = "0";
    menu_toggle__line2.style.left = "13px";
    menu_toggle__line2.style.width = "3px";
    menu_toggle__line2.style.height = "25px";
    menu_toggle__line3.style.right = "1px";
    menu_toggle__line3.style.width = "3px";
    menu_toggle__line3.style.height = "25px";
}

menu.addEventListener('click', function () {
    if (menu_to_show.style.display === "flex") {
        hideFunction();
    } else {
        showFunction();
    }
});

function myFunction() {
    let widthWindow = window.innerWidth;
    if (menu_to_show.style.display === "flex" && widthWindow > 1024) {
        hideFunction();
    }
}

window.addEventListener('resize', myFunction);
