<?php
session_start();
include_once("../include/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['cart_id'])) {
    $cartId = intval($_GET['cart_id']);
    $userId = $_SESSION['user_id'];

    // Ensure user can only delete their own cart item
    $sql = "DELETE FROM cart WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $cartId, $userId);
    $stmt->execute();
}

header("Location: cart.php");
exit();
?>
