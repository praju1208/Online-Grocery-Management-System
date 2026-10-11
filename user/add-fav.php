<?php
session_start();
include("../app/config/database.php");

$uid = $_SESSION['user_id'];
$pid = $_GET['id'];

mysqli_query($conn,
"INSERT INTO favourite(user_id,product_id)
 VALUES('$uid','$pid')");

header("Location: favourite.php");
