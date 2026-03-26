<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_course_hub";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Set UTF-8 for special characters
$conn->set_charset("utf8mb4");
?>