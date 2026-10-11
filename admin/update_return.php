<?php
include("../app/config/db.php");

$id = $_GET['id'];
$action = $_GET['action'];

if($action=='approve'){
mysqli_query($conn,"
UPDATE returns SET 
status='Approved',
pickup_status='Assigned',
refund_status='Pending'
WHERE id='$id'
");
}

if($action=='reject'){
mysqli_query($conn,"
UPDATE returns SET 
status='Rejected',
pickup_status=NULL,
refund_status='N/A'
WHERE id='$id'
");
}

header("Location: returns.php");
exit;
