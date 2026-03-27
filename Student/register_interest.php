<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli('localhost', 'root', '', 'student_course_hub');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

require 'C:/xampp/htdocs/WebApplicationDevelopment/sanitise.php';

$errors  = [];
$success = false;

// Get programme details
$programme_id = sanitise_int($_GET['programme_id'] ?? 0);
$stmt = $conn->prepare("SELECT * FROM programmes WHERE id = ?");
$stmt->bind_param("i", $programme_id);
$stmt->execute();
$programme = $stmt->get_result()->fetch_assoc();

if (!$programme) {
    die("Programme not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name    = sanitise_string($_POST['full_name']);
    $email        = sanitise_email($_POST['email']);
    $programme_id = sanitise_int($_POST['programme_id']);

    // Validate
    if (empty($full_name)) {
        $errors[] = "Full name is required.";
    }
    if (!validate_email($email)) {
        $errors[] = "Please enter a valid email address.";
    }

    // Check if already registered
    $check = $conn->prepare(
        "SELECT id FROM student_interests 
         WHERE email = ? AND programme_id = ?"
    );
    $check->bind_param("si", $email, $programme_id);
    $check->execute();
    if ($check->get_result()->num_rows > 0) {
        $errors[] = "You have already registered interest in this programme.";
    }

    if (empty($errors)) {
        $stmt = $conn->prepare(
            "INSERT INTO student_interests (full_name, email, programme_id) 
             VALUES (?, ?, ?)"
        );
        $stmt->bind_param("ssi", $full_name, $email, $programme_id);

        if ($stmt->execute()) {
            $success = true;
        } else {
            $errors[] = "Something went wrong. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Interest</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; }
        .navbar {
            background: #007bff; color: white;
            padding: 15px 20px;
        }
        .navbar a { color: white; text-decoration: none; }
        .container {
            max-width: 500px; margin: 40px auto;
            background: white; padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        h2 { color: #007bff; margin-bottom: 20px; }
        input {
            width: 100%; padding: 10px;
            margin: 6px 0 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            width: 100%; padding: 10px;
            background: #007bff; color: white;
            border: none; border-radius: 4px;
            cursor: pointer; font-size: 16px;
        }
        button:hover { background: #0056b3; }
        .error { color: red; margin-bottom: 10px; }
        .success { color: green; text-align: center; }
        .back { display:block; margin-top:15px; text-align:center; color:#007bff; }
    </style>
</head>
<body>

<div class="navbar">
    <a href="index.php">← Back to Programmes</a>
</div>

<div class="container">

    <?php if ($success): ?>
        <p class="success">
            ✅ Thank you! Your interest in
            <strong><?= safe_output($programme['title']) ?></strong>
            has been registered.
        </p>
        <a href="index.php" class="back">Browse more programmes</a>
        <a href="withdraw_interest.php" class="back">Withdraw my interest</a>

    <?php else: ?>
        <h2>Register Interest</h2>
        <p>Programme: <strong><?= safe_output($programme['title']) ?></strong></p>

        <?php foreach ($errors as $error): ?>
            <p class="error">⚠ <?= safe_output($error) ?></p>
        <?php endforeach; ?>

        <form method="POST" action="">
            <input type="hidden" name="programme_id"
                   value="<?= safe_output($programme_id) ?>">

            <label>Full Name:</label>
            <input type="text" name="full_name"
                   value="<?= isset($full_name) ? safe_output($full_name) : '' ?>"
                   required>

            <label>Email Address:</label>
            <input type="email" name="email"
                   value="<?= isset($email) ? safe_output($email) : '' ?>"
                   required>

            <button type="submit">Register My Interest</button>
        </form>
    <?php endif; ?>
</div>

</body>
</html>