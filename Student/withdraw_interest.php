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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email        = sanitise_email($_POST['email']);
    $programme_id = sanitise_int($_POST['programme_id']);

    if (!validate_email($email)) {
        $errors[] = "Please enter a valid email address.";
    }

    if (empty($errors)) {
        $stmt = $conn->prepare(
            "DELETE FROM student_interests 
             WHERE email = ? AND programme_id = ?"
        );
        $stmt->bind_param("si", $email, $programme_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $success = true;
        } else {
            $errors[] = "No registration found with that email for this programme.";
        }
    }
}

// Get all programmes for dropdown
$programmes = $conn->query("SELECT id, title FROM programmes");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Withdraw Interest</title>
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
        h2 { color: #dc3545; margin-bottom: 20px; }
        input, select {
            width: 100%; padding: 10px;
            margin: 6px 0 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            width: 100%; padding: 10px;
            background: #dc3545; color: white;
            border: none; border-radius: 4px;
            cursor: pointer; font-size: 16px;
        }
        button:hover { background: #c82333; }
        .error  { color: red;   margin-bottom: 10px; }
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
        <p class="success">✅ Your interest has been successfully withdrawn.</p>
        <a href="index.php" class="back">Back to Programmes</a>

    <?php else: ?>
        <h2>Withdraw Interest</h2>

        <?php foreach ($errors as $error): ?>
            <p class="error">⚠ <?= safe_output($error) ?></p>
        <?php endforeach; ?>

        <form method="POST" action="">
            <label>Email Address:</label>
            <input type="email" name="email"
                   value="<?= isset($email) ? safe_output($email) : '' ?>"
                   required>

            <label>Select Programme:</label>
            <select name="programme_id" required>
                <option value="">Select a programme</option>
                <?php while ($prog = $programmes->fetch_assoc()): ?>
                    <option value="<?= $prog['id'] ?>">
                        <?= safe_output($prog['title']) ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <button type="submit">Withdraw My Interest</button>
        </form>
    <?php endif; ?>

</div>

</body>
</html>