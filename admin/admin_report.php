<?php
session_start();
include '../include/db.php';

$reports = $conn->query("
  SELECT r.*, u.name AS user_name, u.email 
  FROM reports r
  JOIN users u ON r.user_id = u.id
  ORDER BY r.generated_at DESC
");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin | User Reports</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
  <h2 class="mb-4">🚨 User Reports</h2>

  <?php if ($reports->num_rows > 0): ?>
    <table class="table table-bordered align-middle">
      <thead class="table-light">
        <tr>
          <th>User</th>
          <th>Email</th>
          <th>Type</th>
          <th>Message</th>
          <th>Submitted</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $reports->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['user_name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['report_type']) ?></td>
            <td><?= nl2br(htmlspecialchars($row['report_data'])) ?></td>
            <td><?= date("F j, Y, g:i A", strtotime($row['generated_at'])) ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>No reports submitted yet.</p>
  <?php endif; ?>
</div>
</body>
</html>
