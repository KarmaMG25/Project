<?php
session_start();
include '../../include/db.php';

if (!isset($_SESSION['admin_email'])) {
    header("Location: ../login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: orders.php");
    exit();
}

$order_id = intval($_GET['id']);

// Fetch order info
$orderQuery = mysqli_query($conn, "
    SELECT o.*, u.name AS customer_name, u.email, u.phone, u.address
    FROM orders o
    JOIN users u ON o.user_id = u.id
    WHERE o.id = $order_id
");

$order = mysqli_fetch_assoc($orderQuery);
if (!$order) {
    echo "Order not found.";
    exit();
}

// Fetch order items
$orderItems = mysqli_query($conn, "
    SELECT oi.*, p.name AS product_name
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    WHERE oi.order_id = $order_id
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order Details | Angus & Coote</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: url('/Project_7/include/background.jpg') no-repeat center center fixed;
      background-size: cover;
      font-family: 'Segoe UI', sans-serif;
      color: #333;
    }

    .glass-card {
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(10px);
      border-radius: 16px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.1);
      padding: 30px;
      margin-bottom: 30px;
    }

    .section-title {
      font-size: 1.5rem;
      font-weight: 600;
      color: #1e3a8a;
      margin-bottom: 20px;
    }

    .table {
      background: rgba(255, 255, 255, 0.98);
      border-radius: 12px;
      overflow: hidden;
    }

    .table thead th {
      background: #1e3a8a;
      color: white;
      font-weight: 600;
    }

    .btn-back {
      border-radius: 12px;
      padding: 10px 20px;
      font-weight: 500;
    }

    .container {
      max-width: 960px;
    }

    .shadow-glow {
      box-shadow: 0 4px 16px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>

<div class="container my-5">
    <h2 class="text-center mb-5 text-dark">Order #<?= $order['id']; ?> Details</h2>

    <!-- Order Info -->
    <div class="glass-card shadow-glow">
        <h5 class="section-title">Order Info</h5>
        <p><strong>Status:</strong> <?= ucfirst($order['status']); ?></p>
        <p><strong>Created At:</strong> <?= date('d M Y', strtotime($order['created_at'])); ?></p>
    </div>

    <!-- Customer Info -->
    <div class="glass-card shadow-glow">
        <h5 class="section-title">Customer Info</h5>
        <p><strong>Name:</strong> <?= htmlspecialchars($order['customer_name']); ?></p>
        <p><strong>Email:</strong> <?= $order['email']; ?></p>
        <p><strong>Phone:</strong> <?= $order['phone'] ?? 'N/A'; ?></p>
        <p><strong>Address:</strong> <?= $order['address'] ?? 'N/A'; ?></p>
    </div>

    <!-- Order Items -->
    <div class="glass-card shadow-glow">
        <h5 class="section-title">Ordered Items</h5>
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($item = mysqli_fetch_assoc($orderItems)): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['product_name']); ?></td>
                            <td><?= $item['quantity']; ?></td>
                            <td>$<?= number_format($item['price'], 2); ?></td>
                            <td>$<?= number_format($item['price'] * $item['quantity'], 2); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Payment Summary -->
    <div class="glass-card shadow-glow">
        <h5 class="section-title">Payment Summary</h5>
        <p><strong>Total Price:</strong> $<?= number_format($order['total_price'], 2); ?></p>
        <p><strong>Status:</strong> <?= ucfirst($order['status']); ?></p>
    </div>

    <a href="orders.php" class="btn btn-secondary btn-back">← Back to Orders</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
