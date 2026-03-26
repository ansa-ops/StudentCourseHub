<?php
include __DIR__ . '/db.php';
include __DIR__ . '/images.php';

$result = $conn->query("
    SELECT p.*, l.LevelName, s.Name AS LeaderName
    FROM Programmes p
    JOIN Levels l ON p.LevelID = l.LevelID
    JOIN Staff s ON p.ProgrammeLeaderID = s.StaffID
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Course Hub</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<nav class="navbar">
    <div class="nav-left">
        <img src="img/logo.png" class="logo" alt="University Logo">
        <span class="site-title">Student Course Hub</span>
    </div>
    <div class="nav-right">
        <a href="#" id="homeLink">Home</a>
    </div>
</nav>

<section class="hero" id="hero">
    <div class="hero-content">
        <h1>Find Your Future Degree</h1>
        <p>Explore undergraduate and postgraduate programmes designed for your success.</p>
        <button class="hero-btn" id="browseBtn">Browse Programmes</button>
    </div>
</section>

<section id="programmes" class="container hidden" role="region" aria-labelledby="programmes-title">
    <h2 id="programmes-title">Available Programmes</h2>

    <div class="filter-search" role="form" aria-label="Filter and search programmes">
        <label for="levelFilter">Level:</label>
        <select id="levelFilter">
            <option value="All">All Levels</option>
            <option value="Undergraduate">Undergraduate</option>
            <option value="Postgraduate">Postgraduate</option>
        </select>

        <label for="searchInput">Search:</label>
        <input type="text" id="searchInput" placeholder="Search programmes...">
        <button id="searchBtn" class="hero-btn">Search</button>
    </div>

    <div class="programmes-grid" role="list" id="programmesGrid">
        <?php while($programme = $result->fetch_assoc()): 
            $image = $images[$programme['ProgrammeName']] ?? 'default.jpg';
        ?>
        <article class="programme-card" data-level="<?= $programme['LevelName'] ?>" data-name="<?= strtolower($programme['ProgrammeName']) ?>" role="listitem" tabindex="0">
            <img src="img/<?= $image ?>" alt="<?= htmlspecialchars($programme['ProgrammeName']) ?>">
            <h3><?= htmlspecialchars($programme['ProgrammeName']) ?></h3>
            <p><?= substr(htmlspecialchars($programme['Description']), 0, 90) ?>...</p>
            <p><strong>Leader:</strong> <?= htmlspecialchars($programme['LeaderName']) ?></p>
            <a href="programme.php?id=<?= $programme['ProgrammeID'] ?>" class="register-btn">View Details</a>
        </article>
        <?php endwhile; ?>
    </div>

    <div id="aria-live-region" class="sr-only" aria-live="polite"></div>
</section>

<button onclick="topFunction()" id="topBtn" title="Go to top">&#8679;</button>

<footer>
    <p>&copy; 2026 Student Course Hub | University of Excellence</p>
    <p><a href="#">About</a> | <a href="#">Contact</a> | <a href="#">Privacy Policy</a></p>
</footer>

<script src="js/script.js"></script>
</body>
</html>