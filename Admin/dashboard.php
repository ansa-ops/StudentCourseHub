<?php
require '../session.php';
require '../db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 0; }
        .navbar {
            background: #007bff; color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar a { color: white; text-decoration: none; margin-left: 15px; }
        .container { padding: 30px; }
        .cards { display: flex; gap: 20px; flex-wrap: wrap; }
        .card {
            background: white; padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            width: 200px; text-align: center;
        }
        .card a { text-decoration: none; color: #007bff; font-weight: bold; }
    </style>
</head>
<body>

<div class="navbar">
    <span>Welcome, <?= htmlspecialchars($_SESSION['admin_username']) ?> 
    (<?= htmlspecialchars($_SESSION['admin_role']) ?>)</span>
    <div>
        <a href="mailing_list.php">Mailing List</a>
        <?php if (hasRole('superadmin')): ?>
            <a href="manage_admins.php">Manage Admins</a>
        <?php endif; ?>
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="container">
    <h2>Admin Dashboard</h2>
    <div class="cards">
        <div class="card">
            <h3>Mailing List</h3>
            <a href="mailing_list.php">View Students</a>
        </div>
        <?php if (hasRole('superadmin')): ?>
        <div class="card">
            <h3>Manage Admins</h3>
            <a href="manage_admins.php">Manage</a>
        </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>