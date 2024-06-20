<?php

include_once "../database/Database.php";

$db = new Database();
$db->connectDB(include('../database/Config.php'));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = $_POST["animal_type"];
    $city = $_POST["city"];
    $street = $_POST["street"];
    $description = $_POST["description"];
    $additionalAspect = $_POST["additional_aspects"];

    try {

        $query = "INSERT INTO reports (animal_type, city, street, descriptions, additional_aspects) VALUES (?, ?, ?, ?, ?);";        

        $stmt = $db->getConnection()->prepare($query);
        $stmt->bind_param('sssss', $type, $city, $street, $description, $additionalAspect);
        $stmt->execute();

        $stmt->close();
        $db->getConnection()->close();

        header("Location: ../report.php");
        exit;

    } catch (mysqli_sql_exception $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../report.php");
    exit;
}

?>
