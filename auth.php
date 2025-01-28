<?php
// auth.php

// Start the session to access session variables
session_start();

// Check if the user is logged in by checking if 'user_id' session variable is set
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to the login page
    header("Location: login.php");
    exit(); // Stop further script execution
}
?>
