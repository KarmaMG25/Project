<?php
session_start();
include '../include/db.php';

// Check if the admin is logged in
if (!isset($_SESSION['admin_email'])) {
    header("Location: login.php");
    exit();
}

// Fetch current admin information
$admin_email = $_SESSION['admin_email'];
$query = "SELECT * FROM admin WHERE email = '$admin_email'";
$result = mysqli_query($conn, $query);
$admin_data = mysqli_fetch_assoc($result);

// Update profile information
if (isset($_POST['update_profile'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $phone = $_POST['phone'];

    // If a new password is provided, check if it matches the confirm password field
    if (!empty($password)) {
        if ($password === $confirm_password) {
            // Hash the new password if they match
            $password = password_hash($password, PASSWORD_BCRYPT);
        } else {
            $error_message = "Passwords do not match!";
        }
    } else {
        $password = $admin_data['password']; // Keep the old password if no new password
    }

    // Update the admin data in the database if no errors
    if (!isset($error_message)) {
        $update_query = "UPDATE admin SET name = '$name', email = '$email', password = '$password', phone = '$phone' WHERE email = '$admin_email'";
        if (mysqli_query($conn, $update_query)) {
            echo "Profile updated successfully!";
        } else {
            echo "Error updating profile: " . mysqli_error($conn);
        }
    } else {
        echo $error_message; // Show the error message if passwords don't match
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <link rel="stylesheet" href="../Style/admin_profile.css">
</head>
<body>

<!-- Header -->
<header>
    <h1>Admin Profile</h1>
</header>

<!-- Navigation Bar -->
<nav class="navbar">
    <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="profile.php">Profile</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</nav>

<!-- Main Content -->
<div class="container">
    <h2>Update Your Profile</h2><br>

    <form method="POST" action="profile.php">
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" value="<?php echo $admin_data['name']; ?>" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo $admin_data['email']; ?>" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" value="<?php echo $admin_data['phone']; ?>" required>
        </div>

        <!-- New Password and Re-enter New Password Fields -->
        <div class="form-group">
            <label for="password">New Password (Leave blank to keep current)</label>
            <input type="password" id="password" name="password">
        </div>

        <div class="form-group">
            <label for="confirm_password">Re-enter New Password</label>
            <input type="password" id="confirm_password" name="confirm_password">
        </div>

        <button type="submit" name="update_profile">Update Profile</button>
    </form>
</div>

<!-- Footer -->
<footer>
    &copy; 2025 Admin Dashboard. All Rights Reserved.
</footer>

</body>
</html>
