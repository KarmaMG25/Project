<?php
session_start();
include '../include/db.php';

if (!isset($_SESSION['admin_email'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    $stmt = $conn->prepare("INSERT INTO pages (title, content) VALUES (?, ?)");
    $stmt->bind_param("ss", $title, $content);
    $stmt->execute();
    $stmt->close();

    header("Location: pages.php");
    exit();
}
?>

<?php include 'admin_template/header.php'; ?>

<div class="container py-5">
  <h2 class="mb-4 text-center">Add New Page</h2>

  <form method="POST" class="card p-4 shadow-sm">
    <div class="mb-3">
      <label class="form-label">Page Title</label>
      <input type="text" name="title" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Page Content</label>
      <textarea name="content" class="form-control" rows="12" required></textarea>
    </div>
    <div class="text-end">
      <a href="pages.php" class="btn btn-secondary">Cancel</a>
      <button type="submit" class="btn btn-success">Create Page</button>
    </div>
  </form>
</div>

<?php include 'admin_template/footer.php'; ?>
