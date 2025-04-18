<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userName = $_SESSION['user_name'];
?>

<?php include 'user_template/header.php'; ?>

<!-- Greeting Section -->
<div class="text-center mb-5">
  <h1 class="mb-3">Welcome to Angus & Coote</h1>
  <p class="lead">Explore timeless jewellery and exclusive deals just for you.</p>
  <a href="products.php" class="btn btn-primary mt-3 px-4 py-2">Shop Now</a>
</div>

<!-- Dashboard Card -->
<div class="dashboard bg-white p-4 rounded shadow text-center mx-auto mb-5" style="max-width: 600px;">
  <h2 class="mb-3">Hello, <?= htmlspecialchars($userName); ?>!</h2>
  <p>Welcome to your dashboard. What would you like to do today?</p>

  <div class="d-flex flex-wrap justify-content-center gap-3 mt-4">
    <a href="products.php" class="btn btn-outline-dark">Shop Now</a>
    <a href="wishlist.php" class="btn btn-outline-dark">View Wishlist</a>
    <a href="settings.php" class="btn btn-outline-dark">Account Settings</a>
    <a href="orders.php" class="btn btn-outline-dark">My Orders</a>
    <a href="cart.php" class="btn btn-outline-dark">Cart</a>
    <a href="profile.php" class="btn btn-outline-dark">My Profile</a>
    <a href="logout.php" class="btn btn-danger">Logout</a>
  </div>
</div>

<div id="jewelleryCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
  <div class="carousel-inner rounded shadow">
    <div class="carousel-item active">
      <img src="https://images.unsplash.com/photo-1571762787681-94b755e1757f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80" class="d-block w-100" alt="Elegant Rings">
    </div>

    <div class="carousel-item">
      <img src="https://images.unsplash.com/photo-1590080878261-b7b0c57d7469?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80" class="d-block w-100" alt="Gold Necklace">
    </div>

    <div class="carousel-item">
      <img src="https://images.unsplash.com/photo-1589987601370-89f538df7242?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80" class="d-block w-100" alt="Diamond Earrings">
    </div>

    <div class="carousel-item">
      <img src="https://images.unsplash.com/photo-1622319832516-9e16a3a836b8?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80" class="d-block w-100" alt="Luxury Jewelry">
    </div>

    <div class="carousel-item">
      <img src="https://images.unsplash.com/photo-1572434161146-10d438c4a5e5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80" class="d-block w-100" alt="Luxury Watches">
    </div>
  </div>

  <button class="carousel-control-prev" type="button" data-bs-target="#jewelleryCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#jewelleryCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>

<?php include 'user_template/footer.php'; ?>
