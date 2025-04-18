<?php
include '../include/db.php';

$messages = $conn->query("SELECT * FROM inquiries ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin | Contact Messages</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
  <h2 class="mb-4">📬 Contact Messages</h2>

  <?php if ($messages->num_rows > 0): ?>
    <table class="table table-bordered align-middle">
      <thead class="table-light">
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Message</th>
          <th>Submitted</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $messages->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['name']) ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
          <td><?= date("F j, Y, g:i A", strtotime($row['created_at'])) ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p class="text-muted">No messages yet.</p>
  <?php endif; ?>
</div>
</body>
</html>
