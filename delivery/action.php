<?php
include("../app/config/db.php");

$id = $_GET['id'];
$act = $_GET['act'];

if($act=='accept'){
  mysqli_query($conn,"UPDATE orders SET delivery_status='Accepted' WHERE id='$id'");
}
if($act=='reject'){
  mysqli_query($conn,"UPDATE orders SET delivery_boy=NULL,status='Pending' WHERE id='$id'");
}
if($act=='out'){
  mysqli_query($conn,"UPDATE orders SET delivery_status='Out',status='Out for Delivery' WHERE id='$id'");
}
if($act=='done'){
  mysqli_query($conn,"UPDATE orders SET delivery_status='Delivered',status='Delivered' WHERE id='$id'");
}

header("Location: dashboard.php");
