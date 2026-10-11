<?php
session_start();
include("../app/config/db.php");
include("admin_navbar.php");

$fb = mysqli_query($conn,"SELECT * FROM feedback ORDER BY created_at DESC");
?>


<!DOCTYPE html>
<html>
<head>
<title>User Feedback</title>
<link rel="stylesheet" href="admin.css">
<style>
.fb-card{
  background:#fff;
  padding:20px;
  border-radius:12px;
  box-shadow:0 5px 15px rgba(0,0,0,.08);
}
.fb-item{
  border-bottom:1px solid #eee;
  padding:10px 0;
}
.fb-item:last-child{border:none;}
</style>
</head>

<body>
<div class="main">
  <h2>💬 User Feedback</h2>
<?php if(mysqli_num_rows($fb)==0){ ?>
  <p>No feedback received yet.</p>
<?php } ?>
  <div class="fb-card">
    <?php while($f=mysqli_fetch_assoc($fb)){ ?>
      <div class="fb-item">
        <b><?= $f['name'] ?></b> (<?= $f['email'] ?>)<br>
        <small><?= date('d M Y h:i A', strtotime($f['created_at'])) ?></small>
        <p><?= nl2br($f['message']) ?></p>
      </div>
    <?php } ?>
  </div>
</div>
</body>
</html>
