<?php
session_start();
include_once("../include/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Fetch all orders for the logged-in user
$query = "SELECT * FROM orders WHERE user_id = $userId ORDER BY created_at DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h2 {
            text-align: center;
        }
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #333;
            color: white;
        }
        tr:hover {
            background-color: #f2f2f2;
        }
        a.button {
            background-color: #333;
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
        }
        a.button:hover {
            background-color: #555;
        }
    </style>
</head>
<body>

<h2>My Orders</h2>

<table>
    <tr>
        <th>Order ID</th>
        <th>Date</th>
        <th>Status</th>
        <th>Total ($)</th>
        <th>Actions</th>
    </tr>
    <?php if ($result->num_rows > 0): ?>
        <?php while ($order = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $order['id'] ?></td>
                <td><?= date("Y-m-d", strtotime($order['created_at'])) ?></td>
                <td><?= $order['status'] ?></td>
                <td><?= number_format($order['total_price'], 2) ?></td>
                <td><a class="button" href="order_details.php?id=<?= $order['id'] ?>">View</a></td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="5">You have no orders yet.</td>
        </tr>
    <?php endif; ?>
</table>

</body>
</html>
