<?php
session_start();
include("../app/config/db.php");

$user_id = $_SESSION['user_id'];

$returns = mysqli_query($conn,"
SELECT 
  r.id,
  r.order_id,
  r.reason,
  r.status,
  r.pickup_status,
  r.refund_status
FROM returns r
JOIN orders o ON r.order_id=o.id
WHERE o.user_id='$user_id'
ORDER BY r.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>My Returns</title>
<link rel="stylesheet" href="../assets/css/orders.css">
</head>
<body>

<h2>🔄 My Return Requests</h2>

<?php while($r=mysqli_fetch_assoc($returns)){ ?>
<div class="order-card">

<h3>Order #<?= $r['order_id'] ?></h3>

<p><b>Reason:</b> <?= $r['reason'] ?></p>
<p><b>Status:</b> <?= $r['status'] ?></p>
<p><b>Pickup:</b> <?= $r['pickup_status'] ?></p>
<p><b>Refund:</b> <?= $r['refund_status'] ?></p>

</div>
<?php } ?>

<a href="orders.php" class="btn blue">⬅ Back to Orders</a>

</body>
</html>
