<?php
session_start();
include '../include/db.php';

if (!isset($_SESSION['admin_email'])) {
    header("Location: login.php");
    exit();
}

$admin_email = $_SESSION['admin_email'];

// Fetch admin details
$query = "SELECT * FROM admin WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $admin_email);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();
$stmt->close();

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $error = null;

    // If password is entered, validate it
    if (!empty($password)) {
        if ($password === $confirm_password) {
            $hashed = password_hash($password, PASSWORD_BCRYPT);
        } else {
            $error = "Passwords do not match.";
        }
    } else {
        $hashed = $admin['password'];
    }

    // Update if no error
    if (!$error) {
        $stmt = $conn->prepare("UPDATE admin SET name=?, phone=?, password=? WHERE email=?");
        $stmt->bind_param("ssss", $name, $phone, $hashed, $admin_email);
        $stmt->execute();
        $stmt->close();
        $success = "Profile updated successfully.";
        // Refresh data
        $admin['name'] = $name;
        $admin['phone'] = $phone;
    }
}
?>

<?php include 'admin_template/header.php'; ?>

<div class="container my-5">
    <h2 class="text-center mb-4">Admin Profile</h2>

    <!-- Admin Profile Card -->
    <div class="d-flex justify-content-center">
        <div class="card shadow p-4" style="max-width: 550px; width: 100%;">
            <div class="text-center mb-3">
                <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" width="90" class="rounded-circle mb-2" alt="Admin Icon">
                <h4 class="card-title"><?= htmlspecialchars($admin['name']) ?></h4>
                <p class="text-muted">Email: <?= htmlspecialchars($admin['email']) ?></p>
            </div>

            <?php if (isset($success)) : ?>
                <div class="alert alert-success text-center"><?= $success; ?></div>
            <?php elseif (isset($error)) : ?>
                <div class="alert alert-danger text-center"><?= $error; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($admin['name']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone Number</label>
                    <input type="tel" name="phone" class="form-control" value="<?= htmlspecialchars($admin['phone']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">New Password <small class="text-muted">(Leave blank to keep current)</small></label>
                    <input type="password" name="password" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Re-enter New Password</label>
                    <input type="password" name="confirm_password" class="form-control">
                </div>

                <div class="text-center mt-4">
                    <button type="submit" name="update_profile" class="btn btn-primary">Update Profile</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'admin_template/footer.php'; ?>
