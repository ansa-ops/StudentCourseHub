<?php
require '../session.php';
require '../db.php';

// Set headers to download as CSV
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="mailing_list.csv"');

$output = fopen('php://output', 'w');

// CSV column headers
fputcsv($output, ['ID', 'Full Name', 'Email', 'Programme', 'Registered At']);

$result = $conn->query(
    "SELECT si.id, si.full_name, si.email, p.title, si.registered_at
     FROM student_interests si
     JOIN programmes p ON si.programme_id = p.id
     ORDER BY si.registered_at DESC"
);

while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}

fclose($output);
exit();
?>