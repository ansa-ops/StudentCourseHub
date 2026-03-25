<?php
include "db.php";

// Get programme ID from URL
$id = $_GET['id'];

// Fetch programme details
$sql = "SELECT * FROM Programmes WHERE ProgrammeID = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $id]);
$programme = $stmt->fetch();

// Determine hero image based on programme name
$image = "../StudentCourseHub/src/img.jpg"; // default image

switch ($programme['ProgrammeName']) {
    // BSc Programmes
    case "BSc Artificial Intelligence":
        $image = "../StudentCourseHub/src/Bsc At.jpg";
        break;
    case "BSc Computer Science":
        $image = "../StudentCourseHub/src/Bsc CS.jpeg";
        break;
    case "BSc Software Engineering":
        $image = "../StudentCourseHub/src/Bsc SE.webp";
        break;
    case "BSc Data Science":
        $image = "../StudentCourseHub/src/Bsc ds.jpg";
        break;
    case "BSc Cyber Security":
        $image = "../StudentCourseHub/src/Bsc CyberS.jpg";
        break;

    // MSc Programmes
    case "MSc Artificial Intelligence":
        $image = "../StudentCourseHub/src/Msc AT.jpg";
        break;
    case "MSc Cyber Security":
        $image = "../StudentCourseHub/src/msc cyberS.jpg";
        break;
         case "MSc Data Science":
        $image = "../StudentCourseHub/src/Msc Ds.webp";
          break;
        
    case "MSc Machine Learning":
        $image = "../StudentCourseHub/src/Msc CS.jpg";
      
        break;
    case "MSc Software Engineering":
        $image = "../StudentCourseHub/src/Msc SE.webp";
        break;
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($programme['ProgrammeName']) ?> - Supreme University</title>
    <link rel="stylesheet" href="../StudentCourseHub/css/style.css">
</head>
<body>

    <!-- HEADER -->
    <header class="main-header">
        <div class="logo-container">
            <img src="../StudentCourseHub/src/LOGO.png" alt="Supreme University Logo" class="logo">
            <h1>Supreme University</h1>
        </div>
    </header>

    <!-- HERO IMAGE -->
    <div class="hero">
        <img src="<?= $image ?>" alt="<?= htmlspecialchars($programme['ProgrammeName']) ?>">
    </div>

    <!-- CONTENT -->
    <div class="container">
        <div class="programme">
            <h1><?= htmlspecialchars($programme['ProgrammeName']) ?></h1>
            <p><?= htmlspecialchars($programme['Description']) ?></p>
        </div>

        <h2>Modules</h2>
        <?php
        // Fetch programme modules
        $sql2 = "SELECT Modules.ModuleName 
                 FROM ProgrammeModules 
                 JOIN Modules ON ProgrammeModules.ModuleID = Modules.ModuleID 
                 WHERE ProgrammeModules.ProgrammeID = :id";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->execute(['id' => $id]);

        while ($row = $stmt2->fetch()) {
            echo "<div class='module'>" . htmlspecialchars($row['ModuleName']) . "</div>";
        }
        ?>
        <br>
        <a class="button" href="register.php?programme_id=<?= $id ?>">Register Interest</a>
        <br><br>
        <a class="button" href="index.php">Back to Programmes</a>
    </div>

    <!-- FOOTER -->
    <footer>
        <p>Supreme University</p>
        <p>Providing quality education and opportunities for students worldwide.</p>
        <p>© 2026 Supreme University</p>
    </footer>

</body>
</html>