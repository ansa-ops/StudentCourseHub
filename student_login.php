<?php
session_start();
include "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM students WHERE email = ?");
    $stmt->execute([$email]);
    $student = $stmt->fetch();

    if ($student && $student['password'] == $password) {
        $_SESSION['student_id'] = $student['student_id'];
        $_SESSION['student_name'] = $student['full_name'];
        header("Location: student_dashboard.php"); // redirect to dashboard
        exit();
    } else {
        $error = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Login - Supreme University</title>
<link rel="stylesheet" href="../StudentCourseHub/css/style.css">
</head>
<body>
<div class="login-page">
    <h2>Student Login</h2>
    <?php if($error): ?>
        <span><?= htmlspecialchars($error) ?></span>
    <?php endif; ?>
    <form method="POST">
        <input type="text" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Login">
    </form>
    <a class="login-button" href="../index.php">Back to Home</a>
</div>
</body>
</html>