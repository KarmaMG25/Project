<?php
session_start();
include '../../include/db.php';

if (!isset($_SESSION['admin_email'])) {
    header("Location: ../login.php");
    exit();
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$category = null;

if ($id > 0) {
    $result = mysqli_query($conn, "SELECT * FROM categories WHERE id = $id");
    $category = mysqli_fetch_assoc($result);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    if ($id > 0) {
        mysqli_query($conn, "UPDATE categories SET name = '$name', description = '$description' WHERE id = $id");
    } else {
        mysqli_query($conn, "INSERT INTO categories (name, description) VALUES ('$name', '$description')");
    }

    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $id > 0 ? 'Edit' : 'Add'; ?> Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header_categories.php'; ?>


<div class="container my-5">
    <h2 class="text-center mb-4"><?= $id > 0 ? 'Edit' : 'Add New'; ?> Category</h2>

    <form method="POST" class="mx-auto" style="max-width: 600px;">
        <div class="mb-3">
            <label class="form-label">Category Name *</label>
            <input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($category['name'] ?? '') ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($category['description'] ?? '') ?></textarea>
        </div>

        <div class="d-flex justify-content-between">
            <a href="index.php" class="btn btn-secondary">← Back</a>
            <button type="submit" class="btn btn-primary"><?= $id > 0 ? 'Update' : 'Add'; ?> Category</button>
        </div>
    </form>
</div>

<?php include '../admin_template/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
