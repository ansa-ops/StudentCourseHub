<?php
require '../session.php';
requireRole('superadmin');
require '../db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Admins</title>
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
        input, select {
            width: 100%; padding: 8px;
            margin: 6px 0; border: 1px solid #ddd;
            border-radius: 4px; box-sizing: border-box;
        }
        button {
            padding: 10px 20px; background: #007bff;
            color: white; border: none;
            border-radius: 4px; cursor: pointer;
        }
    </style>
</head>
<body>

<div class="navbar">
    <span>Manage Admins</span>
    <div>
        <a href="dashboard.php">Dashboard</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="container">
    <h2>Manage Admins</h2>

    <?php if (isset($_SESSION['success'])): ?>
        <p style="color:green;"><?= htmlspecialchars($_SESSION['success']) ?></p>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <p style="color:red;"><?= htmlspecialchars($_SESSION['error']) ?></p>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <h3>Add New Admin</h3>
    <form action="add_admin.php" method="POST" style="max-width:400px;">
        <label>Username:</label>
        <input type="text" name="username" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <label>Role:</label>
        <select name="role">
            <option value="admin">Admin</option>
            <option value="superadmin">Superadmin</option>
        </select>

        <button type="submit">Add Admin</button>
    </form>

    <h3>Existing Admins</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Role</th>
            <th>Created At</th>
        </tr>
        <?php
        $result = $conn->query("SELECT id, username, role, created_at FROM admins");
        while ($row = $result->fetch_assoc()):
        ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['username']) ?></td>
            <td><?= htmlspecialchars($row['role']) ?></td>
            <td><?= $row['created_at'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>