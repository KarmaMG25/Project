<?php
session_start();
include '../include/db.php';

// Check if user is logged in
if (!isset($_SESSION['admin_email'])) {
    header("Location: login.php");
    exit();
}

// Fetch the total number of registered users
$user_query = "SELECT COUNT(*) AS total_users FROM users";
$user_result = mysqli_query($conn, $user_query);
$user_data = mysqli_fetch_array($user_result);

// Fetch the total number of products
$product_query = "SELECT COUNT(*) AS total_products FROM products";
$product_result = mysqli_query($conn, $product_query);
$product_data = mysqli_fetch_array($product_result);

// Fetch the total number of orders
$order_query = "SELECT COUNT(*) AS total_orders FROM orders";
$order_result = mysqli_query($conn, $order_query);
$order_data = mysqli_fetch_array($order_result);

// Fetch the total number of inquiries
$inquiry_query = "SELECT COUNT(*) AS total_inquiries FROM inquiries";
$inquiry_result = mysqli_query($conn, $inquiry_query);
$inquiry_data = mysqli_fetch_array($inquiry_result);

// Fetch the total number of reviews
$review_query = "SELECT COUNT(*) AS total_reviews FROM reviews";
$review_result = mysqli_query($conn, $review_query);
$review_data = mysqli_fetch_array($review_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Center the header */
        header {
            text-align: center;
            margin-top: 20px;
        }

        /* Center the navbar */
        .navbar {
            display: flex;
            justify-content: center;
            background-color: #f8f9fa;
            padding: 10px;
        }

        .navbar-nav {
            display: flex;
            justify-content: center;
            width: 100%;
        }

        .nav-item {
            margin: 0 15px;
        }

        /* Sticky footer */
        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: #f8f9fa;
            height: 50px;
            text-align: center;
            line-height: 50px;
            box-shadow: 0px -2px 5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<!-- Header -->
<header>
    <h1>Admin Dashboard</h1>
</header>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="managementDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Management
                    </a>
                    <div class="dropdown-menu" aria-labelledby="managementDropdown">
                        <a class="dropdown-item" href="categories/index.php">Manage Categories</a>

                        <a class="dropdown-item" href="subcategories/subcategories.php">Sub-Categories Management</a>
                        <a class="dropdown-item" href="products/products.php">Products Management</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="ordersDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Orders & Reports
                    </a>
                    <div class="dropdown-menu" aria-labelledby="ordersDropdown">
                        <a class="dropdown-item" href="orders/order.php">Orders Management</a>
                        <a class="dropdown-item" href="reports.php">Reports</a>
                        <a class="dropdown-item" href="search_orders.php">Search Orders</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="ordersDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Manage Info
                    </a>
                    <div class="dropdown-menu" aria-labelledby="ordersDropdown">
                        <a class="dropdown-item" href="reviews.php">Reviews</a>
                        <a class="dropdown-item" href="inquiries.php">Inquires</a>
                        <a class="dropdown-item" href="Pages.php">Pages</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="usersDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Users
                    </a>
                    <div class="dropdown-menu" aria-labelledby="usersDropdown">
                        <a class="dropdown-item" href="users.php">Registered Users</a>
                        <a class="dropdown-item" href="subscribers.php">Subscribers</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="profile.php">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-danger text-white" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container mt-4">
    <h1 class="text-center mb-4">Welcome, <?php echo $_SESSION['admin_email']; ?></h1>
    <p class="text-center">This is your admin dashboard.</p>

    <div class="row text-center">
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text display-4"><?php echo $user_data['total_users']; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Total Products</h5>
                    <p class="card-text display-4"><?php echo $product_data['total_products']; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Total Orders</h5>
                    <p class="card-text display-4"><?php echo $order_data['total_orders']; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Total Inquiries</h5>
                    <p class="card-text display-4"><?php echo $inquiry_data['total_inquiries']; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Total Reviews</h5>
                    <p class="card-text display-4"><?php echo $review_data['total_reviews']; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer>
    &copy; 2025 Admin Dashboard. All Rights Reserved.
</footer>

<!-- jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
