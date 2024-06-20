<?php

include_once "../gateways/ReportGateway.php";

class ReportController
{
    private $db;
    private $requestMethod;

    private $reportGateway;

    public function __construct($db, $requestMethod)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;

        $this->reportGateway = new ReportGateway($db);
    }

    public function processRequest()
{
    switch ($this->requestMethod) {
        case 'POST':
            $response = $this->createReportFromRequest();
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
    $input = (array)json_decode(file_get_contents('php://input'), TRUE);
    file_put_contents('php://stderr', print_r($input, TRUE)); // Adăugăm această linie pentru a loga input-ul
    if (!$this->validateReport($input)) {
        return $this->unprocessableEntityResponse();
    }

    $this->reportGateway->insertReport($input);
    $response['status_code_header'] = 'HTTP/1.1 201 Created';
    $response['body'] = json_encode(['message' => 'Report created']);
    return $response;
}



    private function validateReport($input)
    {
        return isset($input['animal_type'], $input['city'], $input['street'], $input['description']);
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
