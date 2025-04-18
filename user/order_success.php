<?php
require '../vendor/autoload.php';
require_once '../include/stripe_config.php';
session_start();
include '../include/db.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['session_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$sessionId = $_GET['session_id'];
$session = \Stripe\Checkout\Session::retrieve($sessionId);

$exists = $conn->query("SELECT id FROM orders WHERE stripe_session_id = '$sessionId' AND user_id = $userId");

if ($exists->num_rows === 0 && $session && $session->payment_status === 'paid') {
    $cartItems = $conn->query("SELECT c.*, p.name, p.price FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = $userId");

    $total_price = 0;
    $items = [];
    while ($item = $cartItems->fetch_assoc()) {
        $total = $item['quantity'] * $item['price'];
        $total_price += $total;
        $items[] = $item;
    }

    $stmt = $conn->prepare("INSERT INTO orders (user_id, total_price, stripe_session_id, status) VALUES (?, ?, ?, 'Pending')");
    $stmt->bind_param("ids", $userId, $total_price, $sessionId);
    $stmt->execute();
    $orderId = $stmt->insert_id;

    foreach ($items as $item) {
        $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $orderId, $item['product_id'], $item['quantity'], $item['price']);
        $stmt->execute();
    }

    $conn->query("DELETE FROM cart WHERE user_id = $userId");
}
?>

<?php include 'user_template/header.php'; ?>

<div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
  <div class="card text-center p-4 shadow" style="max-width: 500px;">
    <div class="card-body">
      <h2 class="mb-3 text-success">🎉 Payment Successful!</h2>
      <p class="lead">Your order has been placed and recorded.</p>
      <div class="mt-4 d-flex justify-content-center gap-3">
        <a href="orders.php" class="btn btn-outline-primary">View My Orders</a>
        <a href="main.php" class="btn btn-primary">Continue Shopping</a>
      </div>
    </div>
  </div>
</div>

<?php include 'user_template/footer.php'; ?>
