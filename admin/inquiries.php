<?php
session_start();
include '../include/db.php';

if (!isset($_SESSION['admin_email'])) {
    header("Location: login.php");
    exit();
}

// Fetch inquiries from database
$query = "SELECT * FROM inquiries ORDER BY created_at DESC";
$inquiries = mysqli_query($conn, $query);
?>

<?php include 'admin_template/header.php'; ?>

<div class="container py-5">
  <h2 class="mb-4 text-center text-primary">
    <i class="bi bi-envelope-fill"></i> Contact Inquiries
  </h2>

  <?php if (mysqli_num_rows($inquiries) > 0): ?>
    <div class="table-responsive">
      <table class="table table-bordered table-striped align-middle shadow-sm">
        <thead class="table-dark">
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Message</th>
            <th>Submitted At</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($inquiries)): ?>
            <tr>
              <td><?= htmlspecialchars($row['name']) ?></td>
              <td><?= htmlspecialchars($row['email']) ?></td>
              <td style="white-space: pre-wrap; max-width: 400px;"><?= nl2br(htmlspecialchars($row['message'])) ?></td>
              <td><?= date("F j, Y, g:i A", strtotime($row['created_at'])) ?></td>
              <td>
                <a href="delete_inquiry.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this inquiry?');">Delete</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="alert alert-info text-center">No inquiries submitted yet.</div>
  <?php endif; ?>
</div>

<?php include 'admin_template/footer.php'; ?>
