<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


use controllers\UserController;
use controllers\ReportController;
use controllers\ImageController;
use database\Database;


include_once "../src/database/Database.php";
include_once "../src/controllers/UserController.php";
include_once "../src/controllers/ReportController.php";
include_once "../src/controllers/ImageController.php";
include_once "../src/rss_generator/RSSGenerator.php";

$db = new Database();

$requestUri = $_SERVER['REQUEST_URI'];
$requestUri = str_replace('/Web_Project', '', $requestUri);
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($uri[1] == 'post' && is_numeric($uri[2])) {
    $requestUri = '/post/number';
}

switch ($requestUri) {
    case '/':
        require __DIR__ . '/../src/views/index.html';
        break;
    case '/admin.html':
        require __DIR__ . '/../src/views/admin.html';
        break;
    case '/about.html':
        require __DIR__ . '/../src/views/about.html';
        break;
    case '/contact.html':
        require __DIR__ . '/../src/views/contact.html';
        break;
    case '/help.html':
        require __DIR__ . '/../src/views/help.html';
        break;
    case '/log_in.html':
        require __DIR__ . '/../src/views/log_in.html';
        break;
    case '/post.html':
        require __DIR__ . '/../src/views/post.html';
        break;
    case '/postuntilapprove.html':
        require __DIR__ . '/../src/views/postuntilapprove.html';
        break;
    case '/report.html':
        require __DIR__ . '/../src/views/report.html';
        break;
    case '/see_reports.html':
        require __DIR__ . '/../src/views/see_reports.html';
        break;
    case '/sign_up.html':
        require __DIR__ . '/../src/views/sign_up.html';
        break;
    case '/statistics.html':
        require __DIR__ . '/../src/views/statistics.html';
        break;
    case '/account.html':
        require __DIR__ . '/../src/views/account.html';
        break;
    case '/public/rss.xml':
        $reportGateway = new ReportGateway($db->getConnection());
        $reportGateway->getReportsForRSS();
        require __DIR__ . '/rss.xml';
        break;
    case '/post/number':
        require __DIR__ . '/../src/views/post_for_rss.html';
        break;
    default:
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
                    if ($uri[5] == 'isAdmin') {
                        $user = 'isAdmin';
                    }
                    if ($uri[5] == 'info') {
                        $user = 'info';
                    }
                    if ($uri[5] == 'change_first_name') {
                        $user = 'change_first_name';
                    }
                    if ($uri[5] == 'change_last_name') {
                        $user = 'change_last_name';
                    }
                    if ($uri[5] == 'change_email') {
                        $user = 'change_email';
                    }
                    if ($uri[5] == 'change_username') {
                        $user = 'change_username';
                    }
                    if (is_numeric($uri[5])) {
                        $user = (int)$uri[5];
                    }
                }

                $controller = new UserController($db->getConnection(), $requestMethod, $user);
                $controller->processRequest();
                break;
            case 'report':
                $report = null;
                $userId = null;
                if (isset($uri[5])) {
                    if ($uri[5] == 'not_approved') {
                        $report = "not_approved";
                    }
                    if ($uri[5] == 'piechart_area') {
                        $report = "piechart_area";
                    }
                    if ($uri[5] == 'piechart_type') {
                        $report = "piechart_type";
                    }
                    if ($uri[5] == 'user_id') {
                        if ($uri[6] != '-') {
                            $userId = $uri[6];
                        }
                        $report = "user_id";
                    }
                    if (is_numeric($uri[5])) {
                        $report = (int)$uri[5];
                    }
                }

                $controller = new ReportController($db->getConnection(), $requestMethod, $report, $userId);
                $controller->processRequest();
                break;
            case 'image':
                $image = null;
                if (isset($uri[5])) {
                    if (is_numeric($uri[5])) {
                        $image = (int)$uri[5];
                    }
                }

                $controller = new ImageController($db->getConnection(), $requestMethod, $image);
                $controller->processRequest();
                break;
            default:
                http_response_code(404);
                header("HTTP/1.1 404 Not Found");
                exit();
        }
}
