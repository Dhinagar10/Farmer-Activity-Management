<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $mobile_number = $_POST['mobile'];
    $password = $_POST['password'];   

    $stmt = $conn->prepare("SELECT * FROM users WHERE mobile_number = ?");
    $stmt->bind_param("s", $mobile_number);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $task_stmt = $conn->prepare("SELECT task_description FROM tasks WHERE task_priority = ?");
            $high_priority = 'high';
            $task_stmt->bind_param("s", $high_priority);
            $task_stmt->execute();
            $task_result = $task_stmt->get_result();

            $tasks = [];
            while ($task = $task_result->fetch_assoc()) {
                $tasks[] = $task['task_description'];
            }
            $task_stmt->close();

            session_start();
            $_SESSION['task_message'] = !empty($tasks) ? implode("\\n", $tasks) : 'No high-priority tasks found.';

            header("Location: index.html");
            exit();
        } else {
            echo "<script>alert('Incorrect password. Please try again.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Mobile number not found. Please check or sign up.'); window.history.back();</script>";
    }
    $stmt->close();
}
?>
