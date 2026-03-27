<?php
require '../session.php';
requireRole('superadmin');
require '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars(trim($_POST['username']));
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role     = in_array($_POST['role'], ['admin', 'superadmin']) 
                ? $_POST['role'] : 'admin';

    $stmt = $conn->prepare(
        "INSERT INTO admins (username, password, role) VALUES (?, ?, ?)"
    );
    $stmt->bind_param("sss", $username, $password, $role);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Admin added successfully.";
    } else {
        $_SESSION['error'] = "Username already exists.";
    }

    header("Location: manage_admins.php");
    exit();
}
?>