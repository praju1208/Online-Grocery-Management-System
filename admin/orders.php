<?php
session_start();
include("../app/config/db.php");

if (!isset($_SESSION['admin'])) {
  header("Location: ../index.php");
  exit();
}

$orders = mysqli_query($conn,"
SELECT 
  o.id,
  o.total,
  o.status,
  o.payment_mode,
  u.name AS user_name,
  d.name AS delivery_name,
  r.id AS return_id
FROM orders o
JOIN users u ON o.user_id = u.id
LEFT JOIN delivery_boys d ON o.delivery_boy = d.id
LEFT JOIN returns r ON r.order_id = o.id
ORDER BY o.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Orders | Admin</title>
  <link rel="stylesheet" href="admin.css">
</head>
<body>

<?php include("admin_navbar.php"); ?>

<div class="main">

  <div class="topbar">
    <h2>🧾 Orders</h2>
  </div>

  <table style="width:100%;background:#fff;border-radius:10px;margin-top:20px;">
    <tr style="background:#f0f0f0;">
      <th>ID</th>
      <th>User</th>
      <th>Total</th>
      <th>Payment</th>
      <th>Status</th>
      <th>Delivery</th>
      <th>Action</th>
    </tr>

<?php while($o = mysqli_fetch_assoc($orders)){ ?>

<tr>
  <td>#<?= $o['id'] ?></td>
  <td><?= htmlspecialchars($o['user_name']) ?></td>
  <td>₹<?= number_format($o['total'],2) ?></td>
  <td><?= $o['payment_mode'] ?></td>

  <!-- ✅ ONLY RETURN LOGIC KEPT -->
  <td>
    <?php if($o['return_id']){ ?>
      <span class="status-badge status-Return">Return</span>
    <?php } else { ?>
      <span class="status-badge status-<?= str_replace(' ','',$o['status']) ?>">
        <?= $o['status'] ?>
      </span>
    <?php } ?>
  </td>

  <td><?= $o['delivery_name'] ?? 'Not Assigned' ?></td>

  <td>
    <a class="btn-sm btn-view" href="view_order.php?id=<?= $o['id'] ?>">
      👁 View
    </a>
  </td>
</tr>

<?php } ?>

  </table>

</div>
</body>
</html>
