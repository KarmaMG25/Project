<?php
include '../include/db.php';
include 'guest_template/header.php';

// Fetch all products with category and subcategory
$query = "
  SELECT p.*, c.name AS category_name, s.name AS subcategory_name
  FROM products p
  JOIN categories c ON p.category_id = c.id
  JOIN subcategories s ON p.subcategory_id = s.id
  ORDER BY p.id DESC
";
$products = mysqli_query($conn, $query);
?>

<div class="container py-5">
  <h2 class="mb-4 text-center">All Products</h2>

  <?php if (mysqli_num_rows($products) > 0): ?>
    <div class="row g-4">
      <?php while ($product = mysqli_fetch_assoc($products)): ?>
        <div class="col-md-4 col-lg-3">
          <div class="card h-100 shadow-sm">
            <!-- Symmetric image with square ratio -->
            <div class="ratio ratio-1x1">
              <img src="/Project_7/user/images/<?= htmlspecialchars($product['image']) ?>" 
                   class="card-img-top object-fit-cover" 
                   alt="<?= htmlspecialchars($product['name']) ?>">
            </div>
            <div class="card-body d-flex flex-column text-center">
              <h6 class="card-title"><?= htmlspecialchars($product['name']) ?></h6>
              <p class="text-muted mb-1"><?= htmlspecialchars($product['category_name']) ?> / <?= htmlspecialchars($product['subcategory_name']) ?></p>
              <p class="fw-bold mb-2">$<?= number_format($product['price'], 2) ?></p>
              <a href="product_detail.php?id=<?= $product['id'] ?>" class="btn btn-sm btn-outline-primary mt-auto">View Details</a>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  <?php else: ?>
    <div class="alert alert-info text-center">No products available.</div>
  <?php endif; ?>
</div>

<?php include 'guest_template/footer.php'; ?>
