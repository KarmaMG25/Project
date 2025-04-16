<?php
session_start();
include '../../include/db.php';

if (!isset($_SESSION['admin_email'])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    
    // Delete the product
    $query = "DELETE FROM products WHERE id = '$product_id'";
    mysqli_query($conn, $query);
    header("Location: products.php");
    exit();
}
?>
