<?php
include '../include/db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $conn->query("UPDATE reports SET status='open' WHERE id = $id");
}

header("Location: reports.php");
exit();
