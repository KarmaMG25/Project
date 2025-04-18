<?php
require '../vendor/autoload.php';
use Dompdf\Dompdf;

session_start();
include_once("../include/db.php");

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    exit("Unauthorized access.");
}

$orderId = (int) $_GET['id'];
$userId = $_SESSION['user_id'];

// Validate order
$orderCheck = $conn->query("SELECT * FROM orders WHERE id = $orderId AND user_id = $userId");
if ($orderCheck->num_rows == 0) {
    exit("Invalid order.");
}

$order = $orderCheck->fetch_assoc();
$orderDate = date("F j, Y, g:i A", strtotime($order['created_at']));

// Get items
$sql = "SELECT oi.quantity, p.name, p.price 
        FROM order_items oi 
        JOIN products p ON oi.product_id = p.id 
        WHERE oi.order_id = $orderId";
$result = $conn->query($sql);

// Build HTML
$html = "
  <h2 style='text-align: center;'>Angus & Coote - Order Invoice</h2>
  <p><strong>Order ID:</strong> #{$orderId}</p>
  <p><strong>Date:</strong> {$orderDate}</p>
  <hr>
  <table width='100%' border='1' cellpadding='10' cellspacing='0'>
    <thead>
      <tr>
        <th>Product</th>
        <th>Qty</th>
        <th>Price</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
";

$grand = 0;
while ($item = $result->fetch_assoc()) {
    $total = $item['quantity'] * $item['price'];
    $grand += $total;
    $html .= "
      <tr>
        <td>{$item['name']}</td>
        <td>{$item['quantity']}</td>
        <td>$" . number_format($item['price'], 2) . "</td>
        <td>$" . number_format($total, 2) . "</td>
      </tr>
    ";
}

$html .= "
      <tr>
        <td colspan='3' align='right'><strong>Grand Total:</strong></td>
        <td><strong>$" . number_format($grand, 2) . "</strong></td>
      </tr>
    </tbody>
  </table>
  <p style='text-align: center; margin-top: 20px;'>Thank you for shopping with Angus & Coote.</p>
";

// Generate PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("invoice_order_{$orderId}.pdf", ["Attachment" => true]);
exit();
