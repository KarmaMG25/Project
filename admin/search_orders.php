<?php
session_start();
include '../include/db.php';

if (!isset($_SESSION['admin_email'])) {
    header("Location: login.php");
    exit();
}

$search = $_GET['query'] ?? '';
$statusFilter = $_GET['status'] ?? '';
$fromDate = $_GET['from'] ?? '';
$toDate = $_GET['to'] ?? '';
$minPrice = $_GET['min'] ?? '';
$maxPrice = $_GET['max'] ?? '';

$where = "WHERE o.user_id = u.id";
$params = [];
$types = "";

// Search by keyword
if (!empty($search)) {
    $q = "%$search%";
    $where .= " AND (o.id = ? OR u.name LIKE ? OR u.email LIKE ?)";
    $params[] = $search;
    $params[] = $q;
    $params[] = $q;
    $types .= "iss";
}

// Status filter
if (!empty($statusFilter)) {
    $where .= " AND o.status = ?";
    $params[] = $statusFilter;
    $types .= "s";
}

// Date range filter
if (!empty($fromDate)) {
    $where .= " AND o.created_at >= ?";
    $params[] = $fromDate;
    $types .= "s";
}
if (!empty($toDate)) {
    $where .= " AND o.created_at <= ?";
    $params[] = $toDate . " 23:59:59";
    $types .= "s";
}

// Price range
if (!empty($minPrice)) {
    $where .= " AND o.total_price >= ?";
    $params[] = $minPrice;
    $types .= "d";
}
if (!empty($maxPrice)) {
    $where .= " AND o.total_price <= ?";
    $params[] = $maxPrice;
    $types .= "d";
}

// Final query
$sql = "SELECT o.*, u.name, u.email FROM orders o JOIN users u ON o.user_id = u.id $where ORDER BY o.created_at DESC";
$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$results = $stmt->get_result();
?>

<?php include 'admin_template/header.php'; ?>

<div class="container py-5">
  <h2 class="mb-4 text-center"><i class="bi bi-search"></i> Search Orders</h2>

  <!-- Enhanced Search Form -->
  <form method="GET" class="row g-3 align-items-end mb-4">
    <div class="col-md-3">
      <label class="form-label">Keyword</label>
      <input type="text" name="query" class="form-control" placeholder="Order ID, Name, Email" value="<?= htmlspecialchars($search) ?>">
    </div>
    <div class="col-md-2">
      <label class="form-label">Status</label>
      <select name="status" class="form-select">
        <option value="">All</option>
        <?php foreach (['Pending', 'Processing', 'Shipped', 'Delivered'] as $status): ?>
          <option value="<?= $status ?>" <?= ($status === $statusFilter) ? 'selected' : '' ?>><?= $status ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-2">
      <label class="form-label">From</label>
      <input type="date" name="from" class="form-control" value="<?= htmlspecialchars($fromDate) ?>">
    </div>
    <div class="col-md-2">
      <label class="form-label">To</label>
      <input type="date" name="to" class="form-control" value="<?= htmlspecialchars($toDate) ?>">
    </div>
    <div class="col-md-1">
      <label class="form-label">Min $</label>
      <input type="number" step="0.01" name="min" class="form-control" value="<?= htmlspecialchars($minPrice) ?>">
    </div>
    <div class="col-md-1">
      <label class="form-label">Max $</label>
      <input type="number" step="0.01" name="max" class="form-control" value="<?= htmlspecialchars($maxPrice) ?>">
    </div>
    <div class="col-md-1">
      <button type="submit" class="btn btn-primary w-100">Search</button>
    </div>
  </form>

  <!-- Results -->
  <?php if ($results && $results->num_rows > 0): ?>
    <div class="table-responsive">
      <table class="table table-bordered align-middle">
        <thead class="table-dark">
          <tr>
            <th>Order ID</th>
            <th>Customer</th>
            <th>Email</th>
            <th>Total ($)</th>
            <th>Status</th>
            <th>Session ID</th>
            <th>Ordered At</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $results->fetch_assoc()): ?>
            <tr>
              <td><?= $row['id'] ?></td>
              <td><?= htmlspecialchars($row['name']) ?></td>
              <td><?= htmlspecialchars($row['email']) ?></td>
              <td>$<?= number_format($row['total_price'], 2) ?></td>
              <td><span class="badge bg-info"><?= htmlspecialchars($row['status']) ?></span></td>
              <td><?= htmlspecialchars($row['stripe_session_id']) ?: '<em>N/A</em>' ?></td>
              <td><?= date("F j, Y, g:i A", strtotime($row['created_at'])) ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="alert alert-warning text-center">No orders found matching your criteria.</div>
  <?php endif; ?>
</div>

<?php include 'admin_template/footer.php'; ?>
