<?php
session_start();
include '../../include/db.php';

if (!isset($_SESSION['admin_email'])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $category_id = $_GET['id'];
    $delete_query = "DELETE FROM categories WHERE id='$category_id'";
    mysqli_query($conn, $delete_query);
}

header("Location: index.php");
exit();
?>
