<?php
session_start();
include '../include/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = trim($_POST['report_type']);
    $data = trim($_POST['report_data']);

    if (!empty($type) && !empty($data)) {
        $stmt = $conn->prepare("INSERT INTO reports (user_id, report_type, report_data) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $userId, $type, $data);
        if ($stmt->execute()) {
            $success = "Report submitted successfully.";
        } else {
            $error = "Something went wrong. Please try again.";
        }
    } else {
        $error = "All fields are required.";
    }
}
?>

<?php include 'user_template/header.php'; ?>

<div class="container py-5">
  <h2 class="mb-4 text-center">Report an Issue</h2>

  <?php if ($success): ?>
    <div class="alert alert-success"><?= $success ?></div>
  <?php elseif ($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="mb-3">
      <label class="form-label">Report Type</label>
      <select name="report_type" class="form-select" required>
        <option value="">-- Select Type --</option>
        <option value="Bug">Bug</option>
        <option value="Product Issue">Product Issue</option>
        <option value="Abuse or Spam">Abuse or Spam</option>
        <option value="Other">Other</option>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Details</label>
      <textarea name="report_data" class="form-control" rows="5" required></textarea>
    </div>
    <div class="text-end">
      <button type="submit" class="btn btn-danger px-4">Submit Report</button>
    </div>
  </form>
</div>

<?php include 'user_template/footer.php'; ?>
