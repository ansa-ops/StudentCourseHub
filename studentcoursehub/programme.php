<?php
include("db.php");

// Get programme ID
$programme_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// SUCCESS + ERROR MESSAGE
$success = "";
$error = "";

// FORM SUBMIT
if(isset($_POST['register'])){
    $name = $_POST['name'];
    $email = $_POST['email'];

    if(empty($name) || empty($email)){
        $error = "Please fill all fields";
    } else {
        mysqli_query($conn, "INSERT INTO interestedstudents (StudentName, Email, ProgrammeID) 
                             VALUES ('$name', '$email', $programme_id)");
        $success = "✔ Your interest has been registered successfully!";
    }
}

// Fetch programme (only published)
$sql = "SELECT * FROM programmes WHERE ProgrammeID=$programme_id AND Published=1";
$res = mysqli_query($conn, $sql);

if(mysqli_num_rows($res) == 0){
    echo "<h2>Programme not found or unpublished.</h2>";
    echo "<a href='index.php'>Back to Programmes</a>";
    exit;
}

$programme = mysqli_fetch_assoc($res);

// Fetch modules
$sql_modules = "SELECT m.ModuleName 
                FROM modules m 
                JOIN programmemodules pm ON m.ModuleID = pm.ModuleID 
                WHERE pm.ProgrammeID = $programme_id";
$res_modules = mysqli_query($conn, $sql_modules);
?>

<!DOCTYPE html>
<html>
<head>
<title><?php echo $programme['ProgrammeName']; ?></title>

<style>
body {
    font-family: Arial;
    padding: 20px;
    background: #eef3f9;
}
.card {
    background: white;
    padding: 20px;
    border-radius: 10px;
}
button {
    background: #007BFF;
    color: white;
    padding: 8px 12px;
    border: none;
    border-radius: 5px;
}
</style>

</head>
<body>

<div class="card">

<h2><?php echo $programme['ProgrammeName']; ?></h2>

<p><?php echo $programme['Description']; ?></p>

<!-- SUCCESS / ERROR MESSAGE -->
<?php if($success != ""){ ?>
    <p style="color:green; font-weight:bold;"><?php echo $success; ?></p>
<?php } ?>

<?php if($error != ""){ ?>
    <p style="color:red;"><?php echo $error; ?></p>
<?php } ?>

<!-- MODULES -->
<h3>Modules</h3>
<?php
if(mysqli_num_rows($res_modules) > 0){
    echo "<ul>";
    while($mod = mysqli_fetch_assoc($res_modules)){
        echo "<li>".$mod['ModuleName']."</li>";
    }
    echo "</ul>";
} else {
    echo "<p>No modules added yet.</p>";
}
?>

<!-- FORM -->
<h3>Register Your Interest</h3>

<form method="POST">
    Name:<br>
    <input type="text" name="name"><br><br>

    Email:<br>
    <input type="email" name="email"><br><br>

    <button type="submit" name="register">Register Interest</button>
</form>

<br>
<h3>Contact via Email</h3>

<a href="mailto:university@example.com?subject=Interest in <?php echo $programme['ProgrammeName']; ?>&body=Hello, I am interested in this programme."
   style="background:#28a745; color:white; padding:10px 15px; text-decoration:none; border-radius:5px;">
   📧 Send Email
</a>
<a href="index.php">Back to Programmes</a>

</div>

</body>
</html>