<?php
session_start();
include '../include/db.php';

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Prepared statement to prevent SQL injection
    $query = "SELECT * FROM admin WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Verify the password
        if (password_verify($password, $row['password'])) {
            // Regenerate session ID to prevent session fixation
            session_regenerate_id(true);
            $_SESSION['admin_email'] = $row['email'];
            
            // Redirect to the dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Login failed!";
        }
    } else {
        $error = "Login failed!";
    }
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="../Style/admin_login.css" rel="stylesheet">

</head>
<body>

    <!-- Header -->
    <header>
        <div class="container">
            <h1>Admin Dashboard</h1>
        </div>
    </header>

    <!-- Navigation -->
    <nav>
        <a href="index.php">Home</a>
        <a href="about.php">About</a>
        <a href="contact.php">Contact</a>
    </nav>

    <!-- Login Form -->
    <div class="login-container">
        <h2>Admin Login</h2>

        <?php if (isset($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" autocomplete="off">
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required autocomplete="username">
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required autocomplete="current-password">
            </div>

            <button type="submit" name="login" class="btn">Login</button>

            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </form>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Angus & Coote. All rights reserved.</p>
    </footer>

</body>
</html>
