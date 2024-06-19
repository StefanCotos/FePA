<?php

include_once "../database/Database.php";

$db = new Database();
$db->connectDB(include('../database/Config.php'));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = $_POST["Animal-type"];
    $city = $_POST["City"];
    $street = $_POST["Street"];
    $description = $_POST["Description"];
    $additionalAspect = $_POST["Additional-aspects"];

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
