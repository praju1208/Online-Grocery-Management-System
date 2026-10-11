<?php
session_start();
include("../app/config/db.php");

if(!isset($_SESSION['user_id'])){
  header("Location: login.php");
  exit;
}

$order_id = $_GET['order_id'] ?? 0;
?>

<!DOCTYPE html>
<html>
<head>
<title>Return Order</title>
<style>
body{
  font-family:Segoe UI;
  background:#f4f6f9;
  padding:40px;
}
.box{
  background:#fff;
  padding:25px;
  max-width:500px;
  margin:auto;
  border-radius:12px;
  box-shadow:0 5px 15px rgba(0,0,0,.1);
}
textarea{
  width:100%;
  height:120px;
  padding:10px;
}
button{
  background:#fd7e14;
  color:#fff;
  border:none;
  padding:10px 20px;
  border-radius:6px;
  cursor:pointer;
}
input{
  width:100%;
  padding:8px;
  margin-bottom:10px;
}
label{
  display:block;
  margin-top:10px;
}

</style>
</head>

<body>

<div class="box">
  <h2>🔄 Return Order #<?= $order_id ?></h2>

  <form method="post" action="/freshkart/app/config/controllers/ReturnController.php">
    <input type="hidden" name="order_id" value="<?= $order_id ?>">

    <label><b>Reason for return</b></label>
    <textarea name="reason" required placeholder="Explain your reason..."></textarea>
    <label>Refund Account Number</label>
    <input type="text" name="refund_account" required><br>

    <label>IFSC Code</label>
     <input type="text" name="refund_ifsc" required><br>

<label>Account Holder Name</label>
<input type="text" name="refund_holder" required>

    <br><br>
    <button type="submit">Submit Return Request</button>
  </form>
</div>

</body>
</html>
