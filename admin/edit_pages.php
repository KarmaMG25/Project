<?php
session_start();
include '../include/db.php';

if (!isset($_SESSION['admin_email'])) {
    header("Location: login.php");
    exit();
}

$id = intval($_GET['id']);
$page = mysqli_query($conn, "SELECT * FROM pages WHERE id = $id");
$pageData = mysqli_fetch_assoc($page);

if (!$pageData) {
    header("Location: pages.php");
    exit();
}

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    $stmt = $conn->prepare("UPDATE pages SET title = ?, content = ? WHERE id = ?");
    $stmt->bind_param("ssi", $title, $content, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: pages.php");
    exit();
}
?>

<?php include 'admin_template/header.php'; ?>

<div class="container py-5">
  <h2 class="mb-4 text-center">Edit Page: <?= htmlspecialchars($pageData['title']) ?></h2>

  <form method="POST" class="card shadow-sm p-4">
    <div class="mb-3">
      <label class="form-label">Page Title</label>
      <input type="text" name="title" class="form-control" required value="<?= htmlspecialchars($pageData['title']) ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Content</label>
      <textarea name="content" class="form-control" rows="12" required><?= htmlspecialchars($pageData['content']) ?></textarea>
    </div>
    <div class="text-end">
      <a href="pages.php" class="btn btn-secondary">Cancel</a>
      <button type="submit" class="btn btn-success">Save Changes</button>
    </div>
  </form>
</div>

<?php include 'admin_template/footer.php'; ?>
