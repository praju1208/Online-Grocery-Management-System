<?php
session_start();
require_once("../app/helpers/auth.php");
include("../app/config/db.php");

$order_id = $_GET['id'] ?? 0;

$order = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM orders WHERE id='$order_id' AND user_id='".$_SESSION['user_id']."'
"));

if(!$order){
  header("Location: home.php");
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Order Success</title>
<link rel="stylesheet" href="../assets/css/main.css">
<style>
.success-box{
  max-width:500px;
  margin:60px auto;
  background:#fff;
  padding:30px;
  border-radius:14px;
  text-align:center;
  box-shadow:0 10px 30px rgba(0,0,0,.1);
}
.success-box h2{color:#1f8b4c;}
.order-id{
  background:#f4f6f9;
  padding:12px;
  border-radius:8px;
  margin:15px 0;
  font-weight:600;
}
.track{
  margin:25px 0;
  display:flex;
  justify-content:space-between;
}
.step{
  flex:1;
  position:relative;
}
.step::after{
  content:"";
  height:3px;
  background:#ddd;
  position:absolute;
  top:12px;
  left:50%;
  width:100%;
}
.step:last-child::after{display:none;}
.step span{
  background:#1f8b4c;
  color:#fff;
  padding:6px 10px;
  border-radius:50%;
}
.actions a{
  display:inline-block;
  margin:10px;
  padding:12px 20px;
  background:#1f8b4c;
  color:#fff;
  border-radius:8px;
  text-decoration:none;
}
</style>
</head>
<body>

<?php include("navbar.php"); ?>

<div class="success-box">
  <h2>🎉 Order Placed Successfully!</h2>

  <div class="order-id">
    Order ID: #<?= $order['id'] ?>
  </div>

  <p>Payment Mode: <b><?= $order['payment_mode'] ?></b></p>
  <p>Status: <b><?= $order['status'] ?></b></p>

  <div class="track">
    <div class="step"><span>✔</span><br>Placed</div>
    <div class="step"><span>⏳</span><br>Packed</div>
    <div class="step"><span>🚚</span><br>Delivered</div>
  </div>

  <div class="actions">
    <a href="orders.php">View Orders</a>
    <a href="home.php">Continue Shopping</a>
  </div>
</div>

</body>
</html>
