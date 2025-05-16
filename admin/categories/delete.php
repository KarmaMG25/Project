<?php
session_start();
include '../../include/db.php';

if (!isset($_SESSION['admin_email'])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    mysqli_query($conn, "DELETE FROM categories WHERE id = $id");
}

header("Location: index.php");
exit();
?>
