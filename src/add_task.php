<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $taskName = trim($_POST['taskName']);
    $taskDate = trim($_POST['taskDate']);
    $taskPriority = trim($_POST['taskPriority']);
    $taskDescription = trim($_POST['taskDescription']);

    
    if (empty($taskName) || empty($taskDate) || empty($taskPriority) || empty($taskDescription)) {
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "All fields are required."]);
        exit;
    }

    
    $taskDateFormatted = str_replace('T', ' ', $taskDate);

    
    $taskDateObject = DateTime::createFromFormat('Y-m-d H:i', $taskDateFormatted);
    if (!$taskDateObject) {
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "Invalid date format. Use yyyy-MM-ddTHH:mm."]);
        exit;
    }

    
    $sql = "INSERT INTO tasks (task_name, task_datetime, task_priority, task_description) 
            VALUES (?, ?, ?, ?)";

    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssss", $taskName, $taskDateFormatted, $taskPriority, $taskDescription);

        
        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(["success" => true, "message" => "Task added successfully!"]);
        } else {
            http_response_code(500);
            echo json_encode(["success" => false, "message" => "Error executing query: " . $stmt->error]);
        }

        $stmt->close();
    } else {

        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Error preparing query: " . $conn->error]);
    }

    $conn->close();
} else {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
?>
