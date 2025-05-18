<?php
session_start();
include '../../include/db.php';

if (!isset($_SESSION['admin_email'])) {
    header("Location: ../login.php");
    exit();
}

// Check if product ID is set and fetch the product
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: products.php");
    exit();
}

$product_id = intval($_GET['id']);

// Fetch product details
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$stmt->close();

if (!$product) {
    header("Location: products.php");
    exit();
}

// Handle update
if (isset($_POST['edit_product'])) {
    $category_id = intval($_POST['category_id']);
    $subcategory_id = intval($_POST['subcategory_id']);
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $image = $_FILES['image']['name'];

    if (!empty($image)) {
        $target = "../../uploads/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);

        $stmt = $conn->prepare("UPDATE products SET category_id=?, subcategory_id=?, name=?, description=?, price=?, stock=?, image=? WHERE id=?");
        $stmt->bind_param("iissdisi", $category_id, $subcategory_id, $name, $description, $price, $stock, $image, $product_id);
    } else {
        $stmt = $conn->prepare("UPDATE products SET category_id=?, subcategory_id=?, name=?, description=?, price=?, stock=? WHERE id=?");
        $stmt->bind_param("iissdii", $category_id, $subcategory_id, $name, $description, $price, $stock, $product_id);
    }

    $stmt->execute();
    $stmt->close();

    header("Location: products.php");
    exit();
}

// Fetch dropdown options
$categories_result = mysqli_query($conn, "SELECT * FROM categories ORDER BY name ASC");
$subcategories_result = mysqli_query($conn, "SELECT * FROM subcategories ORDER BY name ASC");
?>

<?php include 'header_products.php'; ?>

<div class="container my-5">
    <h2 class="text-center mb-4">Edit Product</h2>

    <div class="card p-4 shadow-sm">
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-select" required>
                    <option value="">-- Select Category --</option>
                    <?php while ($cat = mysqli_fetch_assoc($categories_result)) : ?>
                        <option value="<?= $cat['id']; ?>" <?= $cat['id'] == $product['category_id'] ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($cat['name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Subcategory</label>
                <select name="subcategory_id" class="form-select" required>
                    <option value="">-- Select Subcategory --</option>
                    <?php while ($subcat = mysqli_fetch_assoc($subcategories_result)) : ?>
                        <option value="<?= $subcat['id']; ?>" <?= $subcat['id'] == $product['subcategory_id'] ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($subcat['name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Product Name</label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($product['name']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description (optional)</label>
                <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($product['description']); ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Price ($)</label>
                <input type="number" name="price" class="form-control" value="<?= $product['price']; ?>" step="0.01" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Stock</label>
                <input type="number" name="stock" class="form-control" value="<?= $product['stock']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Product Image (leave blank to keep current)</label>
                <input type="file" name="image" class="form-control">
                <div class="mt-2">
                    <?php if (!empty($product['image']) && file_exists("../../uploads/" . $product['image'])): ?>
                        <img src="../../uploads/<?= $product['image']; ?>" width="120" alt="Current Image">
                    <?php else: ?>
                        <small class="text-muted">No image uploaded</small>
                    <?php endif; ?>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <a href="products.php" class="btn btn-secondary">Cancel</a>
                <button type="submit" name="edit_product" class="btn btn-primary">Update Product</button>
            </div>
        </form>
    </div>
</div>

<?php include '../admin_template/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>