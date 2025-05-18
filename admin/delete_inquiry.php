<?php
include '../include/db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $conn->query("DELETE FROM inquiries WHERE id = $id");
}

header("Location: inquiries.php");
exit();
