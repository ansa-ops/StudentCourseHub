<?php
include("../db.php");

if(isset($_POST['add'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $level = (int)$_POST['level'];

    $sql = "INSERT INTO programmes (ProgrammeName, Description, LevelID, Published) 
            VALUES ('$name','$desc','$level',0)";

    mysqli_query($conn,$sql);

    echo "Programme Added Successfully!";
}
?>

<h2>Add New Programme</h2>

<form method="POST">

Programme Name <br>
<input type="text" name="name" required><br><br>

Description <br>
<textarea name="description" required></textarea><br><br>

Level <br>
<select name="level" required>
    <option value="">Select Level</option>
    <option value="1">Undergraduate</option>
    <option value="2">Postgraduate</option>
</select><br><br>

<button name="add">Add Programme</button>

</form>