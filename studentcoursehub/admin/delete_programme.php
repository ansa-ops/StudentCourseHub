<?php
include("../db.php");

if(isset($_GET['id'])){
    $id = (int)$_GET['id'];
    // Delete related modules first
    mysqli_query($conn, "DELETE FROM programmemodules WHERE ProgrammeID=$id");
    // Then delete the programme
    mysqli_query($conn, "DELETE FROM programmes WHERE ProgrammeID=$id");
}

header("Location: view_programmes.php");
exit;
?>