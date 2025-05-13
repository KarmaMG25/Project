<!-- Project_7/admin/admin_template/footer.php -->
<footer class="footer mt-auto py-3">
  <div class="footer-content text-center mx-auto px-4 py-3">
  <small class="d-block" style="color: #000; font-weight: 500;">&copy; <?php echo date("Y"); ?> Angus & Coote. All rights reserved.</small>

    
    <div class="d-flex justify-content-center gap-3 mt-2">
      <a href="https://www.facebook.com" target="_blank"><img src="../include/facebook.png" alt="Facebook" style="width: 28px;"></a>
      <a href="https://www.instagram.com" target="_blank"><img src="../include/instagram.png" alt="Instagram" style="width: 28px;"></a>
      <a href="https://twitter.com" target="_blank"><img src="../include/X.png" alt="Twitter" style="width: 28px;"></a>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</footer>
</body>
</html>

<!-- Add to your admin_login.css or inside a <style> block -->
<style>
  .footer {
    background-color: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(6px);
    color: white;
    text-align: center;
    position: relative;
    bottom: 0;
    width: 100%;
  }

  .footer-content {
    max-width: 1000px;
    border-radius: 12px;
  }

  @media (max-height: 700px) {
    .footer {
      position: static;
      margin-top: 40px;
    }
  }
</style>
