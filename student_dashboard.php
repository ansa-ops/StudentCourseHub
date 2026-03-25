<?php
session_start();
include "db.php";

if (!isset($_SESSION['student_id'])) {
    header("Location: student_login.php");
    exit();
}

$student_name = $_SESSION['student_name'];

// Fetch all programmes
$stmt = $pdo->query("SELECT * FROM Programmes ORDER BY ProgrammeName");
$programmes = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Dashboard - Supreme University</title>
<link rel="stylesheet" href="../StudentCourseHub/css/style.css">
</head>
<body>

<!-- DASHBOARD CONTENT -->
<div class="container student-dashboard">
    <h2>Welcome, <?= htmlspecialchars($student_name) ?></h2>
    <h3>Available Programmes</h3>

    <?php foreach ($programmes as $programme): ?>
        <?php
        $image = "../StudentCourseHub/src/img.jpg";
        switch ($programme['ProgrammeName']) {
            case "BSc Artificial Intelligence": $image="../StudentCourseHub/src/Bsc At.jpg"; break;
            case "BSc Computer Science": $image="../StudentCourseHub/src/Bsc CS.jpeg"; break;
            case "BSc Cyber Security": $image="../StudentCourseHub/src/Bsc CyberS.jpg"; break;
            case "BSc Data Science": $image="../StudentCourseHub/src/Bsc ds.jpg"; break;
            case "BSc Software Engineering": $image="../StudentCourseHub/src/Bsc SE.webp"; break;
            case "MSc Machine Learning": $image="../StudentCourseHub/src/Msc CS.jpg"; break;
            case "MSc Data Science": $image="../StudentCourseHub/src/Msc Ds.webp"; break;
            case "MSc Artificial Intelligence": $image="../StudentCourseHub/src/Msc AT.jpg"; break;
            case "MSc Software Engineering": $image="../StudentCourseHub/src/Msc SE.webp"; break;
            case "MSc Cyber Security": $image="../StudentCourseHub/src/msc cyberS.jpg"; break;
        }
        ?>
        <div class="programme" style="display:flex; gap:15px; margin:15px 0; padding:10px; background:#005f8e; color:white; border-radius:8px; align-items:center;">
            <img src="<?= $image ?>" alt="<?= htmlspecialchars($programme['ProgrammeName']) ?>" style="width:120px; height:80px; object-fit:cover; border-radius:5px;">
            <div>
                <strong><?= htmlspecialchars($programme['ProgrammeName']) ?></strong>
                <p><?= htmlspecialchars($programme['Description']) ?></p>
                <a class="button" href="student_modules.php?programme_id=<?= $programme['ProgrammeID'] ?>">View Modules</a>
            </div>
        </div>
    <?php endforeach; ?>

    <br>
    <a class="button" href="logout.php">Logout</a>
</div>

</body>
</html>