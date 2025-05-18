<?php
session_start();
include '../../include/db.php';

if (!isset($_SESSION['admin_email'])) {
    header("Location: ../login.php");
    exit();
}

// Validate subcategory ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: subcategories.php");
    exit();
}

$id = intval($_GET['id']);

// Fetch subcategory details
$stmt = $conn->prepare("SELECT * FROM subcategories WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$subcat = $result->fetch_assoc();
$stmt->close();

if (!$subcat) {
    header("Location: subcategories.php");
    exit();
}

// Handle update submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $category_id = intval($_POST['category_id']);
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);

    if (!empty($category_id) && !empty($name)) {
        $update_stmt = $conn->prepare("UPDATE subcategories SET category_id = ?, name = ?, description = ? WHERE id = ?");
        $update_stmt->bind_param("issi", $category_id, $name, $description, $id);
        $update_stmt->execute();
        $update_stmt->close();

        header("Location: subcategories.php");
        exit();
    }
}

// Fetch categories for dropdown
$cat_result = $conn->query("SELECT id, name FROM categories ORDER BY name ASC");
?>

<?php include 'header_subcategories.php'; ?>

<div class="container my-5">
    <h2 class="mb-4 text-center">Edit Subcategory</h2>

    <div class="card p-4 shadow-sm">
        <form method="POST">
            <div class="mb-3">
                <label for="category_id" class="form-label">Select Category</label>
                <select name="category_id" id="category_id" class="form-select" required>
                    <?php while ($cat = $cat_result->fetch_assoc()) : ?>
                        <option value="<?= $cat['id']; ?>" <?= $cat['id'] == $subcat['category_id'] ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($cat['name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Subcategory Name</label>
                <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($subcat['name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description (optional)</label>
                <textarea name="description" id="description" class="form-control" rows="3"><?= htmlspecialchars($subcat['description']); ?></textarea>
            </div>
            <div class="d-flex justify-content-between">
                <a href="subcategories.php" class="btn btn-secondary">Cancel</a>
                <button type="submit" name="update" class="btn btn-success">Update Subcategory</button>
            </div>
        </form>
    </div>
</div>

<?php include '../admin_template/footer.php'; ?>
