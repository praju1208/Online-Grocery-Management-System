<?php
include("../app/config/db.php");

if(isset($_POST['register'])){

  // Sanitize
  $name     = trim($_POST['name']);
  $address  = trim($_POST['address']);
  $pincode  = trim($_POST['pincode']);
  $phone    = trim($_POST['phone']);
  $email    = trim($_POST['email']);
  $password = $_POST['password'];

  // ---------- VALIDATION ----------

  if(!preg_match("/^[a-zA-Z ]+$/", $name)){
    die("<script>alert('Name should contain only letters');window.history.back();</script>");
  }

  if(!preg_match("/^[0-9]{10}$/", $phone)){
    die("<script>alert('Phone must be 10 digits');window.history.back();</script>");
  }

  if(!preg_match("/^[0-9]{6}$/", $pincode)){
    die("<script>alert('Pincode must be 6 digits');window.history.back();</script>");
  }

  if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    die("<script>alert('Invalid email format');window.history.back();</script>");
  }

  if(strlen($password) < 6){
    die("<script>alert('Password must be at least 6 characters');window.history.back();</script>");
  }

  // Escape (SQL protection)
  $name     = mysqli_real_escape_string($conn, $name);
  $address  = mysqli_real_escape_string($conn, $address);
  $pincode  = mysqli_real_escape_string($conn, $pincode);
  $phone    = mysqli_real_escape_string($conn, $phone);
  $email    = mysqli_real_escape_string($conn, $email);

  $password = password_hash($password, PASSWORD_DEFAULT);

  // ---------- CHECK DUPLICATE EMAIL ----------
  $check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");

  if(mysqli_num_rows($check) > 0){
    echo "<script>
      alert('Email already registered. Please login.');
      window.location='../index.php';
    </script>";
    exit();
  }

  // ---------- INSERT USER ----------
  mysqli_query($conn,"
    INSERT INTO users
    (name,address,pincode,phone,email,password,role)
    VALUES
    ('$name','$address','$pincode','$phone','$email','$password','user')
  ");

  echo "<script>
    alert('Registration successful. Please login.');
    window.location='../index.php';
  </script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>FreshKart | Register</title>
<link rel="stylesheet" href="../assets/css/auth.css">
</head>
<body>

<div class="login-container">
  <div class="login-card">

    <h2 class="title">Register</h2>

    <form method="post">

      <input type="text" name="name" placeholder="Full Name" required>

      <input type="text" name="address" placeholder="Address" required>

      <input type="text" name="pincode" placeholder="Pincode" required>

      <input type="text" name="phone" placeholder="Phone Number" required>

      <input type="email" name="email" placeholder="Email" required>

      <input type="password" name="password" placeholder="Password" required>

      <button type="submit" name="register" class="btn-login">
        Register
      </button>

    </form>

    <p class="register-text">
      Already have an account?
      <a href="../index.php">Login here</a>
    </p>

  </div>
</div>

</body>
</html>
