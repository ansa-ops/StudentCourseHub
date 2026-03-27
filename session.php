<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../Admin/login.php");
    exit();
}

function hasRole($requiredRole) {
    $roles = ['admin' => 1, 'superadmin' => 2];
    $userRole = $_SESSION['admin_role'] ?? 'admin';
    return $roles[$userRole] >= $roles[$requiredRole];
}

function requireRole($requiredRole) {
    if (!hasRole($requiredRole)) {
        http_response_code(403);
        die("<h2>Access Denied</h2><p>You do not have permission.</p>");
    }
}
?>