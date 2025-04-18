<?php
include '../include/db.php';

$subs = $conn->query("SELECT * FROM subscribers ORDER BY subscribed_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin | Subscribers</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
  <h2 class="mb-4">📧 Newsletter Subscribers</h2>

  <!-- ✅ Export CSV Button -->
  <a href="export_subscriber.php" class="btn btn-success mb-3">📤 Export Subscribers (CSV)</a>

  <?php if ($subs->num_rows > 0): ?>
    <table class="table table-bordered align-middle">
      <thead class="table-light">
        <tr>
          <th>Email</th>
          <th>Subscribed At</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $subs->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= date("F j, Y, g:i A", strtotime($row['subscribed_at'])) ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p class="text-muted">No subscribers yet.</p>
  <?php endif; ?>
</div>
</body>
</html>
