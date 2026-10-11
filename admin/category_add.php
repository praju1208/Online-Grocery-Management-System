<?php
include("../app/config/db.php");

/* ADD CATEGORY */
if(isset($_POST['add'])){
  $name  = $_POST['name'];
  $offer = $_POST['offer'];

  mysqli_query($conn,"
    INSERT INTO categories (name,offer)
    VALUES ('$name','$offer')
  ");
}

/* UPDATE OFFER */
if(isset($_POST['update'])){
  mysqli_query($conn,"
    UPDATE categories
    SET offer='{$_POST['offer']}'
    WHERE id='{$_POST['id']}'
  ");
}

/* FETCH */
$cats = mysqli_query($conn,"SELECT * FROM categories");
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Categories</title>
<link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

<h2>📂 Category Management</h2>

<!-- ADD CATEGORY -->
<form method="post" class="box">
  <input type="text" name="name" placeholder="Category Name" required>
  <input type="number" name="offer" placeholder="Offer %" value="0">
  <button name="add">Add Category</button>
</form>

<!-- LIST -->
<table>
<tr>
  <th>Name</th>
  <th>Offer %</th>
  <th>Update</th>
</tr>

<?php while($c=mysqli_fetch_assoc($cats)){ ?>
<tr>
<form method="post">
  <td><?= $c['name'] ?></td>
  <td>
    <input type="number" name="offer" value="<?= $c['offer'] ?>">
  </td>
  <td>
    <input type="hidden" name="id" value="<?= $c['id'] ?>">
    <button name="update">Save</button>
  </td>
</form>
</tr>
<?php } ?>

</table>
</body>
</html>
