<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$userName = $_SESSION['user_name'];
include '../include/db.php';
?>

<?php include 'user_template/header.php'; ?>

<!-- Greeting Section -->
<div class="text-center mb-5">
  <h1 class="mb-3">Welcome to Angus & Coote</h1>
  <p class="lead">Explore timeless jewellery and exclusive deals just for you.</p>
  <a href="products.php" class="btn btn-primary mt-3 px-4 py-2">Browse Products</a>
</div>

<!-- 🆕 New Arrivals -->
<div class="container mb-5">
  <h3 class="mb-4 text-center">✨ New Arrivals</h3>
  <div class="row g-4">
    <?php
    $result = $conn->query("SELECT * FROM products WHERE name != 'Stud Earrings' ORDER BY created_at DESC LIMIT 4");
    while ($row = $result->fetch_assoc()):
    ?>
      <div class="col-md-3">
        <div class="card shadow-sm h-100">
          <img src="images/<?= htmlspecialchars($row['image']) ?>" class="card-img-top" style="height: 200px; object-fit: cover;" alt="<?= htmlspecialchars($row['name']) ?>">
          <div class="card-body text-center">
            <h5 class="card-title"><?= htmlspecialchars($row['name']) ?></h5>
            <p class="card-text">$<?= number_format($row['price'], 2) ?></p>
            <form action="add_to_cart.php" method="POST">
              <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
              <input type="hidden" name="quantity" value="1">
              <button type="submit" name="add_to_cart" class="btn btn-sm btn-outline-primary">Shop Now</button>
            </form>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<!-- 🖼️ Carousel -->
<div id="jewelleryCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
  <div class="carousel-inner rounded shadow">
    <div class="carousel-item active">
      <img src="images/gold_necklaces.jpg" class="d-block w-100" style="height: 400px; object-fit: cover;" alt="Gold Necklaces">
    </div>
    <div class="carousel-item">
      <img src="images/engagement_rings.jpg" class="d-block w-100" style="height: 400px; object-fit: cover;" alt="Engagement Rings">
    </div>
    <div class="carousel-item">
      <img src="images/luxury_watches.jpg" class="d-block w-100" style="height: 400px; object-fit: cover;" alt="Luxury Watches">
    </div>
    <div class="carousel-item">
      <img src="images/floral_brooches.jpg" class="d-block w-100" style="height: 400px; object-fit: cover;" alt="Floral Brooches">
    </div>
    <div class="carousel-item">
      <img src="images/heart_pendants.jpg" class="d-block w-100" style="height: 400px; object-fit: cover;" alt="Heart Pendants">
    </div>
  </div>

  <button class="carousel-control-prev" type="button" data-bs-target="#jewelleryCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#jewelleryCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>

<!-- 👤 Dashboard -->
<div class="dashboard bg-white p-4 rounded shadow text-center mx-auto mb-5" style="max-width: 600px;">
  <h2 class="mb-3">Hello, <?= htmlspecialchars($userName); ?>!</h2>
  <p>Welcome to your dashboard. What would you like to do today?</p>

  <div class="d-flex flex-wrap justify-content-center gap-3 mt-4">
    <a href="products.php" class="btn btn-outline-dark">Browse Products</a>
    <a href="wishlist.php" class="btn btn-outline-dark">Wishlist</a>
    <a href="settings.php" class="btn btn-outline-dark">Settings</a>
    <a href="orders.php" class="btn btn-outline-dark">Orders</a>
    <a href="cart.php" class="btn btn-outline-dark">Cart</a>
    <a href="profile.php" class="btn btn-outline-dark">Profile</a>
    <a href="logout.php" class="btn btn-danger">Logout</a>
  </div>
</div>

<?php include 'user_template/footer.php'; ?>
