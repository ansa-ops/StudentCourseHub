<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = htmlspecialchars(trim($_POST['username']));
    $password = $_POST['password'];

    $conn = new mysqli('localhost', 'root', '', 'student_course_hub');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT id, username, password, role FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $admin = $result->fetch_assoc();

        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin_id']       = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            $_SESSION['admin_role']     = $admin['role'];

            header("Location: dashboard.php");
            exit();
        }
    }

    $_SESSION['error'] = "Invalid username or password.";
    header("Location: login.php");
    exit();
}
?>