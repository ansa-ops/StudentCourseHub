<?php
session_start();
require 'db.php';

if(!isset($_SESSION['user_id']) || !isset($_SESSION['programme_id'])) {
    header('Location: student_login.php');
    exit();
}

$student_programme_id = $_SESSION['programme_id'];

$stmt = $pdo->prepare("
    SELECT m.ModuleName, m.Description, pm.Year, s.Name AS ModuleLeader
    FROM ProgrammeModules pm
    JOIN Modules m ON pm.ModuleID = m.ModuleID
    LEFT JOIN Staff s ON m.ModuleLeaderID = s.StaffID
    WHERE pm.ProgrammeID = ?
    ORDER BY pm.Year, m.ModuleName
");
$stmt->execute([$student_programme_id]);
$modules = $stmt->fetchAll();
?>

<h1>Your Modules</h1>
<table border="1" cellpadding="5">
<tr>
    <th>Module Name</th>
    <th>Description</th>
    <th>Year</th>
    <th>Module Leader</th>
</tr>
<?php foreach($modules as $mod): ?>
<tr>
    <td><?= htmlspecialchars($mod['ModuleName']) ?></td>
    <td><?= htmlspecialchars($mod['Description']) ?></td>
    <td><?= htmlspecialchars($mod['Year']) ?></td>
    <td><?= htmlspecialchars($mod['ModuleLeader'] ?? '-') ?></td>
</tr>
<?php endforeach; ?>
</table>