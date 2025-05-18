<?php
include '../include/db.php';
include 'guest_template/header.php';

// Fetch latest 12 products
$products = mysqli_query($conn, "
  SELECT id, name, price, image 
  FROM products 
  ORDER BY id DESC 
  LIMIT 12
");
?>

<!-- Hero Section with gradient background -->
<section class="text-white text-center py-5 mb-5" style="background: linear-gradient(to right, #4b6cb7, #182848);">
  <div class="container">
    <h1 class="display-4 fw-bold">Discover Timeless Elegance</h1>
    <p class="lead mb-4">Jewellery that speaks to your style — only at Angus & Coote</p>
    <a href="products.php" class="btn btn-outline-light btn-lg px-4 shadow-sm">Browse Collection</a>
  </div>
</section>

<!-- Embedded Video Section 1 -->
<section class="bg-black py-5">
  <div class="container">
    <div class="ratio ratio-16x9">
      <iframe src="https://www.youtube.com/embed/kYOP52BUZTI?autoplay=1&mute=1&loop=1&playlist=kYOP52BUZTI" title="Jewellery Promo Video" allow="autoplay; encrypted-media" allowfullscreen></iframe>
    </div>
  </div>
</section>

<!-- Featured Products with animation -->
<div class="container py-5">
  <h2 class="text-center mb-4">New Arrivals</h2>
  <?php if (mysqli_num_rows($products) > 0): ?>
    <div class="row g-4">
      <?php while ($p = mysqli_fetch_assoc($products)): ?>
        <div class="col-md-4 col-lg-3">
          <div class="card h-100 shadow-sm border-0 animate__animated animate__fadeInUp">
            <div class="ratio ratio-1x1">
              <img src="/Project_7/user/images/<?= htmlspecialchars($p['image']) ?>" class="card-img-top object-fit-cover" alt="<?= htmlspecialchars($p['name']) ?>">
            </div>
            <div class="card-body text-center">
              <h6 class="card-title mb-1"><?= htmlspecialchars($p['name']) ?></h6>
              <p class="fw-bold mb-2 text-success">$<?= number_format($p['price'], 2) ?></p>
              <a href="product_detail.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-dark">View Details</a>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  <?php else: ?>
    <div class="alert alert-info text-center">No products found.</div>
  <?php endif; ?>
</div>

<!-- Embedded Video Section 2 -->
<section class="bg-dark py-5">
  <div class="container">
    <div class="ratio ratio-16x9">
      <iframe src="https://www.youtube.com/embed/6_J9GMgcIEE?autoplay=1&mute=1&loop=1&playlist=6_J9GMgcIEE" title="Jewellery Craft Video" allow="autoplay; encrypted-media" allowfullscreen></iframe>
    </div>
  </div>
</section>

<!-- Call to Action Section -->
<section class="text-white text-center py-5 mt-5" style="background: linear-gradient(to right, #6a11cb, #2575fc);">
  <div class="container">
    <h3 class="mb-3">Stay Updated</h3>
    <p class="text-white-50 mb-4">Subscribe to our newsletter for latest offers and designs</p>
    <a href="subscribe.php" class="btn btn-light btn-lg">Subscribe Now</a>
  </div>
</section>

<!-- Gallery Section -->
<?php
$gallery = ['gallery1.jpg', 'gallery2.jpg', 'gallery3.jpg', 'gallery4.jpg'];
$validImages = array_filter($gallery, function($img) {
  return file_exists($_SERVER['DOCUMENT_ROOT'] . "/Project_7/include/" . $img);
});
?>
<?php if (!empty($validImages)): ?>
  <section class="bg-light py-5">
    <div class="container">
      <h2 class="text-center mb-4">Jewellery Inspirations</h2>
      <div class="row g-3">
        <?php foreach ($validImages as $img): ?>
          <div class="col-6 col-md-3">
            <div class="ratio ratio-1x1">
              <img src="/Project_7/include/<?= $img ?>" class="img-fluid rounded shadow-sm object-fit-cover" alt="Jewellery inspiration">
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
<?php endif; ?>

<!-- Animate.css CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

<?php include 'guest_template/footer.php'; ?>
