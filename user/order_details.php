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
    include 'user_template/public_header.php';
    echo "<div class='container text-center py-5'><h4>Invalid order.</h4></div>";
    include 'user_template/public_footer.php';
    exit();
}

// Fetch order items
$sql = "SELECT oi.quantity, p.name, p.price 
        FROM order_items oi 
        JOIN products p ON oi.product_id = p.id 
        WHERE oi.order_id = $orderId";

$result = $conn->query($sql);
?>

<?php include 'user_template/header.php'; ?>

<div class="container py-5">
  <h2 class="text-center mb-4">Order #<?= $orderId ?> Details</h2>

  <div class="table-responsive">
    <table class="table table-bordered text-center align-middle">
      <thead class="table-light">
        <tr>
          <th>Product</th>
          <th>Qty</th>
          <th>Price</th>
          <th>Subtotal</th>
        </tr>
      </thead>
      <tbody>
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
        <tr class="table-light">
          <td colspan="3" class="text-end"><strong>Grand Total:</strong></td>
          <td><strong>$<?= number_format($grand, 2) ?></strong></td>
        </tr>
      </tbody>
    </table>
  </div>

  <!-- ✅ Download Invoice Button -->
  <div class="text-end mt-3">
    <a href="generate_invoice.php?id=<?= $orderId ?>" class="btn btn-outline-success">
      Download Invoice (PDF)
    </a>
  </div>

  <!-- ✅ Back Button -->
  <div class="text-end mt-4">
    <a href="orders.php" class="btn btn-outline-secondary">&larr; Back to Orders</a>
  </div>
</div>

<?php include 'user_template/footer.php'; ?>
