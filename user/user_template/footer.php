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

<footer class="bg-light text-center py-3 mt-4 border-top">
  <small>&copy; <?= date("Y") ?> Angus &amp; Coote. All rights reserved.</small>
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
