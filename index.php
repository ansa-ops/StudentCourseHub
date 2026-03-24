<?php 
include "db.php"; 

// Fetch all programmes
$sql = "SELECT ProgrammeID, ProgrammeName, LevelID FROM Programmes ORDER BY ProgrammeName";
$stmt = $pdo->query($sql);
$programmes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supreme University</title>
    <link rel="stylesheet" href="../StudentCourseHub/css/style.css">
</head>
<body>

    <!-- HEADER -->
    <header class="main-header">
        <div class="logo-container">
            <img src="../StudentCourseHub/src/LOGO.png" alt="Supreme University Logo" class="logo">
            <h1>Supreme University</h1>
        </div>

        <!-- RIGHT SIDE: Login + Search + Menu -->
        <div class="header-right">
            <!-- Login Button -->
            <a href="login.php" class="login-btn">Login</a>

            <!-- Search Form -->
            <form action="search.php" method="get" class="search-container">
                <input type="text" name="query" placeholder="Search programmes...">
                <select name="level">
                    <option value="">All Levels</option>
                    <option value="1">Undergraduate</option>
                    <option value="2">Postgraduate</option>
                </select>
                <input type="submit" value="Search">
            </form>

            <!-- Menu Button -->
            <div class="menu-button" id="menuBtn">☰</div>
        </div>
    </header>

    <!-- HERO IMAGE -->
    <div class="hero">
        <img src="../StudentCourseHub/src/img.jpg" alt="University Banner">
    </div>

    <!-- WHY SUPREME -->
    <div class="why-supreme">
        <h2>Why Supreme</h2>
        <br><br>
        <p style="font-weight:bold">
            At Supreme University, we are committed to providing a world-class education that empowers students 
            to achieve their full potential. Our dedicated faculty, state-of-the-art facilities, and diverse academic 
            programs create an environment where innovation, critical thinking, and practical skills thrive. By combining 
            rigorous coursework with real-world experiences, Supreme University prepares students to excel in their 
            careers and make meaningful contributions to society.
        </p>
    </div>

    <!-- MENU PANEL -->
    <div class="menu-panel" id="menuPanel">
        <a href="#">News</a>
        <a href="#">Jobs</a>
        <a href="#" id="coursesBtn">Available Courses ▼</a>

        <!-- COURSES -->
        <div class="courses-list" id="coursesList">
            <!-- Undergraduate -->
            <div class="course-group">
                <h3 id="ugBtn">Undergraduate Degree Programme ▼</h3>
                <div class="submenu" id="ugList">
                    <?php foreach($programmes as $course): ?>
                        <?php if($course['LevelID'] == 1): ?>
                            <div class="menu-course">
                                <a href="programme.php?id=<?= $course['ProgrammeID'] ?>">
                                    <?= $course['ProgrammeName'] ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Postgraduate -->
            <div class="course-group">
                <h3 id="pgBtn">Postgraduate Degree Programme ▼</h3>
                <div class="submenu" id="pgList">
                    <?php foreach($programmes as $course): ?>
                        <?php if($course['LevelID'] == 2): ?>
                            <div class="menu-course">
                                <a href="programme.php?id=<?= $course['ProgrammeID'] ?>">
                                    <?= $course['ProgrammeName'] ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="close-btn" id="closeMenu">Close ×</div>
    </div>

    <!-- FOOTER -->
    <footer>
        <p>Supreme University</p>
        <p>Providing quality education and opportunities for students worldwide.</p>
        <p>© 2026 Supreme University</p>
    </footer>

    <script>
        // MENU
        const menuBtn = document.getElementById('menuBtn');
        const menuPanel = document.getElementById('menuPanel');
        const closeBtn = document.getElementById('closeMenu');

        menuBtn.addEventListener('click', () => {
            menuPanel.style.transform = "translateY(0%)";
        });

        closeBtn.addEventListener('click', () => {
            menuPanel.style.transform = "translateY(100%)";
        });

        // Available Courses toggle
        const coursesBtn = document.getElementById('coursesBtn');
        const coursesList = document.getElementById('coursesList');

        coursesBtn.addEventListener('click', () => {
            coursesList.style.display = (coursesList.style.display === "block") ? "none" : "block";
        });

        // Undergraduate toggle
        const ugBtn = document.getElementById('ugBtn');
        const ugList = document.getElementById('ugList');

        ugBtn.addEventListener('click', () => {
            ugList.style.display = (ugList.style.display === "block") ? "none" : "block";
        });

        // Postgraduate toggle
        const pgBtn = document.getElementById('pgBtn');
        const pgList = document.getElementById('pgList');

        pgBtn.addEventListener('click', () => {
            pgList.style.display = (pgList.style.display === "block") ? "none" : "block";
        });
    </script>

</body>
</html>