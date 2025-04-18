<?php include 'user_template/public_header.php'; ?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <h1 class="text-center mb-4">Contact Us</h1>
      <p class="text-center">Have a question, feedback, or just want to say hello? Fill out the form below and our team will get back to you shortly.</p>

      <form>
        <div class="mb-3">
          <label for="name" class="form-label">Your Name</label>
          <input type="text" id="name" class="form-control" required>
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Your Email</label>
          <input type="email" id="email" class="form-control" required>
        </div>

        <div class="mb-3">
          <label for="message" class="form-label">Message</label>
          <textarea id="message" rows="5" class="form-control" required></textarea>
        </div>

        <div class="d-grid">
          <button type="submit" class="btn btn-primary">Send Message</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include 'user_template/public_footer.php'; ?>
