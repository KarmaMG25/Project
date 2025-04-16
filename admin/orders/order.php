<?php
session_start();
include '../../include/db.php';

if (!isset($_SESSION['admin_email'])) {
    header("Location: ../login.php");
    exit();
}

// Fetch orders
$query = "SELECT * FROM orders ORDER BY id DESC";
$result = mysqli_query($conn, $query);

// Handle order status update
if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    $update_query = "UPDATE orders SET status = '$status' WHERE id = $order_id";
    mysqli_query($conn, $update_query);
    header("Location: orders.php");  // Reload the page to reflect changes
}

// Handle order deletion
if (isset($_GET['delete_id'])) {
    $order_id = $_GET['delete_id'];

    // Delete associated order_items first to maintain integrity
    mysqli_query($conn, "DELETE FROM order_items WHERE order_id = $order_id");
    // Then delete the order
    mysqli_query($conn, "DELETE FROM orders WHERE id = $order_id");

    header("Location: orders.php");  // Reload the page after deletion
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Header Section -->
<header>
    <div class="container">
        <h1>Admin Dashboard</h1>
        <p>Manage your jewelry store orders</p>
    </div>
</header>

<?php include '../require/nav.php'; ?>

<div class="container mt-4">
    <h2 class="text-center">Order Management</h2>

    <!-- Display Orders -->
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Order ID</th>
                <th>User ID</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($order = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?php echo $order['id']; ?></td>
                    <td><?php echo $order['user_id']; ?></td>
                    <td><?php echo $order['total_price']; ?></td>
                    <td>
                        <form method="POST" action="">
                            <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                            <select name="status" class="form-control" onchange="this.form.submit()">
                                <option value="Pending" <?php if ($order['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                                <option value="Processing" <?php if ($order['status'] == 'Processing') echo 'selected'; ?>>Processing</option>
                                <option value="Shipped" <?php if ($order['status'] == 'Shipped') echo 'selected'; ?>>Shipped</option>
                                <option value="Delivered" <?php if ($order['status'] == 'Delivered') echo 'selected'; ?>>Delivered</option>
                            </select>
                        </form>
                    </td>
                    <td><?php echo $order['created_at']; ?></td>
                    <td>
                        <a href="?delete_id=<?php echo $order['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include '../require/footer.php'; ?>

</body>
</html>
