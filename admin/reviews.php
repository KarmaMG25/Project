<?php
session_start();
include '../include/db.php';

if (!isset($_SESSION['admin_email'])) {
    header("Location: login.php");
    exit();
}

// Fetch reviews with user and product names
$query = "
  SELECT r.*, u.name AS user_name, p.name AS product_name 
  FROM reviews r
  JOIN users u ON r.user_id = u.id
  JOIN products p ON r.product_id = p.id
  ORDER BY r.created_at DESC
";
$reviews = mysqli_query($conn, $query);
?>

<?php include 'admin_template/header.php'; ?>

<div class="container py-5">
  <h2 class="mb-4 text-center text-warning">
    <i class="bi bi-star-fill"></i> Product Reviews
  </h2>

  <?php if (mysqli_num_rows($reviews) > 0): ?>
    <div class="table-responsive">
      <table class="table table-bordered align-middle table-striped shadow-sm">
        <thead class="table-dark">
          <tr>
            <th>Product</th>
            <th>User</th>
            <th>Rating</th>
            <th>Review</th>
            <th>Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($reviews)): ?>
            <tr>
              <td><?= htmlspecialchars($row['product_name']) ?></td>
              <td><?= htmlspecialchars($row['user_name']) ?></td>
              <td>
                <?php for ($i = 1; $i <= 5; $i++): ?>
                  <i class="bi <?= $i <= $row['rating'] ? 'bi-star-fill text-warning' : 'bi-star text-muted' ?>"></i>
                <?php endfor; ?>
              </td>
              <td style="white-space: pre-wrap; max-width: 400px;">
                <?= nl2br(htmlspecialchars($row['review'])) ?>
              </td>
              <td><?= date("F j, Y, g:i A", strtotime($row['created_at'])) ?></td>
              <td>
                <a href="delete_review.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this review?');">Delete</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="alert alert-info text-center">No reviews submitted yet.</div>
  <?php endif; ?>
</div>

<?php include 'admin_template/footer.php'; ?>
