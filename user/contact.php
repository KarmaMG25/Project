<?php
session_start();
include '../include/db.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    if (!empty($name) && !empty($email) && !empty($message)) {
        $stmt = $conn->prepare("INSERT INTO inquiries (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);
        if ($stmt->execute()) {
            $success = "Your message has been sent.";
        } else {
            $error = "Something went wrong.";
        }
    } else {
        $error = "Please fill out all fields.";
    }
}
?>

<?php include 'user_template/header.php'; ?>

<div class="container py-5">
  <h2 class="mb-4 text-center">Contact Us</h2>

  <?php if ($success): ?>
    <div class="alert alert-success"><?= $success ?></div>
  <?php elseif ($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <form method="POST" action="">
    <div class="mb-3">
      <label class="form-label">Your Name</label>
      <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Email Address</label>
      <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Message</label>
      <textarea name="message" rows="5" class="form-control" required></textarea>
    </div>
    <div class="text-end">
      <button type="submit" class="btn btn-primary px-4">Send Message</button>
    </div>
  </form>
</div>

<?php include 'user_template/footer.php'; ?>
