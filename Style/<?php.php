<?php
session_start();
include '../include/db.php';

// Check if user is logged in
if (!isset($_SESSION['admin_email'])) {
    header("Location: login.php");
    exit();
}

// Fetch current admin data
$admin_email = $_SESSION['admin_email'];
$query = "SELECT * FROM admin WHERE email = '$admin_email'";
$result = mysqli_query($conn, $query);
$admin_data = mysqli_fetch_array($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Process the form data to update admin profile
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Hash password if it's updated
    if (!empty($password)) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $update_query = "UPDATE admin SET name = '$name', email = '$email', password = '$password' WHERE email = '$admin_email'";
    } else {
        $update_query = "UPDATE admin SET name = '$name', email = '$email' WHERE email = '$admin_email'";
    }

    if (mysqli_query($conn, $update_query)) {
        $_SESSION['admin_email'] = $email; // Update session email
        echo "<div class='success'>Profile updated successfully!</div>";
    } else {
        echo "<div class='error'>Error updating profile. Please try again.</div>";
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

<!-- Navigation Bar -->
<nav>
    <div class="navbar-container">
        <a href="dashboard.php" class="navbar-brand">Admin Dashboard</a>
        <ul class="navbar-nav">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="logout.php" class="btn-logout">Logout</a></li>
        </ul>
    </div>
</nav>

<!-- Main Content -->
<div class="container">
    <h1>Edit Profile</h1>
    <form method="POST" action="profile.php">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($admin_data['name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($admin_data['email']); ?>" required>
        </div>
        <div class="form-group">
            <label for="password">New Password (Leave blank to keep current)</label>
            <input type="password" id="password" name="password">
        </div>
        <button type="submit">Update Profile</button>
    </form>
</div>

<!-- Footer -->
<footer>
    &copy; 2025 Admin Dashboard. All Rights Reserved.
</footer>

</body>
</html>
