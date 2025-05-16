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
  <title>Order Management | Angus & Coote</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="/Project_7/admin/admin_css/admin_style.css">
  <style>
    .table-container {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        padding: 20px;
        backdrop-filter: blur(6px);
    }
    .table thead th {
        background-color: #1e3a8a;
        color: white;
        font-weight: 600;
        border-bottom: none;
    }
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 0, 0, 0.02);
    }
    .table-hover tbody tr:hover {
        background-color: rgba(30, 58, 138, 0.07);
    }
    .table th, .table td {
        vertical-align: middle;
        text-align: center;
        font-weight: 600;
    }
    .table .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.8rem;
    }
    .dropdown-toggle {
        cursor: pointer;
    }
</style>

</head>
<body class="d-flex flex-column min-vh-100">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm sticky-top">
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
        <li class="nav-item"><a class="nav-link" href="../dashboard.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="orders.php">Orders</a></li>
        <li class="nav-item"><a class="nav-link" href="../reports.php">Reports</a></li>
        <li class="nav-item"><a class="nav-link" href="../users.php">Users</a></li>
        <li class="nav-item">
          <a class="nav-link btn btn-outline-danger px-3" href="../logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
