<?php

include_once "..\database\Database.php";
include_once "..\gateways\UserGateway.php";

$db = new Database();
$user_gateway = new UserGateway($db->getConnection());

if (isset($_POST['Password']) && isset($_POST['Confirm_Password'])) {
    $password = $_POST['Password'];
    $confirm_password = $_POST['Confirm_Password'];
    if(isset($_COOKIE['email_value'])){
        $email = $_COOKIE['email_value'];
        $different_password = "true";

        if($password == $confirm_password){
            $user_gateway->setPassword($password, $email);
            $different_password = "false";
        }

        $var = $different_password;
        header("Location: ..\log_in.php?different=$var");
        exit;
    }
}
