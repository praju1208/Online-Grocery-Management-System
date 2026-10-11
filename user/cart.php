<?php
session_start();
require_once("../app/helpers/auth.php");
include("../app/config/db.php");

$user_id = $_SESSION['user_id'];

/* FETCH CART ITEMS */
$q = mysqli_query($conn,"
SELECT 
  c.id AS cart_id,
  c.quantity,
  p.name,
  p.price AS mrp,
  p.image,
  cat.offer AS offer
FROM cart c
JOIN products p ON c.product_id = p.id
JOIN categories cat ON p.category_id = cat.id
WHERE c.user_id = $user_id
");
$grandTotal = 0;

?>

<!DOCTYPE html>
<html>
<head>
<title>FreshKart | My Cart</title>

<link rel="stylesheet" href="../assets/css/main.css">
</head>
<body>

<?php include("navbar.php"); ?>
<div class="cart-wrapper">

<div class="cart-left">
  <h2>🛒 My Cart</h2>
  <a href="home.php" class="continue-btn">Continue Shopping</a>
</div>

<div class="cart-right">

<table class="cart-table">
<tr>
  <th>Product</th>
  <th>Price</th>
  <th>Qty</th>
  <th>Total</th>
  <th></th>
</tr>

<?php
$grand = 0;
$saved = 0;

while ($row = mysqli_fetch_assoc($q)) {

$qty   = (int)$row['quantity'];
$mrp   = (float)$row['mrp'];
$offer = (int)$row['offer'];

$sell = $offer > 0
  ? $mrp - ($mrp * $offer / 100)
  : $mrp;

$item_total = $sell * $qty;

$grand += $item_total;
$saved += ($mrp - $sell) * $qty;


?>

<tr>
  <td>
    <img src="../assets/images/<?= htmlspecialchars($row['image']) ?>" width="60">
    <b><?= htmlspecialchars($row['name']) ?></b>
  </td>

  <td>
 ₹<?= number_format($sell, 2) ?>
<?php if($offer > 0){ ?>
  <br>
  <del>₹<?= number_format($mrp, 2) ?></del>
  <br>
  <small><?= $offer ?>% OFF</small>
<?php } ?>

</td>


  <td>
    <a href="../app/config/controllers/CartQtyController.php?action=dec&id=<?= $row['cart_id'] ?>">−</a>
    <?= $row['quantity'] ?>
    <a href="../app/config/controllers/CartQtyController.php?action=inc&id=<?= $row['cart_id'] ?>">+</a>
  </td>

  <td>
    ₹<?= number_format($item_total,2) ?>
  </td>

  <td>
    <a href="../app/config/controllers/CartQtyController.php?action=remove&id=<?= $row['cart_id'] ?>">✖</a>
  </td>
</tr>

<?php } ?>
</table>

<div class="summary">
 <p>You Saved: <span class="save">−₹<?= number_format($saved,2) ?></span></p>
<h3>Grand Total: ₹<?= number_format($grand,2) ?></h3>

  <a href="checkout.php" class="pay-btn">Proceed to Payment</a>
</div>


</div>
</div>


</div>
</body>
</html>
