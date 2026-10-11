<?php
session_start();
require_once("../app/helpers/auth.php");
include("../app/config/db.php");

$user_id = $_SESSION['user_id'];

$q = mysqli_query($conn,"
SELECT 
  c.quantity,
  p.price AS mrp,
  cat.offer AS offer
FROM cart c
JOIN products p ON c.product_id = p.id
JOIN categories cat ON p.category_id = cat.id
WHERE c.user_id = $user_id
");

$mrp_total = 0;
$selling_total = 0;

while($row = mysqli_fetch_assoc($q)){
  $qty   = (int)$row['quantity'];
  $mrp   = (float)$row['mrp'];
  $offer = (int)$row['offer'];

  $sell = $offer > 0
    ? $mrp - ($mrp * $offer / 100)
    : $mrp;

  $mrp_total     += $mrp * $qty;
  $selling_total += $sell * $qty;
}
$saved = $mrp_total - $selling_total;
/* GST 5% */
$gst = $selling_total * 0.05;

/* Delivery */
$delivery = ($selling_total >= 500) ? 0 : 30;

/* Final amount */
$grand_total = $selling_total + $gst + $delivery;
?>
<!DOCTYPE html>
<html>
<head>
<title>Checkout</title>
<link rel="stylesheet" href="../assets/css/checkout.css">
<script>
function showPayment(type){
  document.getElementById("upi").style.display="none";
  document.getElementById("card").style.display="none";
  document.getElementById("cod").style.display="none";

  document.getElementById(type).style.display="block";
}
</script>
</head>
<body>

<?php include("navbar.php"); ?>

<div class="checkout">

<h2>💳 Payment Details</h2>

<div class="total">Total Payable: ₹<?= number_format($grand_total, 2) ?>
</div>
<div class="bill-box">

  <div class="row">
    <span>Items Total</span>
    <span>₹<?= number_format($selling_total,2) ?></span>
  </div>

  <div class="row save">
    <span>You Saved</span>
    <span>-₹<?= number_format($saved,2) ?></span>
  </div>

  <div class="row">
    <span>GST (5%)</span>
    <span>₹<?= number_format($gst,2) ?></span>
  </div>

  <div class="row">
    <span>Delivery Charges</span>
    <span>
      <?= $delivery == 0 ? "<span class='free'>FREE</span>" : "₹".$delivery ?>
    </span>
  </div>

  <hr>

  <div class="row total">
    <span>Grand Total</span>
    <span>₹<?= number_format($grand_total,2) ?></span>
  </div>

</div>

<form method="post" action="place_order.php">

<div class="method">
  <label>
    <input type="radio" name="mode" value="COD" checked onclick="showPayment('cod')">
    Cash on Delivery
  </label>

  <label>
    <input type="radio" name="mode" value="UPI" onclick="showPayment('upi')">
    UPI
  </label>

  <label>
    <input type="radio" name="mode" value="CARD" onclick="showPayment('card')">
    Card
  </label>
</div>

<!-- COD -->
<div id="cod" class="box">
  <p>Pay cash when product arrives.</p>
</div>

<!-- UPI -->
<div id="upi" class="box" style="display:none;">
  <input type="text" name="upi_id" placeholder="Enter UPI ID (example@upi)">
</div>

<!-- CARD -->
<div id="card" class="box" style="display:none;">
  <input type="text" name="card_no" placeholder="Card Number" maxlength="16">
  <input type="text" name="card_name" placeholder="Card Holder Name">
  <div class="row">
    <input type="text" name="exp" placeholder="MM/YY">
    <input type="password" name="cvv" placeholder="CVV" maxlength="3">
  </div>
</div>

<button type="submit" class="pay">
  Pay ₹<?= number_format($grand_total,2) ?>
</button>

</form>
</div>
</body>
<script>
function showPayment(type){

  // hide all boxes
  document.querySelectorAll(".box").forEach(box => {
    box.style.display = "none";
    box.querySelectorAll("input").forEach(i => i.required = false);
  });

  // show selected box
  let active = document.getElementById(type);
  active.style.display = "block";

  // required only for visible inputs
  active.querySelectorAll("input").forEach(i => i.required = true);
}
</script>


</html>
