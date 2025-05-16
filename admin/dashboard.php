<?php
session_start();
include '../include/db.php';

if (!isset($_SESSION['admin_email'])) {
    header("Location: login.php");
    exit();
}

// Fetch KPI data
$total_orders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM orders"))['count'];
$pending_orders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM orders WHERE status = 'Pending'"))['count'];
$total_revenue = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total_price) AS total FROM orders"))['total'] ?? 0;
$total_users = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM users"))['count'];
$total_products = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM products"))['count'];
$total_inquiries = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM inquiries"))['count'];
$total_reviews = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM reviews"))['count'];

$recent_orders = mysqli_query($conn, "
    SELECT o.id, u.name, o.total_price, o.status, o.created_at 
    FROM orders o 
    JOIN users u ON o.user_id = u.id 
    ORDER BY o.created_at DESC LIMIT 5
");
?>

<?php include 'admin_template/header.php'; ?>

<style>
  body {
    background: url('/Project_7/include/background.jpg') no-repeat center center fixed;
    background-size: cover;
  }

  .glass-card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    padding: 25px;
    text-align: center;
    transition: transform 0.2s ease;
  }

  .glass-card:hover {
    transform: translateY(-5px);
  }

  .dashboard-section {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    padding: 30px;
    margin-top: 30px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.1);
  }

  .info-card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    padding: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: transform 0.2s ease;
  }

  .info-card:hover {
    transform: translateY(-3px);
  }

  .table thead th {
    background-color: #1e3a8a;
    color: white;
  }
</style>

<div class="container my-5">
  <h2 class="text-center mb-5">Admin Dashboard</h2>

  <!-- KPI Cards -->
  <div class="row g-4 mb-4">
    <div class="col-md-3"><div class="glass-card"><i class="bi bi-bag-fill text-primary fs-3 mb-2"></i><div>Total Orders</div><div class="fs-2 fw-bold"><?= $total_orders; ?></div></div></div>
    <div class="col-md-3"><div class="glass-card"><i class="bi bi-clock-fill text-warning fs-3 mb-2"></i><div>Pending Orders</div><div class="fs-2 fw-bold"><?= $pending_orders; ?></div></div></div>
    <div class="col-md-3"><div class="glass-card"><i class="bi bi-cash-coin text-success fs-3 mb-2"></i><div>Total Revenue</div><div class="fs-2 fw-bold">$<?= number_format($total_revenue, 2); ?></div></div></div>
    <div class="col-md-3"><div class="glass-card"><i class="bi bi-people-fill text-info fs-3 mb-2"></i><div>Users</div><div class="fs-2 fw-bold"><?= $total_users; ?></div></div></div>
  </div>

  <!-- Quick Stats -->
  <div class="row g-4 mb-4">
    <div class="col-md-4"><div class="glass-card"><i class="bi bi-box-fill text-secondary fs-3 mb-2"></i><div>Products</div><div class="fs-2 fw-bold"><?= $total_products; ?></div></div></div>
    <div class="col-md-4"><div class="glass-card"><i class="bi bi-chat-dots-fill text-primary fs-3 mb-2"></i><div>Inquiries</div><div class="fs-2 fw-bold"><?= $total_inquiries; ?></div></div></div>
    <div class="col-md-4"><div class="glass-card"><i class="bi bi-star-fill text-warning fs-3 mb-2"></i><div>Reviews</div><div class="fs-2 fw-bold"><?= $total_reviews; ?></div></div></div>
  </div>

  <!-- Recent Orders -->
  <div class="dashboard-section">
    <h5 class="mb-4">Recent Orders</h5>
    <div class="table-responsive">
      <table class="table table-hover">
        <thead><tr><th>#</th><th>Customer</th><th>Amount</th><th>Status</th><th>Date</th></tr></thead>
        <tbody>
          <?php if(mysqli_num_rows($recent_orders) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($recent_orders)): ?>
              <tr>
                <td><?= $row['id']; ?></td>
                <td><?= htmlspecialchars($row['name']); ?></td>
                <td>$<?= number_format($row['total_price'], 2); ?></td>
                <td><?= ucfirst($row['status']); ?></td>
                <td><?= date('d M Y', strtotime($row['created_at'])); ?></td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="5" class="text-center">No recent orders found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Info Cards -->
  <div class="row mt-4 g-3">
    <div class="col-md-6">
      <div class="info-card">
        <div class="d-flex align-items-center"><i class="bi bi-chat-dots-fill fs-2 me-3 text-primary"></i><div><div class="fw-bold">Pending Inquiries</div><div><?= $total_inquiries; ?> pending</div></div></div>
        <a href="inquiries.php" class="btn btn-outline-primary btn-sm">View All</a>
      </div>
    </div>
    <div class="col-md-6">
      <div class="info-card">
        <div class="d-flex align-items-center"><i class="bi bi-flag-fill fs-2 me-3 text-warning"></i><div><div class="fw-bold">User Reports</div><div>Check issues</div></div></div>
        <a href="reports.php" class="btn btn-outline-warning btn-sm">View Reports</a>
      </div>
    </div>
  </div>
</div>

<?php include 'admin_template/footer.php'; ?>
