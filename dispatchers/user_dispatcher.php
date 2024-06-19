<?php

include_once "..\controllers\UserController.php";
include_once "..\database\Database.php";

$db = new Database();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);


if ($uri[4] !== 'user') {
    header("HTTP/1.1 404 Not Found");
    exit();
}

$userId = null;
if (isset($uri[5])) {
    $userId = (int)$uri[5];
}

$requestMethod = $_SERVER["REQUEST_METHOD"];

$controller = new UserController($db->getConnection(), $requestMethod, $userId);
$controller->processRequest();
