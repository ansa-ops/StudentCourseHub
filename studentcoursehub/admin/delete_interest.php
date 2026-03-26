<?php
include("../db.php");

if(isset($_GET['id'])){
    $id = (int)$_GET['id'];
    mysqli_query($conn, "DELETE FROM interestedstudents WHERE InterestID=$id");
}

header("Location: view_interested.php");
exit;
?>