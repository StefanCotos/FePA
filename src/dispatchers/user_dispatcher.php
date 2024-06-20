<?php

use controllers\AuthController;
use controllers\UserController;
use database\Database;

include_once "..\database\Database.php";
include_once "..\controllers\AuthController.php";
include_once "..\controllers\UserController.php";

$db = new Database();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

$requestMethod = $_SERVER["REQUEST_METHOD"];

$authController = new AuthController($requestMethod);

switch ($uri[5]) {
    case 'user':
        /*$jwt = $authController->checkJWTExistence();
        $decodedJWT= $authController->validateJWT($jwt);*/

        /*if (isset($decodedJWT['isAdmin']) && $decodedJWT['isAdmin']) {
            $controller = new AdminController($db->getConnection(), $requestMethod);
            $controller->processRequest();
        } else {
            header('HTTP/1.0 403 Forbidden');
            echo json_encode(array("message" => "Access denied. Admins only."));
            exit();
        }*/

        $user = null;
        if (isset($uri[6])) {
            if ($uri[6] == 'exist') {
                $user = "exist";
            }
            if ($uri[6] == 'forgot') {
                $user = "forgot";
            }
            if ($uri[6] == 'contact') {
                $user = "contact";
            }
        }

        $controller = new UserController($db->getConnection(), $requestMethod, $user);
        $controller->processRequest();
        break;
    default:
        header("HTTP/1.1 404 Not Found");
        exit();
}
