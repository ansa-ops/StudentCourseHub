<?php
$conn = new mysqli('localhost', 'root', '', 'student_course_hub');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
require 'C:/xampp/htdocs/WebApplicationDevelopment/session.php';
require 'C:/xampp/htdocs/WebApplicationDevelopment/sanitise.php';

if (isset($_SESSION['success'])) {
    $successMsg = $_SESSION['success'];
    unset($_SESSION['success']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mailing List</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; }
        .navbar {
            background: #007bff; color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
        }
        .navbar a { color: white; text-decoration: none; margin-left: 15px; }
        .container { padding: 30px; }
        table { width: 100%; border-collapse: collapse; background: white; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background: #007bff; color: white; }
        tr:nth-child(even) { background: #f9f9f9; }
        .btn { padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer; }
        .btn-danger { background: red; color: white; }
        .export-btn {
            background: #28a745; color: white;
            padding: 10px 20px; border: none;
            border-radius: 4px; cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="navbar">
    <span>Mailing List</span>
    <div>
        <a href="dashboard.php">Dashboard</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="container">
    <h2>Student Mailing List</h2>

    <a href="export_mailing_list.php" class="export-btn">Export as CSV</a>

    <?php if (isset($successMsg)): ?>
        <p style="color:green;"><?= htmlspecialchars($successMsg) ?></p>
    <?php endif; ?>

    <table>
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Programme</th>
            <th>Registered At</th>
            <?php if (hasRole('superadmin')): ?>
            <th>Action</th>
            <?php endif; ?>
        </tr>

        <?php
        $result = $conn->query(
            "SELECT si.id, si.full_name, si.email, p.title, si.registered_at
             FROM student_interests si
             JOIN programmes p ON si.programme_id = p.id
             ORDER BY si.registered_at DESC"
        );
        while ($row = $result->fetch_assoc()):
        ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['full_name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['title']) ?></td>
            <td><?= $row['registered_at'] ?></td>
            <?php if (hasRole('superadmin')): ?>
            <td>
                <form action="delete_interest.php" method="POST">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <button class="btn btn-danger"
                            onclick="return confirm('Delete this entry?')">
                        Delete
                    </button>
                </form>
            </td>
            <?php endif; ?>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>