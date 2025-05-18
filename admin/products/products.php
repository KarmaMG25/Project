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

    if (!empty($category_id) && !empty($subcategory_id) && !empty($name) && !empty($price) && !empty($image)) {
        $target = "../../uploads/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);

        $query = "INSERT INTO products (category_id, subcategory_id, name, description, price, stock, image) 
                  VALUES ('$category_id', '$subcategory_id', '$name', '$description', '$price', '$stock', '$image')";
        mysqli_query($conn, $query);
        header("Location: products.php");
        exit();
    }
}

// Fetch categories and subcategories
$categories_result = mysqli_query($conn, "SELECT * FROM categories ORDER BY name ASC");
$subcategories_result = mysqli_query($conn, "SELECT * FROM subcategories ORDER BY name ASC");

// Fetch products
$products_query = "SELECT products.*, categories.name AS category_name, subcategories.name AS subcategory_name
                   FROM products
                   JOIN categories ON products.category_id = categories.id
                   JOIN subcategories ON products.subcategory_id = subcategories.id
                   ORDER BY products.id ASC";
$products_result = mysqli_query($conn, $products_query);
?>

<?php include 'header_products.php'; ?>

<div class="container my-5">
    <h2 class="text-center mb-4">Products Management</h2>

    <!-- Add Product Form -->
    <div class="card p-4 mb-5 shadow-sm">
        <h5 class="mb-3">Add New Product</h5>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Category</label>
                <select name="category_id" class="form-select" required>
                    <option value="">-- Select Category --</option>
                    <?php while ($cat = mysqli_fetch_assoc($categories_result)) : ?>
                        <option value="<?= $cat['id']; ?>"><?= htmlspecialchars($cat['name']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Subcategory</label>
                <select name="subcategory_id" class="form-select" required>
                    <option value="">-- Select Subcategory --</option>
                    <?php while ($subcat = mysqli_fetch_assoc($subcategories_result)) : ?>
                        <option value="<?= $subcat['id']; ?>"><?= htmlspecialchars($subcat['name']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Product Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Description (optional)</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label>Price ($)</label>
                <input type="number" name="price" class="form-control" required step="0.01">
            </div>
            <div class="mb-3">
                <label>Stock</label>
                <input type="number" name="stock" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Product Image</label>
                <input type="file" name="image" class="form-control" required>
            </div>
            <button type="submit" name="add_product" class="btn btn-success">Add Product</button>
        </form>
    </div>

    <!-- Products Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Category</th>
                    <th>Subcategory</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price ($)</th>
                    <th>Stock</th>
                    <th>Image</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($products_result)) : ?>
                    <tr>
                        <td><?= $row['id']; ?></td>
                        <td><?= htmlspecialchars($row['category_name']); ?></td>
                        <td><?= htmlspecialchars($row['subcategory_name']); ?></td>
                        <td><?= htmlspecialchars($row['name']); ?></td>
                        <td><?= htmlspecialchars($row['description']); ?></td>
                        <td><?= $row['price']; ?></td>
                        <td><?= $row['stock']; ?></td>
                        <td>
                            <?php if (!empty($row['image']) && file_exists("../../uploads/" . $row['image'])) : ?>
                                <img src="../../uploads/<?= $row['image']; ?>" width="100" alt="Product Image">
                            <?php else : ?>
                                <span class="text-muted">No image</span>
                            <?php endif; ?>
                        </td>
                        <td><?= $row['created_at']; ?></td>
                        <td>
                            <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../admin_template/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>