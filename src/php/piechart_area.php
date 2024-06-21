<?php

use database\Database;

include_once "../database/Database.php";

$db = new Database();
$db->connectDB(include('../../config/config.php'));

try {
    $query = "SELECT city, COUNT(*) AS numar_linii FROM reports where is_approve=1 GROUP BY city";
    $stmt = $db->getConnection()->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = [$row['city'], (int)$row['numar_linii']];
        }
    }

    $stmt->close();

    echo json_encode($data);
} catch (mysqli_sql_exception $e) {
    die("Query failed: " . $e->getMessage());
}
?>
