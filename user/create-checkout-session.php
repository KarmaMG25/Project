<?php
require '../vendor/autoload.php';
require_once '../include/stripe_config.php';

header('Content-Type: application/json');

$YOUR_DOMAIN = 'http://localhost/Project_7/user';
$amount = 1999; // Example amount in cents

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
