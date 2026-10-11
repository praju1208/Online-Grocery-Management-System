<?php
session_start();
include("../app/config/db.php");

if(!isset($_SESSION['delivery_boy_id'])){
  die("Delivery not logged in");
}

$boy_id = $_SESSION['delivery_boy_id'];

$q = mysqli_query($conn,"
SELECT r.*, u.name, u.phone, u.address, o.total
FROM returns r
JOIN orders o ON r.order_id = o.id
JOIN users u ON o.user_id = u.id
WHERE r.pickup_boy = '$boy_id'
ORDER BY r.id DESC
");

?>

<!DOCTYPE html>
<html>
<head>
<title>Return Pickups | Delivery</title>
<link rel="stylesheet" href="../assets/css/delivery.css">

<style>
body{
  background:#f4f6f9;
  font-family:Arial;
}

.main{
  margin-left:220px;
  padding:30px;
}

.pickup-card{
  background:#fff;
  border-radius:14px;
  padding:20px;
  margin-bottom:20px;
  box-shadow:0 10px 25px rgba(0,0,0,.08);
}

.pickup-card h3{
  margin:0;
}

.btn{
  display:inline-block;
  margin-top:10px;
  padding:8px 14px;
  border-radius:8px;
  text-decoration:none;
  color:#fff;
  font-size:14px;
}

.green{ background:#28a745; }
.blue{ background:#007bff; }
.dark{ background:#343a40; }
.red{ background:#dc3545; }
</style>
</head>
<body>

<?php include("navbar.php"); ?>

<div class="main">
<h2>↩ Return Pickups</h2>

<?php if(mysqli_num_rows($q)==0){ ?>
<p>No pickups assigned.</p>
<?php } ?>

<?php while($r=mysqli_fetch_assoc($q)){ ?>
<div class="pickup-card">

  <h3>Order #<?= $r['order_id'] ?></h3>
  <p><?= $r['name'] ?> | <?= $r['phone'] ?></p>
  <p><?= $r['address'] ?></p>
  <p><b>Refund:</b> ₹<?= number_format($r['total'],2) ?></p>

  <p><b>Status:</b> <?= $r['pickup_status'] ?></p>

  <!-- 1. ACCEPT + REJECT -->
  <?php if($r['pickup_status']=='Assigned'){ ?>
    <a class="btn green"
       href="return_action.php?id=<?= $r['id'] ?>&action=accept">
       Accept
    </a>

    <a class="btn red"
       href="return_action.php?id=<?= $r['id'] ?>&action=reject"
       onclick="return confirm('Are you sure you want to reject this pickup?')">
       Reject
    </a>
  <?php } ?>

  <!-- 2. OUT FOR PICKUP -->
  <?php if($r['pickup_status']=='Accepted'){ ?>
    <a class="btn blue"
       href="return_action.php?id=<?= $r['id'] ?>&action=out">
       Out for Pickup
    </a>

    <a class="btn blue" target="_blank"
       href="https://www.google.com/maps/search/?api=1&query=<?= urlencode($r['address']) ?>">
       📍 Open in Maps
    </a>
  <?php } ?>

  <!-- 3. PICKED UP -->
  <?php if($r['pickup_status']=='Out for Pickup'){ ?>
    <a class="btn dark"
       href="return_action.php?id=<?= $r['id'] ?>&action=pickup">
       Picked Up
    </a>
  <?php } ?>

  <?php if($r['pickup_status']=='Picked Up'){ ?>
    <span style="color:green;font-weight:bold;">
      ✔ Pickup Completed
    </span>
  <?php } ?>

  <?php if($r['pickup_status']=='Rejected'){ ?>
    <span style="color:red;font-weight:bold;">
      ✖ Pickup Rejected
    </span>
  <?php } ?>

</div>
<?php } ?>
</div>
</body>
</html>
