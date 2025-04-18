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

// Get cart items
$cartItems = $conn->query("SELECT c.*, p.name, p.price FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = $userId");

// Total & items array
$total_price = 0;
$items = [];

while ($item = $cartItems->fetch_assoc()) {
    $total = $item['quantity'] * $item['price'];
    $total_price += $total;
    $items[] = $item;
}

// Handle checkout form
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($items)) {
    $stmt = $conn->prepare("INSERT INTO orders (user_id, total_price) VALUES (?, ?)");
    $stmt->bind_param("id", $userId, $total_price);
    $stmt->execute();
    $orderId = $stmt->insert_id;

    foreach ($items as $item) {
        $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $orderId, $item['product_id'], $item['quantity'], $item['price']);
        $stmt->execute();
    }

    $conn->query("DELETE FROM cart WHERE user_id = $userId");

    header("Location: order_success.php");
    exit();
}
?>

<?php include 'user_template/header.php'; ?>

<h2 class="text-center mb-4">Confirm Your Order</h2>

<?php if (!empty($items)): ?>
<form method="post" action="">
  <div class="table-responsive">
    <table class="table table-bordered align-middle text-center">
      <thead class="table-light">
        <tr>
          <th>Product</th>
          <th>Qty</th>
          <th>Price (each)</th>
          <th>Subtotal</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($items as $item): ?>
        <tr>
          <td><?= htmlspecialchars($item['name']) ?></td>
          <td><?= $item['quantity'] ?></td>
          <td>$<?= number_format($item['price'], 2) ?></td>
          <td>$<?= number_format($item['quantity'] * $item['price'], 2) ?></td>
        </tr>
        <?php endforeach; ?>
        <tr class="table-light">
          <td colspan="3" class="text-end"><strong>Total:</strong></td>
          <td><strong>$<?= number_format($total_price, 2) ?></strong></td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="text-end">
    <button type="submit" class="btn btn-success">Place Order</button>
  </div>
</form>
<?php else: ?>
  <p class="text-center text-muted">Your cart is empty.</p>
<?php endif; ?>

<?php include 'user_template/footer.php'; ?>
