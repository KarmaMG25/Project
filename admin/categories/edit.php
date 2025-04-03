<?php
session_start();
include '../../include/db.php';

if (!isset($_SESSION['admin_email'])) {
    header("Location: ../login.php");
    exit();
}

// Fetch category details
if (isset($_GET['id'])) {
    $category_id = $_GET['id'];
    $query = "SELECT * FROM categories WHERE id='$category_id'";
    $result = mysqli_query($conn, $query);
    $category = mysqli_fetch_assoc($result);
}

// Update category
if (isset($_POST['update_category'])) {
    $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $update_query = "UPDATE categories SET name='$category_name', description='$description' WHERE id='$category_id'";
    mysqli_query($conn, $update_query);
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include '../nav.php'; ?>

<div class="container mt-4">
    <h2 class="text-center">Edit Category</h2>

    <div class="card p-3">
        <form method="POST">
            <div class="form-group">
                <label>Category Name</label>
                <input type="text" name="category_name" class="form-control" value="<?php echo $category['name']; ?>" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="3"><?php echo $category['description']; ?></textarea>
            </div>
            <button type="submit" name="update_category" class="btn btn-success">Update Category</button>
        </form>
    </div>
</div>

<?php include '../footer.php'; ?>

</body>
</html>
