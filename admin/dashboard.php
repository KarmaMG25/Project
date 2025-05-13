<?php
session_start();
include '../include/db.php';

if (!isset($_SESSION['admin_email'])) {
    header("Location: login.php");
    exit();
}

// Safe counts
function safe_count($conn, $table, $alias) {
    $result = mysqli_query($conn, "SELECT COUNT(*) AS $alias FROM $table");
    $data = $result ? mysqli_fetch_array($result) : [$alias => 0];
    return $data[$alias];
}

$total_users = safe_count($conn, 'users', 'total_users');
$total_products = safe_count($conn, 'products', 'total_products');
$total_orders = safe_count($conn, 'orders', 'total_orders');
$total_inquiries = safe_count($conn, 'inquiries', 'total_inquiries');
$total_reviews = safe_count($conn, 'reviews', 'total_reviews');

// Recent Orders Query
$recent_orders = mysqli_query($conn, "
  SELECT o.id, u.name, o.total_price, o.status, o.created_at 
  FROM orders o 
  JOIN users u ON o.user_id = u.id 
  ORDER BY o.created_at DESC LIMIT 5
");
?>

<?php include 'admin_template/header.php'; ?>

<div class="container mt-5 bg-overlay">
  <h2 class="text-center mb-4">Welcome, <?php echo htmlspecialchars($_SESSION['admin_email']); ?></h2>

  <!-- Quick Actions -->
  <div class="d-flex justify-content-center gap-3 mb-4 flex-wrap">
    <a href="products.php" class="btn btn-primary">Manage Products</a>
    <a href="orders.php" class="btn btn-success">View Orders</a>
    <a href="users.php" class="btn btn-info">Manage Users</a>
    <a href="reports.php" class="btn btn-warning">View Reports</a>
    <a href="logout.php" class="btn btn-danger">Logout</a>
  </div>

  <!-- Stats Cards -->
  <div class="row text-center">
    <?php
    $stats = [
      'Total Users' => $total_users,
      'Total Products' => $total_products,
      'Total Orders' => $total_orders,
      'Total Inquiries' => $total_inquiries,
      'Total Reviews' => $total_reviews
    ];

    foreach ($stats as $label => $value): ?>
      <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <h5 class="card-title"><?php echo $label; ?></h5>
            <p class="card-text display-4"><?php echo $value; ?></p>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Recent Orders Table -->
  <div class="card mt-4">
    <div class="card-header bg-dark text-white">
      Recent Orders
    </div>
    <div class="card-body p-0">
      <table class="table table-hover mb-0">
        <thead class="thead-dark">
          <tr>
            <th>#</th>
            <th>Customer</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <?php if(mysqli_num_rows($recent_orders) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($recent_orders)): ?>
              <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td>$<?php echo number_format($row['total_price'], 2); ?></td>
                <td><?php echo ucfirst($row['status']); ?></td>
                <td><?php echo date('d M Y', strtotime($row['created_at'])); ?></td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="5" class="text-center">No recent orders found.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Inquiries & Reports Info Cards -->
  <div class="row mt-4 g-3">
    <div class="col-md-6">
      <div class="dashboard-info-card">
        <i class="bi bi-chat-dots-fill dashboard-info-icon"></i>
        <div class="dashboard-info-title">Pending Inquiries</div>
        <div class="dashboard-info-value"><?php echo $total_inquiries; ?> pending</div>
        <div class="dashboard-info-btn">
          <a href="inquiries.php" class="btn btn-outline-primary btn-sm">View All</a>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="dashboard-info-card">
        <i class="bi bi-flag-fill dashboard-info-icon"></i>
        <div class="dashboard-info-title">User Reports</div>
        <div class="dashboard-info-value">Check issues</div>
        <div class="dashboard-info-btn">
          <a href="reports.php" class="btn btn-outline-warning btn-sm">View Reports</a>
        </div>
      </div>
    </div>
  </div>

</div>

<?php include 'admin_template/footer.php'; ?>
