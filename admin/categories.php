<?php
session_start();
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
/* UPDATE CATEGORY */
if (isset($_POST['update_category'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $offer = $_POST['offer'];

    mysqli_query(
        $conn,
        "UPDATE categories SET name='$name', offer='$offer' WHERE id=$id"
    );

    $_SESSION['msg'] = "Category updated successfully";
    header("Location: categories.php");
    exit;
}
/* DELETE CATEGORY */
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM categories WHERE id=$id");
    header("Location: categories.php");
    exit;
}
/* FETCH */
$cats = mysqli_query($conn,"SELECT * FROM categories");
?>
<?php
if (isset($_SESSION['msg'])) {
    echo "<script>alert('{$_SESSION['msg']}');</script>";
    unset($_SESSION['msg']);
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Manage Categories</title>
<link rel="stylesheet" href="admin.css">
<style>
.category-box{
  background:#fff;
  padding:20px;
  border-radius:12px;
  box-shadow:0 5px 15px rgba(0,0,0,.1);
  margin-bottom:30px;
  max-width:500px;
}

.category-table{
  width:100%;
  background:#fff;
  border-radius:12px;
  overflow:hidden;
}

.category-table th{
  background:#1f8b4c;
  color:#fff;
  padding:12px;
}

.category-table td{
  padding:10px;
  border-bottom:1px solid #eee;
}

.category-table input{
  width:100%;
  padding:6px;
}

.save-btn{
  background:#1f8b4c;
  color:#fff;
  padding:6px 12px;
  border:none;
  border-radius:6px;
  cursor:pointer;
}
</style>
</head>
<body>
<?php include("admin_navbar.php"); ?>
<div class="main">
<h2>🗂 Manage Categories & Offers</h2>
<!-- ADD CATEGORY -->
<div class="category-box">
  <h3>Add New Category</h3>
  <form method="post">
    <input type="text" name="name" placeholder="Category Name" required>
    <input type="number" name="offer" placeholder="Offer %" value="0">
    <button class="save-btn" name="add">Add Category</button>
  </form>
</div>
<!-- CATEGORY LIST -->
<table class="category-table">
<tr>
  <th>Category</th>
  <th>Offer (%)</th>
  <th>Action</th>
</tr>
<?php while($c=mysqli_fetch_assoc($cats)){ ?>
<tr>
<form method="post">
  <td>
    <input type="text" name="name" value="<?= $c['name'] ?>">
  </td>
  <td>
    <input type="number" name="offer" value="<?= $c['offer'] ?>" min="0" max="90">
    <input type="hidden" name="id" value="<?= $c['id'] ?>">
  </td>
  <td>
  <div class="btn-group">
                            <!-- Update Button -->
                            <button class="save-btn" type="submit" name="update_category">Update</button>

  <a href="delete_category.php?id=<?= $c['id'] ?>"
     onclick="return confirm('Delete this category?')"
     style="color:red;margin-left:10px;">
     🗑 Delete
  </a>
</td>
</form>
</tr>
<?php } ?>
</table>
</div>
</body>
</html>
