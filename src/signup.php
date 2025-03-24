<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $mobile_number = $_POST['mobile'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM users WHERE mobile_number = '$mobile_number'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        echo "Mobile number already registered. Please choose another.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $insert_sql = "INSERT INTO users (mobile_number, username, password) VALUES ('$mobile_number', '$username', '$hashed_password')";
        
        if ($conn->query($insert_sql) === TRUE) {
            echo "Sign Up successful! You can now <a href='login.html'>Login</a>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>

