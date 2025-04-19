</main>

<!-- ✅ Newsletter Subscription -->
<div class="container my-5">
  <div class="p-4 bg-white border rounded shadow-sm">
    <form action="subscribe.php" method="POST" class="row g-3 justify-content-center align-items-center">
      <div class="col-md-6 col-lg-4">
        <input type="email" name="email" class="form-control" placeholder="Enter your email to subscribe" required>
      </div>
      <div class="col-auto">
        <button type="submit" class="btn btn-primary px-4">Subscribe</button>
      </div>
    </form>
  </div>
</div>

<!-- ✅ Footer with Social Media -->
<footer class="bg-light text-center pt-4 pb-3 mt-4 border-top">
  <div class="mb-3">
    <a href="https://facebook.com" target="_blank" class="mx-2">
      <img src="../include/facebook.png" alt="Facebook" style="height: 28px;">
    </a>
    <a href="https://instagram.com" target="_blank" class="mx-2">
      <img src="../include/instagram.png" alt="Instagram" style="height: 28px;">
    </a>
    <a href="https://twitter.com" target="_blank" class="mx-2">
      <img src="../include/X.png" alt="Twitter / X" style="height: 28px;">
    </a>
  </div>
  <small>&copy; <?= date("Y") ?> <a href="main.php" class="text-decoration-none text-dark fw-semibold">Angus & Coote</a>. All rights reserved.</small>
</footer>

<!-- ✅ Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- ✅ Custom Scripts -->
<script src="user_template/js/script.js"></script>

<!-- ✅ Quote Carousel Script -->
<script>
  const quoteCarousel = document.querySelector('#quoteCarousel');
  if (quoteCarousel) {
    new bootstrap.Carousel(quoteCarousel, {
      interval: 4000,
      ride: 'carousel',
      pause: false,
      wrap: true
    });
  }
</script>
</body>
</html>
