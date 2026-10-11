<?php
session_start();
require_once("../app/helpers/auth.php");
include("../app/config/db.php");

$user_id = $_SESSION['user_id'];

/* GET PAYMENT MODE PROPERLY */
$mode = $_POST['payment_method'] ?? $_POST['mode'] ?? 'COD';

$status ="Pending";

/* ===== RECALCULATE TOTALS ===== */
$q = mysqli_query($conn, "
SELECT 
  c.quantity,
  p.price AS mrp,
  cat.offer AS offer
FROM cart c
JOIN products p ON c.product_id = p.id
JOIN categories cat ON p.category_id = cat.id
WHERE c.user_id = '$user_id'
");

$mrp_total = 0;
$selling_total = 0;

while ($r = mysqli_fetch_assoc($q)) {
  $qty   = (int)$r['quantity'];
  $mrp   = (float)$r['mrp'];
  $offer = (int)$r['offer'];

  $sell = ($offer > 0) ? $mrp - ($mrp * $offer / 100) : $mrp;

  $mrp_total     += $mrp * $qty;
  $selling_total += $sell * $qty;
}

$gst      = $selling_total * 0.05;
$delivery = ($selling_total >= 500) ? 0 : 30;
$grand    = $selling_total + $gst + $delivery;

/* ===== INSERT ORDER ===== */
mysqli_query($conn, "
INSERT INTO orders (user_id, total, status, payment_mode)
VALUES ('$user_id', '$grand', '$status', '$mode')
");

$order_id = mysqli_insert_id($conn);

/* ===== INSERT ORDER ITEMS ===== */
$items = mysqli_query($conn, "
SELECT product_id, quantity 
FROM cart 
WHERE user_id = '$user_id'
");

while ($i = mysqli_fetch_assoc($items)) {
  mysqli_query($conn, "
  INSERT INTO order_items (order_id, product_id, qty)
  VALUES ('$order_id', '{$i['product_id']}', '{$i['quantity']}')
  ");
}

/* ===== CLEAR CART ===== */
mysqli_query($conn, "DELETE FROM cart WHERE user_id = '$user_id'");

/* ===== REDIRECT ===== */
header("Location: order_success.php?id=" . $order_id);
exit();
