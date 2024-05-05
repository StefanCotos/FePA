<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" href="generic.css">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="log_in.css">
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
            <a class="no-link-style" href="contact.html">
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
        <a class="no-link-style" href="contact.html">
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
        <form class="block__log_in_form" id="log_in_form" action="php/verify_user.php" method="POST">
            <div class="block__form_title"><b>Log in</b></div>
            <label for="E-Mail"><b>E-Mail/Username*</b></label>
            <input type="text" id="E-Mail" name="E-Mail" placeholder="Enter your email/username" required>
            <label for="Password"><b>Password*</b></label>
            <input type="password" id="Password" name="Password" placeholder="Enter your password" required>
            <a class="no-link-style " id="forgot_password">Forgot password?</a>
            <input class="no-link-style" type="submit" id="Log_In" value="Login">
            <div id="mask">&nbsp;</div>
            <div id="nonexistentMessage">You don't have an account!</div>
            <div id="passwordMessage">Password incorrect!</div>
            <div id="sign_up">
                You don't have an account?
                <a class="no-link-style" href="sign_up.php">Sign up</a>.
            </div>
        </form>
        <form class="block__forgot_password" id="forgot_form" action="php/forgot_password.php" method="POST">
            <div class="block__form_title"><b>Forgot password</b></div>
            <label for="E-Mail_Send"><b>E-Mail*</b></label>
            <input type="text" id="E-Mail_Send" name="E-Mail" placeholder="Enter your email" required>
            <input class="no-link-style" type="submit" id="Send" value="Send">
            <div id="mask1">&nbsp;</div>
            <div id="emailMessage">Incorrect email! (You don't have an account!)</div>
        </form>
        <form class="block__code_email" id="code_form">
            <div id="email_send">Code send to your email</div>
            <label for="Code"><b>Code*</b></label>
            <input type="text" id="Code" name="Code" placeholder="Enter the received code" required>
            <input class="no-link-style" type="submit" id="Confirm" value="Confirm">
            <div id="mask2">&nbsp;</div>
            <div id="codeMessage">Incorrect code!</div>
        </form>
        <form class="block__reset_password" id="reset_form" action="php/reset_password.php" method="POST">
            <div class="block__form_title"><b>Reset password</b></div>
            <label for="Password_Reset"><b>Password*</b></label>
            <input type="password" id="Password_Reset" name="Password" placeholder="Enter a password" required>
            <label for="Confirm_Password"><b>Confirm Password*</b></label>
            <input type="password" id="Confirm_Password" name="Confirm_Password" placeholder="Confirm password"
                   required>
            <input class="no-link-style" type="submit" id="Reset" value="Reset">
            <div id="mask3">&nbsp;</div>
            <div id="errorMessage">Different passwords!</div>
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
        <a class="no-link-style" href="contact.html">Contact</a>
        <a class="no-link-style" href="help.html">Help</a>
    </div>
    <div id="footer_item">© Copyright 2024, FePA</div>
</footer>
<script>
    const mask = document.getElementById('mask');
    const nonexistentMessage = document.getElementById('nonexistentMessage');
    const passwordMessage = document.getElementById('passwordMessage');
    let val = '<?php echo $_GET['var']; ?>';
    val = val.split("_");
    const exist = val[0];
    const password_correct = val[1];
    const username = val[2];

    if (exist === "false") {
        nonexistentMessage.style.display = 'block';
        mask.style.display = 'none';
        setTimeout(function () {
            nonexistentMessage.style.display = 'none';
            mask.style.display = 'block';
        }, 5000);
    } else if (exist === "true"){
        if (password_correct === "true") {
            localStorage.setItem('profileButton', username);
            setTimeout(function () {
                window.location.href = 'index.html';
            }, 1000);
        } else if (password_correct === "false"){
            passwordMessage.style.display = 'block';
            mask.style.display = 'none';
            setTimeout(function () {
                passwordMessage.style.display = 'none';
                mask.style.display = 'block';
            }, 5000);
        }
    }
</script>
<script>
    const loginForm = document.getElementById("log_in_form");
    const forgotForm = document.getElementById("forgot_form");
    const codeForm = document.getElementById("code_form");
    const mask1 = document.getElementById("mask1");
    const emailMessage = document.getElementById('emailMessage');
    let send = '<?php echo $_GET['send']; ?>';
    send = send.split("_");
    const resp = send[0];
    const code = send[1];
    console.log(code);

    if (resp === "true") {
        loginForm.style.display = "none";
        forgotForm.style.display = "none";
        setTimeout(function () {
            codeForm.style.display = "flex";
        }, 200);
    } else if (resp === "false") {
        loginForm.style.display = "none";
        forgotForm.style.display = "flex";
        emailMessage.style.display = 'block';
        mask1.style.display = 'none';
        setTimeout(function () {
            emailMessage.style.display = 'none';
            mask1.style.display = 'block';
        }, 5000);
    }
</script>
<script>
    const codeForm1 = document.getElementById('code_form');
    const resetForm = document.getElementById('reset_form');
    const code_introduced = document.getElementById('Code');
    const mask2 = document.getElementById("mask2");
    const codeMessage = document.getElementById('codeMessage');

    codeForm1.addEventListener('submit', function (event) {
        event.preventDefault();
        const code_value = code_introduced.value;
        if (code === code_value) {
            codeForm1.style.display = "none";
            setTimeout(function () {
                resetForm.style.display = "flex";
            }, 200);
        } else {
            codeMessage.style.display = 'block';
            mask2.style.display = 'none';
            setTimeout(function () {
                codeMessage.style.display = 'none';
                mask2.style.display = 'block';
            }, 5000);
        }
    });
</script>
<script>
    const loginForm1 = document.getElementById("log_in_form");
    const resetForm1 = document.getElementById('reset_form');
    const mask3 = document.getElementById("mask3");
    const errorMessage = document.getElementById('errorMessage');
    let different = '<?php echo $_GET['different']; ?>';
    different = different.split("_");
    const msg = different[0];

    if (msg === "true") {
        loginForm1.style.display = "none";
        resetForm1.style.display = "flex";
        errorMessage.style.display = 'block';
        mask3.style.display = 'none';
        setTimeout(function () {
            errorMessage.style.display = 'none';
            mask3.style.display = 'block';
        }, 5000);
    }
</script>
<script>
    const loginForm2 = document.getElementById("log_in_form");
    const forgot = document.getElementById("forgot_password");
    const forgotForm1 = document.getElementById("forgot_form");

    forgot.addEventListener('click', function () {
        loginForm2.style.display="none";
        setTimeout(function () {
            forgotForm1.style.display = "flex";
        }, 200);
    });
</script>
<script src="javascript/menu_button.js"></script>

</body>

</html>