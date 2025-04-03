<?php
session_start();
include '../../include/db.php';

if (!isset($_SESSION['admin_email'])) {
    header("Location: ../login.php");
    exit();
}

// Handle category addition
if (isset($_POST['add_category'])) {
    $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    if (!empty($category_name)) {
        $query = "INSERT INTO categories (name, description) VALUES ('$category_name', '$description')";
        mysqli_query($conn, $query);
        header("Location: index.php");
        exit();
    }
}

// Fetch categories
$categories_query = "SELECT * FROM categories ORDER BY id DESC";
$categories_result = mysqli_query($conn, $categories_query);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories Management</title>

    
    <link rel="stylesheet" href="style.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>


<!-- Header Section -->
<header>
    <div class="container">
        <h1>Admin Dashboard</h1>
        <p>Manage your jewelry store effortlessly</p>
    </div>
</header>

<?php include '../require/nav.php'; ?>

<div class="container mt-4">
    <h2 class="text-center">Categories Management</h2>

    <!-- Add Category Form -->
    <div class="card p-3 mb-4">
        <h5>Add New Category</h5>
        <form method="POST">
            <div class="form-group">
                <label>Category Name</label>
                <input type="text" name="category_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>
            <button type="submit" name="add_category" class="btn btn-primary">Add Category</button>
        </form>
    </div>

    <!-- Display Categories -->
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Category Name</th>
                <th>Description</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($categories_result)) : ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo $row['created_at']; ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include '../require/footer.php'; ?>

</body>
</html>
