<?php
session_start();
include "db.php";

if (!isset($_SESSION['student_id'])) {
    header("Location: student_login.php");
    exit();
}

$student_name = $_SESSION['student_name'];

// Get programme ID from URL
$programme_id = $_GET['programme_id'] ?? null;

if (!$programme_id) {
    echo "No programme selected.";
    exit();
}

// Fetch programme details
$stmt = $pdo->prepare("SELECT * FROM Programmes WHERE ProgrammeID = ?");
$stmt->execute([$programme_id]);
$programme = $stmt->fetch();

// Hero image
$image = "../StudentCourseHub/src/img.jpg";
switch ($programme['ProgrammeName']) {
    case "BSc Artificial Intelligence": $image="../StudentCourseHub/src/Bsc At.jpg"; break;
    case "BSc Computer Science": $image="../StudentCourseHub/src/Bsc CS.jpeg"; break;
    case "BSc Software Engineering": $image="../StudentCourseHub/src/Bsc SE.webp"; break;
    case "BSc Data Science": $image="../StudentCourseHub/src/Bsc ds.jpg"; break;
    case "BSc Cyber Security": $image="../StudentCourseHub/src/Bsc CyberS.jpg"; break;
    case "MSc Computer Science": $image="../StudentCourseHub/src/Msc CS.jpg"; break;
    case "MSc Data Science": $image="../StudentCourseHub/src/Msc Ds.webp"; break;
    case "MSc Artificial Intelligence": $image="../StudentCourseHub/src/Msc AT.jpg"; break;
    case "MSc Software Engineering": $image="../StudentCourseHub/src/Msc SE.webp"; break;
    case "MSc Cyber Security": $image="../StudentCourseHub/src/msc cyberS.jpg"; break;
}

// Fetch modules for this programme
$stmt2 = $pdo->prepare("
    SELECT m.ModuleName, m.Description, m.Image, pm.Year
    FROM ProgrammeModules pm
    JOIN Modules m ON pm.ModuleID = m.ModuleID
    WHERE pm.ProgrammeID = ?
    ORDER BY pm.Year
");
$stmt2->execute([$programme_id]);
$modules = $stmt2->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($programme['ProgrammeName']) ?> Modules - Supreme University</title>
<link rel="stylesheet" href="../StudentCourseHub/css/style.css">
<style>
/* Additional module styling for visibility */
.student-modules .module {
    background: #005f8e;
    color: white;
    display: flex;
    flex-direction: row;
    gap: 15px;
    padding: 10px;
    margin: 10px 0;
    border-radius: 8px;
    align-items: center;
}

.student-modules .module img {
    width: 120px;
    height: 80px;
    object-fit: cover;
    border-radius: 5px;
}

.student-modules .module div {
    flex: 1;
}

@media (max-width: 768px) {
    .student-modules .module {
        flex-direction: column;
        text-align: center;
    }

    .student-modules .module img {
        margin-bottom: 10px;
    }
}
</style>
</head>
<body>

<div class="container student-modules">
    <h2>Welcome, <?= htmlspecialchars($student_name) ?></h2>
    
    <div class="programme">
        <h1><?= htmlspecialchars($programme['ProgrammeName']) ?></h1>
        <p><?= htmlspecialchars($programme['Description']) ?></p>
        <img src="<?= $image ?>" alt="<?= htmlspecialchars($programme['ProgrammeName']) ?>" style="width:100%; max-height:300px; object-fit:cover; margin-bottom:20px; border-radius:8px;">
    </div>

    <h2>Modules</h2>
    <?php if(count($modules) > 0): ?>
        <?php foreach($modules as $module): ?>
            <div class="module">
                <?php if(!empty($module['Image'])): ?>
                    <img src="../StudentCourseHub/src/modules/<?= $module['Image'] ?>" 
                         alt="<?= htmlspecialchars($module['ModuleName']) ?>">
                <?php endif; ?>
                <div>
                    <strong><?= htmlspecialchars($module['ModuleName']) ?></strong><br>
                    <small>Year: <?= $module['Year'] ?></small>
                    <p><?= htmlspecialchars($module['Description']) ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No modules assigned to this programme yet.</p>
    <?php endif; ?>

    <br>
    <a class="button" href="student_dashboard.php">Back to Dashboard</a>
    <a class="button" href="logout.php">Logout</a>
</div>

</body>
</html>