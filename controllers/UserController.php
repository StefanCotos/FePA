<?php

include_once "..\gateways\UserGateway.php";

class UserController
{
    private $db;
    private $requestMethod;
    private $user;

    private $userGateway;

    public function __construct($db, $requestMethod, $user)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->user = $user;

        $this->userGateway = new UserGateway($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':

                break;
            case 'POST':
                if ($this->user == "exist") {
                    $response = $this->checkUserExist();
                } else if ($this->user == "forgot") {
                    $response = $this->checkEmailAndSend();
                } else {
                    $response = $this->createUserFromRequest();
                }
                break;
            case 'PUT':
                $response = $this->updateUserFromRequest();
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


    private function checkUserExist()
    {
        $input = (array)json_decode(file_get_contents('php://input'), TRUE);
        if (!isset($input['user']) || !isset($input['password'])) {
            return $this->unprocessableEntityResponse();
        }

        if (!$this->userGateway->emailExists($input["user"])) {
            if (!$this->userGateway->usernameExists($input["user"])) {
                return $this->notFoundResponse();
            } else {
                if (!password_verify($input["password"], $this->userGateway->getPasswordByUsername($input["user"]))) {
                    return $this->unauthorizedResponse("Incorrect password");
                }

                $response['status_code_header'] = 'HTTP/1.1 200 OK';
                $response['body'] = json_encode([
                    'username' => $input["user"]
                ]);
                return $response;
            }
        } else {
            if (!password_verify($input["password"], $this->userGateway->getPasswordByEmail($input["user"]))) {
                return $this->unauthorizedResponse("Incorrect password");
            }

            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode([
                'username' => $this->userGateway->getUsername($input["user"])
            ]);
            return $response;
        }
    }

    private function checkEmailAndSend()
    {
        $input = (array)json_decode(file_get_contents('php://input'), TRUE);
        if (!isset($input['email'])) {
            return $this->unprocessableEntityResponse();
        }

        if (!$this->userGateway->emailExists($input["email"])) {
            return $this->notFoundResponse();
        } else {
            setcookie("email_value", $input['email']);
            $name = "Feral Presence Adviser";
            $subject = "Reset Password";
            $code = rand(10000, 99999);
            $message = "Your confirmation code is: " . $code;
            $headers = "From: " . $name . " \r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

            if (filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
                if (mail($input['email'], $subject, $message, $headers)) {
                    $response['status_code_header'] = 'HTTP/1.1 200 OK';
                    $response['body'] = json_encode([
                        'code' => $code
                    ]);
                } else {
                    $response['status_code_header'] = 'HTTP/1.1 500 Internal Server Error';
                    $response['body'] = null;
                }
                return $response;
            } else {
                return $this->conflictResponse("Invalid email address");
            }
        }
    }

    private function updateUserFromRequest()
    {
        $input = (array)json_decode(file_get_contents('php://input'), TRUE);
        if (!isset($input['password'])) {
            return $this->unprocessableEntityResponse();
        }
        $input['password'] = password_hash($input['password'], PASSWORD_DEFAULT);
        $email = $_COOKIE['email_value'];
        $input['email']=$email;

        $this->userGateway->setPassword($input);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
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

    private function unauthorizedResponse($message)
    {
        $response['status_code_header'] = 'HTTP/1.1 401 Unauthorized';
        $response['body'] = json_encode([
            'error' => $message
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