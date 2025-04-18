<?php
session_start();
include '../include/db.php';

$success = false;
$error = '';

if (isset($_SESSION['user_id'])) {
    header("Location: main.php");
    exit();
}

// Handle form submission
if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($user_id, $user_name, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_name'] = $user_name;
            $success = true;
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "No account found with that email.";
    }

    $stmt->close();
}
?>

<?php include 'user_template/public_header.php'; ?>


<div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
  <div class="card p-4 shadow-sm" style="min-width: 350px; max-width: 400px; width: 100%;">
    <h4 class="text-center mb-4">Login to Your Account</h4>

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="login.php" method="POST">
      <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" name="email" id="email" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" id="password" class="form-control" required>
      </div>

      <div class="d-grid">
        <button type="submit" name="login" class="btn btn-primary">Login</button>
      </div>

      <div class="mt-3 text-center">
        <small>Don't have an account? <a href="register.php">Register here</a></small>
      </div>
    </form>
  </div>
</div>

<!-- ✅ Show toast if login was successful -->
<?php if ($success): ?>
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11;">
  <div class="toast align-items-center text-bg-success border-0 show" role="alert">
    <div class="d-flex">
      <div class="toast-body">
        ✅ Logging in... Redirecting to dashboard.
      </div>
    </div>
  </div>
</div>

<script>
  setTimeout(() => {
    window.location.href = "main.php";
  }, 2500); // Redirect after 2.5 seconds
</script>
<?php endif; ?>

<?php include 'user_template/public_footer.php'; ?>
