<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $year = filter_input(INPUT_POST, 'year', FILTER_VALIDATE_INT);
    $crop = filter_input(INPUT_POST, 'crop', FILTER_SANITIZE_STRING);
    $profit = filter_input(INPUT_POST, 'profit', FILTER_VALIDATE_FLOAT);

    if ($year === false || $crop === false || $profit === false || empty($crop)) {
        http_response_code(400);
        echo json_encode(["error" => true, "message" => "Invalid input data."]);
        exit;
    }

    
    $stmt = $conn->prepare("INSERT INTO profits (year, crop, profit) VALUES (?, ?, ?)");

    if ($stmt) {
        $stmt->bind_param("isd", $year, $crop, $profit);

        
        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(["success" => true, "message" => "Data saved successfully!"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => true, "message" => "Failed to save data."]);
        }

        $stmt->close();
    } else {
        http_response_code(500);
        echo json_encode(["error" => true, "message" => "Failed to prepare the SQL statement."]);
    }

    $conn->close();
} else {
    http_response_code(405);
    echo json_encode(["error" => true, "message" => "Invalid request method."]);
}
?>
