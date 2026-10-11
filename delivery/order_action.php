<?php
include("../app/config/db.php");

$id = $_GET['id'];
$action = $_GET['action'];

if($action=='accept'){
  mysqli_query($conn,"UPDATE orders SET status='Accepted' WHERE id='$id'");
}
elseif($action=='reject'){
  mysqli_query($conn,"UPDATE orders SET status='Cancelled' WHERE id='$id'");
}
elseif($action=='out'){
  mysqli_query($conn,"UPDATE orders SET status='Out for Delivery' WHERE id='$id'");
}
elseif($action=='done'){
  mysqli_query($conn,"UPDATE orders SET status='Delivered' WHERE id='$id'");
}

header("Location: dashboard.php");
exit();
