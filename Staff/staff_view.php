<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli('localhost', 'root', '', 'student_course_hub');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

require 'C:/xampp/htdocs/WebApplicationDevelopment/sanitise.php';

$errors  = [];
$staff   = null;
$modules = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitise_email($_POST['email']);

    if (!validate_email($email)) {
        $errors[] = "Please enter a valid email address.";
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT * FROM staff WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $staff = $stmt->get_result()->fetch_assoc();

        if (!$staff) {
            $errors[] = "No staff member found with that email.";
        } else {
            $stmt2 = $conn->prepare(
                "SELECT m.title AS module_title,
                        p.title AS programme_title,
                        p.level
                 FROM modules m
                 JOIN programmes p ON m.programme_id = p.id
                 WHERE m.staff_id = ?"
            );
            $stmt2->bind_param("i", $staff['id']);
            $stmt2->execute();
            $modules = $stmt2->get_result()->fetch_all(MYSQLI_ASSOC);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff View</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; }
        .navbar {
            background: #343a40; color: white;
            padding: 15px 20px;
        }
        .container {
            max-width: 700px; margin: 40px auto;
            background: white; padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        h2 { color: #343a40; margin-bottom: 20px; }
        input {
            width: 100%; padding: 10px;
            margin: 6px 0 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            padding: 10px 20px;
            background: #343a40; color: white;
            border: none; border-radius: 4px;
            cursor: pointer; font-size: 16px;
        }
        button:hover { background: #23272b; }
        .error { color: red; margin-bottom: 10px; }
        .staff-info {
            background: #f8f9fa; padding: 15px;
            border-radius: 8px; margin-bottom: 20px;
            margin-top: 20px;
        }
        table {
            width: 100%; border-collapse: collapse;
            margin-top: 20px;
        }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background: #343a40; color: white; }
        tr:nth-child(even) { background: #f9f9f9; }
        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 12px;
        }
        .undergraduate { background: #d4edda; color: #155724; }
        .postgraduate  { background: #cce5ff; color: #004085; }
    </style>
</head>
<body>

<div class="navbar">
    <span>Staff Portal</span>
</div>

<div class="container">
    <h2>Staff Module View</h2>

    <form method="POST" action="">
        <label>Enter your staff email to view your modules:</label>
        <input type="email" name="email"
               value="<?= isset($email) ? safe_output($email) : '' ?>"
               placeholder="e.g. j.smith@university.ac.uk"
               required>
        <button type="submit">View My Modules</button>
    </form>

    <?php foreach ($errors as $error): ?>
        <p class="error">⚠ <?= safe_output($error) ?></p>
    <?php endforeach; ?>

    <?php if ($staff): ?>
        <div class="staff-info">
            <h3>👤 <?= safe_output($staff['full_name']) ?></h3>
            <p>📧 <?= safe_output($staff['email']) ?></p>
        </div>

        <?php if (empty($modules)): ?>
            <p>No modules assigned to you yet.</p>
        <?php else: ?>
            <h3>Your Modules & Programmes</h3>
            <table>
                <tr>
                    <th>Module</th>
                    <th>Programme</th>
                    <th>Level</th>
                </tr>
                <?php foreach ($modules as $module): ?>
                <tr>
                    <td><?= safe_output($module['module_title']) ?></td>
                    <td><?= safe_output($module['programme_title']) ?></td>
                    <td>
                        <span class="badge <?= strtolower($module['level']) ?>">
                            <?= safe_output($module['level']) ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    <?php endif; ?>

</div>

</body>
</html>