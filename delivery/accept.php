
<?php
mysqli_query($conn,"
UPDATE orders
SET delivery_boy_status='Accepted',
delivery_status='Shipped'
WHERE id=$id
");

mysqli_query($conn,"
INSERT INTO notifications
(user_type,user_id,message)
VALUES ('admin',1,'Delivery boy accepted order #$id')
");
?>