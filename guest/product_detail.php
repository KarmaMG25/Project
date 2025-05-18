<?php
include '../include/db.php';
include 'guest_template/header.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  echo "<div class='container py-5'><div class='alert alert-danger text-center'>Invalid product ID.</div></div>";
  include 'guest_template/footer.php';
  exit();
}

$id = intval($_GET['id']);
$query = "
  SELECT p.*, c.name AS category_name, s.name AS subcategory_name
  FROM products p
  JOIN categories c ON p.category_id = c.id
  JOIN subcategories s ON p.subcategory_id = s.id
  WHERE p.id = $id
  LIMIT 1
";
$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);

if (!$product) {
  echo "<div class='container py-5'><div class='alert alert-warning text-center'>Product not found.</div></div>";
  include 'guest_template/footer.php';
  exit();
}
?>

<div class="container py-5">
  <div class="row g-5">
    <div class="col-md-6">
      <img src="/Project_7/user/images/<?= htmlspecialchars($product['image']) ?>" class="img-fluid shadow-sm" alt="<?= htmlspecialchars($product['name']) ?>">
    </div>
    <div class="col-md-6">
      <h2 class="mb-3"><?= htmlspecialchars($product['name']) ?></h2>
      <p class="text-muted">Category: <?= htmlspecialchars($product['category_name']) ?> > <?= htmlspecialchars($product['subcategory_name']) ?></p>
      <h4 class="text-success mb-3">$<?= number_format($product['price'], 2) ?></h4>
      <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
      <p><strong>Stock:</strong> <?= (int)$product['stock'] ?></p>
      <a href="products.php" class="btn btn-outline-secondary mt-3">← Back to Products</a>
    </div>
  </div>
</div>

<?php include 'guest_template/footer.php'; ?>
