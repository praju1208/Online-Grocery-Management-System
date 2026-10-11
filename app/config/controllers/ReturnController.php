<?php
session_start();
require_once __DIR__ . "/../db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../../user/login.php");
    exit;
}

$order_id = $_POST['order_id'];
$user_id = $_SESSION['user_id'];   // <-- FIX
$reason = mysqli_real_escape_string($conn, $_POST['reason']);
$account = mysqli_real_escape_string($conn, $_POST['refund_account']);
$ifsc = mysqli_real_escape_string($conn, $_POST['refund_ifsc']);
$holder = mysqli_real_escape_string($conn, $_POST['refund_holder']);

mysqli_query($conn, "
INSERT INTO returns
(order_id, user_id, reason, refund_account, refund_ifsc, refund_holder, status, pickup_status, refund_status)
VALUES
('$order_id', '$user_id', '$reason', '$account', '$ifsc', '$holder',
 'Pending', 'Not Assigned', 'Pending')
");

mysqli_query($conn, "
UPDATE orders SET status='Return Requested'
WHERE id='$order_id'
");

header("Location: ../../../user/orders.php?return=success");
exit;
