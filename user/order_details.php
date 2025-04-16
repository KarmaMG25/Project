<?php
session_start();
include_once("../include/db.php");

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: login.php");
    exit();
}

$orderId = (int) $_GET['id'];
$userId = $_SESSION['user_id'];

// Validate order belongs to user
$orderCheck = $conn->query("SELECT * FROM orders WHERE id = $orderId AND user_id = $userId");
if ($orderCheck->num_rows == 0) {
    echo "Invalid order.";
    exit();
}

// Fetch order items
$sql = "SELECT oi.quantity, p.name, p.price 
        FROM order_items oi 
        JOIN products p ON oi.product_id = p.id 
        WHERE oi.order_id = $orderId";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Details</title>
</head>
<body>
    <h2>Order #<?= $orderId ?> Details</h2>
    <table border="1" cellpadding="10">
        <tr>
            <th>Product</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Total</th>
        </tr>
        <?php $grand = 0;
        while ($item = $result->fetch_assoc()):
            $total = $item['quantity'] * $item['price'];
            $grand += $total;
        ?>
        <tr>
            <td><?= htmlspecialchars($item['name']) ?></td>
            <td><?= $item['quantity'] ?></td>
            <td>$<?= number_format($item['price'], 2) ?></td>
            <td>$<?= number_format($total, 2) ?></td>
        </tr>
        <?php endwhile; ?>
        <tr>
            <td colspan="3" align="right"><strong>Grand Total:</strong></td>
            <td><strong>$<?= number_format($grand, 2) ?></strong></td>
        </tr>
    </table>
    <br>
    <a href="orders.php">← Back to Orders</a>
</body>
</html>
