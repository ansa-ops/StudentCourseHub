<?php
session_start();
require 'db.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Assuming students table has StudentID, Name, Username, Password, ProgrammeID
    $stmt = $pdo->prepare("SELECT * FROM students WHERE Username = ?");
    $stmt->execute([$username]);
    $student = $stmt->fetch();

    if ($student && password_verify($password, $student['Password'])) {
        $_SESSION['user_id'] = $student['StudentID'];
        $_SESSION['programme_id'] = $student['ProgrammeID'];
        header('Location: student_dashboard.php');
        exit();
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Login</title>
</head>
<body>
<h2>Student Login</h2>
<?php if($error) echo "<p style='color:red;'>$error</p>"; ?>
<form method="POST">
    <input type="text" name="username" placeholder="Username" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit">Login</button>
</form>
</body>
</html>