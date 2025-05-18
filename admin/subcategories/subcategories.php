<?php
session_start();
include '../../include/db.php';

if (!isset($_SESSION['admin_email'])) {
    header("Location: ../login.php");
    exit();
}

// Handle subcategory addition
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_subcategory'])) {
    $category_id = intval($_POST['category_id']);
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);

    if (!empty($category_id) && !empty($name)) {
        $stmt = $conn->prepare("INSERT INTO subcategories (category_id, name, description) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $category_id, $name, $description);
        $stmt->execute();
        $stmt->close();

        header("Location: subcategories.php");
        exit();
    }
}

// Fetch categories for dropdown
$categories_stmt = $conn->prepare("SELECT id, name FROM categories ORDER BY name ASC");
$categories_stmt->execute();
$categories_result = $categories_stmt->get_result();

// Fetch subcategories
$subcategories_stmt = $conn->prepare("
    SELECT subcategories.id, subcategories.name, subcategories.description, subcategories.created_at, categories.name AS category_name
    FROM subcategories
    JOIN categories ON subcategories.category_id = categories.id
    ORDER BY subcategories.id ASC
");

$subcategories_stmt->execute();
$subcategories_result = $subcategories_stmt->get_result();
?>

<?php include 'header_subcategories.php'; ?>

<div class="container my-5">
    <h2 class="text-center mb-4">Subcategories Management</h2>

    <!-- Add Subcategory Form -->
    <div class="card p-4 mb-5 shadow-sm">
        <h5 class="mb-3">Add New Subcategory</h5>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="category_id" class="form-label">Parent Category</label>
                <select name="category_id" id="category_id" class="form-select" required>
                    <option value="">-- Select Category --</option>
                    <?php while ($cat = $categories_result->fetch_assoc()) : ?>
                        <option value="<?= htmlspecialchars($cat['id']); ?>"><?= htmlspecialchars($cat['name']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Subcategory Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description (optional)</label>
                <textarea name="description" id="description" class="form-control" rows="3"></textarea>
            </div>
            <button type="submit" name="add_subcategory" class="btn btn-success">Add Subcategory</button>
        </form>
    </div>

    <!-- Subcategories Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
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
                <?php while ($row = $subcategories_result->fetch_assoc()) : ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']); ?></td>
                        <td><?= htmlspecialchars($row['category_name']); ?></td>
                        <td><?= htmlspecialchars($row['name']); ?></td>
                        <td><?= htmlspecialchars($row['description']); ?></td>
                        <td><?= htmlspecialchars($row['created_at']); ?></td>
                        <td>
                            <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this subcategory?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../admin_template/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>