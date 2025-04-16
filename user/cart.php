<?php
session_start();
include_once("../include/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

$sql = "SELECT c.id, c.quantity, p.name, p.price, p.image 
        FROM cart c 
        JOIN products p ON c.product_id = p.id 
        WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$total = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Cart</title>
    <link href="../Style/user_login.css" rel="stylesheet">
</head>
<body>
    <h2>Your Cart</h2>
    <table border="1" cellpadding="10">
        <tr>
            <th>Product</th><th>Price</th><th>Quantity</th><th>Total</th><th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): 
            $subtotal = $row['price'] * $row['quantity'];
            $total += $subtotal;
        ?>
        <tr>
            <td><?php echo $row['name']; ?></td>
            <td>$<?php echo number_format($row['price'], 2); ?></td>
            <td><?php echo $row['quantity']; ?></td>
            <td>$<?php echo number_format($subtotal, 2); ?></td>
            <td><a href="remove_from_cart.php?id=<?php echo $row['id']; ?>">Remove</a></td>
        </tr>
        <?php endwhile; ?>
        <tr>
            <td colspan="3" align="right"><strong>Total:</strong></td>
            <td colspan="2">$<?php echo number_format($total, 2); ?></td>
        </tr>
    </table>

    <br><a href="checkout.php">Proceed to Checkout</a>
</body>
</html>
