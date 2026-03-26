<?php
session_start();
include("../db.php");

// Protect page
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}

// Check ID
if(!isset($_GET['id'])){
    echo "Invalid Request!";
    exit;
}

$id = (int)$_GET['id'];

// Fetch current data
$result = mysqli_query($conn, "SELECT * FROM programmes WHERE ProgrammeID=$id");

if(!$result || mysqli_num_rows($result) == 0){
    echo "Programme not found!";
    exit;
}

$row = mysqli_fetch_assoc($result);

// Update
if(isset($_POST['update'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $level = (int)$_POST['level'];

    mysqli_query($conn, "UPDATE programmes 
                         SET ProgrammeName='$name', Description='$desc', LevelID=$level 
                         WHERE ProgrammeID=$id");

    echo "<script>alert('Updated Successfully!'); window.location='view_programmes.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Programme</title>
</head>
<body>

<h2>✏ Edit Programme</h2>

<form method="POST">

Name <br>
<input type="text" name="name" value="<?php echo $row['ProgrammeName']; ?>"><br><br>

Description <br>
<textarea name="description"><?php echo $row['Description']; ?></textarea><br><br>

Level <br>
<select name="level">
    <option value="1" <?php if($row['LevelID']==1) echo "selected"; ?>>Undergraduate</option>
    <option value="2" <?php if($row['LevelID']==2) echo "selected"; ?>>Postgraduate</option>
</select><br><br>

<button name="update">Update</button>

</form>

<br>
<a href="view_programmes.php">⬅ Back</a>

</body>
</html>