<?php
session_start();
include '../../include/db.php';

if (!isset($_SESSION['admin_email'])) {
    header("Location: ../login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: subcategories.php");
    exit();
}

$id = $_GET['id'];
$delete_query = "DELETE FROM subcategories WHERE id = $id";
mysqli_query($conn, $delete_query);

header("Location: subcategories.php");
exit();
