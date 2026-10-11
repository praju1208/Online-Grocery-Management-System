<?php
include("../app/config/db.php");

$id = $_POST['id'];
$name = $_POST['name'];
$offer = $_POST['offer'];

mysqli_query(
  $conn,
  "UPDATE categories SET name='$name', offer='$offer' WHERE id=$id"
);

header("Location: categories.php");
exit;
