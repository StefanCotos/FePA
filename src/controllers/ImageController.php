<?php

namespace controllers;

use Cloudinary\Api\Exception\ApiError;
use ImageGateway;
use load_images\LoadImages;

include_once __DIR__ . "/../gateways/ImageGateway.php";
include_once __DIR__ . "/../controllers/AuthController.php";
include_once __DIR__ . "/../load_images/LoadImages.php";


class ImageController
{
    private $requestMethod;
    private $image;
    private $imageGateway;
    private $authController;
    private $loadImages;

    public function __construct($db, $requestMethod, $image)
    {
        $this->requestMethod = $requestMethod;
        $this->image = $image;

        $this->imageGateway = new ImageGateway($db);
        $this->authController = new AuthController($requestMethod);
        $this->loadImages = new LoadImages();
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->image)
                    $response = $this->getImagesByReportId($this->image);
                break;
            case 'POST':
                $response = $this->createImageFromRequest();
                break;
            case 'DELETE':
                if ($this->image)
                    $response = $this->deleteImagesByReportId($this->image);
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

    private function createImageFromRequest()
    {
        $jwt = $this->authController->checkJWTExistence();
        $this->authController->validateJWT($jwt);

        $input = (array)json_decode(file_get_contents('php://input'), TRUE);
        if (!$this->validateImage($input)) {
            return $this->unprocessableEntityResponse();
        }

        $image = json_encode([
            "name" => "",
            "report_id" => $input['reportId'],
        ]);
        $imageArray = (array)json_decode($image, true);
        $imageId = $this->imageGateway->insertImage($imageArray);

        try {
            $imageURL = $this->loadImages->upload_image($input['base64'], $input['type'], $imageId);
        } catch (ApiError $e) {
            return $this->unprocessableEntityResponse();
        }

        $this->imageGateway->updateImage($imageURL, $imageId);

        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = null;
        return $response;

    }

    private function getImagesByReportId($reportId)
    {
        $result = $this->imageGateway->getImagesByReportId($reportId);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function deleteImagesByReportId($reportId)
    {
        $jwt = $this->authController->checkJWTExistence();
        $this->authController->validateJWT($jwt);

        $this->imageGateway->deleteImagesByReportId($reportId);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
    }

    private function validateImage($input)
    {
        if (!isset($input['type'])) {
            return false;
        }
        if (!isset($input['base64'])) {
            return false;
        }
        if (!isset($input['reportId'])) {
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