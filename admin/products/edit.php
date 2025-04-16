<?php
session_start();
include '../../include/db.php';

if (!isset($_SESSION['admin_email'])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Fetch the product data
    $query = "SELECT * FROM products WHERE id = '$product_id'";
    $result = mysqli_query($conn, $query);
    $product = mysqli_fetch_assoc($result);
}

// Handle the edit process
if (isset($_POST['edit_product'])) {
    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);
    $subcategory_id = mysqli_real_escape_string($conn, $_POST['subcategory_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $stock = mysqli_real_escape_string($conn, $_POST['stock']);
    $image = $_FILES['image']['name'];

    // If image is uploaded, update it, otherwise use the existing one
    if (!empty($image)) {
        $target = "../../uploads/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
        $image_query = "image = '$image',";
    } else {
        $image_query = "";
    }

    // Update the product
    $query = "UPDATE products SET 
              category_id = '$category_id', 
              subcategory_id = '$subcategory_id', 
              name = '$name', 
              description = '$description', 
              price = '$price', 
              stock = '$stock', 
              $image_query
              WHERE id = '$product_id'";
    mysqli_query($conn, $query);
    header("Location: products.php");
    exit();
}

$categories_query = "SELECT * FROM categories ORDER BY name ASC";
$categories_result = mysqli_query($conn, $categories_query);

$subcategories_query = "SELECT * FROM subcategories ORDER BY name ASC";
$subcategories_result = mysqli_query($conn, $subcategories_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="../../style.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include '../require/nav.php'; ?>

<header class="bg-primary text-white text-center py-4 mb-4">
    <div class="container">
        <h1>Edit Product</h1>
    </div>
</header>

<div class="container mt-4">
    <div class="card p-3">
        <h5>Edit Product Details</h5>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Parent Category</label>
                <select name="category_id" class="form-control" required>
                    <option value="">-- Select Category --</option>
                    <?php while ($cat = mysqli_fetch_assoc($categories_result)) : ?>
                        <option value="<?php echo $cat['id']; ?>" <?php echo $product['category_id'] == $cat['id'] ? 'selected' : ''; ?>><?php echo $cat['name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Parent Subcategory</label>
                <select name="subcategory_id" class="form-control" required>
                    <option value="">-- Select Subcategory --</option>
                    <?php while ($subcat = mysqli_fetch_assoc($subcategories_result)) : ?>
                        <option value="<?php echo $subcat['id']; ?>" <?php echo $product['subcategory_id'] == $subcat['id'] ? 'selected' : ''; ?>><?php echo $subcat['name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo $product['name']; ?>" required>
            </div>
            <div class="form-group">
                <label>Description (optional)</label>
                <textarea name="description" class="form-control" rows="3"><?php echo $product['description']; ?></textarea>
            </div>
            <div class="form-group">
                <label>Price</label>
                <input type="number" name="price" class="form-control" value="<?php echo $product['price']; ?>" required step="0.01">
            </div>
            <div class="form-group">
                <label>Stock</label>
                <input type="number" name="stock" class="form-control" value="<?php echo $product['stock']; ?>" required>
            </div>
            <div class="form-group">
                <label>Product Image (Leave empty to keep the same)</label>
                <input type="file" name="image" class="form-control">
            </div>
            <button type="submit" name="edit_product" class="btn btn-primary">Update Product</button>
        </form>
    </div>
</div>

<br><br>
<br><br>            <?php include '../require/footer.php'; ?>

</body>
</html>
