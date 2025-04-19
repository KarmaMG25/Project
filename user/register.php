<?php
session_start();
include '../include/db.php';

$success = false;
$error = '';

if (isset($_POST['register'])) {
    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone    = trim($_POST['phone']);
    $address  = trim($_POST['address']);

    // Check if email exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $error = "An account with this email already exists.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, phone, address) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $password, $phone, $address);
        if ($stmt->execute()) {
            $success = true;
        } else {
            $error = "Something went wrong. Please try again.";
        }
    }
    $stmt->close();
}
?>

<?php include 'user_template/public_header.php'; ?>

<!-- ✅ Background Style -->
<style>
  body {
    background: url('../include/background.jpg') no-repeat center center fixed;
    background-size: cover;
  }
  .card {
    background-color: rgba(255, 255, 255, 0.95);
  }
</style>

<!-- ✅ Registration Form -->
<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
  <div class="card p-4 shadow-sm" style="min-width: 350px; max-width: 500px; width: 100%;">
    <h4 class="text-center mb-4">Create Your Account</h4>

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form action="register.php" method="POST">
      <div class="mb-3">
        <label for="name" class="form-label">Full Name</label>
        <input type="text" name="name" id="name" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" name="email" id="email" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Create Password</label>
        <input type="password" name="password" id="password" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="phone" class="form-label">Phone Number</label>
        <input type="text" name="phone" id="phone" class="form-control">
      </div>

      <div class="mb-3">
        <label for="address" class="form-label">Address</label>
        <textarea name="address" id="address" rows="3" class="form-control"></textarea>
      </div>

      <div class="d-grid">
        <button type="submit" name="register" class="btn btn-primary">Register</button>
      </div>

      <div class="mt-3 text-center">
        <small>Already have an account? <a href="login.php">Login here</a></small>
      </div>
    </form>
  </div>
</div>

<!-- ✅ Toast on Success -->
<?php if ($success): ?>
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11;">
  <div class="toast align-items-center text-bg-success border-0 show" role="alert">
    <div class="d-flex">
      <div class="toast-body">
        🎉 Account created successfully! Redirecting to login...
      </div>
    </div>
  </div>
</div>

<script>
  setTimeout(() => {
    window.location.href = "login.php";
  }, 3000);
</script>
<?php endif; ?>

<?php include 'user_template/public_footer.php'; ?>
