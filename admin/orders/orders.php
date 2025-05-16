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

// Fetch orders ascending
$orderQuery = "
    SELECT o.id, u.name AS customer_name, o.total_price, o.status, o.created_at
    FROM orders o
    JOIN users u ON o.user_id = u.id
    ORDER BY o.id ASC
";

$orderResult = mysqli_query($conn, $orderQuery);
?>

<?php include 'header_order.php'; ?>

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
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="order_id" value="<?= $order['id']; ?>">
                                    <input type="hidden" name="update_status" value="1">
                                    <div class="dropdown">
                                        <button class="btn btn-sm badge bg-<?php
                                            switch ($order['status']) {
                                                case 'Pending': echo 'warning'; break;
                                                case 'Processing': echo 'info'; break;
                                                case 'Shipped': echo 'primary'; break;
                                                case 'Delivered': echo 'success'; break;
                                                default: echo 'secondary';
                                            }
                                        ?> dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <?= $order['status']; ?>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <?php foreach (['Pending', 'Processing', 'Shipped', 'Delivered'] as $status): ?>
                                                <?php if ($order['status'] !== $status): ?>
                                                    <li>
                                                        <button type="submit" name="status" value="<?= $status; ?>" class="dropdown-item">
                                                            <?= $status; ?>
                                                        </button>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
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
                    <tr><td colspan="6" class="text-center">No orders found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'footer_order.php'; ?>
