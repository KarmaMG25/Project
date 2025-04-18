</main>
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
