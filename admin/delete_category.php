<?php
session_start();
include("../app/config/db.php");

if (!isset($_SESSION['admin'])) {
  header("Location: ../index.php");
  exit();
}

$id = (int)$_GET['id'];

/* Will auto delete products due to FK cascade */
mysqli_query($conn,"DELETE FROM categories WHERE id = '$id'");

header("Location: categories.php");
exit;
