<?php

namespace controllers;

use ReportGateway;
use UserGateway;

include_once __DIR__ . "/../gateways/ReportGateway.php";
include_once __DIR__ . "/../controllers/AuthController.php";

class ReportController
{
    private $requestMethod;
    private $report;
    private $reportGateway;
    private $authController;
    private $userGateway;
    private $userId;

    public function __construct($db, $requestMethod, $report, $userId)
    {
        $this->requestMethod = $requestMethod;
        $this->report = $report;
        $this->userId = $userId;

        $this->reportGateway = new ReportGateway($db);
        $this->authController = new AuthController($requestMethod);
        $this->userGateway = new UserGateway($db);

    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->report == "not_approved") {
                    $response = $this->getNotApprovedReports();
                } else if ($this->report == "piechart_area") {
                    $response = $this->getAreaStatistics();
                } else if ($this->report == "piechart_type") {
                    $response = $this->getTypeStatistics();
                } else if ($this->report == "user_id") {
                    if ($this->userId) {
                        $response = $this->getReportsByUserIdAnother($this->userId);
                    } else {
                        $response = $this->getReportsByUserId();
                    }
                } else if ($this->report) {
                    $response = $this->getReportById($this->report);
                } else {
                    $response = $this->getApprovedReports();
                }
                break;
            case 'POST':
                $response = $this->createReportFromRequest();
                break;
            case 'PUT':
                if ($this->report) {
                    $response = $this->approveReport($this->report);
                }
                break;
            case 'DELETE':
                if ($this->report) {
                    $response = $this->deleteReport($this->report);
                }
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    private function createReportFromRequest()
    {
        $jwt = $this->authController->checkJWTExistence();
        $decodedJWT = $this->authController->validateJWT($jwt);

        if (isset($decodedJWT['userName'])) {
            $username = $decodedJWT['userName'];
        }

        $userId = $this->userGateway->getIdByUsername($username);

        $input = (array)json_decode(file_get_contents('php://input'), TRUE);
        if (!$this->validateReport($input)) {
            return $this->unprocessableEntityResponse();
        }
        $input['user_id'] = $userId;

        $reportId = $this->reportGateway->insertReport($input);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = json_encode([
            "reportId" => $reportId
        ]);
        return $response;
    }

    private function getApprovedReports()
    {
        $result = $this->reportGateway->getApprovedReports();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getNotApprovedReports()
    {
        $jwt = $this->authController->checkJWTExistence();
        $this->authController->validateJWT($jwt);

        $result = $this->reportGateway->getNotApprovedReports();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getAreaStatistics()
    {
        $result = $this->reportGateway->getAreaStatistics();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getTypeStatistics()
    {
        $result = $this->reportGateway->getTypeStatistics();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getReportById($id)
    {
        $result = $this->reportGateway->getReportById($id);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function approveReport($id)
    {
        $jwt = $this->authController->checkJWTExistence();
        $this->authController->validateJWT($jwt);

        $this->reportGateway->approveReport($id);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
    }

    private function deleteReport($id)
    {
        $jwt = $this->authController->checkJWTExistence();
        $this->authController->validateJWT($jwt);

        $this->reportGateway->deleteReport($id);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
    }

    private function getReportsByUserId()
    {
        $jwt = $this->authController->checkJWTExistence();
        $decodedJWT = $this->authController->validateJWT($jwt);

        if (isset($decodedJWT['userName'])) {
            $username = $decodedJWT['userName'];
        }

        $userId = $this->userGateway->getIdByUsername($username);

        $result = $this->reportGateway->getReportsByUserId($userId);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getReportsByUserIdAnother($userId)
    {
        $result = $this->reportGateway->getReportsByUserId($userId);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function validateReport($input)
    {
        if (!isset($input['animal_type'])) {
            return false;
        }
        if (!isset($input['city'])) {
            return false;
        }
        if (!isset($input['street'])) {
            return false;
        }
        if (!isset($input['description'])) {
            return false;
        }
        if (!isset($input['additional_aspects'])) {
            return false;
        }
        return true;
    }

    private function unprocessableEntityResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);
        return $response;
    }

    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = json_encode([
            'error' => "Not Found"
        ]);
        return $response;
    }
}
