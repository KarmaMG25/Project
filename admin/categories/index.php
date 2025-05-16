<?php
session_start();
include '../../include/db.php';

if (!isset($_SESSION['admin_email'])) {
    header("Location: ../login.php");
    exit();
}

$categories = mysqli_query($conn, "SELECT * FROM categories ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Categories</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include '../admin_template/header.php'; ?>

<div class="container my-5">
    <h2 class="text-center mb-4">Manage Categories</h2>

    <div class="d-flex justify-content-end mb-3">
        <a href="edit.php" class="btn btn-success">+ Add New Category</a>
    </div>

    <table class="table table-bordered table-hover text-center">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($cat = mysqli_fetch_assoc($categories)): ?>
                <tr>
                    <td><?= $cat['id']; ?></td>
                    <td><?= htmlspecialchars($cat['name']); ?></td>
                    <td><?= htmlspecialchars($cat['description']); ?></td>
                    <td><?= date('d M Y', strtotime($cat['created_at'])); ?></td>
                    <td>
                        <a href="edit.php?id=<?= $cat['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="delete.php?id=<?= $cat['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this category?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include '../admin_template/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
