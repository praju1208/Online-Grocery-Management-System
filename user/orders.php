<?php
session_start();
include("../app/config/db.php");

if(!isset($_SESSION['user_id'])){
  header("Location: login.php");
  exit;
}

$user_id = $_SESSION['user_id'];

$q = mysqli_query($conn,"
SELECT 
  o.id,
  o.total,
  o.status,
  d.name AS delivery_name,
  r.status AS return_status,
  r.reason AS return_reason
FROM orders o
LEFT JOIN delivery_boys d ON o.delivery_boy = d.id
LEFT JOIN returns r ON r.order_id = o.id
WHERE o.user_id = '$user_id'
ORDER BY o.id DESC
");

?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="../assets/css/bg.css">
<title>My Orders</title>
<link rel="stylesheet" href="../assets/css/orders.css">

<style>
body{
  background:#f4f6f9;
  font-family:Segoe UI;
  padding:20px;
}

.order-card{
  background:#fff;
  padding:18px;
  border-radius:12px;
  margin-bottom:20px;
  box-shadow:0 4px 10px rgba(0,0,0,.05);
}

.order-head{
  display:flex;
  justify-content:space-between;
  align-items:center;
}

.badge{
  padding:5px 14px;
  border-radius:20px;
  font-size:13px;
  color:#fff;
}

.green{background:#28a745;}
.orange{background:#fd7e14;}
.gray{background:#6c757d;}
.blue{background:#007bff;}
.red{background:#dc3545;}

.btn{
  padding:6px 14px;
  border-radius:6px;
  text-decoration:none;
  display:inline-block;
  margin-top:10px;
  font-size:14px;
}

.timeline{
  list-style:none;
  padding-left:15px;
  margin-top:10px;
}

.timeline li{
  position:relative;
  padding-left:15px;
  margin-bottom:6px;
  color:#999;
}

.timeline li::before{
  content:'';
  width:8px;
  height:8px;
  background:#ccc;
  border-radius:50%;
  position:absolute;
  left:-10px;
  top:6px;
}

.timeline li.done{
  color:#28a745;
}

.timeline li.done::before{
  background:#28a745;
}

/* ORDER ITEMS */
.order-items{
  margin-top:15px;
  border-top:1px solid #eee;
  padding-top:10px;
}

.item-row{
  display:flex;
  align-items:center;
  gap:15px;
  padding:8px 0;
  border-bottom:1px dashed #ddd;
}

.item-row img{
  width:50px;
  height:50px;
  object-fit:contain;
}

.item-info{
  flex:1;
}

.item-price{
  text-align:right;
  font-size:14px;
}
.bill-box{
  margin-top:15px;
  background:#f9fafb;
  border:1px solid #eee;
  border-radius:12px;
  padding:15px;
}

.bill-row{
  display:flex;
  justify-content:space-between;
  margin-bottom:6px;
  font-size:14px;
}

.bill-row.total{
  font-weight:700;
  font-size:16px;
  border-top:1px dashed #ccc;
  padding-top:8px;
  margin-top:8px;
}

</style>
</head>

<body>

<h2>📦 My Orders</h2>

<?php while($o = mysqli_fetch_assoc($q)){ ?>

<div class="order-card">

  <div class="order-head">
    <h3>Order #<?= $o['id'] ?></h3>
    <span class="badge green"><?= $o['status'] ?></span>
  </div>

  <p><b>Total:</b> ₹<?= $o['total'] ?></p>
  <p><b>Delivery Boy:</b> <?= $o['delivery_name'] ?? 'Not Assigned' ?></p>

  <!-- ORDER ITEMS -->
  <div class="order-items">
    <h4>🛒 Items</h4>

    <?php
    $items = mysqli_query($conn,"
      SELECT 
        p.name,
        p.price,
        p.weight,
        p.image,
        oi.qty
      FROM order_items oi
      JOIN products p ON oi.product_id = p.id
      WHERE oi.order_id = '{$o['id']}'
    ");

    while($i = mysqli_fetch_assoc($items)){
      $subtotal = $i['price'] * $i['qty'];
    ?>
      <div class="item-row">
        <img src="../assets/images/<?= $i['image'] ?>" alt="">
        <div class="item-info">
          <b><?= $i['name'] ?></b><br>
          <small><?= $i['weight'] ?></small>
        </div>
        <div class="item-price">
          <?= $i['qty'] ?> × ₹<?= $i['price'] ?><br>
          
          <b>₹<?= $subtotal ?></b>
        </div>
      </div>
    <?php } ?>
  </div>

  <!-- TIMELINE -->
  <?php
  $steps = ['Placed','Assigned','Accepted','Out for Delivery','Delivered'];
  ?>
  <ul class="timeline">
    <?php foreach($steps as $s){ ?>
      <li class="<?= array_search($s,$steps) <= array_search($o['status'],$steps) ? 'done' : '' ?>">
        <?= $s ?>
      </li>
    <?php } ?>
  </ul>

  <!-- ACTIONS -->
  <?php if(in_array($o['status'],['Placed','Assigned'])){ ?>
    <a class="btn red" href="cancel_order.php?id=<?= $o['id'] ?>">
      ❌ Cancel Order
    </a>
  <?php } ?>

  <?php if($o['status']=='Delivered'){ ?>

  <?php if($o['return_status']){ ?>
    <p>
      <b>Return Status:</b>
      <span class="badge orange"><?= $o['return_status'] ?></span>
    </p>
    <p><b>Reason:</b> <?= $o['return_reason'] ?></p>
  <?php } else { ?>
    <a class="btn red"
       href="return_request.php?order_id=<?= $o['id'] ?>">
       🔄 Request Return
    </a>
  <?php } ?>

<?php } ?>
<?php
$ret = mysqli_query($conn,"
SELECT status,pickup_status,refund_status
FROM returns
WHERE order_id='{$o['id']}'
");
if(mysqli_num_rows($ret)){
$r=mysqli_fetch_assoc($ret);
?>
<hr>
<p><b>Pickup:</b> <?= $r['pickup_status'] ?></p>
<p><b>Refund:</b> <?= $r['refund_status'] ?></p>
<?php } ?>


</div>

<?php } ?>

<a href="home.php" class="btn blue">⬅ Continue Shopping</a>
<?php if(isset($_SESSION['return_success'])){ ?>
<script>
alert("✅ Return request submitted successfully!");
</script>
<?php unset($_SESSION['return_success']); } ?>

</body>

</html>   