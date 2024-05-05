<?php

include_once "..\database\Database.php";

$db = new Database();
$db->connectDB(include('..\database\Config.php'));

if (isset($_POST['E-Mail']) && isset($_POST['Password'])) {
    $email_username = $_POST['E-Mail'];
    $password = $_POST['Password'];
    $exist = "true";
    $password_correct = "true";
    $username = "";

    if (strpos($email_username, '@')) {
        if ($db->emailExists($email_username)) {
            if ($password != $db->getPasswordByEmail($email_username)) {
                $password_correct = "false";
            }
            $username = $db->getUsername($email_username);
        } else {
            $exist = "false";
        }
    } else {
        if ($db->usernameExists($email_username)) {
            if ($password != $db->getPasswordByUsername($email_username)) {
                $password_correct = "false";
            }
            $username = $email_username;
        } else {
            $exist = "false";
        }
    }

    $var = $exist . "_" . $password_correct ."_". $username;
    header("Location: ..\log_in.php?var=$var");
    exit;

}