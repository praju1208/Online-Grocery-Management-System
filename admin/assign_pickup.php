<?php
include("../app/config/db.php");

$return_id   = $_POST['return_id'];
$delivery_id = $_POST['delivery_id'];

mysqli_query($conn,"
UPDATE returns SET 
  pickup_boy = '$delivery_id',
  pickup_status = 'Assigned'
WHERE id = '$return_id'
");

header("Location: returns.php");
exit;
