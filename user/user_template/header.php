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
  <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
      <a class="navbar-brand" href="main.php">Angus & Coote</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
      <li class="nav-item"><a class="nav-link" href="products.php">Products</a></li>
      <li class="nav-item"><a class="nav-link" href="cart.php">Cart</a></li>
      <li class="nav-item"><a class="nav-link" href="wishlist.php">Wishlist</a></li>
      <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
      <li class="nav-item"><a class="nav-link" href="report.php">Report</a></li> <!-- ✅ Added -->
      <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
      </ul>

      </div>
    </div>
  </nav>

  <!-- ✅ Let this main grow to push footer down -->
  <main class="container mt-4 flex-grow-1">
