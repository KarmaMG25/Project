<?php
include '../include/db.php';
include 'guest_template/header.php';

$success = $error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email']);

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "Please enter a valid email address.";
  } else {
    // Check for duplicates
    $check = $conn->prepare("SELECT id FROM subscribers WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
      $error = "You're already subscribed.";
    } else {
      $stmt = $conn->prepare("INSERT INTO subscribers (email) VALUES (?)");
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $stmt->close();
      $success = "Thank you for subscribing!";
    }
    $check->close();
  }
}
?>

<div class="container py-5">
  <h2 class="mb-4 text-center">Subscribe to Our Newsletter</h2>

  <?php if ($success): ?>
    <div class="alert alert-success"><?= $success ?></div>
  <?php elseif ($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <form method="POST" class="card p-4 shadow-sm mx-auto" style="max-width: 500px;">
    <div class="mb-3">
      <label class="form-label">Email Address</label>
      <input type="email" name="email" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success w-100">Subscribe</button>
  </form>
</div>

<?php include 'guest_template/footer.php'; ?>
