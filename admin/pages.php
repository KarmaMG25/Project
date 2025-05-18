<?php
session_start();
include '../include/db.php';

if (!isset($_SESSION['admin_email'])) {
    header("Location: login.php");
    exit();
}

$pages = mysqli_query($conn, "SELECT * FROM pages ORDER BY updated_at DESC, created_at DESC");
?>

<?php include 'admin_template/header.php'; ?>

<div class="container py-5">
  <h2 class="mb-4 text-center"><i class="bi bi-file-earmark-text-fill"></i> Manage Pages</h2>

  <?php if (mysqli_num_rows($pages) > 0): ?>
    <div class="table-responsive">
      <table class="table table-bordered table-striped shadow-sm align-middle">
        <thead class="table-dark">
          <tr>
            <th>Title</th>
            <th>Created</th>
            <th>Updated</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($pages)): ?>
            <tr>
              <td><?= htmlspecialchars($row['title']) ?></td>
              <td><?= date("F j, Y", strtotime($row['created_at'])) ?></td>
              <td><?= $row['updated_at'] ? date("F j, Y", strtotime($row['updated_at'])) : '—' ?></td>
              <td>
                <a href="edit_page.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="alert alert-info text-center">No pages found.</div>
  <?php endif; ?>
</div>

<?php include 'admin_template/footer.php'; ?>
