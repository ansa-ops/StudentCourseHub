<?php
session_start();

// Protect page (only logged-in admin allowed)
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            margin: 0;
        }

        /* Top navbar */
        .navbar {
            background-color: #667eea;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 3px 6px rgba(0,0,0,0.1);
        }

        .navbar h1 {
            margin: 0;
            font-size: 22px;
        }

        .navbar a.logout {
            color: #ff6b6b;
            text-decoration: none;
            font-weight: bold;
            padding: 8px 12px;
            border: 1px solid #ff6b6b;
            border-radius: 6px;
            transition: 0.3s;
        }

        .navbar a.logout:hover {
            background-color: #ff6b6b;
            color: white;
        }

        /* Dashboard container */
        .container {
            max-width: 1000px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .welcome {
            font-size: 20px;
            margin-bottom: 20px;
        }

        /* Cards grid */
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .card {
            background: white;
            padding: 30px 20px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0,0,0,0.15);
        }

        .card a {
            text-decoration: none;
            color: #667eea;
            font-size: 18px;
            font-weight: bold;
        }

        .card a:hover {
            color: #5a67d8;
        }

        /* Footer */
        .footer {
            text-align: center;
            color: #555;
            margin-top: 50px;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <div class="navbar">
        <h1>Admin Dashboard</h1>
        <a href="logout.php" class="logout">Logout</a>
    </div>

    <div class="container">
        <div class="welcome">Welcome, <?php echo $_SESSION['admin']; ?> 👋</div>

        <div class="cards">
            <div class="card"><a href="add_programme.php">Add Programme</a></div>
            <div class="card"><a href="view_programmes.php">View Programmes</a></div>
            <div class="card"><a href="view_interested.php">View Interested Students</a></div>
        </div>
    </div>

    <div class="footer">© 2026 Your Company</div>

</body>
</html>