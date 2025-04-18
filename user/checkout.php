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
?>

<?php include 'user_template/header.php'; ?>

<h2 class="text-center mb-4">Confirm Your Order</h2>

<?php if (!empty($items)): ?>
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

  <!-- ✅ Stripe Payment Button -->
  <div class="text-end mt-4">
    <button id="checkout-button" class="btn btn-success px-4">Pay with Card</button>
  </div>

  <!-- ✅ Stripe JS -->
  <script src="https://js.stripe.com/v3/"></script>
  <script>
    const stripe = Stripe("pk_test_51RFMQ6PsY7SQKpLPpc7sWuALAbGhvynuBwbZXGShLUUhjGSUwdlJLgTMOLUz7ac29dkLJvxavU7GlHYoy0De8az500t1zOJJ6U");

    document.getElementById("checkout-button").addEventListener("click", function () {
      fetch("create-checkout-session.php", {
        method: "POST"
      })
      .then(res => res.json())
      .then(data => {
        return stripe.redirectToCheckout({ sessionId: data.id });
      });
    });
  </script>
<?php else: ?>
  <p class="text-center text-muted">Your cart is empty.</p>
<?php endif; ?>

<?php include 'user_template/footer.php'; ?>
