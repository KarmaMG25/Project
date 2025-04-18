<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include '../include/db.php';

$user_id = $_SESSION['user_id'];

$query = "SELECT c.id as cart_id, p.id as product_id, p.name, p.price, p.image, c.quantity
          FROM cart c
          JOIN products p ON c.product_id = p.id
          WHERE c.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$total = 0;
?>

<?php include 'user_template/header.php'; ?>

<h2 class="text-center mb-4">My Cart</h2>

<?php if ($result->num_rows > 0): ?>
  <div class="table-responsive">
    <table class="table align-middle table-bordered">
    <thead class="table-light text-center">
  <tr>
    <th>Product</th>
    <th>Name</th>
    <th>Price</th>
    <th>Qty</th>
    <th>Subtotal</th>
    <th>Action</th>
  </tr>
</thead>
<tbody>
  <?php while($row = $result->fetch_assoc()): 
    $subtotal = $row['price'] * $row['quantity'];
    $total += $subtotal;
  ?>
  <tr class="text-center">
    <td class="text-start">
      <img src="../uploads/<?= htmlspecialchars($row['image']) ?>" alt="" width="80" height="80" style="object-fit:cover;">
    </td>
    <td><?= htmlspecialchars($row['name']) ?></td>
    <td>$<?= number_format($row['price'], 2) ?></td>
    <td><?= $row['quantity'] ?></td>
    <td>$<?= number_format($subtotal, 2) ?></td>
    <td>
      <a href="remove_from_cart.php?cart_id=<?= $row['cart_id'] ?>" class="btn btn-sm btn-outline-danger">Remove</a>
    </td>
  </tr>
  <?php endwhile; ?>
</tbody>

    </table>
  </div>

  <div class="text-end mt-4">
    <h5>Total: <strong>$<?= number_format($total, 2) ?></strong></h5>
    <a href="checkout.php" class="btn btn-primary mt-2">Proceed to Checkout</a>
  </div>

<?php else: ?>
  <p class="text-center">Your cart is empty.</p>
<?php endif; ?>

<?php include 'user_template/footer.php'; ?>
