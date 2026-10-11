<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<title>Card Payment</title>
<link rel="stylesheet" href="../assets/css/main.css">
</head>
<body>

<div class="payment-card">
<h2>Card Payment</h2>

<form action="order_success.php" method="post">
  <input type="text" placeholder="Card Number" required>
  <input type="text" placeholder="Expiry MM/YY" required>
  <input type="password" placeholder="CVV" required>
  <button>Pay ₹<?= $_SESSION['pay_total'] ?></button>
</form>

</div>
</body>
</html>
