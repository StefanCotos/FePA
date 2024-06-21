<?php
/*
use controllers\UserController;
use controllers\ReportController;
use database\Database;

include_once "..\src\database\Database.php";
include_once "..\src\controllers\UserController.php";
include_once "..\src\controllers\ReportController.php";

$db = new Database();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

$requestMethod = $_SERVER["REQUEST_METHOD"];


switch ($uri[4]) {
    case 'user':
        $user = null;
        if (isset($uri[5])) {
            if ($uri[5] == 'exist') {
                $user = "exist";
            }
            if ($uri[5] == 'forgot') {
                $user = "forgot";
            }
            if ($uri[5] == 'contact') {
                $user = "contact";
            }
            if (is_numeric($uri[5])) {
                $user = (int)$uri[5];
            }
        }

        $controller = new UserController($db->getConnection(), $requestMethod, $user);
        $controller->processRequest();
        break;
    case 'report':
//        $report = null;

        $controller = new ReportController($db->getConnection(), $requestMethod);
        $controller->processRequest();
        break;
    default:
        header("HTTP/1.1 404 Not Found");
        exit();
}*/


$request_uri = $_SERVER['REQUEST_URI'];

// Redirecționează la index.html din src/views dacă se accesează rădăcina
if ($request_uri == '/' || $request_uri == '/index.php') {
    header('Location: /views/index.html');
    exit;
}

// Pagină implicită dacă cererea nu este pentru un fișier HTML
echo "Hello, Heroku!";
