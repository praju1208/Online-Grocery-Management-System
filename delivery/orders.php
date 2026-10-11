<?php
session_start();
include("../app/config/db.php");

$boy = $_SESSION['delivery_boy_name'];

$orders = mysqli_query($conn,"
SELECT * FROM orders
WHERE delivery_boy='$boy'
AND delivery_status='Pending'
");
?>

<link rel="stylesheet" href="../assets/css/order_timeline.css">

<h2>🚚 New Orders</h2>

<?php while($o=mysqli_fetch_assoc($orders)){ ?>
<div class="order-card">

  <h4>Order #<?= $o['id'] ?></h4>
  <p>Total: ₹<?= $o['total'] ?></p>

  <a href="accept_order.php?id=<?= $o['id'] ?>" class="btn">Accept</a>
  <a href="reject_order.php?id=<?= $o['id'] ?>" class="btn danger">Reject</a>

</div>
<?php } ?>
