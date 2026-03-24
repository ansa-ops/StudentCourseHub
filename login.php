<?php
// Start the session at the top
session_start();

// Dummy login credentials (replace with your DB logic)
$users = [
    'student' => 'student123',
    'staff' => 'staff123',
    'admin' => 'admin123'
];

// Handle form submission
$error = '';
if(isset($_POST['login'])) {
    $role = $_POST['role'] ?? '';
    $password = $_POST['password'] ?? '';

    if(isset($users[$role]) && $users[$role] === $password){
        $_SESSION['user_role'] = $role;
        // Redirect to dashboard
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid role or password!";
    }
}

// Adjust the CSS path relative to this file
$cssPath = 'css/style.css';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Supreme University</title>
    <link rel="stylesheet" href="<?php echo $cssPath; ?>">
</head>
<body>
    <div class="login-page">
        <h1>Login</h1>
        <?php if($error): ?>
            <span><?php echo $error; ?></span>
        <?php endif; ?>
        <form method="POST" action="">
            <select name="role" required>
                <option value="">Select Role</option>
                <option value="student">Student</option>
                <option value="staff">Staff</option>
                <option value="admin">Admin</option>
            </select>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" name="login" value="Login">
        </form>

        <div class="login-options">
            <a href="student_login.php" class="login-button">Student Login</a>
            <a href="staff_login.php" class="login-button">Staff Login</a>
            <a href="admin_login.php" class="login-button">Admin Login</a>
        </div>
    </div>
</body>
</html>