<?php
$boy = $_SESSION['delivery_boy']['id'];

$n = mysqli_query($conn,"
SELECT * FROM notifications
WHERE user_type='delivery_boy'
AND user_id=$boy
AND is_read=0
");
?>