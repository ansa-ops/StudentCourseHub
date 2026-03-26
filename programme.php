<?php
include __DIR__ . '/db.php';
include __DIR__ . '/images.php';

$programme_id = intval($_GET['id'] ?? 0);

$stmt = $conn->prepare("
    SELECT p.*, l.LevelName, s.Name AS LeaderName
    FROM Programmes p
    JOIN Levels l ON p.LevelID = l.LevelID
    JOIN Staff s ON p.ProgrammeLeaderID = s.StaffID
    WHERE p.ProgrammeID = ?
");
$stmt->bind_param("i", $programme_id);
$stmt->execute();
$programme = $stmt->get_result()->fetch_assoc();

$modules_result = $conn->query("
    SELECT m.ModuleName, st.Name AS ModuleLeader, pm.Year
    FROM ProgrammeModules pm
    JOIN Modules m ON pm.ModuleID = m.ModuleID
    JOIN Staff st ON m.ModuleLeaderID = st.StaffID
    WHERE pm.ProgrammeID = $programme_id
    ORDER BY pm.Year ASC
");

$modules_by_year = [];
while($mod = $modules_result->fetch_assoc()) {
    $modules_by_year[$mod['Year']][] = $mod;
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);

    $check = $conn->prepare("SELECT * FROM InterestedStudents WHERE ProgrammeID=? AND Email=?");
    $check->bind_param("is", $programme_id, $email);
    $check->execute();
    $result_check = $check->get_result();

    if($result_check->num_rows == 0) {
        $stmt = $conn->prepare("INSERT INTO InterestedStudents (ProgrammeID, StudentName, Email) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $programme_id, $name, $email);
        $stmt->execute();
        $success = "Thank you! Your interest has been registered.";
    } else {
        $success = "You have already registered your interest for this programme.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($programme['ProgrammeName']) ?> - Student Course Hub</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<nav class="navbar">
    <div class="nav-left">
        <img src="img/logo.png" class="logo" alt="University Logo">
        <span class="site-title">Student Course Hub</span>
    </div>
    <div class="nav-right">
        <a href="index.php">Home</a>
    </div>
</nav>

<section class="programme-header container">
    <h1><?= htmlspecialchars($programme['ProgrammeName']) ?></h1>
    <p><strong>Level:</strong> <?= htmlspecialchars($programme['LevelName']) ?></p>
    <p><strong>Programme Leader:</strong> <?= htmlspecialchars($programme['LeaderName']) ?></p>

    <div class="programme-image-wrapper">
        <img src="img/<?= $images[$programme['ProgrammeName']] ?? 'default.jpg' ?>" alt="<?= htmlspecialchars($programme['ProgrammeName']) ?>" class="programme-img">
    </div>

    <p><?= htmlspecialchars($programme['Description']) ?></p>
</section>

<div class="container modules-section" role="region" aria-labelledby="modules-title">
    <h2 id="modules-title">Modules by Year</h2>
    <div class="modules-grid" role="list">
        <?php foreach($modules_by_year as $year => $mods): ?>
            <div class="year-box" role="group" aria-labelledby="year-<?= $year ?>">
                <h3 id="year-<?= $year ?>">Year <?= $year ?></h3>
                <ul>
                    <?php foreach($mods as $mod): ?>
                        <li class="module-item">
                            <span class="module-name"><?= htmlspecialchars($mod['ModuleName']) ?></span> – 
                            <span class="module-leader"><?= htmlspecialchars($mod['ModuleLeader']) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="container register-box" role="form" aria-labelledby="register-title">
    <h2 id="register-title">Register Interest</h2>
    <?php if(isset($success)) echo "<p class='success'>$success</p>"; ?>
    <form method="post">
        <input type="text" name="name" placeholder="Your Name" required>
        <input type="email" name="email" placeholder="Your Email" required>
        <button type="submit" class="register-btn">Register</button>
    </form>
</div>

<button onclick="topFunction()" id="topBtn" title="Go to top">&#8679;</button>

<footer>
    <p>&copy; 2026 Student Course Hub | University of Excellence</p>
    <p><a href="#">About</a> | <a href="#">Contact</a> | <a href="#">Privacy Policy</a></p>
</footer>

<script src="js/script.js"></script>
</body>
</html>