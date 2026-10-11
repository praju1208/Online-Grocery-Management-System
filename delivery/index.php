<?php
session_start();
include("../app/config/db.php");
$boy=$_SESSION['delivery_boy_id'];

$orders = mysqli_num_rows(mysqli_query($conn,"
SELECT id FROM orders WHERE delivery_boy='$boy'
"));

$returns = mysqli_num_rows(mysqli_query($conn,"
SELECT id FROM returns WHERE pickup_boy='$boy'
"));
?>

<!DOCTYPE html>
<html>
<body style="margin-left:240px;background:#f4f6f9">

<?php include("navbar.php"); ?>

<div style="padding:30px">
<h2>📊 Dashboard</h2>

<div style="display:flex;gap:20px">

<div style="background:#fff;padding:30px;border-radius:12px;width:250px">
<h3>📦 Deliveries</h3>
<h1><?= $orders ?></h1>
</div>

<div style="background:#fff;padding:30px;border-radius:12px;width:250px">
<h3>↩ Return Pickups</h3>
<h1><?= $returns ?></h1>
</div>

</div>
</div>
</body>
</html>
