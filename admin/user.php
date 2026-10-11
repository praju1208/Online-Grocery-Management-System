<?php
session_start();
include("../app/config/db.php");
include("admin_navbar.php");

$users = mysqli_query($conn, "SELECT id, name, email, created_at FROM users");
?>

<!DOCTYPE html>
<html>
<head>
<title>Users</title>
<link rel="stylesheet" href="admin.css">
<style>
.user-card{
  background:#fff;
  padding:25px;
  border-radius:14px;
  box-shadow:0 8px 20px rgba(0,0,0,.08);
}

.user-table{
  width:100%;
  border-collapse:collapse;
  text-align:left;
}

.user-table th{
  background:#1f8b4c;
  color:#fff;
  padding:14px;
  font-size:15px;
}

.user-table td{
  padding:12px 14px;
  border-bottom:1px solid #eee;
  font-size:14px;
}

.user-table tr:hover{
  background:#f9f9f9;
}

.user-table th:nth-child(1),
.user-table td:nth-child(1){
  width:80px;
  text-align:center;
}

.user-table th:nth-child(4),
.user-table td:nth-child(4){
  width:150px;
  text-align:center;
}

</style>
</head>

<body>
<div class="main">
  <h2>👤 Registered Users</h2>

  <div class="user-card">
    <table class="user-table">
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Joined On</th>
      </tr>

      <?php while($u = mysqli_fetch_assoc($users)){ ?>
      <tr>
        <td><?= $u['id'] ?></td>
        <td><?= $u['name'] ?></td>
        <td><?= $u['email'] ?></td>
        <td><?= date('d M Y', strtotime($u['created_at'])) ?></td>
      </tr>
      <?php } ?>
    </table>
  </div>
</div>
</body>
</html>
