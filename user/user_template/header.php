<!-- Project_7/user/user_template/header.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Angus & Coote</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- ✅ Bootstrap 5 via CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- ✅ Custom Styles -->
  <link rel="stylesheet" href="user_template/css/style.css">
</head>

<!-- ✅ Apply flex layout to body -->
<body class="d-flex flex-column min-vh-100">

  <!-- ✅ Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
    
      <!-- ✅ Logo + Brand -->
      <a class="navbar-brand d-flex align-items-center gap-2" href="main.php">
        <img src="../include/logo.jpg" alt="Angus & Coote Logo" style="height: 40px;">
        <span class="fw-bold">Angus & Coote</span>
      </a>

      <!-- ✅ Hamburger Toggle -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- ✅ Nav Items -->
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="products.php">Products</a></li>
          <li class="nav-item"><a class="nav-link" href="cart.php">Cart</a></li>
          <li class="nav-item"><a class="nav-link" href="wishlist.php">Wishlist</a></li>
          <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
          <li class="nav-item"><a class="nav-link" href="report.php">Report</a></li>
          <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
        </ul>
      </div>
      
    </div>
  </nav>

  <!-- ✅ Content Area -->
  <main class="container mt-4 flex-grow-1">
