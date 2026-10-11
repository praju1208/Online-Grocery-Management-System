<?php
session_start();
include("../app/config/db.php");

if(!isset($_SESSION['admin'])){
  header("Location: ../index.php");
  exit;
}

$q = mysqli_query($conn,"
SELECT 
  r.*,
  u.name AS user_name,
  u.phone,
  u.address,
  o.total,
  d.name AS pickup_boy_name
FROM returns r
JOIN orders o ON r.order_id = o.id
JOIN users u ON o.user_id = u.id
LEFT JOIN delivery_boys d ON r.pickup_boy = d.id
ORDER BY r.id DESC
");

?>

<!DOCTYPE html>
<html>
<head>
<title>Returns | Admin</title>
<link rel="stylesheet" href="admin.css">

<style>
.sidebar{
  height:100vh;
  position:fixed;
}

.return-card{
  background:#fff;
  border-radius:14px;
  padding:22px;
  margin-bottom:20px;
  box-shadow:0 10px 25px rgba(0,0,0,.08);
}

.return-header{
  display:flex;
  justify-content:space-between;
  align-items:center;
  margin-bottom:10px;
}

.badge{
  padding:6px 14px;
  border-radius:20px;
  font-size:13px;
  font-weight:600;
}

.badge.pending{ background:#ffe8a1; color:#856404; }
.badge.approved{ background:#d4edda; color:#155724; }
.badge.rejected{ background:#f8d7da; color:#721c24; }

.return-actions{
  margin-top:15px;
  display:flex;
  flex-wrap:wrap;
  gap:10px;
}

.btn{
  padding:8px 14px;
  border-radius:8px;
  text-decoration:none;
  color:#fff;
  font-size:14px;
}

.btn.green{ background:#28a745; }
.btn.red{ background:#dc3545; }
.btn.blue{ background:#007bff; }
.btn.dark{ background:#343a40; }

select{
  padding:7px;
  border-radius:6px;
}
</style>

</head>
<body>

<?php include("admin_navbar.php"); ?>

<div class="main">

<h2>🔄 Return Requests</h2>

<?php while($r=mysqli_fetch_assoc($q)){ ?>

<div class="return-card">

  <div class="return-header">
    <h3>Order #<?= $r['order_id'] ?></h3>
    <span class="badge <?= strtolower($r['status']) ?>">
      <?= $r['status'] ?>
    </span>
  </div>

  <p><b><?= $r['user_name'] ?></b> | <?= $r['phone'] ?></p>
  <p><?= $r['address'] ?></p>

  <p><b>Reason:</b> <?= $r['reason'] ?></p>

  <hr>

  <p><b>Refund Amount:</b> ₹<?= number_format($r['total'],2) ?></p>

  <p><b>Bank Details</b><br>
  Acc: <?= $r['refund_account'] ?><br>
  IFSC: <?= $r['refund_ifsc'] ?><br>
  Name: <?= $r['refund_holder'] ?></p>

  <p>
    📦 Pickup: <b><?= $r['pickup_status'] ?: 'Not Assigned' ?></b><br>
    💰 Refund: <b><?= $r['refund_status'] ?: 'Pending' ?></b><br>
    🚚 Pickup Boy: <?= $r['pickup_boy_name'] ?? 'Not Assigned' ?>
  </p>

  <div class="return-actions">

  <!-- 1️⃣ APPROVE / REJECT -->
  <?php if($r['status']=='Pending'){ ?>
    <a class="btn green" href="update_return.php?id=<?= $r['id'] ?>&action=approve">Approve</a>
    <a class="btn red" href="update_return.php?id=<?= $r['id'] ?>&action=reject">Reject</a>
  <?php } ?>

  <!-- 2️⃣ ASSIGN OR RE-ASSIGN PICKUP BOY -->
  <?php 
  if($r['status']=='Approved' && 
     ($r['pickup_status']=='Assigned' || 
      $r['pickup_status']=='Rejected' || 
      empty($r['pickup_status'])))
  { 
  ?>

  <form action="assign_pickup.php" method="post">
    <input type="hidden" name="return_id" value="<?= $r['id'] ?>">

    <select name="delivery_id" required>
      <option value="">Assign Delivery Boy</option>
      <?php
      $boys = mysqli_query($conn,"SELECT * FROM delivery_boys");
      while($b = mysqli_fetch_assoc($boys)){
      ?>
        <option value="<?= $b['id'] ?>">
          <?= $b['name'] ?>
        </option>
      <?php } ?>
    </select>

    <button type="submit" class="btn green">
      Assign Pickup
    </button>
  </form>

  <?php } ?>

  <!-- 3️⃣ REFUND AFTER PICKUP -->
  <?php if($r['pickup_status']=='Picked Up' && $r['refund_status']=='Pending'){ ?>
    <a href="refund.php?id=<?= $r['id'] ?>" class="btn green">
      Process Refund
    </a>
  <?php } ?>

  </div>

</div>

<?php } ?>

</div>
</body>
</html>
