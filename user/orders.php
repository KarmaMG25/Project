<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include '../include/db.php';
$userId = $_SESSION['user_id'];

// Fetch user's orders
$orders = $conn->query("SELECT * FROM orders WHERE user_id = $userId ORDER BY created_at DESC");
?>

<?php include 'user_template/header.php'; ?>

<h2 class="text-center mb-4">My Orders</h2>

<?php if ($orders->num_rows > 0): ?>
  <div class="accordion" id="ordersAccordion">
    <?php $i = 0; while ($order = $orders->fetch_assoc()): ?>
      <?php
        $status = $order['status'];
        $badgeClass = match ($status) {
          'Processing' => 'bg-info',
          'Shipped'    => 'bg-warning',
          'Delivered'  => 'bg-success',
          'Cancelled'  => 'bg-danger',
          default      => 'bg-secondary'
        };
        $orderId = $order['id'];
      ?>
      <div class="accordion-item mb-3">
        <h2 class="accordion-header" id="heading<?= $i ?>">
          <button class="accordion-button <?= $i > 0 ? 'collapsed' : '' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $i ?>" aria-expanded="<?= $i === 0 ? 'true' : 'false' ?>" aria-controls="collapse<?= $i ?>">
            Order #<?= $orderId ?> &nbsp; | &nbsp;
            $<?= number_format($order['total_price'], 2) ?> &nbsp; | &nbsp;
            <?= date("F j, Y, g:i A", strtotime($order['created_at'])) ?> &nbsp; | &nbsp;
            <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($status) ?></span>
          </button>
        </h2>
        <div id="collapse<?= $i ?>" class="accordion-collapse collapse <?= $i === 0 ? 'show' : '' ?>" aria-labelledby="heading<?= $i ?>" data-bs-parent="#ordersAccordion">
          <div class="accordion-body">
            <table class="table table-bordered align-middle text-center">
              <thead class="table-light">
                <tr>
                  <th class="text-start">Product</th>
                  <th>Quantity</th>
                  <th>Price</th>
                  <th>Subtotal</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $items = $conn->query("
                    SELECT oi.*, p.name, p.image 
                    FROM order_items oi 
                    JOIN products p ON oi.product_id = p.id 
                    WHERE oi.order_id = $orderId
                  ");
                  while ($item = $items->fetch_assoc()):
                    $subtotal = $item['quantity'] * $item['price'];
                ?>
                <tr>
                  <td class="text-start d-flex align-items-center gap-3">
                    <img src="images/<?= htmlspecialchars($item['image']) ?>"
                         width="60" height="60"
                         style="object-fit: cover;"
                         class="rounded shadow-sm"
                         alt="<?= htmlspecialchars($item['name']) ?>">
                    <span><?= htmlspecialchars($item['name']) ?></span>
                  </td>
                  <td><?= $item['quantity'] ?></td>
                  <td>$<?= number_format($item['price'], 2) ?></td>
                  <td>$<?= number_format($subtotal, 2) ?></td>
                </tr>
                <?php endwhile; ?>
              </tbody>
            </table>

            <div class="text-end mt-3">
              <a href="order_details.php?id=<?= $orderId ?>" class="btn btn-sm btn-outline-primary">View Details</a>
            </div>
          </div>
        </div>
      </div>
    <?php $i++; endwhile; ?>
  </div>
<?php else: ?>
  <p class="text-center text-muted">You haven't placed any orders yet.</p>
<?php endif; ?>

<?php include 'user_template/footer.php'; ?>
