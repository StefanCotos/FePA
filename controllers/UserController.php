<?php

include_once "..\gateways\UserGateway.php";

class UserController
{
    private $db;
    private $requestMethod;
    private $userId;

    private $userGateway;

    public function __construct($db, $requestMethod, $userId)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->userId = $userId;

        $this->userGateway = new UserGateway($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                $response = $this->getUser();
                break;
            case 'POST':
                $response = $this->createUserFromRequest();
                break;
            case 'PUT':
//                $response = $this->updateUserFromRequest($this->userId);
                break;
            case 'DELETE':
//                $response = $this->deleteUser($this->userId);
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

    private function getUser()
    {
        $input = (array)json_decode(file_get_contents('php://input'), TRUE);
        if (!isset($input["user"]) || !isset($input["password"])) {
            return $this->unprocessableEntityResponse();
        }

        if (!$this->userGateway->emailExists($input["user"])) {
            if (!$this->userGateway->usernameExists($input["user"])) {
                return $this->notFoundResponse();
            }
            else{
                $response['status_code_header'] = 'HTTP/1.1 200 OK';
                $response['body'] = null;
                return $response;
            }
        } else {
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = null;
            return $response;
        }
    }

    private function createUserFromRequest()
    {
        $input = (array)json_decode(file_get_contents('php://input'), TRUE);
        if (!$this->validatePerson($input)) {
            return $this->unprocessableEntityResponse();
        }
        $input['password'] = password_hash($input['password'], PASSWORD_DEFAULT);

        if ($this->userGateway->emailExists($input['email'])) {
            return $this->conflictResponse("Email already exists");
        } else if ($this->userGateway->usernameExists($input['username'])) {
            return $this->conflictResponse("Username already exists");
        } else {
            $this->userGateway->insertUser($input);
            $response['status_code_header'] = 'HTTP/1.1 201 Created';
            $response['body'] = null;
            return $response;
        }
    }

    private function validatePerson($input)
    {
        if (!isset($input['first_name'])) {
            return false;
        }
        if (!isset($input['last_name'])) {
            return false;
        }
        if (!isset($input['email'])) {
            return false;
        }
        if (!isset($input['password'])) {
            return false;
        }
        if (!isset($input['username'])) {
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

    private function conflictResponse($message)
    {
        $response['status_code_header'] = 'HTTP/1.1 409 Conflict';
        $response['body'] = json_encode([
            'error' => $message
        ]);
        return $response;
    }

    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }
}