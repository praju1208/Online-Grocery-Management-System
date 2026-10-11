<?php
include("../app/config/db.php");

$id = $_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM categories WHERE id=$id");
$cat = mysqli_fetch_assoc($result);
?>

<h2>Edit Category</h2>

<form method="POST" action="update_category.php">
  <input type="hidden" name="id" value="<?= $cat['id'] ?>">

  <label>Category Name</label>
  <input type="text" name="name" value="<?= $cat['name'] ?>" required>

  <label>Offer (%)</label>
  <input type="number" name="offer" value="<?= $cat['offer'] ?>">

  <br><br>
  <button type="submit">Update Category</button>
</form>
