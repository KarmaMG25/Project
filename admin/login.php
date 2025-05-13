<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include '../include/db.php';

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $query = "SELECT * FROM admin WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            session_regenerate_id(true);
            $_SESSION['admin_email'] = $row['email'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid password. Please try again.";
        }
    } else {
        $error = "No account found with this email.";
    }

    mysqli_stmt_close($stmt);
}
?>

<?php include 'admin_template/header_auth.php'; ?>

<div class="login-wrapper">
  <div class="login-card mt-3">
    <h2>Login</h2>

    <?php if (isset($error)): ?>
      <div class="error-box"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" autocomplete="off">
      <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" name="email" class="form-control" id="email" required>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" class="form-control" id="password" required>
      </div>

      <button type="submit" name="login" class="btn btn-primary w-100">Login</button>

      <p class="mt-3 text-center">
        Don't have an account?
        <a href="register.php" class="text-decoration-underline">Register</a>
      </p>
    </form>
  </div>
</div>

<?php include 'admin_template/footer.php'; ?>
