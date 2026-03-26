<?php
$conn = mysqli_connect("localhost", "root", "", "student_course_hub");
if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}
?>