<?php
session_start(); // Start the session
if (isset($_SESSION['task_message'])) {
    echo $_SESSION['task_message'];  // Return the session message
    unset($_SESSION['task_message']);  // Optionally clear the session message after returning it
} else {
    echo '';  // Return empty if no message exists
}
?>
