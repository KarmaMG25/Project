<?php
session_start();
include '../include/db.php';

if (!isset($_SESSION['admin_email'])) {
    header("Location: login.php");
    exit();
}

$subs = mysqli_query($conn, "SELECT * FROM subscribers ORDER BY created_at DESC");
?>

<?php include 'admin_template/header.php'; ?>

<div class="container py-5">
  <h2 class="mb-4 text-center text-success"><i class="bi bi-envelope-check-fill"></i> Email Subscribers</h2>

  <?php if (mysqli_num_rows($subs) > 0): ?>
    <div class="table-responsive">
      <table class="table table-bordered align-middle shadow-sm">
        <thead class="table-dark">
          <tr>
            <th>Email</th>
            <th>Subscribed On</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($subs)): ?>
            <tr>
              <td><?= htmlspecialchars($row['email']) ?></td>
              <td><?= date("F j, Y", strtotime($row['created_at'])) ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="alert alert-info text-center">No subscribers found.</div>
  <?php endif; ?>
</div>

<?php include 'admin_template/footer.php'; ?>
