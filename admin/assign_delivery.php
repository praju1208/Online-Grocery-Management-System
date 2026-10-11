<?php
session_start();
include("../app/config/db.php");

if (!isset($_SESSION['admin'])) {
  header("Location: ../index.php");
  exit();
}

if (!isset($_POST['order_id'], $_POST['delivery_boy'])) {
  header("Location: orders.php");
  exit();
}

$order_id = (int)$_POST['order_id'];
$delivery_boy = (int)$_POST['delivery_boy'];

/* Assign delivery boy + update status */
mysqli_query($conn,"
UPDATE orders 
SET delivery_boy = '$delivery_boy',
    status = 'Assigned'
WHERE id = '$order_id'
");

header("Location: orders.php");
exit();
