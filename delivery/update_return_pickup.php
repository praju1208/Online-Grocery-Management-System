<?php
include("../app/config/db.php");

$id = $_GET['id'];

mysqli_query($conn,"
UPDATE returns SET
pickup_status='Picked Up'
WHERE id='$id'
");

header("Location: return_pickups.php");
exit();
