<?php
include '../include/db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $conn->query("DELETE FROM reviews WHERE id = $id");
}

header("Location: reviews.php");
exit();
