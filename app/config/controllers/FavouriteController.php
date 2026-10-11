<?php
session_start();
include("../db.php");

if(!isset($_SESSION['user_id'])){
  http_response_code(401);
  exit;
}

$user = $_SESSION['user_id'];
$product = $_GET['id'];

$check = mysqli_query($conn,
  "SELECT * FROM favourites 
   WHERE user_id=$user AND product_id=$product");

if(mysqli_num_rows($check)){
  mysqli_query($conn,
    "DELETE FROM favourites 
     WHERE user_id=$user AND product_id=$product");
  echo "removed";
}else{
  mysqli_query($conn,
    "INSERT INTO favourites(user_id, product_id)
     VALUES($user,$product)");
  echo "added";
}
