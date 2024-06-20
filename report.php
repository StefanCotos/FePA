<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <link rel="stylesheet" href="styles/generic.css">
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/report.css">
    <link rel="stylesheet" href="styles/footer.css">
</head>

<body>
    <div class="wrapper">
        <header id="to_show">
            <a href="index.html">
                <img class="logo" src="assets/Logo.png" alt="Logo">
            </a>
            <div class="menu">
                <a class="no-link-style" href="about.html">
                    <div class="menu__about">About</div>
                </a>
                <a class="no-link-style" href="report.html">
                    <div class="menu__report">Report</div>
                </a>
                <a class="no-link-style" href="see_reports.html">
                    <div class="menu__see_reports">See Reports</div>
                </a>
                <a class="no-link-style" href="statistics.html">
                    <div class="menu__statistics">Statistics</div>
                </a>
                <a class="no-link-style" href="contact.php">
                    <div class="menu__contact">Contact</div>
                </a>
                <a class="no-link-style" href="help.html">
                    <div class="menu__help">Help</div>
                </a>
                <div class="menu__log_in--button half_button" id="profile">
                    <a class="left_half no-link-style" href="log_in.html">Log In</a>/
                    <a class="right_half no-link-style" href="sign_up.html">Sign Up</a>
                </div>
            </div>
            <div class="no-link-style menu_toggle" id="menu_visible">
                <div id="menu_toggle__line1"></div>
                <div id="menu_toggle__line2"></div>
                <div id="menu_toggle__line3"></div>
            </div>
        </header>
        <div class="menu__to_show" id="menu__to_show">
            <div class="menu__log_in--button half_button" id="profile_for_menu">
                <a class="left_half no-link-style" href="log_in.html">Log In</a>/
                <a class="right_half no-link-style" href="sign_up.html">Sign Up</a>
            </div>
            <a class="no-link-style" href="about.html">
                <div class="menu__about">About</div>
            </a>
            <a class="no-link-style" href="report.html">
                <div class="menu__report">Report</div>
            </a>
            <a class="no-link-style" href="see_reports.html">
                <div class="menu__see_reports">See Reports</div>
            </a>
            <a class="no-link-style" href="statistics.html">
                <div class="menu__statistics">Statistics</div>
            </a>
            <a class="no-link-style" href="contact.php">
                <div class="menu__contact">Contact</div>
            </a>
            <a class="no-link-style" href="help.html">
                <div class="menu__help">Help</div>
            </a>
        </div>
        <div class="menu__to_show" id="profile_menu_to_show">
            <div class="menu__log_in--button half_button" id="profile_for_menu_to_show">
                <a class="left_half no-link-style" href="log_in.html">Log In</a>/
                <a class="right_half no-link-style" href="sign_up.html">Sign Up</a>
            </div>
            <a class="no-link-style">
                <div class="menu__admin">Account</div>
            </a>
            <a class="no-link-style">
                <div class="menu__about">Settings</div>
            </a>
            <a class="no-link-style" id="logout_menu">
                <div class="menu__report">Log Out</div>
            </a>
        </div>
    </div>
    <main>
        <div class="block">
            <div class="block__report_form">
                <form id="submit_form" action="php/formhandler.ini.php" method="POST">
                    <h1 class="block__report_form_title">Report</h1>
                    <label for="Animal-type"><b>Animal type</b></label>
                    <input type="text" id="Animal-type" name="Animal-type" placeholder="Enter the animal type" required>
                    <label for="City"><b>City</b></label>
                    <input type="text" id="City" name="City" placeholder="Enter the city" required>
                    <label for="Street"><b>Street</b></label>
                    <input type="text" id="Street" name="Street" placeholder="Enter the street name" required>
                    <label for="Additional-aspects"><b>Additional aspects</b></label>
                    <input type="text" id="Additional-aspects" name="Additional-aspects"
                        placeholder="Enter the additional aspects">
                    <label for="Description"><b>Description</b></label>
                    <input type="text" id="Description" name="Description" placeholder="Enter the description" required>
                    <div class="form">
                        <label for="Photos"><b>Upload photos</b></label>
                        <label for="Photos" class="photos-input">
                            Here
                        </label>
                    </div>
                    <input id="Photos" type="file" name="Photos" required>
                    <input class="no-link-style" type="submit" id="submit_button" value="Submit">
                </form>
            </div>
            <iframe class="block__report_map"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d86818.8540019321!2d27.504398892512704!3d47.15610763483555!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40cafb7cf639ddbb%3A0x7ccb80da5426f53c!2zSWHImWk!5e0!3m2!1sro!2sro!4v1712834887839!5m2!1sro!2sro"
                style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
        <div class="profile_menu" id="closable">
            <div class="profile_menu--options no-link-style">Account</div>
            <div class="profile_menu--options no-link-style">Settings</div>
            <div class="profile_menu--options no-link-style" id="logout">Log Out</div>
        </div>
    </main>
    <footer id="myFooter">
        <a href="index.html">
            <img class="footer__logo" src="assets/Logo.png" alt="Logo">
        </a>
        <div class="footer__content">
            <div>Contact Us</div>
            <a class="no-link-style" href="mailto:stefancotos8@gmail.com">
                stefancotos8@gmail.com
            </a>
            <a class="no-link-style" href="mailto:burcaiulianstefan@gmail.com">
                burcaiulianstefan@gmail.com
            </a>
            <a class="no-link-style" href="tel:+40747816344">
                Tel: +40 747 816 344
            </a>
        </div>
        <div class="footer__content">
            <a class="no-link-style" href="about.html">About</a>
            <a class="no-link-style" href="report.html">Report</a>
            <a class="no-link-style" href="see_reports.html">See reports</a>
            <a class="no-link-style" href="statistics.html">Statistics</a>
            <a class="no-link-style" href="contact.php">Contact</a>
            <a class="no-link-style" href="help.html">Help</a>
        </div>
        <div id="footer_item">© Copyright 2024, FePA</div>
    </footer>
    <script src="scripts/connected_user.js"></script>
    <script src="scripts/menu_button.js"></script>
</body>

</html>