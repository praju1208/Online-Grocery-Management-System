<?php
session_start();
include("../app/config/db.php");

if (!isset($_SESSION['admin'])) {
  header("Location: ../index.php");
  exit();
}

$cats = mysqli_query($conn, "SELECT * FROM categories");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Product</title>
  <link rel="stylesheet" href="admin.css">
</head>
<body>

<?php include("admin_navbar.php"); ?>

<div class="main">

  <div class="topbar">
    <h2>Add Product</h2>
  </div>

  <form method="POST" action="" enctype="multipart/form-data"
        style="background:#fff;padding:25px;border-radius:10px;max-width:500px;">

    <input type="text" name="name" placeholder="Product name" required><br><br>

    <select name="category_id" required>
  <option value="">Select Category</option>
  <?php
  $cats = mysqli_query($conn,"SELECT * FROM categories");
  while($c=mysqli_fetch_assoc($cats)){
  ?>
    <option value="<?= $c['id'] ?>">
      <?= $c['name'] ?> (<?= $c['offer'] ?>% OFF)
    </option>
  <?php } ?>
</select>
<br><br>

    <input type="number" name="price" placeholder="Price" required><br><br>

    <input type="text" name="weight" placeholder="Weight (e.g. 1kg)"><br><br>

    <input type="file" name="image" required><br><br>

    <button type="submit" name="add"
      style="background:#1f8b4c;color:#fff;padding:10px 15px;border:none;border-radius:6px;">
      Save Product
    </button>

  </form>

</div>
</body>
</html>

<?php
if (isset($_POST['add'])) {

  /* FETCH FORM DATA */
  $name       = $_POST['name'];
  $category   = $_POST['category_id'];   // ✅ VERY IMPORTANT
  $price      = $_POST['price'];
  $weight     = $_POST['weight'];

  /* IMAGE */
  $image = $_FILES['image']['name'];
  $tmp   = $_FILES['image']['tmp_name'];

  move_uploaded_file($tmp, "../assets/images/".$image);

  /* INSERT PRODUCT */
  mysqli_query($conn,"
    INSERT INTO products (name, category_id, price, weight, image)
    VALUES ('$name','$category','$price','$weight','$image')
  ");

  header("Location: products.php");
  exit();
}
?>

