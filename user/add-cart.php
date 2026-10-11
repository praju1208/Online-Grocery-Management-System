<?php
session_start();
include("../app/config/database.php");

if(!isset($_SESSION['user_id'])){
  echo "<script>alert('Login required');
  window.location.href='../index.php';</script>";
}

$uid = $_SESSION['user_id'];
$pid = $_GET['id'];

$check = mysqli_query($conn,
"SELECT * FROM cart WHERE user_id='$uid' AND product_id='$pid'");

if(mysqli_num_rows($check)){
  mysqli_query($conn,
  "UPDATE cart SET qty=qty+1
   WHERE user_id='$uid' AND product_id='$pid'");
}else{
  mysqli_query($conn,
  "INSERT INTO cart(user_id,product_id) VALUES('$uid','$pid')");
}

header("Location: cart.php");
