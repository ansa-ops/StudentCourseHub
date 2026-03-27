<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli('localhost', 'root', '', 'student_course_hub');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

require 'C:/xampp/htdocs/WebApplicationDevelopment/sanitise.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Course Hub</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
        .navbar {
            background: #007bff; color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar h1 { font-size: 20px; }
        .container { padding: 30px; }
        .filters {
            display: flex; gap: 10px;
            margin-bottom: 20px; flex-wrap: wrap;
        }
        .filters input, .filters select {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        .filters button {
            padding: 8px 16px;
            background: #007bff;
            color: white; border: none;
            border-radius: 4px; cursor: pointer;
        }
        .cards {
            display: flex; flex-wrap: wrap; gap: 20px;
        }
        .card {
            background: white; padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            width: calc(33% - 20px);
            min-width: 250px;
        }
        .card h3 { color: #007bff; margin-bottom: 10px; }
        .card p { color: #666; font-size: 14px; margin-bottom: 10px; }
        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 12px;
            margin-bottom: 10px;
        }
        .undergraduate { background: #d4edda; color: #155724; }
        .postgraduate  { background: #cce5ff; color: #004085; }
        .btn {
            display: inline-block;
            padding: 8px 16px;
            background: #007bff;
            color: white; border: none;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px; cursor: pointer;
        }
        .btn:hover { background: #0056b3; }
        @media (max-width: 768px) {
            .card { width: 100%; }
        }
    </style>
</head>
<body>

<div class="navbar">
    <h1>Student Course Hub</h1>
</div>

<div class="container">
    <h2>Available Programmes</h2>

    <form method="GET" action="">
        <div class="filters">
            <input type="text" name="search" placeholder="Search programmes..."
                   value="<?= isset($_GET['search']) ? safe_output($_GET['search']) : '' ?>">

            <select name="level">
                <option value="">All Levels</option>
                <option value="Undergraduate"
                    <?= (isset($_GET['level']) && $_GET['level'] === 'Undergraduate')
                        ? 'selected' : '' ?>>
                    Undergraduate
                </option>
                <option value="Postgraduate"
                    <?= (isset($_GET['level']) && $_GET['level'] === 'Postgraduate')
                        ? 'selected' : '' ?>>
                    Postgraduate
                </option>
            </select>

            <button type="submit">Search</button>
            <a href="index.php" style="padding:8px 16px; color:#007bff;">Clear</a>
        </div>
    </form>

    <div class="cards">
        <?php
        $query  = "SELECT * FROM programmes WHERE 1=1";
        $params = [];
        $types  = "";

        if (!empty($_GET['search'])) {
            $search  = sanitise_string($_GET['search']);
            $query  .= " AND title LIKE ?";
            $params[] = "%" . $search . "%";
            $types   .= "s";
        }

        if (!empty($_GET['level'])) {
            $level   = sanitise_string($_GET['level']);
            $query  .= " AND level = ?";
            $params[] = $level;
            $types   .= "s";
        }

        $stmt = $conn->prepare($query);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0):
        ?>
            <p>No programmes found.</p>
        <?php else: ?>
            <?php while ($prog = $result->fetch_assoc()): ?>
            <div class="card">
                <span class="badge <?= strtolower($prog['level']) ?>">
                    <?= safe_output($prog['level']) ?>
                </span>
                <h3><?= safe_output($prog['title']) ?></h3>
                <a href="register_interest.php?programme_id=<?= $prog['id'] ?>"
                   class="btn">
                    Register Interest
                </a>
            </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</div>

</body>
</html>