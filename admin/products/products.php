<?php
session_start();
include '../../include/db.php';

if (!isset($_SESSION['admin_email'])) {
    header("Location: ../login.php");
    exit();
}

// Handle product addition
if (isset($_POST['add_product'])) {
    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);
    $subcategory_id = mysqli_real_escape_string($conn, $_POST['subcategory_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $stock = mysqli_real_escape_string($conn, $_POST['stock']);
    $image = $_FILES['image']['name'];

    if (!empty($category_id) && !empty($subcategory_id) && !empty($name) && !empty($price)) {
        $target = "../../uploads/" . basename($image); // Correct path for the image upload
        move_uploaded_file($_FILES['image']['tmp_name'], $target);

        $query = "INSERT INTO products (category_id, subcategory_id, name, description, price, stock, image) 
                  VALUES ('$category_id', '$subcategory_id', '$name', '$description', '$price', '$stock', '$image')";
        mysqli_query($conn, $query);
        header("Location: products.php");
        exit();
    }
}

// Fetch categories and subcategories
$categories_query = "SELECT * FROM categories ORDER BY name ASC";
$categories_result = mysqli_query($conn, $categories_query);

$subcategories_query = "SELECT * FROM subcategories ORDER BY name ASC";
$subcategories_result = mysqli_query($conn, $subcategories_query);

// Fetch products
$products_query = "SELECT products.*, categories.name AS category_name, subcategories.name AS subcategory_name
                   FROM products
                   JOIN categories ON products.category_id = categories.id
                   JOIN subcategories ON products.subcategory_id = subcategories.id
                   ORDER BY products.id DESC";
$products_result = mysqli_query($conn, $products_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Management</title>
    <link rel="stylesheet" href="../../style.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include '../require/nav.php'; ?> <!-- Corrected path to nav.php -->

<header class="bg-primary text-white text-center py-4 mb-4">
    <div class="container">
        <h1>Products Management</h1>
        <p>Manage your jewelry products</p>
    </div>
</header>

<div class="container mt-4">
    <!-- Add Product Form -->
    <div class="card p-3 mb-4">
        <h5>Add New Product</h5>
        <form method="POST" enctype="multipart/form-data">
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
                <label>Parent Subcategory</label>
                <select name="subcategory_id" class="form-control" required>
                    <option value="">-- Select Subcategory --</option>
                    <?php while ($subcat = mysqli_fetch_assoc($subcategories_result)) : ?>
                        <option value="<?php echo $subcat['id']; ?>"><?php echo $subcat['name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Description (optional)</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label>Price</label>
                <input type="number" name="price" class="form-control" required step="0.01">
            </div>
            <div class="form-group">
                <label>Stock</label>
                <input type="number" name="stock" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Product Image</label>
                <input type="file" name="image" class="form-control" required>
            </div>
            <button type="submit" name="add_product" class="btn btn-success">Add Product</button>
        </form>
    </div>

    <!-- Products Table -->
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Category</th>
                <th>Subcategory</th>
                <th>Product Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Image</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($products_result)) : ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['category_name']; ?></td>
                    <td><?php echo $row['subcategory_name']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo $row['price']; ?></td>
                    <td><?php echo $row['stock']; ?></td>
                    <td><img src="../../uploads/<?php echo $row['image']; ?>" width="100" alt="Product Image"></td>
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

<?php include '../require/footer.php'; ?> <!-- Corrected path to footer.php -->

</body>
</html>
