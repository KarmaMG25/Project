<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include_once("../include/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Get cart items to calculate total
$cartItems = $conn->query("SELECT c.*, p.name, p.price FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = $userId");

// Calculate total price
$total_price = 0;
$items = [];

while ($item = $cartItems->fetch_assoc()) {
    $total = $item['quantity'] * $item['price'];
    $total_price += $total;
    $items[] = $item; // Save for later use
}

// Handle order placement
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Insert order with total price
    $stmt = $conn->prepare("INSERT INTO orders (user_id, total_price) VALUES (?, ?)");
    $stmt->bind_param("id", $userId, $total_price);
    $stmt->execute();
    $orderId = $stmt->insert_id;

    // Insert into order_items
// Insert into order_items
foreach ($items as $item) {
    $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiid", $orderId, $item['product_id'], $item['quantity'], $item['price']);
    $stmt->execute();
}


    // Clear cart
    $conn->query("DELETE FROM cart WHERE user_id = $userId");

    // Redirect
    header("Location: order_success.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
</head>
<body>
    <h2>Checkout</h2>
    <form method="post" action="">
        <table border="1" cellpadding="10">
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price (each)</th>
                <th>Total</th>
            </tr>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td>$<?= number_format($item['price'], 2) ?></td>
                    <td>$<?= number_format($item['quantity'] * $item['price'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3" align="right"><strong>Grand Total:</strong></td>
                <td><strong>$<?= number_format($total_price, 2) ?></strong></td>
            </tr>
        </table>
        <br>
        <button type="submit">Place Order</button>
    </form>
</body>
</html>
