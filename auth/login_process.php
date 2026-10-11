<?php
session_start();
include("../app/config/db.php");

$email = trim($_POST['email']);
$password = trim($_POST['password']);
$role = $_POST['role'];

/* ---------- ADMIN ---------- */
if ($role === "admin") {
  if ($email === "admin@gmail.com" && $password === "admin123") {
    $_SESSION['admin'] = true;
    header("Location: ../admin/dashboard.php");
    exit();
  }
  echo "<script>alert('Invalid admin credentials');location='../index.php';</script>";
  exit();
}

/* DELIVERY */
if ($role === "delivery") {

    if ($email === "delivery@gmail.com" && $password === "delivery123") {

        $_SESSION['delivery_logged'] = true;

        // FIXED DELIVERY BOY ID (example: 1)
        $_SESSION['delivery_boy_id'] = 1;

        header("Location: ../delivery/dashboard.php");
        exit();
    }

    echo "<script>alert('Invalid delivery credentials');location='../index.php';</script>";
    exit();
}

/* ---------- USER LOGIN ---------- */

$q = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

$found = false;

while ($user = mysqli_fetch_assoc($q)) {

  if (password_verify($password, $user['password'])) {

    $_SESSION['user_id']   = $user['id'];
    $_SESSION['user_name'] = $user['name'];
    $_SESSION['role']      = 'user';

    header("Location: ../user/home.php");
    exit();
  }
}

echo "<script>
  alert('Wrong email or password');
  window.location='../index.php';
</script>";
exit();
