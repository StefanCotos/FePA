<?php

include_once "..\database\Database.php";
include_once "..\gateways\UserGateway.php";

$db = new Database();
$user_gateway = new UserGateway($db->getConnection());

if (isset($_POST['E-Mail'])) {
    $email = $_POST['E-Mail'];
    $exist = "true";
    $code = null;

    if ($user_gateway->emailExists($email)) {
        setcookie("email_value", $email);
        $code = rand(10000, 99999);
//        $subject = "Forgotten Password";
//        mail($email, $subject, $code);
    } else {
        $exist = "false";
    }

    $var = $exist . "_" . $code;
    header("Location: ..\log_in.php?send=$var");
    exit;
}
