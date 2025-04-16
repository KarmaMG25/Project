<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userName = $_SESSION['user_name'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome | User Dashboard</title>
    <link href="../Style/user_login.css" rel="stylesheet">
    <style>
        .dashboard {
            max-width: 600px;
            margin: 40px auto;
            text-align: center;
            padding: 30px;
            background-color: #f8f8f8;
            border-radius: 15px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }
        .dashboard h2 {
            margin-bottom: 15px;
        }
        .dashboard a {
            display: inline-block;
            margin: 15px 10px;
            text-decoration: none;
            color: #ffffff;
            background-color: #333;
            padding: 10px 20px;
            border-radius: 8px;
            transition: background 0.3s;
        }
        .dashboard a:hover {
            background-color: #555;
        }
    </style>
</head>
<body>

    <header>
        <div class="container">
            <h1>Welcome to Angus & Coote</h1>
        </div>
    </header>

    <nav>
    <a href="main.php">Home</a>
    <a href="cart.php">Cart</a>
    <a href="orders.php">My Orders</a>
    <a href="wishlist.php">Wishlist</a>
    <a href="profile.php">My Profile</a>
    <a href="settings.php">Settings</a>
    <a href="logout.php">Logout</a>
</nav>


    <div class="dashboard">
        <h2>Hello, <?php echo htmlspecialchars($userName); ?>!</h2>
        <p>Welcome to your dashboard. What would you like to do today?</p>

        <!-- Link to Products Page -->
        <a href="products.php">Shop Now</a> <!-- Link to the user/products.php page -->
        <a href="wishlist.php">View Wishlist</a>
        <a href="settings.php">Account Settings</a>
    </div>

    <footer>
        <p>&copy; 2025 Angus & Coote. All rights reserved.</p>
    </footer>

</body>
</html>
