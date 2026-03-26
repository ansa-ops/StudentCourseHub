<?php
include("db.php");

$level = isset($_GET['level']) ? (int)$_GET['level'] : 0;

$sql = "SELECT * FROM programmes WHERE Published = 1";
if($level > 0){
    $sql .= " AND LevelID = $level";
}
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Student Course Hub</title>

<style>
body {
    font-family: Arial;
    margin: 0;
    background: #eef3f9;
}

.header {
    background: #007BFF;
    color: white;
    padding: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.menu-btn {
    font-size: 28px;
    cursor: pointer;
}

.sidebar {
    height: 100%;
    width: 0;
    position: fixed;
    top: 0;
    right: 0;
    background: #333;
    overflow-x: hidden;
    transition: 0.3s;
    padding-top: 60px;
}

.sidebar a {
    padding: 12px 20px;
    display: block;
    color: white;
    text-decoration: none;
}

.sidebar a:hover {
    background: #575757;
}

.close-btn {
    position: absolute;
    top: 10px;
    right: 20px;
    font-size: 30px;
}

.card {
    border: 1px solid #ddd;
    padding: 15px;
    margin: 15px;
    background: white;
    border-radius: 8px;
}
</style>

<script>
function openMenu() {
    document.getElementById("menu").style.width = "250px";
}
function closeMenu() {
    document.getElementById("menu").style.width = "0";
}
</script>

</head>

<body>

<!-- MENU -->
<div id="menu" class="sidebar">
    <a href="javascript:void(0)" class="close-btn" onclick="closeMenu()">&times;</a>
    <a href="index.php">All Programmes</a>
    <a href="index.php?level=1">Undergraduate</a>
    <a href="index.php?level=2">Postgraduate</a>
</div>

<!-- HEADER -->
<div class="header">
    <div style="display:flex; align-items:center;">
        <img src="images/LOGO.png" style="height:100px; margin-right:10px;">
        <h2>Supreme University</h2>
    </div>

    <span class="menu-btn" onclick="openMenu()">☰</span>
</div>

<!-- ✅ DYNAMIC HEADING -->
<h2 style="padding:10px; color:#007BFF;">
<?php
if($level == 1){
    echo "🎓 Undergraduate Programmes";
}
elseif($level == 2){
    echo "🎓 Postgraduate Programmes";
}
else{
    echo "📚 All Programmes";
}
?>
</h2>

<?php while($row = mysqli_fetch_assoc($result)) { ?>

<?php
$image = "default.jpg";

if($row['ProgrammeName'] == "BSc Computer Science"){
    $image = "Bsc CS.jpeg";
}
elseif($row['ProgrammeName'] == "BSc Artificial Intelligence"){
    $image = "Bsc At.jpg";
}
elseif($row['ProgrammeName'] == "BSc Cyber Security"){
    $image = "Bsc CyberS.jpg";
}
elseif($row['ProgrammeName'] == "BSc Data Science"){
    $image = "Bsc ds.jpg";
}
elseif($row['ProgrammeName'] == "BSc Software Engineering"){
    $image = "Bsc SE.webp";
}
elseif($row['ProgrammeName'] == "MSc Machine Learning"){
    $image = "Msc CS.jpg";
}
elseif($row['ProgrammeName'] == "MSc Data Science"){
    $image = "Msc Ds.webp";
}
elseif($row['ProgrammeName'] == "MSc Cyber Security"){
    $image = "msc cyberS.jpg";
}
elseif($row['ProgrammeName'] == "MSc Artificial Intelligence"){
    $image = "Msc AT.jpg";
}
elseif($row['ProgrammeName'] == "MSc Software Engineering"){
    $image = "Msc SE.webp";
}
?>

<div class="card">

    <img src="images/attachments/<?php echo $image; ?>" 
         style="width:50%; max-height:300px; object-fit:cover; border-radius:7px;">

    <h3><?php echo $row['ProgrammeName']; ?></h3>
    <p><?php echo $row['Description']; ?></p>

    <a href="programme.php?id=<?php echo $row['ProgrammeID']; ?>" 
       style="background:#007BFF; color:white; padding:8px 12px; text-decoration:none; border-radius:5px;">
        View Details
    </a>

</div>

<?php } ?>

</body>
</html>