<?php
require '../vendor/autoload.php';
require_once '../include/stripe_config.php';

session_start();
include '../include/db.php';

header('Content-Type: application/json');

// ✅ Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$userId = $_SESSION['user_id'];
$YOUR_DOMAIN = 'http://localhost/Project_7/user';

// ✅ Calculate total from cart
$total_price = 0;
$cartItems = $conn->query("SELECT c.quantity, p.price FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = $userId");

while ($item = $cartItems->fetch_assoc()) {
    $total_price += $item['quantity'] * $item['price'];
}

// ✅ Convert to cents for Stripe (integer only)
$amount = intval($total_price * 100);

if ($amount < 50) {
    echo json_encode(['error' => 'Minimum total must be at least $0.50']);
    exit();
}

// ✅ Create Stripe Checkout session
$checkout_session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => [[
        'price_data' => [
            'currency' => 'usd',
            'product_data' => [
                'name' => 'Jewellery Order',
            ],
            'unit_amount' => $amount,
        ],
        'quantity' => 1,
    ]],
    'mode' => 'payment',
    'success_url' => $YOUR_DOMAIN . '/order_success.php?session_id={CHECKOUT_SESSION_ID}',
    'cancel_url' => $YOUR_DOMAIN . '/checkout.php?cancelled=true',
]);

echo json_encode(['id' => $checkout_session->id]);
