<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include '../include/db.php';
$userId = $_SESSION['user_id'];

// Fetch wishlist products
$query = "SELECT w.id AS wishlist_id, p.id AS product_id, p.name, p.price, p.image 
          FROM wishlist w 
          JOIN products p ON w.product_id = p.id 
          WHERE w.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$results = $stmt->get_result();
?>

<?php include 'user_template/header.php'; ?>

<h2 class="text-center mb-4">My Wishlist</h2>

<?php if ($results->num_rows > 0): ?>
  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
    <?php while($row = $results->fetch_assoc()): ?>
      <div class="col">
        <div class="card h-100 shadow-sm">
          <img src="../uploads/<?= htmlspecialchars($row['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($row['name']) ?>" style="height: 200px; object-fit: cover;">
          <div class="card-body text-center">
            <h5 class="card-title"><?= htmlspecialchars($row['name']) ?></h5>
            <p class="card-text"><strong>$<?= number_format($row['price'], 2) ?></strong></p>
            <div class="d-grid gap-2">
              <a href="add_to_cart.php?product_id=<?= $row['product_id'] ?>" class="btn btn-primary btn-sm">Add to Cart</a>
              <a href="remove_from_wishlist.php?id=<?= $row['wishlist_id'] ?>" class="btn btn-outline-danger btn-sm">Remove</a>
            </div>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
<?php else: ?>
  <p class="text-center text-muted">Your wishlist is empty.</p>
<?php endif; ?>

<?php include 'user_template/footer.php'; ?>
