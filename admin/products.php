<?php
session_start();
include("../app/config/db.php");

if (!isset($_SESSION['admin'])) {
  header("Location: ../index.php");
  exit();
}

$products = mysqli_query($conn,
"SELECT p.*, 
  c.name AS category,
  c.offer AS category_offer
FROM products p
JOIN categories c ON p.category_id = c.id
");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Products | Admin</title>
  <link rel="stylesheet" href="admin.css">
</head>
<body>

<?php include("admin_navbar.php"); ?>

<div class="main">

  <div class="topbar">
    <h2>Products</h2>
    <a href="product_add.php" style="background:#1f8b4c;color:#fff;padding:10px 15px;border-radius:6px;text-decoration:none;">
      + Add Product
    </a>
  </div>

  <table style="width:100%;margin-top:20px;background:#fff;border-radius:10px;">
    <tr style="background:#f0f0f0;">
      <th>Name</th>
      <th>Category</th>
      <th>Price</th>
      <th>Offer</th>
      <th>Action</th>
    </tr>

    <?php while($p = mysqli_fetch_assoc($products)){ ?>
    <tr>
      <td><?= $p['name'] ?></td>
      <td><?= $p['category'] ?></td>
      <td>₹<?= $p['price'] ?></td>
      <td>
  <?php if($p['category_offer'] > 0){ ?>
    <?= $p['category_offer'] ?>% OFF
  <?php } else { ?>
    —
  <?php } ?>
</td>

      <td>
        <a href="product_delete.php?id=<?= $p['id'] ?>"
           onclick="return confirm('Delete product?')">
           ❌ Delete
        </a>
      </td>
    </tr>
    <?php } ?>
  </table>

</div>
</body>
</html>
