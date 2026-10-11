<?php
session_start();
include("../app/config/db.php");

if(isset($_POST['login'])){
  $email = $_POST['email'];
  $pass  = $_POST['password'];

  $q = mysqli_query($conn,"SELECT * FROM delivery_boys 
                           WHERE email='$email' AND password='$pass'");

  if(mysqli_num_rows($q)==1){
    $d = mysqli_fetch_assoc($q);
    $_SESSION['delivery_id'] = $d['id'];   // ONLY THIS
    header("Location: dashboard.php");
  }else{
    echo "Invalid login";
  }
}
