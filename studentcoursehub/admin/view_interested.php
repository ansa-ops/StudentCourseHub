<?php
include("../db.php");

$sql = "SELECT i.InterestID, i.StudentName, i.Email, i.RegisteredAt, p.ProgrammeName 
        FROM interestedstudents i
        JOIN programmes p ON i.ProgrammeID = p.ProgrammeID
        ORDER BY i.RegisteredAt DESC";
$res = mysqli_query($conn, $sql);
?>

<h2>Interested Students</h2>
<table border="1" cellpadding="5">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Programme</th>
    <th>Registered At</th>
    <th>Action</th>
</tr>
<?php while($row = mysqli_fetch_assoc($res)){ ?>
<tr>
    <td><?php echo $row['InterestID']; ?></td>
    <td><?php echo $row['StudentName']; ?></td>
    <td><?php echo $row['Email']; ?></td>
    <td><?php echo $row['ProgrammeName']; ?></td>
    <td><?php echo $row['RegisteredAt']; ?></td>
    <td>
        <a href="delete_interest.php?id=<?php echo $row['InterestID']; ?>">Delete</a>
    </td>
</tr>
<?php } ?>
</table>
<br>
<a href="dashboard.php">Back to Dashboard</a>