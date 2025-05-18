<?php
session_start();
if (!isset($_SESSION['admin_email'])) {
    header("Location: /Project_7/admin/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Subcategories | Angus & Coote Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <!-- Custom Admin Styles -->
  <link rel="stylesheet" href="/Project_7/admin/admin_css/admin_style.css">
</head>
<body class="d-flex flex-column min-vh-100">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="/Project_7/admin/dashboard.php">
      <img src="/Project_7/include/logo.jpg" alt="Logo" style="height: 40px;" class="me-2">
      Angus & Coote Admin
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="adminNavbar">
      <ul class="navbar-nav ms-auto">
        <!-- Management Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="managementDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Management
          </a>
          <ul class="dropdown-menu" aria-labelledby="managementDropdown">
            <li><a class="dropdown-item" href="/Project_7/admin/categories/index.php">Categories</a></li>
            <li><a class="dropdown-item" href="/Project_7/admin/subcategories/subcategories.php">Subcategories</a></li>
            <li><a class="dropdown-item" href="/Project_7/admin/products/products.php">Products</a></li>
          </ul>
        </li>

        <!-- Orders & Reports -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="ordersDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Orders & Reports
          </a>
          <ul class="dropdown-menu" aria-labelledby="ordersDropdown">
            <li><a class="dropdown-item" href="/Project_7/admin/orders/orders.php">Orders</a></li>
            <li><a class="dropdown-item" href="/Project_7/admin/reports.php">Reports</a></li>
            <li><a class="dropdown-item" href="/Project_7/admin/search_orders.php">Search Orders</a></li>
          </ul>
        </li>

        <!-- Info -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="infoDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Info
          </a>
          <ul class="dropdown-menu" aria-labelledby="infoDropdown">
            <li><a class="dropdown-item" href="/Project_7/admin/reviews.php">Reviews</a></li>
            <li><a class="dropdown-item" href="/Project_7/admin/inquiries.php">Inquiries</a></li>
            <li><a class="dropdown-item" href="/Project_7/admin/pages.php">Pages</a></li>
          </ul>
        </li>

        <!-- Users -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="usersDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Users
          </a>
          <ul class="dropdown-menu" aria-labelledby="usersDropdown">
            <li><a class="dropdown-item" href="/Project_7/admin/users.php">Registered Users</a></li>
            <li><a class="dropdown-item" href="/Project_7/admin/subscribers.php">Subscribers</a></li>
          </ul>
        </li>

        <!-- Profile & Logout -->
        <li class="nav-item"><a class="nav-link" href="/Project_7/admin/profile.php">Profile</a></li>
        <li class="nav-item"><a class="nav-link btn btn-outline-danger px-3" href="/Project_7/admin/logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Your page content starts here -->

<!-- Bootstrap JS (with Popper.js) – must be at bottom before </body> -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
