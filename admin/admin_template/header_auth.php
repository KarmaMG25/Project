<!-- admin_template/header_auth.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin | Angus & Coote</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom Admin CSS -->
  <link rel="stylesheet" href="admin_css/admin_login.css">

  <!-- Background & Navbar Styling -->
  <style>
    body {
      background: url('../include/background.jpg') no-repeat center center fixed;
      background-size: cover;
      min-height: 100vh;
      margin: 0;
      padding-top: 80px; /* Prevent overlap with fixed navbar */
    }

    .navbar {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1000;
      background-color: rgba(255, 255, 255, 0.75);
      backdrop-filter: blur(8px);
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .navbar-brand span {
      font-weight: 600;
      color: #1e3a8a;
    }

    .navbar .nav-link {
      color: #333;
      font-weight: 500;
    }

    .navbar .nav-link:hover {
      color: #1e3a8a;
    }

    .page-heading {
      text-align: center;
      color: #1e3a8a;
      margin-top: 1rem;
      font-weight: 600;
    }
  </style>
</head>

<body>
  <!-- Fixed Navbar -->
  <nav class="navbar navbar-expand-lg px-4 py-2">
    <div class="container-fluid">
      <a class="navbar-brand d-flex align-items-center" href="#">
        <img src="../include/logo.jpg" alt="Logo" style="height: 40px;" class="me-2 rounded">
        <span>Angus & Coote Admin</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#authNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="authNavbar">
        <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="../guest/index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
       
        </ul>
      </div>
    </div>
  </nav>

  <!-- Optional Page Title -->
  <h4 class="page-heading">Welcome to the Admin Panel</h4>
