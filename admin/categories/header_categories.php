<?php
session_start();
if (!isset($_SESSION['admin_email'])) {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Categories | Angus & Coote Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <!-- Custom Admin Styles -->
  <link rel="stylesheet" href="../admin_css/admin_style.css">
</head>
<body class="d-flex flex-column min-vh-100">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="../dashboard.php">
      <img src="/Project_7/include/logo.jpg" alt="Logo" style="height: 40px;" class="me-2">
      Angus & Coote Admin
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="adminNavbar">
      <ul class="navbar-nav ms-auto">
        <!-- Management Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Management</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../categories/index.php">Categories</a></li>
            <li><a class="dropdown-item" href="../subcategories/subcategories.php">Subcategories</a></li>
            <li><a class="dropdown-item" href="../products/products.php">Products</a></li>
          </ul>
        </li>

        <!-- Orders & Reports -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Orders & Reports</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../orders/orders.php">Orders</a></li>
            <li><a class="dropdown-item" href="../reports.php">Reports</a></li>
            <li><a class="dropdown-item" href="../search_orders.php">Search Orders</a></li>
          </ul>
        </li>

        <!-- Info -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Info</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../reviews.php">Reviews</a></li>
            <li><a class="dropdown-item" href="../inquiries.php">Inquiries</a></li>
            <li><a class="dropdown-item" href="../pages.php">Pages</a></li>
          </ul>
        </li>

        <!-- Users -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Users</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../users.php">Registered Users</a></li>
            <li><a class="dropdown-item" href="../subscribers.php">Subscribers</a></li>
          </ul>
        </li>

        <!-- Profile & Logout -->
        <li class="nav-item"><a class="nav-link" href="../profile.php">Profile</a></li>
        <li class="nav-item"><a class="nav-link btn btn-outline-danger px-3" href="../logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
