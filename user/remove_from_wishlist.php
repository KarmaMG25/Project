<?php
session_start();
include_once("../include/db.php");

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: login.php");
    exit();
}

$productId = (int) $_GET['id'];
$userId = $_SESSION['user_id'];

// Remove product from wishlist
$conn->query("DELETE FROM wishlist WHERE user_id = $userId AND product_id = $productId");

header("Location: wishlist.php");
exit();
