<?php
session_start();
include("../../config/db.php");

if (!isset($_SESSION['user_id'])) {
  header("Location: ../../../index.php");
  exit();
}

$user_id = (int)$_SESSION['user_id'];
$action  = $_GET['action'] ?? '';
$cart_id = (int)($_GET['id'] ?? 0);

if ($cart_id <= 0) {
  die("Invalid cart");
}

if ($action === "inc") {
  mysqli_query($conn,"
    UPDATE cart 
    SET quantity = quantity + 1 
    WHERE id='$cart_id' AND user_id='$user_id'
  ");
}

if ($action === "dec") {
  mysqli_query($conn,"
    UPDATE cart 
    SET quantity = quantity - 1 
    WHERE id='$cart_id' AND user_id='$user_id'
  ");

  mysqli_query($conn,"
    DELETE FROM cart 
    WHERE id='$cart_id' AND quantity <= 0
  ");
}

if ($action === "remove") {
  mysqli_query($conn,"
    DELETE FROM cart 
    WHERE id='$cart_id' AND user_id='$user_id'
  ");
}

header("Location: ../../../user/cart.php");
exit();
