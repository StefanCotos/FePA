<?php

namespace controllers;

use mail_sender\MailSender;
use UserGateway;

include_once __DIR__ . "/../gateways/UserGateway.php";
include_once __DIR__ . "/../controllers/AuthController.php";
include_once __DIR__ . "/../mail_sender/MailSender.php";


class UserController
{
    private $requestMethod;
    private $user;
    private $userGateway;
    private $authController;
    private $sendEmail;

    public function __construct($db, $requestMethod, $user)
    {
        $this->requestMethod = $requestMethod;
        $this->user = $user;

        $this->userGateway = new UserGateway($db);
        $this->authController = new AuthController($requestMethod);
        $this->sendEmail = new MailSender();
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->user == "isAdmin") {
                    $response = $this->isAdmin();
                } else if ($this->user == "info") {
                    $response = $this->getInfo();
                } else if ($this->user) {
                    $response = $this->getUsernameById($this->user);
                } else {
                    $response = $this->getAllUsers();
                }
                break;
            case 'POST':
                if ($this->user == "exist") {
                    $response = $this->checkUserExist();
                } else if ($this->user == "forgot") {
                    $response = $this->checkEmailAndSend();
                } else if ($this->user == "contact") {
                    $response = $this->sendEmail();
                } else {
                    $response = $this->createUserFromRequest();
                }
                break;
            case 'PUT':
                if ($this->user == "change_first_name") {
                    $response = $this->changeFirstName();
                } else if ($this->user == "change_last_name") {
                    $response = $this->changeLastName();
                } else if ($this->user == "change_email") {
                    $response = $this->changeEmail();
                } else if ($this->user == "change_username") {
                    $response = $this->changeUsername();
                } else {
                    $response = $this->updateUserFromRequest();
                }
                break;
            case 'DELETE':
                $response = $this->deleteUser($this->user);
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

    private function getAllUsers()
    {
        $jwt = $this->authController->checkJWTExistence();
        $this->authController->validateJWT($jwt);

        $result = $this->userGateway->findAll();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
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

            $jwt = $this->authController->processRequest($input['username'],0);
            $this->userGateway->insertUser($input);
            $response['status_code_header'] = 'HTTP/1.1 201 Created';
            $response['body'] = json_encode([
                'jwt' => $jwt
            ]);
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
                    return $this->unauthorizedResponse();
                }

                $jwt = $this->authController->processRequest($input['user'], $this->userGateway->getAdmin($input['user']));
                $decodedJWT = $this->authController->validateJWT($jwt);

                if (isset($decodedJWT['isAdmin'])) {
                    $isAdmin = $decodedJWT['isAdmin'];
                }

                $response['status_code_header'] = 'HTTP/1.1 200 OK';
                $response['body'] = json_encode([
                    'username' => $input["user"],
                    'jwt' => $jwt,
                    'isAdmin' => $isAdmin
                ]);
                return $response;
            }
        } else {
            if (!password_verify($input["password"], $this->userGateway->getPasswordByEmail($input["user"]))) {
                return $this->unauthorizedResponse();
            }

            $username = $this->userGateway->getUsername($input["user"]);
            $jwt = $this->authController->processRequest($username, $this->userGateway->getAdmin($username));
            $decodedJWT = $this->authController->validateJWT($jwt);

            if (isset($decodedJWT['isAdmin'])) {
                $isAdmin = $decodedJWT['isAdmin'];
            }

            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode([
                'username' => $username,
                'jwt' => $jwt,
                'isAdmin' => $isAdmin
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

            if (filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
                if ($this->sendEmail->sendEmail($name, "fepawebsite@gmail.com", $input['email'], $subject, $message)) {
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
        $input['email'] = $email;

        $this->userGateway->setPassword($input);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
    }

    private function sendEmail()
    {
        $jwt = $this->authController->checkJWTExistence();
        $this->authController->validateJWT($jwt);

        $input = (array)json_decode(file_get_contents('php://input'), TRUE);
        if (!isset($input['name']) || !isset($input['subject']) || !isset($input['email']) || !isset($input['message'])) {
            return $this->unprocessableEntityResponse();
        }

        if (filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
            if ($this->sendEmail->sendEmail($input['name'], $input['email'], "feralpresenceadvise@gmail.com", $input['subject'], $input['message'])) {
                $response['status_code_header'] = 'HTTP/1.1 200 OK';
                $response['body'] = null;
            } else {
                error_log("Mail function failed");
                $response['status_code_header'] = 'HTTP/1.1 500 Internal Server Error';
                $response['body'] = json_encode([
                    'error' => 'Internal Server Error'
                ]);
            }
            return $response;
        } else {
            return $this->conflictResponse("Invalid email address");
        }
    }

    private function deleteUser($id)
    {
        $jwt = $this->authController->checkJWTExistence();
        $this->authController->validateJWT($jwt);

        $result = $this->userGateway->find($id);
        if (!$result) {
            return $this->notFoundResponse();
        }
        $this->userGateway->deleteUser($id);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
    }

    private function getUsernameById($id)
    {
        $result = $this->userGateway->getUsernameById($id);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode([
            'username' => $result
        ]);
        return $response;
    }

    private function isAdmin()
    {
        $jwt = $this->authController->checkJWTExistence();
        $decodedJWT = $this->authController->validateJWT($jwt);

        if (isset($decodedJWT['isAdmin'])) {
            $isAdmin = $decodedJWT['isAdmin'];
        }

        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode([
            'isAdmin' => $isAdmin
        ]);
        return $response;

    }

    private function getInfo()
    {
        $jwt = $this->authController->checkJWTExistence();
        $decodedJWT = $this->authController->validateJWT($jwt);

        if (isset($decodedJWT['userName'])) {
            $username = $decodedJWT['userName'];
        }

        $id = $this->userGateway->getIdByUsername($username);

        $result = $this->userGateway->find($id);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function changeFirstName()
    {
        $jwt = $this->authController->checkJWTExistence();
        $decodedJWT = $this->authController->validateJWT($jwt);

        $input = (array)json_decode(file_get_contents('php://input'), TRUE);
        if (!isset($input['first_name'])) {
            return $this->unprocessableEntityResponse();
        }

        if (isset($decodedJWT['userName'])) {
            $username = $decodedJWT['userName'];
        }

        $id = $this->userGateway->getIdByUsername($username);

        $this->userGateway->changeFirstName($input['first_name'], $id);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
    }

    private function changeLastName()
    {
        $jwt = $this->authController->checkJWTExistence();
        $decodedJWT = $this->authController->validateJWT($jwt);

        $input = (array)json_decode(file_get_contents('php://input'), TRUE);
        if (!isset($input['last_name'])) {
            return $this->unprocessableEntityResponse();
        }

        if (isset($decodedJWT['userName'])) {
            $username = $decodedJWT['userName'];
        }

        $id = $this->userGateway->getIdByUsername($username);

        $this->userGateway->changeLastName($input['last_name'], $id);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
    }

    private function changeEmail()
    {
        $jwt = $this->authController->checkJWTExistence();
        $decodedJWT = $this->authController->validateJWT($jwt);

        $input = (array)json_decode(file_get_contents('php://input'), TRUE);
        if (!isset($input['email'])) {
            return $this->unprocessableEntityResponse();
        }

        if($this->userGateway->emailExists($input['email'])) {
            return $this->conflictResponse("Account already exists with this email");
        }

        if (isset($decodedJWT['userName'])) {
            $username = $decodedJWT['userName'];
        }

        $id = $this->userGateway->getIdByUsername($username);

        $this->userGateway->changeEmail($input['email'], $id);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
    }

    private function changeUsername()
    {
        $jwt = $this->authController->checkJWTExistence();
        $decodedJWT = $this->authController->validateJWT($jwt);

        $input = (array)json_decode(file_get_contents('php://input'), TRUE);
        if (!isset($input['username'])) {
            return $this->unprocessableEntityResponse();
        }

        if($this->userGateway->usernameExists($input['username'])) {
            return $this->conflictResponse("Account already exists with this username");
        }

        if (isset($decodedJWT['userName'])) {
            $username = $decodedJWT['userName'];
        }

        $id = $this->userGateway->getIdByUsername($username);

        $this->userGateway->changeUsername($input['username'], $id);

        $newJWT = $this->authController->modifyJWTUsername($decodedJWT, $input['username']);

        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode([
            'newJWT' => $newJWT
        ]);
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

    private function unauthorizedResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 401 Unauthorized';
        $response['body'] = json_encode([
            'error' => "Incorrect password"
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