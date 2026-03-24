<?php 
include "db.php";

$name = $email = "";
$nameError = $emailError = "";
$successMsg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $programme_id = $_POST['programme_id'];

    // Validate Name
    if (empty($_POST['name'])) {
        $nameError = "Name required";
    } else {
        $name = test_input($_POST['name']);
    }

    // Validate Email
    if (empty($_POST['email'])) {
        $emailError = "Email required";
    } else {
        $email = test_input($_POST['email']);
    }

    // Insert into database if valid
    if ($name && $email) {
        $sql = "INSERT INTO InterestedStudents (ProgrammeID, StudentName, Email) 
                VALUES (:programme_id, :name, :email)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'programme_id' => $programme_id,
            'name' => $name,
            'email' => $email
        ]);
        $successMsg = "Registration Successful!";
    }
}

// Clean input function
function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Get programme_id from URL
$programme_id = $_GET['programme_id'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Interest - Supreme University</title>
    <link rel="stylesheet" href="../StudentCourseHub/css/style.css">
</head>
<body>

    <!-- HEADER -->
    <header class="main-header">
        <div class="logo-container">
            <img src="../StudentCourseHub/src/LOGO.png" alt="Supreme University Logo" class="logo">
            <h1>Supreme University</h1>
        </div>
    </header>

    <!-- HERO IMAGE -->
    <div class="hero">
        <img src="../StudentCourseHub/src/img.jpg" alt="University Banner">
    </div>

    <!-- CONTENT -->
    <div class="container">
        <h2>Register Interest</h2>

        <?php if($successMsg): ?>
            <h3 style="color:green;text-align:center;"><?= $successMsg ?></h3>
        <?php endif; ?>

        <form method="post">
            <input type="hidden" name="programme_id" value="<?= htmlspecialchars($programme_id) ?>">

            <label>Name</label><br>
            <input type="text" name="name" value="<?= htmlspecialchars($name) ?>">
            <span style="color:red;"><?= $nameError ?></span>
            <br><br>

            <label>Email</label><br>
            <input type="text" name="email" value="<?= htmlspecialchars($email) ?>">
            <span style="color:red;"><?= $emailError ?></span>
            <br><br>

            <input type="submit" value="Register">
        </form>

        <br>
        <a class="button" href="programme.php?id=<?= htmlspecialchars($programme_id) ?>">Back to Programme</a>
        <br><br>
        <a class="button" href="index.php">Back to Homepage</a>
    </div>

    <!-- FOOTER -->
    <footer>
        <p>Supreme University</p>
        <p>Providing quality education and opportunities for students worldwide.</p>
        <p>© 2026 Supreme University</p>
    </footer>

</body>
</html>