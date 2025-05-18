<?php
include '../include/db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $conn->query("DELETE FROM reports WHERE id = $id");
}

header("Location: reports.php");
exit();
