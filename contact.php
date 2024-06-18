<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" href="generic.css">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="contact.css">
    <link rel="stylesheet" href="footer.css">
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
                    <a class="left_half no-link-style" href="log_in.php">Log In</a>/
                    <a class="right_half no-link-style" href="sign_up.php">Sign Up</a>
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
                <a class="left_half no-link-style" href="log_in.php">Log In</a>/
                <a class="right_half no-link-style" href="sign_up.php">Sign Up</a>
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
                <a class="left_half no-link-style" href="log_in.php">Log In</a>/
                <a class="right_half no-link-style" href="sign_up.php">Sign Up</a>
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
            <div class="block__contact_form">
                <form id="submit_form" method="POST" action="">
                    <h1 class="block__contact_form_title">Contact</h1>
                    <label for="Name"><b>Name</b></label>
                    <input type="text" id="Name" name="Name" placeholder="Enter your name" required>
                    <label for="Subject"><b>Subject</b></label>
                    <input type="text" id="Subject" name="Subject" placeholder="Enter the subject" required>
                    <label for="E-Mail"><b>E-Mail Address</b></label>
                    <input type="email" id="E-Mail" name="E-Mail" placeholder="Enter your email" required>
                    <label for="Message"><b>Message</b></label>
                    <textarea id="Message" name="Message" placeholder="Enter your message" rows="3" required></textarea>
                    
                    <?php
                        if (isset($_POST['submit'])) {
                            $name = $_POST['Name'];
                            $subject = $_POST['Subject'];
                            $email = $_POST['E-Mail'];
                            $message = $_POST['Message'];
                            $headers = "From: " . $name . " <" . $email . ">\r\n";
                            $headers .= "Reply-To: " . $email . "\r\n";
                            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    
                            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                if (mail('feralpresenceadvise@gmail.com', $subject, $message, $headers)) {
                                    echo "Email sent!";
                                } else {
                                    echo "Email failed!";
                                    error_log("Mail function failed", 0);
                                }
                            } else {
                                echo "Invalid email address!";
                            }
                        } else {
                            echo "Form not submitted!";
                        }
                    ?>

                    <input class="no-link-style" type="submit" name="submit" id="submit_button" value="Submit">
                </form>
            </div>
            <iframe class="block__contact_map"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2712.1865973441013!2d27.57214091258295!3d47.1737830710332!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40cafb6227e846bd%3A0x193e4b6864504e2c!2sFacultatea%20de%20Informatic%C4%83!5e0!3m2!1sro!2sro!4v1712831782365!5m2!1sro!2sro"
                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
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
    <script src="javascript/connected_user.js"></script>
    <script src="javascript/menu_button.js"></script>
</body>

</html>