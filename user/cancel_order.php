<?php
session_start();
include_once("../include/db.php");

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: login.php");
    exit();
}

$orderId = (int) $_GET['id'];
$userId = $_SESSION['user_id'];

// Update only if order is Pending
$conn->query("UPDATE orders SET status='Cancelled' WHERE id=$orderId AND user_id=$userId AND status='Pending'");

header("Location: orders.php");
exit();
