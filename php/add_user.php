<?php

include_once "..\database\Database.php";

$db = new Database();
$db->connectDB(include('..\database\Config.php'));

if (isset($_POST['First_Name']) && isset($_POST['Last_Name']) && isset($_POST['E-Mail']) && isset($_POST['Password']) && isset($_POST['Confirm_Password'])) {
    $first_name = $_POST['First_Name'];
    $last_name = $_POST['Last_Name'];
    $email = $_POST['E-Mail'];
    $password = $_POST['Password'];
    $confirm_password = $_POST['Confirm_Password'];
    $username = $_POST['Username'];
    $email_exist = "true";
    $different_password = "true";
    $username_exist = "true";

    if (!$db->emailExists($email)) {
        if ($password == $confirm_password) {
            if ($username == null || $username == "") {
                $username = explode('@', $email);
                $username = $username[0];
            }
            if(!$db->usernameExists($username)){
                $username_exist = "false";
                $db->insertUser($first_name, $last_name, $email, $password, $username);
            }
            $different_password = "false";
        }
        $email_exist = "false";
    }
    else{
        if ($password == $confirm_password) {
            $different_password = "false";
        }
    }

    $var = $email_exist . "_" . $different_password . "_" . $username_exist . "_" . $username;
    header("Location: ..\sign_up.php?var=$var");
    exit;
}


