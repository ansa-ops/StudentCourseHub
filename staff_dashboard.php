<?php
session_start();
require 'db.php';

if(!isset($_SESSION['user_id'])) {
    header('Location: staff_login.php');
    exit();
}

$staff_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT m.ModuleName, m.Description, p.ProgrammeName, pm.Year
    FROM Modules m
    LEFT JOIN ProgrammeModules pm ON m.ModuleID = pm.ModuleID
    LEFT JOIN Programmes p ON pm.ProgrammeID = p.ProgrammeID
    WHERE m.ModuleLeaderID = ?
    ORDER BY pm.Year, p.ProgrammeName
");
$stmt->execute([$staff_id]);
$modules = $stmt->fetchAll();
?>

<h1>Your Modules</h1>
<table border="1" cellpadding="5">
<tr>
    <th>Module Name</th>
    <th>Description</th>
    <th>Programme</th>
    <th>Year</th>
</tr>
<?php foreach($modules as $mod): ?>
<tr>
    <td><?= htmlspecialchars($mod['ModuleName']) ?></td>
    <td><?= htmlspecialchars($mod['Description']) ?></td>
    <td><?= htmlspecialchars($mod['ProgrammeName'] ?? '-') ?></td>
    <td><?= htmlspecialchars($mod['Year'] ?? '-') ?></td>
</tr>
<?php endforeach; ?>
</table>