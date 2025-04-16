<?php
session_start();
include_once("../include/db.php");

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['product_id'])) {
    $productId = intval($_GET['product_id']);
    $userId = $_SESSION['user_id'];

    // Check if product already in cart
    $checkSql = "SELECT id FROM cart WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($checkSql);
    $stmt->bind_param("ii", $userId, $productId);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // If exists, update quantity
        $updateSql = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("ii", $userId, $productId);
        $stmt->execute();
    } else {
        // Else, insert new item
        $insertSql = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)";
        $stmt = $conn->prepare($insertSql);
        $stmt->bind_param("ii", $userId, $productId);
        $stmt->execute();
    }

    header("Location: cart.php");
    exit();
} else {
    echo "Invalid product.";
}
?>
