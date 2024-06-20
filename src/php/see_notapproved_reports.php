<?php

$host = "localhost:3307";
$username = "root";
$password = "";
$database = "web_project";

$connect = mysqli_connect($host, $username, $password, $database);
$sql = "SELECT * FROM reports where is_approve=0";
$results = mysqli_query($connect, $sql);
$json_array = array();

while($data = mysqli_fetch_assoc($results))
{
    $json_array[] = $data;
}

echo json_encode($json_array)

?>