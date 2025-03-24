<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $crop = $_POST['crop']; 
    $year = $_POST['year']; 
    $profit = $_POST['profit'];

  
        $insert_sql = "INSERT INTO  profits (crop, year, profit) VALUES ('$crop', '$year', '$profit')";
        
        if ($conn->query($insert_sql) === TRUE) {
            http_response_code(200);
            echo json_encode(["success" => true, "message" => "Added Successfully"]);
            exit;
        } else {
            http_response_code(400);
            echo json_encode(["success" => false, "message" => "An error Occurred"]);
            exit;
        }
}
?>

