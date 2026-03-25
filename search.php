<?php
include "db.php";

$keyword = $_GET['keyword'] ?? '';
$year = $_GET['year'] ?? '';
$level = $_GET['level'] ?? '';
$results = [];

if ($keyword !== '' || $year !== '' || $level !== '') {
    $sql = "SELECT DISTINCT Programmes.ProgrammeID, ProgrammeName 
            FROM Programmes 
            LEFT JOIN ProgrammeModules ON Programmes.ProgrammeID = ProgrammeModules.ProgrammeID 
            LEFT JOIN Modules ON ProgrammeModules.ModuleID = Modules.ModuleID 
           /LEFT JOIN Levels ON Programmes.LevelID = Levels.LevelID 
          WHERE 1=1";

    $params = [];

    // Search by programme or module name
    if ($keyword !== '') {
        $sql .= " AND (ProgrammeName LIKE :keyword OR Modules.ModuleName LIKE :keyword)";
        $params['keyword'] = "%$keyword%";
    }

    // Filter by year
    if ($year !== '') {
        $sql .= " AND ProgrammeModules.Year = :year";
        $params['year'] = $year;
    }

    // Filter by level
    if ($level !== '') {
        $sql .= " AND Levels.LevelName = :level";
        $params['level'] = $level;
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $results = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Programmes</title>
    <link rel="stylesheet" href="../StudentCourseHub/css/style.css">
</head>
<body>

    <!-- HEADER -->
    <header class="main-header">
        <div class="logo-container">
            <h1>Search Programmes</h1>
        </div>
    </header>

    <div class="container">
        <h2>Search</h2>

        <!-- SEARCH FORM -->
        <form method="GET">
            <input type="text" name="keyword" placeholder="Search programme or module..." value="<?= htmlspecialchars($keyword) ?>">

            <select name="year">
                <option value="">Select Year</option>
                <option value="1" <?= ($year=='1')?'selected':'' ?>>Year 1</option>
                <option value="2" <?= ($year=='2')?'selected':'' ?>>Year 2</option>
                <option value="3" <?= ($year=='3')?'selected':'' ?>>Year 3</option>
            </select>

            <select name="level">
                <option value="">Select Level</option>
                <option value="Undergraduate" <?= ($level=='Undergraduate')?'selected':'' ?>>Undergraduate</option>
                <option value="Postgraduate" <?= ($level=='Postgraduate')?'selected':'' ?>>Postgraduate</option>
            </select>

            <input type="submit" value="Search">
        </form>

        <hr><br>

        <h2>Results</h2>
        <?php if ($keyword !== '' || $year !== '' || $level !== ''): ?>
            <?php if (count($results) > 0): ?>
                <?php foreach ($results as $row): ?>
                    <div class="module">
                        <a href="programme.php?id=<?= htmlspecialchars($row['ProgrammeID']) ?>" style="color:white; text-decoration:none;">
                            <?= htmlspecialchars($row['ProgrammeName']) ?>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No results found.</p>
            <?php endif; ?>
        <?php else: ?>
            <p style="text-align:center; font-weight:bold;">Use the search box or filters above to find programmes</p>
        <?php endif; ?>

        <br>
        <a class="button" href="index.php">Back</a>
    </div>

</body>
</html>