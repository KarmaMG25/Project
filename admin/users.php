<?php
session_start();
include '../include/db.php';

if (!isset($_SESSION['admin_email'])) {
    header("Location: login.php");
    exit();
}

$users = mysqli_query($conn, "SELECT * FROM users ORDER BY created_at DESC");
?>

<?php include 'admin_template/header.php'; ?>

<div class="container py-5">
  <h2 class="mb-4 text-center text-info"><i class="bi bi-people-fill"></i> Registered Users</h2>

  <?php if (mysqli_num_rows($users) > 0): ?>
    <div class="table-responsive">
      <table class="table table-bordered align-middle shadow-sm">
        <thead class="table-dark">
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Joined</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($users)): ?>
            <tr>
              <td><?= htmlspecialchars($row['name']) ?></td>
              <td><?= htmlspecialchars($row['email']) ?></td>
              <td><?= htmlspecialchars($row['phone'] ?: '-') ?></td>
              <td><?= htmlspecialchars($row['address'] ?: '-') ?></td>
              <td><?= date("F j, Y", strtotime($row['created_at'])) ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="alert alert-info text-center">No users found.</div>
  <?php endif; ?>
</div>

<?php include 'admin_template/footer.php'; ?>
