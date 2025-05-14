<?php
session_start();
include '../../include/db.php';

if (!isset($_SESSION['admin_email'])) {
    header("Location: ../login.php");
    exit();
}

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $order_id = intval($_POST['order_id']);
    $new_status = mysqli_real_escape_string($conn, $_POST['status']);
    mysqli_query($conn, "UPDATE orders SET status = '$new_status' WHERE id = $order_id");
    header("Location: orders.php");
    exit();
}

// Handle delete order
if (isset($_GET['delete_id'])) {
    $order_id = intval($_GET['delete_id']);
    mysqli_query($conn, "DELETE FROM order_items WHERE order_id = $order_id");
    mysqli_query($conn, "DELETE FROM orders WHERE id = $order_id");
    header("Location: orders.php");
    exit();
}

// Fetch orders with user info
$orderQuery = "
    SELECT o.id, u.name AS customer_name, o.total_price, o.status, o.created_at
    FROM orders o
    JOIN users u ON o.user_id = u.id
    ORDER BY o.id DESC
";
$orderResult = mysqli_query($conn, $orderQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order Management | Angus & Coote</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="../../admin/admin_css/admin_style.css">

  <style>
    .table-responsive {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(6px);
    }

    .table thead th {
        background-color: rgba(30, 58, 138, 0.9);
        color: white;
        font-weight: 600;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 0, 0, 0.02);
    }

    .table-hover tbody tr:hover {
        background-color: rgba(30, 58, 138, 0.08);
    }

    .navbar-brand {
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
    }
  </style>
</head>
<body class="d-flex flex-column min-vh-100">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold" href="../dashboard.php">
      <img src="../../include/logo.jpg" alt="Logo" style="height: 40px;" class="me-2">
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
        <li class="nav-item"><a class="nav-link btn btn-danger text-white px-3" href="../logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container my-5">
    <h2 class="text-center mb-4">Order Management</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($orderResult) > 0): ?>
                    <?php while ($order = mysqli_fetch_assoc($orderResult)): ?>
                        <tr>
                            <td><?= $order['id']; ?></td>
                            <td><?= htmlspecialchars($order['customer_name']); ?></td>
                            <td>$<?= number_format($order['total_price'], 2); ?></td>
                            <td>
                                <span class="badge bg-<?php
                                    switch ($order['status']) {
                                        case 'Pending': echo 'warning'; break;
                                        case 'Processing': echo 'info'; break;
                                        case 'Shipped': echo 'primary'; break;
                                        case 'Delivered': echo 'success'; break;
                                        default: echo 'secondary';
                                    }
                                ?>">
                                    <?= $order['status']; ?>
                                </span>
                                <form method="POST" class="mt-2">
                                    <input type="hidden" name="order_id" value="<?= $order['id']; ?>">
                                    <div class="input-group input-group-sm">
                                        <select name="status" class="form-select" onchange="this.form.submit()">
                                            <?php foreach (['Pending', 'Processing', 'Shipped', 'Delivered'] as $status): ?>
                                                <option value="<?= $status; ?>" <?= ($order['status'] === $status) ? 'selected' : ''; ?>>
                                                    <?= $status; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <input type="hidden" name="update_status" value="1">
                                </form>
                            </td>
                            <td><?= date('d M Y', strtotime($order['created_at'])); ?></td>
                            <td class="d-flex flex-column gap-2">
                                <a href="order_details.php?id=<?= $order['id']; ?>" class="btn btn-sm btn-outline-primary">View</a>
                                <a href="orders.php?delete_id=<?= $order['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this order?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No orders found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Footer -->
<footer class="footer mt-auto py-3">
  <div class="text-center">
    <small>&copy; <?= date('Y'); ?> Angus & Coote. All rights reserved.</small>
    <div class="d-flex justify-content-center gap-3 mt-2">
      <a href="https://www.facebook.com" target="_blank"><img src="../../include/facebook.png" alt="Facebook" style="width: 28px;"></a>
      <a href="https://www.instagram.com" target="_blank"><img src="../../include/instagram.png" alt="Instagram" style="width: 28px;"></a>
      <a href="https://twitter.com" target="_blank"><img src="../../include/X.png" alt="Twitter" style="width: 28px;"></a>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
