<?php
session_start();
include("../app/config/db.php");

if (!isset($_SESSION['admin'])) {
  header("Location: ../index.php");
  exit();
}

/* COUNTS */
$products = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM products"));
$orders   = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM orders"));
$pendingOrders = mysqli_query(
  $conn,
  "SELECT COUNT(*) AS total FROM orders WHERE status='Pending'"
);
$pending = mysqli_fetch_assoc($pendingOrders)['total'];

$users = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM users"));

$sales = mysqli_fetch_assoc(mysqli_query($conn,"
  SELECT SUM(total) AS total_sales
  FROM orders
  WHERE status IN ('Placed','Shipped','Delivered')
"));
$total_sales = $sales['total_sales'] ?? 0;

?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard | FreshKart</title>
  <link rel="stylesheet" href="admin.css">
</head>
<body>

<?php include("admin_navbar.php"); ?>

<div class="main">

  <div class="topbar">
    <h2>Dashboard</h2>
    <div class="admin">👤 Admin</div>
  </div>

  <div class="cards">

    <div class="card">
      <h3>Total Products</h3>
      <p><?= $products ?></p>
    </div>

    <div class="card">
      <h3>Total Orders</h3>
      <p><?= $orders ?></p>
    </div>

    <div class="card">
      <h3>Pending Orders</h3>
      <p><?= $pending ?></p>
    </div>
     <div class="card">
  <h3>Total Users</h3>
  <p><?= $users ?></p>
</div>

<div class="card">
  <h3>Total Sales</h3>
  <p>₹<?= number_format($total_sales,2) ?></p>
</div>

  </div>

</div>

</body>
</html>
