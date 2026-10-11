<?php
session_start();
include("../app/config/db.php");

$user_id = $_SESSION['user_id'];

$q = mysqli_query($conn,"
SELECT r.*, o.total, o.payment_mode
FROM returns r
JOIN orders o ON r.order_id=o.id
WHERE r.user_id='$user_id'
ORDER BY r.id DESC
");
?>

<h2>🔄 My Returns</h2>

<?php while($r=mysqli_fetch_assoc($q)){ ?>
<div class="order-card">

<b>Order ID:</b> #<?= $r['order_id'] ?><br>
<b>Reason:</b> <?= $r['reason'] ?><br>
<b>Status:</b> <?= $r['status'] ?><br>
<b>Pickup:</b> <?= $r['pickup_status'] ?><br>
<b>Refund:</b> <?= $r['refund_status'] ?><br>
<b>Payment:</b> <?= $r['payment_mode'] ?><br>
<b>Total:</b> ₹<?= number_format($r['total'],2) ?>

</div>
<?php } ?>
