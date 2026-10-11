<?php
include("../app/config/db.php");

$id = $_GET['id'];
$action = $_GET['action'];

$status = "";   // default

if($action=='accept') $status = "Accepted";
if($action=='out')    $status = "Out for Pickup";
if($action=='pickup') $status = "Picked Up";
if($action=='reject') $status = "Rejected";

if($status != ""){
   mysqli_query($conn,"
   UPDATE returns SET pickup_status='$status'
   WHERE id='$id'
   ");
}

header("Location: return_pickups.php");
exit();
?>
