<?php
include("../app/config/db.php");
$id = $_GET['id'];

$o = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT latitude,longitude,status FROM orders WHERE id='$id'
"));
?>

<h2>📍 Live Order Tracking</h2>

<?php if($o['latitude']){ ?>
<iframe
width="100%"
height="350"
src="https://maps.google.com/maps?q=<?= $o['latitude'] ?>,<?= $o['longitude'] ?>&z=15&output=embed">
</iframe>
<?php } else { ?>
<p>Waiting for delivery boy location...</p>
<?php } ?>
