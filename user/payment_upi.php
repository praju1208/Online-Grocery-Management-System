<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<title>UPI Payment</title>
<link rel="stylesheet" href="../assets/css/main.css">
</head>
<body>

<div class="payment-card">
<h2>UPI Payment</h2>

<form action="order_success.php" method="post">
  <input type="text" name="upi" placeholder="Enter UPI ID" required>
  <button>Pay ₹<?= $_SESSION['pay_total'] ?></button>
</form>

</div>
</body>
</html>
