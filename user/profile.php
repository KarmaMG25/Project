<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include '../include/db.php';
$userId = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT name, email, phone, address, created_at FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($name, $email, $phone, $address, $created_at);
$stmt->fetch();
$stmt->close();
?>

<?php include 'user_template/header.php'; ?>

<h2 class="text-center mb-4">Welcome, <?= htmlspecialchars($name) ?>!</h2>

<!-- Quote Carousel (7 quotes, fixed height) -->
<div id="quoteCarousel" class="carousel slide carousel-fade mb-4 mx-auto" data-bs-ride="carousel" style="max-width: 600px; min-height: 130px;">
  <div class="carousel-inner text-center">

    <div class="carousel-item active">
      <blockquote class="blockquote">
        <p>"Elegance is not about being noticed, it's about being remembered."</p>
        <footer class="blockquote-footer">Giorgio Armani</footer>
      </blockquote>
    </div>

    <div class="carousel-item">
      <blockquote class="blockquote">
        <p>"Jewellery is like the perfect spice – it always complements what's already there."</p>
        <footer class="blockquote-footer">Diane Von Furstenberg</footer>
      </blockquote>
    </div>

    <div class="carousel-item">
      <blockquote class="blockquote">
        <p>"Shine bright like a diamond."</p>
        <footer class="blockquote-footer">Rihanna</footer>
      </blockquote>
    </div>

    <div class="carousel-item">
      <blockquote class="blockquote">
        <p>"Jewelry has the power to be this one little thing that can make you feel unique."</p>
        <footer class="blockquote-footer">Jennie Kwon</footer>
      </blockquote>
    </div>

    <div class="carousel-item">
      <blockquote class="blockquote">
        <p>"A piece of jewelry is often a piece of art. But it only becomes valuable when emotions are added to it."</p>
        <footer class="blockquote-footer">Unknown</footer>
      </blockquote>
    </div>

    <div class="carousel-item">
      <blockquote class="blockquote">
        <p>"You never really know a woman until you’ve seen her jewelry."</p>
        <footer class="blockquote-footer">Unknown</footer>
      </blockquote>
    </div>

    <div class="carousel-item">
      <blockquote class="blockquote">
        <p>"Accessories are what, in my opinion, pull the whole look together and make it unique."</p>
        <footer class="blockquote-footer">Yves Saint Laurent</footer>
      </blockquote>
    </div>

  </div>
</div>


<!-- Profile Card -->
<div class="d-flex justify-content-center">
  <div class="card shadow p-4" style="max-width: 550px; width: 100%;">
    <div class="text-center mb-3">
      <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" width="90" class="rounded-circle mb-2" alt="User Icon">
      <h4 class="card-title"><?= htmlspecialchars($name) ?></h4>
      <p class="text-muted">Member since <?= date("F Y", strtotime($created_at)) ?></p>
    </div>

    <ul class="list-group list-group-flush">
      <li class="list-group-item"><strong>Email:</strong> <?= htmlspecialchars($email) ?></li>
      <li class="list-group-item"><strong>Phone:</strong> <?= $phone ? htmlspecialchars($phone) : '<em>Not set</em>' ?></li>
      <li class="list-group-item"><strong>Address:</strong><br><?= $address ? nl2br(htmlspecialchars($address)) : '<em>Not set</em>' ?></li>
    </ul>

    <div class="text-center mt-4">
      <a href="settings.php" class="btn btn-outline-primary">Edit Profile</a>
    </div>
  </div>
</div>

<?php include 'user_template/footer.php'; ?>
