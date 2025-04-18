<?php
include '../include/db.php';

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename="subscribers.csv"');

$output = fopen("php://output", "w");
fputcsv($output, ['Email', 'Subscribed At']);

$result = $conn->query("SELECT email, subscribed_at FROM subscribers ORDER BY subscribed_at DESC");
while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}
fclose($output);
exit();
