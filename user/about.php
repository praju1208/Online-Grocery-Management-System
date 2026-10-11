<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
  <title>About Us | FreshKart</title>
  <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body>

<div class="page-wrapper">
  <div class="container" style="max-width:600px; margin:50px auto;">
    <h2>About FreshKart</h2>
    <p>
      FreshKart is an online grocery platform delivering fresh vegetables,
      fruits, dairy, snacks and household essentials.
    </p>

    <h3>Send us your feedback</h3>

    <form method="POST" action="#">
      <input type="text" placeholder="Your Name" required>
      <input type="email" placeholder="Your Email" required>
      <textarea placeholder="Your Feedback" required></textarea>
      <button class="auth-btn">Submit</button>
    </form>
  </div>
</div>

<footer class="footer">
  © <?= date('Y') ?> FreshKart
</footer>

</body>
</html>
