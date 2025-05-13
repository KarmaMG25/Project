<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include '../include/db.php';

$error = "";
if (isset($_POST['register'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $checkEmail = mysqli_query($conn, "SELECT * FROM admin WHERE email='$email' OR phone='$phone'");
    if (mysqli_num_rows($checkEmail) > 0) {
        $error = "Email or phone already registered!";
    } else {
        $query = "INSERT INTO admin (name, email, phone, password) VALUES ('$name', '$email', '$phone', '$password')";
        if (mysqli_query($conn, $query)) {
            header("Location: login.php");
            exit();
        } else {
            $error = "Registration failed!";
        }
    }
}
?>

<?php include 'admin_template/header_auth.php'; ?>

<div class="login-wrapper">
  <div class="login-card mt-3">
    <h2>Register</h2>

    <?php if (!empty($error)): ?>
      <div class="error-box"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" autocomplete="off">
      <div class="mb-3">
        <label for="name" class="form-label">Full Name</label>
        <input type="text" name="name" id="name" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <input type="email" name="email" id="email" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="phone" class="form-label">Phone Number</label>
        <input type="tel" name="phone" id="phone" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" id="password" class="form-control" required>
      </div>

      <button type="submit" name="register" class="btn btn-primary w-100">Register</button>

      <p class="mt-3 text-center">
        Already have an account? <a href="login.php" class="text-decoration-underline">Login here</a>
      </p>
    </form>
  </div>
</div>

<?php include 'admin_template/footer.php'; ?>
