<?php
session_start();
include '../include/db.php';

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header("Location: main.php");
            exit();
        } else {
            $error = "Incorrect password!";
        }
    } else {
        $error = "User not found!";
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Login</title>
    <link href="../Style/user_login.css" rel="stylesheet">
</head>
<body>
    <header>
        <div class="container">
            <h1>User Portal</h1>
        </div>
    </header>

    <nav>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
    </nav>

    <div class="login-container">
        <h2>User Login</h2>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" name="email" required>
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit" name="login" class="btn">Login</button>
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </form>
    </div>

    <footer>
        <p>&copy; 2025 Angus & Coote. All rights reserved.</p>
    </footer>
</body>
</html>
