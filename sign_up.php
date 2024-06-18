<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link rel="stylesheet" href="generic.css">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="sign_up.css">
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
        <div class="menu__log_in--button half_button">
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
        <div class="menu__log_in--button half_button">
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
        <form class="block__sign_up_form" id="sign_up_form" action="php/add_user.php" method="POST">
            <div class="block__form_title"><b>Sign Up</b></div>
            <div class="name">
                <div class="name_position">
                    <label for="First_Name"><b>First Name*</b></label>
                    <input type="text" id="First_Name" name="First_Name" placeholder="Enter your first name" required>
                </div>
                <div class="name_position">
                    <label for="Last_Name"><b>Last Name*</b></label>
                    <input type="text" id="Last_Name" name="Last_Name" placeholder="Enter your last name" required>
                </div>
            </div>
            <label for="E-Mail"><b>E-Mail*</b></label>
            <input type="email" id="E-Mail" name="E-Mail" placeholder="Enter your email" required>
            <label for="Password"><b>Password*</b></label>
            <input type="password" id="Password" name="Password" placeholder="Enter a password" required>
            <label for="Confirm_Password"><b>Confirm Password*</b></label>
            <input type="password" id="Confirm_Password" name="Confirm_Password" placeholder="Confirm password"
                   required>
            <label for="Username"><b>Username</b></label>
            <input type="text" id="Username" name="Username" placeholder="How do you want to be called?">
            <input class="no-link-style" type="submit" id="Sign_up" value="Sign Up">
            <div id="mask">&nbsp;</div>
            <div id="errorMessage">Different passwords!</div>
            <div id="existMessage">E-Mail exist!</div>
            <div id="usernameMessage">Username exist, please choose another one!</div>
            <div class="log_in">
                You already have an account?
                <a class="no-link-style" href="log_in.php">Click here</a>.
            </div>
        </form>
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
<script>
    const mask = document.getElementById('mask');
    const errorMessage = document.getElementById('errorMessage');
    const existMessage = document.getElementById('existMessage');
    const usernameMessage = document.getElementById('usernameMessage');
    let val = '<?php echo $_GET['var']; ?>';
    val = val.split("_");
    const email_exist = val[0];
    const different_password = val[1];
    const username_exist = val[2];
    const username = val[3];

    if (email_exist === "false") {
        if (different_password === "true") {
            errorMessage.style.display = 'block';
            mask.style.display = 'none';
            setTimeout(function () {
                errorMessage.style.display = 'none';
                mask.style.display = 'block';
            }, 5000);
        } else {
            if(username_exist === "false") {
                localStorage.setItem('profileButton', username);
                setTimeout(function () {
                    window.location.href = 'index.html';
                }, 1000);
            }
            else
            {
                usernameMessage.style.display = 'block';
                mask.style.display = 'none';
                setTimeout(function () {
                    usernameMessage.style.display = 'none';
                    mask.style.display = 'block';
                }, 5000);
            }
        }
    } else {
        existMessage.style.display = 'block';
        mask.style.display = 'none';
        setTimeout(function () {
            existMessage.style.display = 'none';
            mask.style.display = 'block';
        }, 5000);
    }

</script>
<script src="javascript/menu_button.js"></script>
</body>

</html>