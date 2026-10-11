<?php
session_start();
include("../app/config/db.php");

$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'];

$check = mysqli_query($conn,
  "SELECT * FROM favourites 
   WHERE user_id='$user_id' AND product_id='$product_id'"
);

if(mysqli_num_rows($check) > 0){
  // remove favourite
  mysqli_query($conn,
    "DELETE FROM favourites 
     WHERE user_id='$user_id' AND product_id='$product_id'"
  );
  echo "removed";
} else {
  // add favourite
  mysqli_query($conn,
    "INSERT INTO favourites(user_id, product_id) 
     VALUES('$user_id','$product_id')"
  );
  echo "added";
}
