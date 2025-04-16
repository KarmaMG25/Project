<?php
session_start();
include '../../include/db.php';

if (!isset($_SESSION['admin_email'])) {
    header("Location: ../login.php");
    exit();
}

// Handle subcategory addition
if (isset($_POST['add_subcategory'])) {
    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    if (!empty($category_id) && !empty($name)) {
        $query = "INSERT INTO subcategories (category_id, name, description) 
                  VALUES ('$category_id', '$name', '$description')";
        mysqli_query($conn, $query);
        header("Location: subcategories.php");
        exit();
    }
}

// Fetch categories for dropdown
$categories_query = "SELECT * FROM categories ORDER BY name ASC";
$categories_result = mysqli_query($conn, $categories_query);

// Fetch subcategories
$subcategories_query = "SELECT subcategories.*, categories.name AS category_name 
                        FROM subcategories 
                        JOIN categories ON subcategories.category_id = categories.id 
                        ORDER BY subcategories.id DESC";
$subcategories_result = mysqli_query($conn, $subcategories_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subcategories Management</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include '../require/nav.php'; ?>

<header class="bg-primary text-white text-center py-4 mb-4">
    <div class="container">
        <h1>Subcategories Management</h1>
        <p>Manage subcategories of your jewelry products</p>
    </div>
</header>

<div class="container mt-4">
    <!-- Add Subcategory Form -->
    <div class="card p-3 mb-4">
        <h5>Add New Subcategory</h5>
        <form method="POST">
            <div class="form-group">
                <label>Parent Category</label>
                <select name="category_id" class="form-control" required>
                    <option value="">-- Select Category --</option>
                    <?php while ($cat = mysqli_fetch_assoc($categories_result)) : ?>
                        <option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Subcategory Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Description (optional)</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>
            <button type="submit" name="add_subcategory" class="btn btn-success">Add Subcategory</button>
        </form>
    </div>

    <!-- Subcategories Table -->
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Parent Category</th>
                <th>Subcategory Name</th>
                <th>Description</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($subcategories_result)) : ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['category_name']; ?></td>
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
