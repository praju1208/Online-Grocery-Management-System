<?php
include("../config/database.php");
session_start();

if($_POST['role']=="admin"){
 if($_POST['email']=="admin@gmail.com" && $_POST['password']=="admin123"){
   $_SESSION['admin']=true;
   header("Location: /freshkart/views/admin/dashboard.php");
 }
}

elseif($_POST['role']=="delivery"){
 if($_POST['email']=="delivery@gmail.com" && $_POST['password']=="delivery123"){
   $_SESSION['delivery']=true;
   header("Location: /freshkart/views/delivery/dashboard.php");
 }
}

else{
 $email=$_POST['email'];
 $pass=$_POST['password'];

 $q=mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");
 $u=mysqli_fetch_assoc($q);

 if($u && password_verify($pass,$u['password'])){
   $_SESSION['user_id']=$u['id'];
   $_SESSION['user_name']=$u['name'];
   header("Location: /freshkart/views/user/home.php");
 }
}
