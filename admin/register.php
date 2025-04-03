<?php
session_start();
include '../include/db.php';

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check if email or phone already exists
    $checkEmail = mysqli_query($conn, "SELECT * FROM admin WHERE email='$email' OR phone='$phone'");
    if (mysqli_num_rows($checkEmail) > 0) {
        $error = "Email or phone already registered!";
    } else {
        // Insert admin data into the database
        $query = "INSERT INTO admin (name, email, phone, password) VALUES ('$name', '$email', '$phone', '$password')";
        if (mysqli_query($conn, $query)) {
            header("Location: login.php");  // Redirect to login after successful registration
            exit();
        } else {
            $error = "Registration failed!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
    <link href="../Style/admin_register.css" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header>
        <nav>
            <a class="navbar-brand" href="index.php">Jewelry Store</a>
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register.php">Register</a>
                </li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Admin Registration</h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
                        <form method="POST">
                            <div class="form-group">
                                <label for="name">Full Name</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Enter your full name" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="tel" class="form-control" name="phone" id="phone" placeholder="Enter your phone number" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" required>
                            </div>
                            <button type="submit" name="register" class="btn btn-primary btn-block">Register</button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <p>Already have an account? <a href="login.php">Login here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-light text-center py-3 mt-5">
        <p>&copy; 2025 Jewelry Store. All rights reserved.</p>
        <p><a href="contact.php">Contact Us</a></p>
    </footer>

</body>
</html>
