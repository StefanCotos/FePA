<?php

include_once "../controllers/ReportController.php";
include_once "../database/Database.php";

$db = new Database();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

if ($uri[4] !== 'report') {
    header("HTTP/1.1 404 Not Found");
    exit();
}

$report = null;

$requestMethod = $_SERVER["REQUEST_METHOD"];

$controller = new ReportController($db->getConnection(), $requestMethod, $report);
$controller->processRequest();
