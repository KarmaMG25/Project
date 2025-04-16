<?php
session_start();
include '../../include/db.php';

if (!isset($_SESSION['admin_email'])) {
    header("Location: ../login.php");
    exit();
}

// Get subcategory to edit
if (!isset($_GET['id'])) {
    header("Location: subcategories.php");
    exit();
}

$id = $_GET['id'];

// Fetch subcategory details
$query = "SELECT * FROM subcategories WHERE id = $id";
$result = mysqli_query($conn, $query);
$subcat = mysqli_fetch_assoc($result);

// Handle update
if (isset($_POST['update'])) {
    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $update_query = "UPDATE subcategories SET category_id = '$category_id', name = '$name', description = '$description' WHERE id = $id";
    mysqli_query($conn, $update_query);
    header("Location: subcategories.php");
    exit();
}

// Fetch categories for dropdown
$cat_result = mysqli_query($conn, "SELECT * FROM categories");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Subcategory</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h2>Edit Subcategory</h2>
    <form method="POST">
        <div class="form-group">
            <label>Category</label>
            <select name="category_id" class="form-control" required>
                <?php while ($cat = mysqli_fetch_assoc($cat_result)) : ?>
                    <option value="<?= $cat['id']; ?>" <?= $cat['id'] == $subcat['category_id'] ? 'selected' : ''; ?>>
                        <?= $cat['name']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Subcategory Name</label>
            <input type="text" name="name" class="form-control" value="<?= $subcat['name']; ?>" required>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control"><?= $subcat['description']; ?></textarea>
        </div>
        <button type="submit" name="update" class="btn btn-success">Update</button>
        <a href="subcategories.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

</body>
</html>
