<?php
include("../app/config/db.php");

$id = $_GET['id'];

mysqli_query($conn,"
UPDATE orders
SET delivery_status='Accepted',
    accepted_at=NOW()
WHERE id='$id'
");

header("Location: orders.php");
