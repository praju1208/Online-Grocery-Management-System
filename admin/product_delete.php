<?php
session_start();
include("../app/config/db.php");

if (!isset($_SESSION['admin'])) {
  header("Location: ../index.php");
  exit();
}

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM products WHERE id='$id'");

header("Location: products.php");
