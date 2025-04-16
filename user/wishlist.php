<?php
session_start();
include_once("../include/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Fetch wishlist items
$sql = "SELECT p.id, p.name, p.price, p.image FROM wishlist w JOIN products p ON w.product_id = p.id WHERE w.user_id = $userId";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Wishlist</title>
</head>
<body>
    <h2>My Wishlist</h2>
    <?php if ($result->num_rows > 0): ?>
        <table border="1" cellpadding="10">
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td>
                    <img src="../uploads/<?= $row['image'] ?>" alt="<?= $row['name'] ?>" style="width: 50px;">
                    <?= htmlspecialchars($row['name']) ?>
                </td>
                <td>$<?= number_format($row['price'], 2) ?></td>
                <td>
                    <a href="remove_from_wishlist.php?id=<?= $row['id'] ?>" onclick="return confirm('Remove this item from wishlist?')">Remove</a>
                    <a href="add_to_cart.php?id=<?= $row['id'] ?>">Add to Cart</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>Your wishlist is empty.</p>
    <?php endif; ?>
</body>
</html>
