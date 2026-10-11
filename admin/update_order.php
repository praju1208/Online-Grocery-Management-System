<?php
session_start();
include("../app/config/db.php");

$id = $_GET['id'];

if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $status = $_POST['status'];
  $delivery = $_POST['delivery'];

  mysqli_query($conn,"
    UPDATE orders 
    SET status='$status', delivery_boy='$delivery'
    WHERE id='$id'
  ");

  header("Location: orders.php");
  exit();
}

/* fetch order */
$o = mysqli_fetch_assoc(
  mysqli_query($conn,"SELECT * FROM orders WHERE id='$id'")
);
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Order</title>
</head>
<body>

<h2>Manage Order #<?= $id ?></h2>

<form method="post">

<label>Status</label><br>
<select name="status" required>
  <option value="Pending"   <?= $o['status']=='Pending'?'selected':'' ?>>Pending</option>
  <option value="Placed"    <?= $o['status']=='Placed'?'selected':'' ?>>Placed</option>
  <option value="Shipped"   <?= $o['status']=='Shipped'?'selected':'' ?>>Shipped</option>
  <option value="Delivered" <?= $o['status']=='Delivered'?'selected':'' ?>>Delivered</option>
</select>

<br><br>

<label>Delivery Person</label><br>
<input type="text" name="delivery" value="<?= $o['delivery_boy'] ?>" placeholder="Eg: Rahul">

<br><br>

<button type="submit">Update Order</button>

</form>

</body>
</html>
