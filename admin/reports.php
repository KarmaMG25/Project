<?php
session_start();
include '../include/db.php';

if (!isset($_SESSION['admin_email'])) {
    header("Location: login.php");
    exit();
}

// Fetch all reports with user info
$reports = $conn->query("
  SELECT r.*, u.name AS user_name, u.email 
  FROM reports r
  JOIN users u ON r.user_id = u.id
  ORDER BY r.generated_at DESC
");
?>

<?php include 'admin_template/header.php'; ?>

<div class="container py-5">
  <h2 class="mb-4 text-center text-danger">
    <i class="bi bi-flag-fill"></i> User Reports
  </h2>

  <?php if ($reports->num_rows > 0): ?>
    <div class="table-responsive">
      <table class="table table-bordered table-striped align-middle shadow-sm">
        <thead class="table-dark">
          <tr>
            <th>User</th>
            <th>Email</th>
            <th>Type</th>
            <th>Message</th>
            <th>Submitted</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $reports->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($row['user_name']) ?></td>
              <td><?= htmlspecialchars($row['email']) ?></td>
              <td><span class="badge bg-primary"><?= htmlspecialchars($row['report_type']) ?></span></td>
              <td style="white-space: pre-wrap; max-width: 400px;"><?= nl2br(htmlspecialchars($row['report_data'])) ?></td>
              <td><?= date("F j, Y, g:i A", strtotime($row['generated_at'])) ?></td>
              <td>
                <?php if ($row['status'] === 'resolved'): ?>
                  <span class="badge bg-success">Resolved</span>
                <?php else: ?>
                  <span class="badge bg-warning text-dark">Open</span>
                <?php endif; ?>
              </td>
              <td>
                <?php if ($row['status'] !== 'resolved'): ?>
                  <a href="mark_report_resolved.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-success mb-1">Mark Resolved</a>
                <?php endif; ?>
                <a href="delete_report.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this report?');">Delete</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="alert alert-info text-center">No reports submitted yet.</div>
  <?php endif; ?>
</div>

<?php include 'admin_template/footer.php'; ?>
