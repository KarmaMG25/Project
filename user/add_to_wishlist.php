<?php
session_start();
include_once("../include/db.php");

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: login.php");
    exit();
}

$productId = (int) $_GET['id'];
$userId = $_SESSION['user_id'];

// Check if the product is already in the wishlist
$check = $conn->query("SELECT * FROM wishlist WHERE user_id = $userId AND product_id = $productId");

if ($check->num_rows == 0) {
    $conn->query("INSERT INTO wishlist (user_id, product_id) VALUES ($userId, $productId)");
}

// Redirect back to products page or wishlist
header("Location: wishlist.php");
exit();
