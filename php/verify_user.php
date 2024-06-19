<?php


include_once "..\database\Database.php";
include_once "..\gateways\UserGateway.php";

$db = new Database();
$user_gateway = new UserGateway($db->getConnection());

if (isset($_POST['E-Mail']) && isset($_POST['Password'])) {
    $email_username = $_POST['E-Mail'];
    $password = $_POST['Password'];
    $exist = "true";
    $password_correct = "true";
    $username = "";

    if (strpos($email_username, '@')) {
        if ($user_gateway->emailExists($email_username)) {
            if ($password != $user_gateway->getPasswordByEmail($email_username)) {
                $password_correct = "false";
            }
            $username = $user_gateway->getUsername($email_username);
        } else {
            $exist = "false";
        }
    } else {
        if ($user_gateway->usernameExists($email_username)) {
            if ($password != $user_gateway->getPasswordByUsername($email_username)) {
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