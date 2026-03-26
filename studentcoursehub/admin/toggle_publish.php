<?php
include("../db.php");

if(isset($_GET['id'])){
    $id = $_GET['id'];

    // Fetch current status
    $sql = "SELECT Published FROM programmes WHERE ProgrammeID = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    
    // Toggle status
    $newStatus = $row['Published'] ? 0 : 1;
    $sql2 = "UPDATE programmes SET Published = $newStatus WHERE ProgrammeID = $id";
    mysqli_query($conn, $sql2);

    header("Location: view_programmes.php");
    exit();
}
?>