<?php
session_start();
include("../app/config/db.php");

if (!isset($_SESSION['delivery_boy_id'])) {
  header("Location: ../index.php");
  exit();
}

$boy_id = $_SESSION['delivery_boy_id'];

$q = mysqli_query($conn,"
SELECT 
  o.id,
  o.total,
  o.status,
  o.payment_mode,
  u.name AS customer,
  u.phone,
  u.address
FROM orders o
JOIN users u ON o.user_id = u.id
WHERE o.delivery_boy = '$boy_id'
ORDER BY o.id DESC
");

?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="/freshkart/assets/css/global.css">

  <title>Delivery Dashboard</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <style>
    body{background:#f4f6f9;font-family:Arial}
    .container{max-width:900px;margin:auto;padding:20px}
    .card{
      background:#fff;
      padding:20px;
      border-radius:12px;
      box-shadow:0 8px 20px rgba(0,0,0,.08);
      margin-bottom:20px;
    }
    .status{
      display:inline-block;
      padding:6px 14px;
      border-radius:20px;
      font-size:14px;
      font-weight:bold;
    }
    .Placed{background:#ffc107;color:#000}
    .Assigned{background:#17a2b8;color:#fff}
    .Accepted{background:#28a745;color:#fff}
    .Out{background:#007bff;color:#fff}
    .Delivered{background:#6c757d;color:#fff}
    .Cancelled{background:#dc3545;color:#fff}
    .pay-badge{
  display:inline-block;
  padding:3px 10px;
  font-size:12px;
  border-radius:12px;
  font-weight:600;
  background:#eee;
  color:#333;
}
.pay-badge.card{ background:#e3f2fd; color:#0d47a1; }
.pay-badge.cod{ background:#fff3cd; color:#856404; }
.pay-badge.upi{ background:#e8f5e9; color:#1b5e20; }

  </style>
</head>

<body style="margin-left:240px">
  <?php include("navbar.php");?>
 <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
</div>
 
<div class="container">

<h2>🚚 Assigned Orders</h2>

<?php if(mysqli_num_rows($q)==0){ ?>
  <p>No orders assigned yet.</p>
<?php } ?>

<?php while($o = mysqli_fetch_assoc($q)){ ?>
<div class="card">

  <h3>Order #<?= $o['id'] ?></h3>

  <p><b>Customer:</b> <?= $o['customer'] ?></p>
  <p><b>Phone:</b> <?= $o['phone'] ?></p>
  <p><b>Address:</b> <?= $o['address'] ?></p>
  <p><b>Total:</b> ₹<?= number_format($o['total'],2) ?></p>
  <p>
  <b>Payment:</b>
  <span class="pay-badge <?= strtolower($o['payment_mode']) ?>">
    <?= $o['payment_mode'] ?>
  </span>
</p>

  <p>
    <b>Status:</b>
    <span class="status <?= str_replace(' ','',$o['status']) ?>">
      <?= $o['status'] ?>
    </span>
  </p>

  <!-- ACTIONS -->

  <?php if($o['status']=='Assigned'){ ?>
    <a class="btn green" href="order_action.php?id=<?= $o['id'] ?>&action=accept">Accept</a>
    <a class="btn red" href="order_action.php?id=<?= $o['id'] ?>&action=reject">Reject</a>
  <?php } ?>

  <?php if($o['status']=='Accepted'){ ?>
    <a class="btn blue" href="order_action.php?id=<?= $o['id'] ?>&action=out">
      Out for Delivery
    </a>
  <?php } ?>

  <?php if($o['status']=='Out for Delivery'){ ?>
    <a class="btn dark" target="_blank"
       href="https://www.google.com/maps/search/?api=1&query=<?= urlencode($o['address']) ?>">
      📍 Open GPS
    </a>

    <a class="btn green" href="order_action.php?id=<?= $o['id'] ?>&action=done">
      Delivered
    </a>
  <?php } ?>

</div>
<?php } ?>

</div>
</body>
</html>
