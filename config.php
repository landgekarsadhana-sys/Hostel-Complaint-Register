<?php
// Display no raw internal DB errors to public end users
ini_set('display_errors', 0);
error_reporting(0);

// Replace with your actual InfinityFree MySQL credentials
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "hostel_complaint_db";     

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$conn) {
    // Graceful error display without exposing server paths or passwords
    die("A secure connection to the database could not be established. Please try again later.");
}

// Ensure UTF-8 character encoding
mysqli_set_charset($conn, "utf8mb4");
?>