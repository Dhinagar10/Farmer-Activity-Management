    <?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    // Include the database connection file
    include 'db_connect.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Retrieve form data
        $category = $_POST['expenseCategory']; // User mobile number
        $amount = $_POST['expenseAmount']; // User chosen username
        $notes = $_POST['expenseNotes']; // User chosen password

        // Validate if the mobile number already exists in the database
    
            $insert_sql = "INSERT INTO  expenses (expenseCategory, expenseAmount, expenseNotes) VALUES ('$category', '$amount', '$notes')";
            
            if ($conn->query($insert_sql) === TRUE) {
                // Successfully inserted the new user into the database
                http_response_code(200);
                echo json_encode(["success" => true, "message" => "Added Successfully"]);
                exit;
            } else {
                // Error occurred while inserting the user data
                http_response_code(400);
                echo json_encode(["success" => false, "message" => "An error Occurred"]);
                exit;
                // echo "Error: " . $conn->error;
            }
    }
    ?>

