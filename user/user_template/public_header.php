<!-- Project_7/user/user_template/public_header.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Angus & Coote</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="user_template/css/style.css">
</head>

<body class="d-flex flex-column min-vh-100">

  <!-- ✅ Public Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
    
      <!-- ✅ Logo + Brand -->
      <a class="navbar-brand d-flex align-items-center gap-2" href="main.php">
        <img src="../include/logo.jpg" alt="Angus & Coote Logo" style="height: 40px;">
        <span class="fw-bold">Angus & Coote</span>
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
  <li class="nav-item"><a class="nav-link" href="../guest/index.php">Home</a></li>
  <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
  <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
  <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
  <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
</ul>

      </div>
    </div>
  </nav>

  <!-- ✅ Page Content -->
  <main class="container mt-4 flex-grow-1">
