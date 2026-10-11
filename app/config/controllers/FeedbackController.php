<?php
session_start();
include("../db.php");

$user_id = $_SESSION['user_id'] ?? NULL;
$name    = $_POST['name'];
$email   = $_POST['email'];
$message = $_POST['message'];

mysqli_query($conn,"
  INSERT INTO feedback (user_id, name, email, message)
  VALUES ('$user_id', '$name', '$email', '$message')
");

$_SESSION['feedback_success'] = true;

header("Location: /freshkart/user/home.php");
exit;
