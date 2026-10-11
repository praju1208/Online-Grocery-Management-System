<?php
include("../app/config/db.php");
session_start();
$id = $_SESSION['delivery_boy_id'];

mysqli_query($conn,"
UPDATE orders
SET latitude='$_GET[lat]', longitude='$_GET[lng]'
WHERE delivery_boy='$id' AND status='Out for Delivery'
");
?>