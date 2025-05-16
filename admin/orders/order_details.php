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

// Handle cancel item action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_item_id'])) {
    $item_id = intval($_POST['cancel_item_id']);

    // Delete item from order_items table
    mysqli_query($conn, "DELETE FROM order_items WHERE id = $item_id");

    // Update total_price in orders table
    mysqli_query($conn, "
        UPDATE orders o
        SET total_price = (
            SELECT IFNULL(SUM(oi.price * oi.quantity), 0)
            FROM order_items oi
            WHERE oi.order_id = o.id
        )
        WHERE o.id = $order_id
    ");

    header("Location: order_details.php?id=$order_id");
    exit();
}

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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    body {
      background: url('/Project_7/include/background.jpg') no-repeat center center fixed;
      background-size: cover;
      font-family: 'Segoe UI', sans-serif;
      color: #333;
    }
    .glass-card {
      background: rgba(255, 255, 255, 0.95);
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
      text-align: center;
    }
    .table {
      background: rgba(255, 255, 255, 0.98);
      border-radius: 12px;
      overflow: hidden;
      text-align: center;
    }
    .table thead th {
      background: #1e3a8a;
      color: white;
      font-weight: 600;
      text-align: center;
    }
    .table td, .table th {
      text-align: center;
      font-weight: 600;
      vertical-align: middle;
    }
    .btn-back {
      border-radius: 12px;
      padding: 10px 20px;
      font-weight: 500;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold" href="../dashboard.php">
      <img src="/Project_7/include/logo.jpg" alt="Logo" style="height: 40px;" class="me-2">
      Angus & Coote Admin
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="adminNavbar">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="../dashboard.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="orders.php">Orders</a></li>
        <li class="nav-item"><a class="nav-link" href="../reports.php">Reports</a></li>
        <li class="nav-item"><a class="nav-link" href="../users.php">Users</a></li>
        <li class="nav-item">
          <a class="nav-link btn btn-outline-danger px-3" href="../logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Main Content -->
<div class="container my-5">
    <h2 class="text-center mb-5 text-dark">Order #<?= $order['id']; ?> Details</h2>

    <!-- Order Info -->
    <div class="glass-card">
        <h5 class="section-title">Order Info</h5>
        <p><strong>Status:</strong> <?= ucfirst($order['status']); ?></p>
        <p><strong>Created At:</strong> <?= date('d M Y', strtotime($order['created_at'])); ?></p>
    </div>

    <!-- Customer Info -->
    <div class="glass-card">
        <h5 class="section-title">Customer Info</h5>
        <p><strong>Name:</strong> <?= htmlspecialchars($order['customer_name']); ?></p>
        <p><strong>Email:</strong> <?= $order['email']; ?></p>
        <p><strong>Phone:</strong> <?= $order['phone'] ?? 'N/A'; ?></p>
        <p><strong>Address:</strong> <?= $order['address'] ?? 'N/A'; ?></p>
    </div>

    <!-- Order Items -->
    <div class="glass-card">
        <h5 class="section-title">Ordered Items</h5>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($item = mysqli_fetch_assoc($orderItems)): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['product_name']); ?></td>
                            <td><?= $item['quantity']; ?></td>
                            <td>$<?= number_format($item['price'], 2); ?></td>
                            <td>$<?= number_format($item['price'] * $item['quantity'], 2); ?></td>
                            <td>
                                <form method="POST" onsubmit="return confirm('Cancel this item?');">
                                    <input type="hidden" name="cancel_item_id" value="<?= $item['id']; ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">Cancel</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Payment Summary -->
    <div class="glass-card">
        <h5 class="section-title">Payment Summary</h5>
        <p><strong>Total Price:</strong> $<?= number_format($order['total_price'], 2); ?></p>
        <p><strong>Status:</strong> <?= ucfirst($order['status']); ?></p>
    </div>

    <div class="text-center">
        <a href="orders.php" class="btn btn-secondary btn-back">← Back to Orders</a>
    </div>
</div>

<!-- Footer -->
<footer class="footer mt-auto py-3">
  <div class="text-center">
    <small>&copy; <?= date('Y'); ?> Angus & Coote. All rights reserved.</small>
    <div class="d-flex justify-content-center gap-3 mt-2">
      <a href="https://www.facebook.com" target="_blank">
        <img src="/Project_7/include/facebook.png" alt="Facebook" style="width: 28px;">
      </a>
      <a href="https://www.instagram.com" target="_blank">
        <img src="/Project_7/include/instagram.png" alt="Instagram" style="width: 28px;">
      </a>
      <a href="https://twitter.com" target="_blank">
        <img src="/Project_7/include/X.png" alt="Twitter" style="width: 28px;">
      </a>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
