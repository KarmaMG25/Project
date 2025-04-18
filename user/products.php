<?php
session_start();
include_once("../include/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch filters
$categories = $conn->query("SELECT * FROM categories");
$subcategories = $conn->query("SELECT * FROM subcategories");

// Build WHERE clause
$where = "WHERE 1";
if (!empty($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $where .= " AND (p.name LIKE '%$search%' OR p.description LIKE '%$search%')";
}
if (!empty($_GET['category'])) {
    $cat = (int)$_GET['category'];
    $where .= " AND p.category_id = $cat";
}
if (!empty($_GET['subcategory'])) {
    $subcat = (int)$_GET['subcategory'];
    $where .= " AND p.subcategory_id = $subcat";
}

// Get products
$products = $conn->query("SELECT p.*, c.name AS category, s.name AS subcategory 
                          FROM products p 
                          LEFT JOIN categories c ON p.category_id = c.id 
                          LEFT JOIN subcategories s ON p.subcategory_id = s.id 
                          $where");
?>

<?php include 'user_template/header.php'; ?>

<h2 class="text-center mb-4">Browse Our Jewellery</h2>

<!-- Search & Filter Form -->
<form method="GET" class="row g-3 mb-4">
  <div class="col-md-4">
    <input type="text" name="search" class="form-control" placeholder="Search products..." 
           value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
  </div>

  <div class="col-md-3">
    <select name="category" class="form-select">
      <option value="">All Categories</option>
      <?php while($cat = $categories->fetch_assoc()): ?>
        <option value="<?= $cat['id'] ?>" <?= (isset($_GET['category']) && $_GET['category'] == $cat['id']) ? 'selected' : '' ?>>
          <?= htmlspecialchars($cat['name']) ?>
        </option>
      <?php endwhile; ?>
    </select>
  </div>

  <div class="col-md-3">
    <select name="subcategory" class="form-select">
      <option value="">All Subcategories</option>
      <?php while($sub = $subcategories->fetch_assoc()): ?>
        <option value="<?= $sub['id'] ?>" <?= (isset($_GET['subcategory']) && $_GET['subcategory'] == $sub['id']) ? 'selected' : '' ?>>
          <?= htmlspecialchars($sub['name']) ?>
        </option>
      <?php endwhile; ?>
    </select>
  </div>

  <div class="col-md-2 d-grid">
    <button type="submit" class="btn btn-primary">Filter</button>
  </div>
</form>

<!-- Product Cards -->
<?php if ($products->num_rows > 0): ?>
  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
    <?php while($row = $products->fetch_assoc()): ?>
      <div class="col">
        <div class="card h-100 shadow-sm">
          <img src="../uploads/<?= htmlspecialchars($row['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($row['name']) ?>" style="height: 200px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($row['name']) ?></h5>
            <p class="card-text small"><?= htmlspecialchars($row['description']) ?></p>
            <p class="mb-2"><strong>$<?= number_format($row['price'], 2) ?></strong></p>
            <p class="text-muted small"><?= htmlspecialchars($row['category']) ?> > <?= htmlspecialchars($row['subcategory']) ?></p>
            <div class="d-grid gap-2">
              <a href="add_to_cart.php?product_id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">Add to Cart</a>
              <a href="add_to_wishlist.php?id=<?= $row['id'] ?>" class="btn btn-outline-dark btn-sm">Add to Wishlist</a>
            </div>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
<?php else: ?>
  <p class="text-center">No products found.</p>
<?php endif; ?>

<?php include 'user_template/footer.php'; ?>
