<?php
include("../app/config/db.php");
$id = $_GET['id'];

$order = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT o.*, u.name user, d.name delivery_name
FROM orders o
JOIN users u ON o.user_id=u.id
LEFT JOIN delivery_boys d ON o.delivery_boy=d.id
WHERE o.id='$id'
"));

$boys = mysqli_query($conn,"SELECT * FROM delivery_boys WHERE status='Active'");
?>

<h2>Order #<?= $order['id'] ?></h2>
<p>User: <?= $order['user'] ?></p>
<p>Total: ₹<?= $order['total'] ?></p>
<p>Status: <?= $order['status'] ?></p>
<p>Delivery Boy: <?= $order['delivery_name'] ?? 'Not Assigned' ?></p>

<?php if($order['delivery_boy']==NULL && $order['status']!='Cancelled'){ ?>
<form method="post"
      action="assign_delivery.php"
      class="assign-form">
  <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
  <select name="delivery_boy" required>
    <option value="">Select Delivery Boy</option>
    <?php while($b=mysqli_fetch_assoc($boys)){ ?>
      <option value="<?= $b['id'] ?>"><?= $b['name'] ?></option>
    <?php } ?>
  </select>
  <button class="btn-sm">Assign</button>
</form>
<?php } ?>
