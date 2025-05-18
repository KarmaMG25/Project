<?php
include '../include/db.php';
include 'guest_template/header.php';

$query = trim($_GET['q'] ?? '');
$results = [];

if (!empty($query)) {
  $stmt = $conn->prepare("
    SELECT p.*, c.name AS category_name, s.name AS subcategory_name
    FROM products p
    JOIN categories c ON p.category_id = c.id
    JOIN subcategories s ON p.subcategory_id = s.id
    WHERE p.name LIKE ? OR p.description LIKE ?
    ORDER BY p.id DESC
  ");
  $like = "%$query%";
  $stmt->bind_param("ss", $like, $like);
  $stmt->execute();
  $results = $stmt->get_result();
}
?>

<div class="container py-5">
  <h2 class="mb-4 text-center">Search Products</h2>

  <form method="GET" class="mb-4">
    <div class="input-group">
      <input type="text" name="q" class="form-control" placeholder="Search by name or description..." value="<?= htmlspecialchars($query) ?>" required>
      <button class="btn btn-outline-primary" type="submit">Search</button>
    </div>
  </form>

  <?php if ($query): ?>
    <h5 class="mb-3">Results for "<strong><?= htmlspecialchars($query) ?></strong>":</h5>

    <?php if ($results && $results->num_rows > 0): ?>
      <div class="row g-4">
        <?php while ($product = $results->fetch_assoc()): ?>
          <div class="col-md-4 col-lg-3">
            <div class="card h-100 shadow-sm">
              <img src="/Project_7/user/images/<?= htmlspecialchars($product['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>">
              <div class="card-body text-center">
                <h6 class="card-title"><?= htmlspecialchars($product['name']) ?></h6>
                <p class="text-muted small mb-1"><?= htmlspecialchars($product['category_name']) ?> / <?= htmlspecialchars($product['subcategory_name']) ?></p>
                <p class="fw-bold mb-2">$<?= number_format($product['price'], 2) ?></p>
                <a href="product_detail.php?id=<?= $product['id'] ?>" class="btn btn-sm btn-outline-primary">View</a>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    <?php else: ?>
      <div class="alert alert-warning">No products found matching your search.</div>
    <?php endif; ?>
  <?php endif; ?>
</div>

<?php include 'guest_template/footer.php'; ?>
