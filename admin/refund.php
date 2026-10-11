<?php
include("../app/config/db.php");
$id = $_GET['id'];

mysqli_query($conn,"
UPDATE returns SET refund_status='Refunded'
WHERE id='$id'
");

header("Location: returns.php");
