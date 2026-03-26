<?php
session_start();
include("../db.php");

// Protect admin page
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}

// Toggle Publish/Unpublish
if(isset($_GET['toggle_id'])){
    $id = (int)$_GET['toggle_id'];

    $res = mysqli_query($conn, "SELECT Published FROM programmes WHERE ProgrammeID=$id");
    $row = mysqli_fetch_assoc($res);

    $new_status = ($row['Published'] == 1) ? 0 : 1;

    mysqli_query($conn, "UPDATE programmes SET Published=$new_status WHERE ProgrammeID=$id");

    header("Location: view_programmes.php");
    exit;
}

// Fetch all programmes
$sql = "SELECT * FROM programmes";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - View Programmes</title>
    <style>
        body { font-family: Arial; background:#f2f2f2; padding:20px; }
        h2 { color:#333; }
        table { border-collapse: collapse; width:100%; background:#fff; }
        th, td { padding:10px; border:1px solid #ccc; }
        th { background:#007BFF; color:white; }
        a { text-decoration:none; color:#007BFF; }
        a:hover { text-decoration:underline; }
    </style>
</head>
<body>

<h2>📚 View Programmes</h2>

<table>
<tr>
    <th>ID</th>
    <th>Programme Name</th>
    <th>Description</th>
    <th>Level</th>
    <th>Status</th>
    <th>Actions</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>
<tr>
    <td><?php echo $row['ProgrammeID']; ?></td>
    <td><?php echo htmlspecialchars($row['ProgrammeName']); ?></td>
    <td><?php echo htmlspecialchars($row['Description']); ?></td>

    <td>
        <?php 
        echo ($row['LevelID']==1) ? "Undergraduate" : "Postgraduate"; 
        ?>
    </td>

    <td>
        <?php echo ($row['Published']==1) ? "Published" : "Unpublished"; ?>
    </td>

    <td>
        <!-- Publish Toggle -->
        <a href="view_programmes.php?toggle_id=<?php echo $row['ProgrammeID']; ?>">
            <?php echo ($row['Published']==1) ? "Unpublish" : "Publish"; ?>
        </a> |

        <!-- Edit -->
        <a href="edit_programme.php?id=<?php echo $row['ProgrammeID']; ?>">Edit</a> |

        <!-- Delete -->
        <a href="delete_programme.php?id=<?php echo $row['ProgrammeID']; ?>" 
           onclick="return confirm('Are you sure you want to delete this programme?');">
           Delete
        </a>
    </td>
</tr>
<?php } ?>

</table>

<br>
<a href="dashboard.php">⬅ Back to Dashboard</a>

</body>
</html>