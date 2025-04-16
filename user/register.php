<?php
include '../include/db.php';

if (isset($_POST['register'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    $query = "INSERT INTO users (name, email, password, phone, address) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'sssss', $name, $email, $password, $phone, $address);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: login.php");
        exit();
    } else {
        $error = "Registration failed!";
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Registration</title>
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
        <h2>Create an Account</h2>

        <?php if (isset($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="input-group">
                <label for="name">Full Name</label>
                <input type="text" name="name" required>
            </div>

            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" name="email" required>
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" name="password" required>
            </div>

            <div class="input-group">
                <label for="phone">Phone</label>
                <input type="text" name="phone">
            </div>

            <div class="input-group">
                <label for="address">Address</label>
                <textarea name="address"></textarea>
            </div>

            <button type="submit" name="register" class="btn">Register</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2025 Angus & Coote. All rights reserved.</p>
    </footer>
</body>
</html>
